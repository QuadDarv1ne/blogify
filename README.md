# Blogify

Современное приложение блога на Laravel 12 с RESTful API, кешированием и Docker-поддержкой.

## Возможности

- 📝 Публикация постов с категориями и тегами
- 💬 Комментарии с модерацией
- 🔐 Система авторизации (Laravel Breeze)
- 📱 RESTful API v1 с версионированием
- ⚡ Кеширование (Redis/Files)
- 🐳 Docker-окружение
- 🧪 Тестирование (PHPUnit)

## Требования

- PHP 8.2+
- Composer
- MySQL 8.0+ / PostgreSQL / SQLite
- Node.js 18+ (для фронтенда)

## Быстрый старт

### Установка

```bash
# Клонирование
git clone https://github.com/your-repo/blogify.git
cd blogify

# Зависимости
composer install
npm install

# Настройка окружения
cp .env.example .env
php artisan key:generate

# Миграции и сиды
php artisan migrate --seed
```

### Запуск

```bash
# Локальный сервер
php artisan serve

# или через Docker
docker-compose up -d
```

## Команды

### Основные

```bash
# Миграции
php artisan migrate                 # миграции
php artisan migrate:fresh           # сброс и новые миграции
php artisan migrate:fresh --seed    # с сидами

# Сиды
php artisan db:seed                 # запуск сидов
php artisan migrate:fresh --seed    # всё сразу

# Очистка
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear          # всё сразу

# Кеширование
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Разработка

```bash
# Локальный сервер
php artisan serve

# Очереди
php artisan queue:work
php artisan queue:listen

# Логи
tail -f storage/logs/laravel.log

# Роуты
php artisan route:list
php artisan route:list --path=api

# Tinker (REPL)
php artisan tinker
```

### Тестирование

```bash
# Все тесты
php artisan test

# Только юнит
php artisan test --unit

# Только feature
php artisan test --feature

# С покрытием
php artisan test --coverage

# Code style (Pint)
./vendor/bin/pint
./vendor/bin/pint --test  # проверка без исправлений
```

### Docker

```bash
# Запуск
docker-compose up -d

# Остановка
docker-compose down

# Логи
docker-compose logs -f app
docker-compose logs -f nginx

# Вход в контейнер
docker exec -it blog_app bash

# Пересборка
docker-compose build --no-cache
```

## Структура проекта

```
app/
├── Http/
│   ├── Controllers/     # Контроллеры
│   │   ├── Api/V1/     # API v1
│   │   └── Admin/      # Админ-панель
│   └── Middleware/     # Промежуточное ПО
├── Models/             # Eloquent модели
├── Services/           # Бизнес-логика
└── Providers/          # Сервис-провайдеры

config/                 # Конфигурация
database/
├── migrations/         # Миграции
├── factories/          # Фабрики
└── seeders/           # Сиды

routes/
├── api.php             # API (включает api_v1.php)
├── api_v1.php          # API v1
├── web.php             # Веб-роуты
└── console.php         # Команды

resources/views/        # Blade-шаблоны
tests/                 # Тесты
docker/                # Docker-конфиги
```

## API Endpoints

### Posts

| Method | Endpoint | Описание |
|--------|----------|----------|
| GET | `/api/v1/posts` | Список постов |
| GET | `/api/v1/posts/{slug}` | Пост по slug |
| GET | `/api/v1/posts/popular` | Популярные посты |

### Categories

| Method | Endpoint | Описание |
|--------|----------|----------|
| GET | `/api/v1/categories` | Все категории |
| GET | `/api/v1/categories/{slug}` | Категория |
| GET | `/api/v1/categories/{slug}/posts` | Посты категории |

### Tags

| Method | Endpoint | Описание |
|--------|----------|----------|
| GET | `/api/v1/tags` | Все теги |
| GET | `/api/v1/tags/{slug}` | Тег |
| GET | `/api/v1/tags/{slug}/posts` | Посты тега |

### Comments

| Method | Endpoint | Описание |
|--------|----------|----------|
| GET | `/api/v1/posts/{id}/comments` | Комментарии поста |
| POST | `/api/v1/posts/{id}/comments` | Добавить комментарий |

### Пример ответа

```json
{
  "success": true,
  "message": "Success",
  "data": {
    "data": [...],
    "current_page": 1,
    "last_page": 1,
    "per_page": 15,
    "total": 10
  }
}
```

## Переменные окружения

```env
APP_NAME=Blogify
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogify
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Redis (опционально)
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

## Горячие клавиши (VS Code)

- `Ctrl+Shift+P` → ` artisan` — выполнить команду
- `Ctrl+Shift+D` — отладка
- `F5` — запустить отладку

## Полезные ссылки

- [Документация Laravel](https://laravel.com/docs)
- [Laravel API](https://laravel.com/api)
- [Pint (code style)](https://laravel.com/docs/pint)
- [Docker](https://docs.docker.com)

## Лицензия

MIT License — подробности в файле `LICENCE`.
