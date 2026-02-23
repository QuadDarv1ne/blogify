# Установка, настройка и запуск проекта Blogify

## Установка

### 1. Клонирование репозитория

```bash
git clone https://github.com/Quadd4rv1ne/blogify.git
cd blogify
```

### 2. Установка зависимостей

```bash
# Установка PHP зависимостей
composer install

# Установка JavaScript зависимостей
npm install
```

### 3. Настройка окружения

```bash
# Копирование файла окружения
cp .env.example .env

# Генерация ключа приложения
php artisan key:generate
```

### 4. Настройка базы данных

**Отредактируйте файл `.env` и укажите параметры подключения к базе данных:**

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogify
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Миграции и сиды

```bash
# Запуск миграций
php artisan migrate

# Заполнение базы тестовыми данными (опционально)
php artisan db:seed
```

### 6. Создание символической ссылки для хранилища

```bash
php artisan storage:link
```

### 7. Сборка frontend-ресурсов

```bash
# Для разработки
npm run dev

# Для production
npm run build
```

### 8. Запуск приложения

```bash
# Запуск встроенного сервера разработки
php artisan serve
```

> Приложение будет доступно по адресу `http://localhost:8000`

---

## Конфигурация

### Настройка почты

**Отредактируйте параметры почты в файле .env:**

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@blogify.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Настройка хранилища файлов

**Для использования Amazon S3:**

```bash
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket
```

### Настройка очередей

```bash
# Запуск обработчика очередей
php artisan queue:work

# Для production используйте supervisor
```

## Использование

### Создание первого администратора

```bash
php artisan blogify:create-admin
```

> Следуйте инструкциям в консоли для создания учетной записи администратора.

### Панель администратора

**Доступ к панели администратора:** `http://localhost:8000/admin`

## API Endpoints

**Платформа предоставляет RESTful API для интеграции:**

- GET /api/posts - Получение списка статей
- GET /api/posts/{id} - Получение конкретной статьи
- GET /api/categories - Получение категорий
- GET /api/tags - Получение тегов

> Полная документация API доступна по адресу `/api/documentation`

---

## Тестирование

```bash
# Запуск всех тестов
php artisan test

# Запуск конкретного набора тестов
php artisan test --testsuite=Feature

# Запуск с покрытием кода
php artisan test --coverage
```

---

```bash
# Создать проект с git репозиторием
laravel new blogify --git

# Создать с определенной базой данных
laravel new blogify --database=mysql

# Создать с Breeze (аутентификация)
laravel new blogify --breeze

# Создать с Jetstream
laravel new blogify --jet

# Все вместе
laravel new blogify --git --database=mysql --breeze
```

---

**Преподаватель:** Дуплей Максим Игоревич

**Дата:** 25.11.2025
