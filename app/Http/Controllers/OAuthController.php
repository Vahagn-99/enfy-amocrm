<?php

namespace App\Http\Controllers;


use App\Base\Client\Events\AmoAccountAuthenticated;
use App\Http\Requests\CallbackRequest;
use App\Models\Client as ClientModel;
use App\Services\AmoCRM\Core\Facades\Amo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Throwable;

class OAuthController extends Controller
{
    /**
     * Получение ссылки для авторизации.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login() : RedirectResponse
    {
        return redirect(Amo::authenticator()->url());
    }

    /**
     * Обработка колбэка от AmoCRM.
     *
     * @param \App\Http\Requests\CallbackRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(CallbackRequest $request) : JsonResponse
    {
        $domain = $request->validated("referer");
        $code = $request->validated("code");

        $client = ClientModel::getByDomain($domain);

        if (empty($client)) {
            $client = new ClientModel();

            $client->domain = $domain;

            $client->save();
        }

        $authenticator = Amo::setAccount($client)->authenticator();

        try {
            $access_token = $authenticator->exchangeCodeWithAccessToken($code);

            $authenticator->oauth()->saveOAuthToken($access_token, $client->getDomain());

            $client->save();

            AmoAccountAuthenticated::dispatch($client);

            return response()->json(['status' => 'success']);
        } catch (Exception $e) {
            alt_log()->file("error_client_oauth")->error("{$client->getDomain()} Ошибка авторизации", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'error']);
        } catch (Throwable $e) {
            alt_log()->file("error_client_oauth")->error("{$client->getDomain()} Ошибка авторизации", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['status' => 'error']);
        }
    }
}