# Job Board API

## Introduction

This is a Laravel-based RESTful API for managing job listings with advanced filtering capabilities. It implements a job board system using a combination of traditional relational database models and an Entity-Attribute-Value (EAV) structure to handle dynamic job attributes. The API supports complex filtering on job fields, relationships, and EAV attributes, with logical operators and grouping.

## Project Overview

The application manages job listings with the following features:

- Core job details (title, salary, job type, etc.).
- Many-to-many relationships with languages, locations, and categories.
- Dynamic attributes via an EAV system.
- A powerful filtering API endpoint (`GET /api/jobs`) supporting various operators and conditions.

## Requirements

- PHP 8.1 or higher
- Composer (latest version)
- MySQL 5.7 or higher (or compatible database)
- Laravel 11
- Git (for version control)

## Setup Instructions

### Clone the Repository

```bash
git clone https://github.com/Abdulrahman-Abdelrazeq/job-board.git
cd job-board
```

### Install Dependencies

```bash
composer install
```

### Configure Environment

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Update the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_board
DB_USERNAME=root
DB_PASSWORD=
```

Generate an application key:

```bash
php artisan key:generate
```

### Run Migrations and Seed Data

Create the database (e.g., `job_board`) in your MySQL server.
Run migrations and seed the database with sample data:

```bash
php artisan migrate:fresh --seed
```

### Serve the Application

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`.

## API Documentation

### Endpoint: `GET /api/jobs`

Retrieve a paginated list of jobs with advanced filtering capabilities.

### Query Parameters

- `filter`: A string defining the filter conditions (optional).
  - Supports basic fields, relationships, and EAV attributes.
  - Uses operators, logical conditions (`AND`, `OR`), and grouping with parentheses.
- `per_page`: Number of jobs per page (default: 20).

### Response Example

```json
{
    "status": true,
    "message": "Jobs data.",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "Stonemason",
                "description": "Minima quasi est corrupti error iure mollitia. Est incidunt magni autem excepturi. Odit eius cum id amet. Amet doloribus tempore dolores sunt aspernatur.",
                "company_name": "Greenfelder, Berge and Goldner",
                "salary_min": "45245.00",
                "salary_max": "60741.00",
                "is_remote": false,
                "job_type": "full-time",
                "status": "draft",
                "published_at": "2025-03-26T20:12:12.000000Z",
                "created_at": "2025-03-26T20:12:12.000000Z",
                "updated_at": "2025-03-26T20:12:12.000000Z",
                "languages": [
                    {
                        "id": 1,
                        "name": "PHP",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 1,
                            "language_id": 1
                        }
                    }
                ],
                "locations": [
                    {
                        "id": 5,
                        "city": "North Ewald",
                        "state": "Illinois",
                        "country": "Chile",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 1,
                            "location_id": 5
                        }
                    },
                    {
                        "id": 6,
                        "city": "South Odessa",
                        "state": "California",
                        "country": "Monaco",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 1,
                            "location_id": 6
                        }
                    },
                    {
                        "id": 9,
                        "city": "Wardtown",
                        "state": "South Dakota",
                        "country": "Cook Islands",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 1,
                            "location_id": 9
                        }
                    }
                ],
                "categories": [
                    {
                        "id": 2,
                        "name": "Design",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 1,
                            "category_id": 2
                        }
                    },
                    {
                        "id": 5,
                        "name": "HR",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 1,
                            "category_id": 5
                        }
                    }
                ],
                "attribute_values": [
                    {
                        "id": 47,
                        "job_id": 1,
                        "attribute_id": 1,
                        "value": "10",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "attribute": {
                            "id": 1,
                            "name": "years_experience",
                            "type": "number",
                            "options": null,
                            "created_at": "2025-03-26T20:12:12.000000Z",
                            "updated_at": "2025-03-26T20:12:12.000000Z"
                        }
                    }
                ]
            },
            {
                "id": 2,
                "title": "Precision Printing Worker",
                "description": "Numquam itaque architecto repellendus est ipsam similique. Voluptas nobis perferendis at ipsam cumque quia. Ducimus tempore consequuntur assumenda voluptatem at et.",
                "company_name": "Schmitt-Pfannerstill",
                "salary_min": "43112.00",
                "salary_max": "87747.00",
                "is_remote": false,
                "job_type": "full-time",
                "status": "draft",
                "published_at": "2025-03-26T20:12:12.000000Z",
                "created_at": "2025-03-26T20:12:12.000000Z",
                "updated_at": "2025-03-26T20:12:12.000000Z",
                "languages": [
                    {
                        "id": 4,
                        "name": "Java",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 2,
                            "language_id": 4
                        }
                    },
                    {
                        "id": 5,
                        "name": "Ruby",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 2,
                            "language_id": 5
                        }
                    }
                ],
                "locations": [
                    {
                        "id": 1,
                        "city": "Port Lemuel",
                        "state": "Kentucky",
                        "country": "Sao Tome and Principe",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 2,
                            "location_id": 1
                        }
                    },
                    {
                        "id": 8,
                        "city": "Marvinfort",
                        "state": "Mississippi",
                        "country": "Guernsey",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 2,
                            "location_id": 8
                        }
                    }
                ],
                "categories": [
                    {
                        "id": 3,
                        "name": "Marketing",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 2,
                            "category_id": 3
                        }
                    }
                ],
                "attribute_values": [
                    {
                        "id": 23,
                        "job_id": 2,
                        "attribute_id": 2,
                        "value": "Junior",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "attribute": {
                            "id": 2,
                            "name": "seniority_level",
                            "type": "select",
                            "options": "[\"Junior\",\"Mid-Level\",\"Senior\"]",
                            "created_at": "2025-03-26T20:12:12.000000Z",
                            "updated_at": "2025-03-26T20:12:12.000000Z"
                        }
                    }
                ]
            },
            {
                "id": 3,
                "title": "Forging Machine Setter",
                "description": "Quod non impedit placeat natus aut error iure. Dolores ex optio officiis commodi saepe neque. Magnam ex quod excepturi. Quis modi voluptatem quis veritatis.",
                "company_name": "Bogan, Spencer and Bins",
                "salary_min": "48903.00",
                "salary_max": "87430.00",
                "is_remote": true,
                "job_type": "freelance",
                "status": "published",
                "published_at": "2025-03-26T20:12:12.000000Z",
                "created_at": "2025-03-26T20:12:12.000000Z",
                "updated_at": "2025-03-26T20:12:12.000000Z",
                "languages": [
                    {
                        "id": 5,
                        "name": "Ruby",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 3,
                            "language_id": 5
                        }
                    }
                ],
                "locations": [
                    {
                        "id": 6,
                        "city": "South Odessa",
                        "state": "California",
                        "country": "Monaco",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 3,
                            "location_id": 6
                        }
                    }
                ],
                "categories": [
                    {
                        "id": 2,
                        "name": "Design",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 3,
                            "category_id": 2
                        }
                    },
                    {
                        "id": 3,
                        "name": "Marketing",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 3,
                            "category_id": 3
                        }
                    },
                    {
                        "id": 5,
                        "name": "HR",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 3,
                            "category_id": 5
                        }
                    }
                ],
                "attribute_values": [
                    {
                        "id": 14,
                        "job_id": 3,
                        "attribute_id": 1,
                        "value": "15",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "attribute": {
                            "id": 1,
                            "name": "years_experience",
                            "type": "number",
                            "options": null,
                            "created_at": "2025-03-26T20:12:12.000000Z",
                            "updated_at": "2025-03-26T20:12:12.000000Z"
                        }
                    },
                    {
                        "id": 19,
                        "job_id": 3,
                        "attribute_id": 2,
                        "value": "Junior",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "attribute": {
                            "id": 2,
                            "name": "seniority_level",
                            "type": "select",
                            "options": "[\"Junior\",\"Mid-Level\",\"Senior\"]",
                            "created_at": "2025-03-26T20:12:12.000000Z",
                            "updated_at": "2025-03-26T20:12:12.000000Z"
                        }
                    },
                    {
                        "id": 28,
                        "job_id": 3,
                        "attribute_id": 2,
                        "value": "Mid-Level",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "attribute": {
                            "id": 2,
                            "name": "seniority_level",
                            "type": "select",
                            "options": "[\"Junior\",\"Mid-Level\",\"Senior\"]",
                            "created_at": "2025-03-26T20:12:12.000000Z",
                            "updated_at": "2025-03-26T20:12:12.000000Z"
                        }
                    },
                    {
                        "id": 29,
                        "job_id": 3,
                        "attribute_id": 1,
                        "value": "16",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "attribute": {
                            "id": 1,
                            "name": "years_experience",
                            "type": "number",
                            "options": null,
                            "created_at": "2025-03-26T20:12:12.000000Z",
                            "updated_at": "2025-03-26T20:12:12.000000Z"
                        }
                    }
                ]
            },
            {
                "id": 4,
                "title": "Shear Machine Set-Up Operator",
                "description": "Omnis voluptatibus adipisci maxime. Tempore pariatur id sunt facilis sit modi. Repudiandae sequi consequatur eaque ipsum magni.",
                "company_name": "Willms and Sons",
                "salary_min": "34999.00",
                "salary_max": "50591.00",
                "is_remote": true,
                "job_type": "full-time",
                "status": "published",
                "published_at": "2025-03-26T20:12:12.000000Z",
                "created_at": "2025-03-26T20:12:12.000000Z",
                "updated_at": "2025-03-26T20:12:12.000000Z",
                "languages": [
                    {
                        "id": 2,
                        "name": "JavaScript",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 4,
                            "language_id": 2
                        }
                    }
                ],
                "locations": [
                    {
                        "id": 7,
                        "city": "Port Aidan",
                        "state": "Nevada",
                        "country": "Botswana",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 4,
                            "location_id": 7
                        }
                    },
                    {
                        "id": 8,
                        "city": "Marvinfort",
                        "state": "Mississippi",
                        "country": "Guernsey",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 4,
                            "location_id": 8
                        }
                    },
                    {
                        "id": 10,
                        "city": "Nathanielton",
                        "state": "Alaska",
                        "country": "Libyan Arab Jamahiriya",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 4,
                            "location_id": 10
                        }
                    }
                ],
                "categories": [
                    {
                        "id": 1,
                        "name": "Development",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 4,
                            "category_id": 1
                        }
                    },
                    {
                        "id": 2,
                        "name": "Design",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 4,
                            "category_id": 2
                        }
                    },
                    {
                        "id": 3,
                        "name": "Marketing",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 4,
                            "category_id": 3
                        }
                    }
                ],
                "attribute_values": []
            },
            {
                "id": 5,
                "title": "Home Appliance Installer",
                "description": "Earum et nostrum eos ab molestiae. Eos omnis voluptatum non at soluta magnam. Deleniti omnis blanditiis vel suscipit.",
                "company_name": "Veum, Graham and Price",
                "salary_min": "34924.00",
                "salary_max": "87601.00",
                "is_remote": false,
                "job_type": "contract",
                "status": "published",
                "published_at": "2025-03-26T20:12:12.000000Z",
                "created_at": "2025-03-26T20:12:12.000000Z",
                "updated_at": "2025-03-26T20:12:12.000000Z",
                "languages": [
                    {
                        "id": 1,
                        "name": "PHP",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 5,
                            "language_id": 1
                        }
                    },
                    {
                        "id": 3,
                        "name": "Python",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 5,
                            "language_id": 3
                        }
                    },
                    {
                        "id": 5,
                        "name": "Ruby",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 5,
                            "language_id": 5
                        }
                    }
                ],
                "locations": [
                    {
                        "id": 1,
                        "city": "Port Lemuel",
                        "state": "Kentucky",
                        "country": "Sao Tome and Principe",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 5,
                            "location_id": 1
                        }
                    },
                    {
                        "id": 4,
                        "city": "West Jaden",
                        "state": "Minnesota",
                        "country": "Jordan",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 5,
                            "location_id": 4
                        }
                    }
                ],
                "categories": [
                    {
                        "id": 1,
                        "name": "Development",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 5,
                            "category_id": 1
                        }
                    },
                    {
                        "id": 2,
                        "name": "Design",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "pivot": {
                            "job_id": 5,
                            "category_id": 2
                        }
                    }
                ],
                "attribute_values": [
                    {
                        "id": 16,
                        "job_id": 5,
                        "attribute_id": 2,
                        "value": "Junior",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "attribute": {
                            "id": 2,
                            "name": "seniority_level",
                            "type": "select",
                            "options": "[\"Junior\",\"Mid-Level\",\"Senior\"]",
                            "created_at": "2025-03-26T20:12:12.000000Z",
                            "updated_at": "2025-03-26T20:12:12.000000Z"
                        }
                    },
                    {
                        "id": 43,
                        "job_id": 5,
                        "attribute_id": 2,
                        "value": "Senior",
                        "created_at": "2025-03-26T20:12:12.000000Z",
                        "updated_at": "2025-03-26T20:12:12.000000Z",
                        "attribute": {
                            "id": 2,
                            "name": "seniority_level",
                            "type": "select",
                            "options": "[\"Junior\",\"Mid-Level\",\"Senior\"]",
                            "created_at": "2025-03-26T20:12:12.000000Z",
                            "updated_at": "2025-03-26T20:12:12.000000Z"
                        }
                    }
                ]
            }
        ],
        "first_page_url": "http://127.0.0.1:8000/api/jobs?page=1",
        "from": 1,
        "last_page": 10,
        "last_page_url": "http://127.0.0.1:8000/api/jobs?page=10",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=3",
                "label": "3",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=4",
                "label": "4",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=5",
                "label": "5",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=6",
                "label": "6",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=7",
                "label": "7",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=8",
                "label": "8",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=9",
                "label": "9",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=10",
                "label": "10",
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/jobs?page=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": "http://127.0.0.1:8000/api/jobs?page=2",
        "path": "http://127.0.0.1:8000/api/jobs",
        "per_page": 5,
        "prev_page_url": null,
        "to": 5,
        "total": 50
    }
}
```

## Filter Syntax

### Supported Fields

- **Basic Fields**: `title`, `description`, `company_name`, `salary_min`, `salary_max`, `is_remote`, `job_type`, `status`, `published_at`
- **Relationships**: `languages`, `locations`, `categories`
- **EAV Attributes**: `attribute:<name>` (e.g., `attribute:years_experience`)

### Operators

| Type              | Supported Operators                |
| ----------------- | ---------------------------------- |
| **Text**          | `=`, `!=`, `LIKE`                  |
| **Number**        | `=`, `!=`, `>`, `<`, `>=`, `<=`    |
| **Boolean**       | `=`, `!=`                          |
| **Enum**          | `=`, `!=`, `IN`                    |
| **Date**          | `=`, `!=`, `>`, `<`, `>=`, `<=`    |
| **Relationships** | `=`, `HAS_ANY`, `IS_ANY`, `EXISTS` |

### Logical Operators

- **AND**: Combines conditions conjunctively.
- **OR**: Combines conditions disjunctively.
- **Grouping**: Use parentheses `()` for nested conditions.

### Example Queries

#### **Full-time jobs requiring PHP or JavaScript**

```http
GET /api/jobs?filter=(job_type=full-time AND (languages HAS_ANY (PHP,JavaScript)))
```

#### **Remote jobs in New York or San Francisco with 3+ years experience**

```http
GET /api/jobs?filter=(is_remote=1 AND (locations IS_ANY (New York,San Francisco)) AND attribute:years_experience>=3)
```

#### **Published jobs with "developer" in the title**

```http
GET /api/jobs?filter=(status=published AND title LIKE developer)
```

#### **Jobs posted after March 1, 2025, in Engineering category**

```http
GET /api/jobs?filter=(published_at>2025-03-01 AND categories HAS_ANY (Engineering))
```

## Database Design

### Tables

- **jobs**: Core job data.
- **languages, locations, categories**: Many-to-many relationships with jobs via pivot tables.
- **attributes**: EAV attribute definitions.
- **job\_attribute\_values**: EAV values.

### Indexing Strategy

- Indexes on `salary_min` and `salary_max` for range queries.
- Composite indexes on pivot tables for efficient relationship filtering.

## Assumptions and Design Decisions

- **Filter Parsing**: Custom recursive parser to handle nested conditions.
- **EAV Implementation**: Values stored as strings with type casting in the model.
- **Performance**: Indexes optimized for filtering, avoiding `N+1 query` issues with eager loading.
- **Trade-offs**: Prioritizes flexibility over strict validation.

## Running Tests

Test the API with seeded data:

```bash
curl "http://localhost:8000/api/jobs?filter=(job_type=full-time AND (languages HAS_ANY (PHP,JavaScript)))"
```

Use the provided Postman collection for pre-configured requests.

## Test API request in Documentation

https://abdelrahman.apidog.io/

##

