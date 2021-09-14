# Cashew Nuts Stock REST API
PHP based REST API for Stock Management


## Implementation
PHP Framework: Laravel


## Installation

Clone repo and add .env file with databse credentials.

```
composer install
php artisan migrate --path=database/migrations/2021_09_12_102726_create_brands_table.php
php artisan migrate --path=database/migrations/2021_09_12_094220_create_locations_table.php
php artisan migrate --path=database/migrations/2021_09_13_170419_create_qualities_table.php
php artisan migrate --path=database/migrations/2021_09_12_103141_create_varieties_table.php
php artisan serve
```


## API Endpoints
The API provides the following endpoints.

# Add variety stock
Creates and returns created variety along with ID and other attributes.

Request
`POST /api/stock`

```
{
	"brand": "Laravel", // Required
	"quality": "B-100", // Required
	"location": "Margao, Goa", // Required
	"stock": 5,
	"price": 24.5
}
```

Headers
`Content-Type: application/json`

Response
```{
  "id": 11,
  "brand": "Laravel",
  "location": "Margao, Goa",
  "quality": "B-100",
  "stock": 5,
  "price": "24.50",
  "created_at": "2021-09-14 18:08:09",
  "updated_at": "2021-09-14 18:08:09"
}```

# Update variety stock
Updates and returns existing variety with updated attributes.

Request
`PUT /api/stock/{id}`

```{
	"brand": "Laravel", // Required
	"quality": "A-200", // Required
	"location": "Panjim, Goa", // Required
	"price": 22.4,
	"stock": 56
}```

Headers
`Content-Type: application/json`

Response
```{
  "id": 8,
  "brand": "Laravel",
  "location": "Panjim, Goa",
  "quality": "A-200",
  "stock": 56,
  "price": "22.40",
  "created_at": "2021-09-14 18:02:29",
  "updated_at": "2021-09-14 18:16:53"
}```

# Search variety stock to check availability based on attributes
Searches varieties with matching attributes and returns a list of results.

Request
`GET /api/availability`

```{
	"brand": "Laravel", // Any one required
	"quality": "B-100", // Any one required
	"location": "Margao, Goa" // Any one required
}```

Headers
`Content-Type: application/json`

Response
```[
  {
    "id": 2,
    "brand": "Zantye",
    "location": "Vasco, Goa",
    "quality": "B-30",
    "stock": 5,
    "price": "24.50",
    "created_at": "2021-09-14 17:54:21",
    "updated_at": "2021-09-14 17:54:21"
  }
]```


## API request and response formats
JSON requests and responses. 

### Request
For a single variety
```{
	"brand": "Vedanka", // Brand name - String
	"quality": "A-100", // Quality name - String
	"location": "Panjim, Goa", // Address - String
	"stock": 5, // Quantity - Integer
	"price": 24.5 // Price - Decimal
}```

### Response
For a single variety
```{
  "id": 1, // Variety ID
  "brand": "Vedanka", // Brand name
  "location": "Panjim, Goa", // Address
  "quality": "AB-200", // Quality name
  "stock": 5, // Quantity
  "price": "24.50", // Price
  "created_at": "2021-09-13 18:27:35", // Created date
  "updated_at": "2021-09-13 18:27:35" // Modified date
}```

### Error Response
```{
  "error": "Variety does not exist" // Error message
}```



