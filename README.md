# Student Result Portal

A Laravel application for managing students and their course results. Students and results have a one-to-many relationship. Student create, edit, and delete actions and all result changes require an authenticated user.

## Requirements

- PHP 8.2 or newer
- Composer
- Laravel dependencies installed with `composer install`

## Run locally

From the project directory:

```bash
php artisan migrate --seed
php artisan serve
```

Open <http://127.0.0.1:8000>. The seeded demo login is `admin@example.com` with password `password`.

## Features

- Students: name, unique roll, department, and unique email
- Results: student, course code, marks from 0 to 100, and automatically calculated grade
- Student CRUD with Form Request validation
- Result validation and per-field Blade error messages
- Student result page with average marks
- Authentication middleware for student and result changes

Grade bands used by the application: 80+ A+, 70–79 A, 60–69 A-, 50–59 B, 40–49 C, 33–39 D, and below 33 F.

## Verify

Run the feature and unit tests with:

```bash
php artisan test
```
