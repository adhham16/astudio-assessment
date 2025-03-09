# Laravel EAV API Project

This project is a Laravel-based RESTful API that implements an **Entity-Attribute-Value (EAV) model** for handling dynamic attributes for projects. It also includes authentication using Laravel Passport and supports flexible filtering on both standard and dynamic attributes.

---

## 🚀 Features
- **User Authentication** (Register, Login, Logout) using Laravel Passport
- **Projects Management** with dynamic attributes
- **Timesheet Logging** for tracking user work hours on projects
- **Entity-Attribute-Value (EAV) implementation** for flexible attribute storage
- **Filtering Support** on both standard and dynamic attributes
- **RESTful API Endpoints** following best practices
- **Database Migrations & Seeders** for easy setup
- **Error Handling & Validation**

---

## 🛠 Installation

### Prerequisites
Make sure you have the following installed:
- PHP 8+
- Composer
- MySQL or PostgreSQL
- Laravel 10+
- Git

### Setup Instructions
```sh
# Clone the repository
git clone https://github.com/adhham16/astudio-assessment.git
cd astudio-assessment

# Install dependencies
composer install

# Copy .env file and configure database
cp .env.example .env
nano .env  # Update DB credentials

# Generate application key
php artisan key:generate

# Run migrations and seeders
php artisan migrate --seed

# Install Laravel Passport
php artisan passport:install

# Start the server
php artisan serve

# Testing Credentials
"email": "johnsmith@test.com",
"password": "Test@1234"
```

---

## 🔐 Authentication
The API uses Laravel Passport for authentication.

### **Register**
```http
POST /api/register
```
#### Request Body:
```json
{
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

### **Login**
```http
POST /api/login
```
#### Request Body:
```json
{
  "email": "johnsmith@test.com",
  "password": "Test@1234"
}
```
#### Response:
```json
{
  "token": "your-access-token"
}
```
**Use this token in the Authorization header for protected routes:**
```
Authorization: Bearer your-access-token
```

### **Logout**
```http
POST /api/logout
```

---

## 📌 API Endpoints

### **Users**
| Method | Endpoint                 | Description                    |
|--------|--------------------------|--------------------------------|
| GET    | `/api/user`             | Get all users                  |
| GET    | `/api/user/{id}`        | Get a specific user            |
| POST   | `/api/user`             | Create a new user              |
| PUT    | `/api/user/{id}`        | Update a user                  |
| DELETE | `/api/user/{id}`        | Delete a user                  |

### **Projects**
| Method | Endpoint                 | Description                    |
|--------|--------------------------|--------------------------------|
| GET    | `/api/project`          | Get all projects              |
| GET    | `/api/project/{id}`     | Get a specific project        |
| POST   | `/api/project`          | Create a new project          |
| PUT    | `/api/project/{id}`     | Update a project              |
| DELETE | `/api/project/{id}`     | Delete a project              |

### **Attributes**
| Method | Endpoint                 | Description                    |
|--------|--------------------------|--------------------------------|
| GET    | `/api/attribute`        | Get all attribute            |
| GET    | `/api/attribute/{id}`   | Get a specific attribute      |
| POST   | `/api/attribute`        | Create an attribute           |
| PUT    | `/api/attribute/{id}`   | Update an attribute           |
| DELETE | `/api/attribute/{id}`   | Delete a attribute entry      |

### **Assign Attributes to Projects**
| Method | Endpoint                       | Description                    |
|--------|--------------------------------|--------------------------------|
| POST   | `/api/project/attribute/{id}` | Assign attributes to a project |

### **Timesheets**
| Method | Endpoint                 | Description                    |
|--------|--------------------------|--------------------------------|
| GET    | `/api/timesheet`        | Get all timesheets            |
| GET    | `/api/timesheet/{id}`   | Get a specific timesheet      |
| POST   | `/api/timesheet`        | Log a new timesheet entry     |
| PUT    | `/api/timesheet/{id}`   | Update a timesheet entry      |
| DELETE | `/api/timesheet/{id}`   | Delete a timesheet entry      |

## 🏗 Database Schema
### **Users Table**
| Column     | Type    | Description         |
|------------|--------|---------------------|
| id         | int    | Primary Key         |
| first_name | string | User's first name   |
| last_name  | string | User's last name    |
| email      | string | Unique email        |
| password   | string | Hashed password     |

### **Projects Table**
| Column | Type    | Description        |
|--------|--------|--------------------|
| id     | int    | Primary Key        |
| name   | string | Project Name       |
| status | string | Active/Inactive    |

### **Timesheets Table**
| Column    | Type    | Description                 |
|-----------|--------|-----------------------------|
| id        | int    | Primary Key                 |
| user_id   | int    | Foreign Key (User)          |
| project_id| int    | Foreign Key (Project)       |
| task_name | string | Task description            |
| date      | date   | Date of the work entry      |
| hours     | int    | Hours worked                |

### **Attributes Table**
| Column | Type    | Description      |
|--------|--------|------------------|
| id     | int    | Primary Key      |
| name   | string | Attribute Name   |
| type   | string | text, number, etc. |

### **Attribute Values Table**
| Column       | Type    | Description            |
|-------------|--------|------------------------|
| id          | int    | Primary Key            |
| attribute_id| int    | Foreign Key (Attribute)|
| project_id  | int    | Foreign Key (Project)  |
| value       | string | Attribute Value        |

