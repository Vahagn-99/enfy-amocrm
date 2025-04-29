<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Base\Client\{
    EventRecognizer,
    HttpIncomingWebhook,
};
use App\Services\AmoCRM\Core\Facades\Amo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Exception;
use Throwable;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;

class WebhookController extends Controller
{
    /**
     * Количество запросов в секунду.
     */
    const WEBHOOK_RATE_LIMIT = 10;

    /**
     * Время жизни токена в секундах.
     */
    const WEBHOOK_RATE_LIMIT_TTL = 3;

    /**
     * Обработка вебхука.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request) : JsonResponse
    {
//        try {
            $data = $request->all();

            $domain = $data['account']['subdomain'].'.amocrm.ru';

            $rate_limiter_key = "webhook:domain:$domain";

            if (RateLimiter::tooManyAttempts($rate_limiter_key, self::WEBHOOK_RATE_LIMIT)) {
                throw new Exception(
                    "{$domain} попал в лимит. Данные: ".json_encode([
                        "client_domain" => $domain,
                        "data" => $data,
                    ])
                );
            }

            RateLimiter::hit($rate_limiter_key, self::WEBHOOK_RATE_LIMIT_TTL);

            $client = Client::getByDomain($domain);

            Amo::setAccount($client);

            if (! Amo::authenticator()->isAuthorized()) {
                throw new AmoCRMMissedTokenException(
                    "У клиента: {$domain} токен доступа  истек. данные:".json_encode([
                        "client_domain" => $domain,
                        "data" => $data,
                    ])
                );
            }

            $webhook = HttpIncomingWebhook::fromRequestData($data);

            $event = EventRecognizer::getEvent($webhook->entity, $webhook->action);

            if (empty($event)) {
                throw new Exception(
                    "Данный Вебхук не поддерживается: {$webhook->entity} {$webhook->action}. Данные: ".json_encode([
                        "client_domain" => $domain,
                        "data" => $data,
                    ])
                );
            }

            $event::dispatch($client, $webhook);
//        } catch (AmoCRMMissedTokenException $e) {
//            alt_log()->file("error_amocrm_webhook")->error($e->getMessage());
//        } catch (Throwable $e) {
//            alt_log()->file("critical_amocrm_webhook")->critical($e);
//        } finally {
            return response()->json();
//        }
    }
}

