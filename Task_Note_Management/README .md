
# TaskAndNoteManagement

## 📌 Project Description

Task & Notes Manager is a backend-focused RESTful API built using Laravel.  
The application allows users to manage their personal tasks and attach notes to them securely.

This project is designed as a mini assignment to demonstrate fundamental Laravel concepts such as authentication, database design, REST APIs, validation, and authorization. The system ensures that users can only access and modify their own data.

No frontend interface is included. All functionalities are exposed via APIs and can be tested using tools like Postman or Thunder Client.




## 🎯 Key Features

- User registration and authentication
- Create, update, delete, and view tasks
- Add notes to individual tasks
- Mark tasks as completed
- Secure access using authentication and authorization policies
- Users can only access their own tasks and notes
- Clean and consistent JSON API responses

## ⚠️ Assumptions & Limitations

- This is a backend-only project; no frontend UI is included
- Authentication is handled using Laravel Sanctum
- No role-based access control (admin/user) implemented
- Pagination is not implemented for task listing
- APIs are intended for learning and evaluation purposes

## API Reference

####  🔐 Authentication Service

```http
  POST  http://127.0.0.1:8000/api/signup
```
| Parameter  | Type     | Description                 |
| ---------- | -------- | --------------------------- |
| `name`     | `string` | **Required.** User name     |
| `email`    | `string` | **Required.** User email    |
| `password` | `string` | **Required.** User password |


```http
  POST http://127.0.0.1:8000/api/login

```
| Parameter  | Type     | Description                 |
| ---------- | -------- | --------------------------- |
| `email`    | `string` | **Required.** User email    |
| `password` | `string` | **Required.** User password |

🛡️ Protected Routes

Requires Authorization: Bearer {token}

📋 Task Service

```http
  POST http://127.0.0.1:8000/api/add-task
```
| Parameter     | Type     | Description                |
| ------------- | -------- | -------------------------- |
| `title`       | `string` | **Required.** Task title   |
| `description` | `string` | Optional. Task description |

```http
  GET http://127.0.0.1:8000/api/tasks
```

```http
 PUT http://127.0.0.1:8000/api/task/{task}
```
| Parameter     | Type     | Description                      |
| ------------- | -------- | -------------------------------- |
| `title`       | `string` | **Required.** Updated task title |
| `description` | `string` | Optional. Updated description    |


```http
 PUT  http://127.0.0.1:8000/api/complete/{task}
```


```http
 DELETE http://127.0.0.1:8000/api/delete/{task}
```

📝 Task Notes Service
```http
 POST http://127.0.0.1:8000/api/task/{task}/note
```
| Parameter | Type     | Description                |
| --------- | -------- | -------------------------- |
| `note`    | `string` | **Required.** Note content |










## Running Tests

To run tests, run the following command

```bash
  git clone https://github.com/SouravAmbati/TaskAndNotesManagement.git
  cd Task-Notes-Manager
```

## Install Dependencies
```bash
composer install
```
## Environment Setup
```bash
  cp .env.example .env
```
## Generate the application key:
```bash
  php artisan key:generate
```
## Database Configuration
Create the database manually in MySQL:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_notes_db
DB_USERNAME=root
DB_PASSWORD=your_password

## Run Migrations
```bash
  php artisan migrate
```
## Start the Development Server
```bash
  php artisan serve
```
## The application will be available at:
http://127.0.0.1:8000

## API Testing
You can test the APIs using:
Postman
Thunder Client


Authentication is handled using Laravel Sanctum.
Pass the token in the request header:




