## Installation

```bash
git clone https://github.com/cetver/midnight-works-test-task -- <project-dir>
cd <project-dir>
composer install
php artisan migrate --path=/api/v1/database/migrations
php artisan api-v1:create-swagger-specification
```

## Usage

```bash
php artisan serve
```

**[http://127.0.0.1:8000/](http://127.0.0.1:8000/)**


