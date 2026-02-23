# ============================================
# BLOGIFY - Laravel Artisan Commands
# ============================================

# 1. СОЗДАНИЕ МИГРАЦИЙ
# ============================================

# Миграция для постов
php artisan make:migration create_posts_table

# Миграция для категорий
php artisan make:migration create_categories_table

# Миграция для тегов
php artisan make:migration create_tags_table

# Миграция для комментариев
php artisan make:migration create_comments_table

# Добавить поля в таблицу users (если нужно)
php artisan make:migration add_role_to_users_table --table=users


# 2. СОЗДАНИЕ МОДЕЛЕЙ
# ============================================

# Модель Post с миграцией, фабрикой, сидером и контроллером
php artisan make:model Post -mfsc

# Модель Category с миграцией, фабрикой, сидером и контроллером
php artisan make:model Category -mfsc

# Модель Tag с миграцией, фабрикой и сидером
php artisan make:model Tag -mfs

# Модель Comment с миграцией и фабрикой
php artisan make:model Comment -mf


# 3. СОЗДАНИЕ КОНТРОЛЛЕРОВ
# ============================================

# Публичные контроллеры
php artisan make:controller PostController
php artisan make:controller CommentController

# Admin контроллеры
php artisan make:controller Admin/PostController --resource
php artisan make:controller Admin/CategoryController --resource
php artisan make:controller Admin/TagController --resource
php artisan make:controller Admin/CommentController
php artisan make:controller Admin/DashboardController


# 4. СОЗДАНИЕ REQUESTS (для валидации)
# ============================================

php artisan make:request StorePostRequest
php artisan make:request UpdatePostRequest
php artisan make:request StoreCategoryRequest
php artisan make:request UpdateCategoryRequest
php artisan make:request StoreTagRequest
php artisan make:request StoreCommentRequest


# 5. СОЗДАНИЕ MIDDLEWARE
# ============================================

# Middleware для проверки админа
php artisan make:middleware IsAdmin

# Middleware для проверки автора поста
php artisan make:middleware PostOwner


# 6. СОЗДАНИЕ SEEDERS
# ============================================

php artisan make:seeder UserSeeder
php artisan make:seeder CategorySeeder
php artisan make:seeder TagSeeder
php artisan make:seeder PostSeeder
php artisan make:seeder CommentSeeder

# Или создать DatabaseSeeder (уже существует)


# 7. СОЗДАНИЕ FACTORIES
# ============================================

php artisan make:factory PostFactory
php artisan make:factory CategoryFactory
php artisan make:factory TagFactory
php artisan make:factory CommentFactory


# 8. СОЗДАНИЕ POLICIES (для авторизации)
# ============================================

php artisan make:policy PostPolicy --model=Post
php artisan make:policy CommentPolicy --model=Comment


# 9. СОЗДАНИЕ EVENTS & LISTENERS
# ============================================

# Event когда пост опубликован
php artisan make:event PostPublished

# Listener для отправки уведомлений
php artisan make:listener SendPostPublishedNotification --event=PostPublished


# 10. СОЗДАНИЕ JOBS (для фоновых задач)
# ============================================

# Job для генерации превью изображений
php artisan make:job ProcessPostImage

# Job для отправки email уведомлений
php artisan make:job SendCommentNotification


# 11. СОЗДАНИЕ NOTIFICATIONS
# ============================================

php artisan make:notification NewCommentNotification
php artisan make:notification PostPublishedNotification


# 12. СОЗДАНИЕ MAIL CLASSES
# ============================================

php artisan make:mail NewPostPublished
php artisan make:mail CommentApproved


# 13. СОЗДАНИЕ COMMANDS (консольные команды)
# ============================================

# Команда для создания админа
php artisan make:command CreateAdminCommand

# Команда для публикации запланированных постов
php artisan make:command PublishScheduledPosts


# 14. СОЗДАНИЕ RESOURCE CLASSES (для API)
# ============================================

php artisan make:resource PostResource
php artisan make:resource PostCollection
php artisan make:resource CategoryResource
php artisan make:resource TagResource
php artisan make:resource CommentResource


# 15. СОЗДАНИЕ API КОНТРОЛЛЕРОВ
# ============================================

php artisan make:controller Api/PostController --api
php artisan make:controller Api/CategoryController --api
php artisan make:controller Api/TagController --api
php artisan make:controller Api/CommentController --api


# 16. СОЗДАНИЕ OBSERVERS
# ============================================

php artisan make:observer PostObserver --model=Post
php artisan make:observer CommentObserver --model=Comment


# 17. СОЗДАНИЕ VIEWS
# ============================================

# Views создаются вручную в resources/views/
# Но можно использовать пакеты для генерации CRUD


# 18. УСТАНОВКА АУТЕНТИФИКАЦИИ
# ============================================

# Laravel Breeze (простая аутентификация)
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
npm install && npm run dev

# ИЛИ Laravel UI (альтернатива)
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev


# 19. ЗАПУСК МИГРАЦИЙ И СИДЕРОВ
# ============================================

# Запустить все миграции
php artisan migrate

# Откатить последнюю миграцию
php artisan migrate:rollback

# Откатить все миграции и запустить заново
php artisan migrate:fresh

# Запустить миграции с сидерами
php artisan migrate:fresh --seed

# Запустить только сидеры
php artisan db:seed

# Запустить конкретный сидер
php artisan db:seed --class=UserSeeder


# 20. СОЗДАНИЕ STORAGE LINK
# ============================================

php artisan storage:link


# 21. ОЧИСТКА КЭША
# ============================================

# Очистить кэш приложения
php artisan cache:clear

# Очистить кэш конфигурации
php artisan config:clear

# Очистить кэш маршрутов
php artisan route:clear

# Очистить кэш представлений
php artisan view:clear

# Очистить всё
php artisan optimize:clear


# 22. КЭШИРОВАНИЕ ДЛЯ PRODUCTION
# ============================================

# Кэшировать конфигурацию
php artisan config:cache

# Кэшировать маршруты
php artisan route:cache

# Кэшировать представления
php artisan view:cache

# Оптимизировать автозагрузчик
composer install --optimize-autoloader --no-dev


# 23. СОЗДАНИЕ ТЕСТОВ
# ============================================

# Feature тесты
php artisan make:test PostTest
php artisan make:test CategoryTest
php artisan make:test CommentTest

# Unit тесты
php artisan make:test PostUnitTest --unit
php artisan make:test CategoryUnitTest --unit


# 24. ЗАПУСК ТЕСТОВ
# ============================================

# Запустить все тесты
php artisan test

# Запустить конкретный тест
php artisan test --filter PostTest

# Запустить тесты с покрытием
php artisan test --coverage


# 25. ПОЛЕЗНЫЕ КОМАНДЫ
# ============================================

# Показать все маршруты
php artisan route:list

# Показать маршруты с фильтром
php artisan route:list --except-vendor

# Показать информацию о приложении
php artisan about

# Запустить планировщик задач
php artisan schedule:run

# Запустить очереди
php artisan queue:work

# Показать список всех команд
php artisan list

# Открыть tinker (интерактивная консоль)
php artisan tinker


# ============================================
# БЫСТРАЯ НАСТРОЙКА ПРОЕКТА
# ============================================

# Полная последовательность команд для быстрого старта:

# 1. Создать проект
composer create-project laravel/laravel blogify

# 2. Перейти в папку
cd blogify

# 3. Установить Breeze для аутентификации
composer require laravel/breeze --dev
php artisan breeze:install
npm install

# 4. Настроить .env файл (база данных)

# 5. Создать все модели с миграциями
php artisan make:model Post -mfsc
php artisan make:model Category -mfsc
php artisan make:model Tag -mfs
php artisan make:model Comment -mf

# 6. Создать контроллеры
php artisan make:controller PostController
php artisan make:controller Admin/PostController --resource
php artisan make:controller Admin/CategoryController --resource
php artisan make:controller Admin/TagController --resource
php artisan make:controller Admin/CommentController
php artisan make:controller Admin/DashboardController

# 7. Создать middleware
php artisan make:middleware IsAdmin

# 8. Запустить миграции
php artisan migrate

# 9. Создать символическую ссылку для storage
php artisan storage:link

# 10. Запустить сервер разработки
php artisan serve

# 11. В отдельном терминале запустить Vite
npm run dev


# ============================================
# ДОПОЛНИТЕЛЬНЫЕ ПАКЕТЫ (ОПЦИОНАЛЬНО)
# ============================================

# Laravel Debugbar (для разработки)
composer require barryvdh/laravel-debugbar --dev

# Laravel IDE Helper (для автодополнения)
composer require --dev barryvdh/laravel-ide-helper

# Laravel Telescope (для мониторинга)
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate

# Spatie Media Library (для работы с медиа)
composer require spatie/laravel-medialibrary

# Spatie Permission (для ролей и прав)
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

# Laravel Scout (для поиска)
composer require laravel/scout
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"

# Intervention Image (для работы с изображениями)
composer require intervention/image

---

**Преподаватель:** Дуплей Максим Игоревич

**Дата:** 25.11.2025
