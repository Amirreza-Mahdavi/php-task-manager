# PHP Task Manager 

A backend REST API for managing tasks, subtasks, users, and task assignments, built with **PHP 8.1+**, **PostgreSQL**, **PDO**, and **Composer**.

## Features

- User registration
- User authentication using PHP sessions
- Task and subtask creation
- Task and subtask updates
- Task and subtask deletion
- Task assignment to users
- Role-based authorization for task assignment
- Request validation
- DTO-based request/response handling
- Enum-based task status and priority
- PostgreSQL persistence using PDO
- Prepared SQL statements
- PSR-4 autoloading with Composer
- Custom HTTP router
- JSON API responses
- Layered application architecture

## Tech Stack

| Technology | Purpose |
|---|---|
| PHP 8.1+ | Backend language |
| PostgreSQL | Relational database |
| PDO | Database access |
| Composer | Dependency management and autoloading |
| PHP-Dotenv | Environment configuration |
| PHP Sessions | Authentication state |
| PSR-4 | Class autoloading |

# Architecture

The application follows a layered architecture inspired by patterns commonly found in frameworks such as Laravel.

```text
HTTP Request -> Router -> Controller -> Service -> Repository -> PDO -> PostgreSQL
```

The response follows the opposite direction:

```text
PostgreSQL -> Repository -> Model -> Service -> Controller ->  Response DTO -> JsonResponse -> HTTP Response
```

# Installation

## Requirements

Make sure the following are installed:

- PHP 8.1 or newer
- PostgreSQL
- Composer
- PHP PDO PostgreSQL extension

Check PHP:

```bash
php -v
```

Check Composer:

```bash
composer --version
```

Check PostgreSQL:

```bash
psql --version
```

---

## 1. Clone the Repository

```bash
git clone <repository-url>
cd php-task-manager
```

---

## 2. Install Dependencies

Run:

```bash
composer install
```

Composer will install the project dependencies and generate the autoloader.

If the PSR-4 configuration has been changed, regenerate the autoloader with:

```bash
composer dump-autoload
```

---

## 3. Configure Environment Variables

Copy:

```text
.env.example
```

to:

```text
.env
```

Example:

```env
DB_HOST=localhost
DB_PORT=5432
DB_NAME=task_manager_db
DB_USER=postgres_user
DB_PASSWORD=postgres_password
```

Update these values to match your PostgreSQL configuration.

> Do not commit `.env` to version control.

---

# Database Setup

Create the PostgreSQL database:

```sql
CREATE DATABASE task_manager_db;
```

Then execute the schema:

```bash
psql -U postgres_user -d task_manager_db -f database/schema.sql
```

The schema creates:

- Roles
- Users
- Tasks
- Assignments

and inserts the initial roles:

```text
Admin
Member
```