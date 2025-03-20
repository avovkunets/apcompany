# Employee API

## Description
The **Employee API** is a simple RESTful service built with Symfony and API Platform. It allows you to manage employee records by providing endpoints for creating, reading, updating, and deleting employees. The API ensures data integrity through built-in validation and automatically generates OpenAPI/Swagger documentation.

## Features
- Create an employee with required details
- Retrieve employee details by ID
- Update employee information
- Delete an employee record
- Automatic OpenAPI/Swagger documentation via API Platform
- Functional tests for API reliability

## Technologies Used
- **Symfony** – PHP framework
- **API Platform** – For building the RESTful API and auto-generating documentation
- **Doctrine ORM** – For database interactions
- **PHPUnit** – Testing framework
- **Docker & Docker Compose** – For containerized environment
- **MySQL** (or your preferred database) – For data storage

## Installation and Setup

### Prerequisites
Ensure you have the following installed:
- **Docker** & **Docker Compose**
- **PHP 8.2+**
- **Composer**

### Setup Steps

1. **Clone the Repository:**
   ```bash
   git clone <repository_url>
   cd <repository_directory>

2. Configure the environment: Ensure your `.env` file is set correctly, for example:

        ###> symfony/framework-bundle ###
        APP_ENV=dev
        APP_SECRET=secret
        APP_RUNTIME_ENV=dev
        APP_RUNTIME_MODE=web
        ###< symfony/framework-bundle ###
        
        ###> doctrine/doctrine-bundle ###
        DATABASE_URL="pgsql://root:root@db:5432/apcompany"
        ###< doctrine/doctrine-bundle ###
        
        ###> symfony/messenger ###
        MESSENGER_TRANSPORT_DSN=doctrine://default
        ###< symfony/messenger ###

3. Install dependencies:
    - composer install

4. Run Database Migrations:
    - bin/console doctrine:database:create
    - bin/console doctrine:migrations:migrate

## API Usage
The API endpoints follow RESTful conventions:

### 1. Create an Employee
**Request:**
```http
POST /api/employees
Content-Type: application/json

{
  "firstName": "John",
  "lastName": "Doe",
  "email": "john@example.com",
  "hiredAt": "2025-04-01T00:00:00+00:00",
  "salary": 150
}
```

**Response:**
```json
{
  "id": 1,
  "firstName": "John",
  "lastName": "Doe",
  "email": "john@example.com",
  "hiredAt": "2025-04-01T00:00:00+00:00",
  "salary": 150,
  "createdAt": "2025-04-01T12:00:00+00:00",
  "updatedAt": "2025-04-01T12:05:00+00:00"
}

```

### 2. Retrieve an Employee
```http
GET /api/employees/{id}
```

### 3. Update an Employee
```http
PUT /api/employees/{id}
Content-Type: application/json

{
  "firstName": "Den",
  "lastName": "Joe",
  "email": "den.joe@example.com",
  "hiredAt": "2025-04-01T00:00:00+00:00",
  "salary": 200
}

```

### 4. Delete an Employee
```http
DELETE /api/employees/{id}
```

**Swagger UI: `/api/docs`**

---

## Manual API Testing

A sample `api.http` file is included in the repository, which uses global variables for the host and stores the last created employee ID for subsequent requests.

### Execute Unit & Functional Tests
To run tests inside the Docker container:
```sh
docker-compose exec php bin/phpunit
```

To see detailed output, use:
```sh
docker-compose exec php bin/phpunit --debug
```

---

## Notes
- This is a simple version of the Employee API using API Platform.
- For enhanced API documentation and additional features, consider exploring more advanced configuration options in API Platform.
- If you encounter any issues or need further customization, refer to the official API Platform documentation.