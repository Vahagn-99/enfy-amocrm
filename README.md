# Emfy Laravel Service for AmoCRM Integration

Этот проект представляет собой Laravel-сервис, предназначенный для интеграции с AmoCRM через виджет. Он использует Docker, Horizon для обработки очередей и поддерживает автоматическую подписку на вебхуки AmoCRM.

## 🚀 Установка и запуск

### 1. Клонировать репозиторий

```
git clone https://github.com/Vahagn-99/enfy-amocrm.git
cd enfy-amocrm
```

### 2. Создать `.env` файл

```
cp .env.example .env
```

### 3. Запустить Docker Compose

```
docker-compose up -d
```

### 4. Войти в контейнер приложения

```
docker exec -it emfy-app /bin/zsh
```

### 5. Установить зависимости

Внутри контейнера выполнить команду:

```
composer install
```

### 6. Запустить миграции

```
php artisan migrate
```

### 7. Запустить Horizon (обработка очередей)

```
php artisan horizon
```

## 🌐 Ссылка для виджета AmoCRM

Виджет будет обращаться по адресу:

```
https://legally-fleet-hen.ngrok-free.app
```

## 🔐 Авторизация в AmoCRM и получение Access Token

    - Нужно копировать ключи виджета из AmoCRM и вставить в файл `.env`:
    ```
    AMOCRM_CLIENT_ID=ваш_client_id
    AMOCRM_CLIENT_SECRET=ваш_client_secret
    ```

1. Войдите в аккаунт AmoCRM в браузере.
2. После входа вставьте в адресную строку **в этом же браузере** ссылку:

```
https://legally-fleet-hen.ngrok-free.app/amocrm/oauth/login
```

3. Нажмите Enter.
4. Выберите ваш аккаунт в списке и нажмите **"Дать доступ"**.
5. После успешной авторизации токены сохраняются в базе данных.

📦 Доступ к базе данных phpmyadmin:

```
http://localhost:8010
```

## 🔄 Проверка интеграции

После успешной авторизации вы можете:

- Создавать или обновлять **сделки** и **контакты** в AmoCRM — виджет будет обрабатывать события.
- Автоматическая подписка на вебхуки выполняется **однократно** при первой регистрации аккаунта. При повторной авторизации дублирование подписки **не происходит**.# enfy-amocrm

## 📦 Используемые технологии

- **Laravel** — PHP фреймворк для создания веб-приложений.
- **Docker** — контейнеризация приложения.
- **ngrok** — создание публичного URL для локального сервера.
- **MySQL** — база данных для хранения данных приложения.
- **phpMyAdmin** — веб-интерфейс для управления MySQL базой данных.
- **Redis** — система управления очередями.
- **Horizon** — управление очередями в Laravel. (http://localhost/horizon)
- **Laravel opcodesio/log-viewer** — просмотр логов приложения. (http://localhost/log-viewer)
- **Laravel Telescope** — отладка и мониторинг приложения. (http://localhost/telescope)
- **AmoCRM API** — интеграция с AmoCRM.

## 📄 Авторизация в сервисах http://localhost/horizon, http://localhost/log-viewer, http://localhost/telescope для простоты сделано через basic auth.
- **Логин:** admin
- **Пароль:** admin

можно изменить в файле `.env`

