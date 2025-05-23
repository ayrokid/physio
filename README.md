## API Documentation

### Endpoints

#### 1. Get All Patients
**Endpoint:** `GET /api/patient`  
**Description:** Retrieve a list of all patients.  
**Response:**
```json
{
    "success": true,
    "message": "Patient successfully",
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "medium_acquisition": "Online",
            "user": {
                "id": 1,
                "uuid": "123e4567-e89b-12d3-a456-426614174000",
                "name": "John Doe",
                "id_type": "Passport",
                "id_no": "A12345678",
                "gender": "Male",
                "dob": "1990-01-01",
                "address": "123 Main St"
            }
        }
    ]
}
```

#### 2. Create a Patient
**Endpoint:** `POST /api/patient`  
**Description:** Create a new patient.  
**Request Body:**
```json
{
    "name": "John Doe",
    "id_type": "Passport",
    "id_no": "A12345678",
    "gender": "Male",
    "dob": "1990-01-01",
    "address": "123 Main St",
    "medium_acquisition": "Online"
}
```
**Response:**
```json
{
    "success": true,
    "message": "Patient created successfully",
    "data": {
        "patient": {
            "id": 1,
            "user_id": 1,
            "medium_acquisition": "Online"
        },
        "user": {
            "id": 1,
            "uuid": "123e4567-e89b-12d3-a456-426614174000",
            "name": "John Doe",
            "id_type": "Passport",
            "id_no": "A12345678",
            "gender": "Male",
            "dob": "1990-01-01",
            "address": "123 Main St"
        }
    }
}
```

#### 3. Get a Patient by UUID
**Endpoint:** `GET /api/patient/{uuid}`  
**Description:** Retrieve a specific patient by UUID.  
**Response:**
```json
{
    "id": 1,
    "user_id": 1,
    "medium_acquisition": "Online",
    "user": {
        "id": 1,
        "uuid": "123e4567-e89b-12d3-a456-426614174000",
        "name": "John Doe",
        "id_type": "Passport",
        "id_no": "A12345678",
        "gender": "Male",
        "dob": "1990-01-01",
        "address": "123 Main St"
    }
}
```

#### 4. Update a Patient
**Endpoint:** `PUT /api/patient/{uuid}`  
**Description:** Update an existing patient.  
**Request Body:**
```json
{
    "name": "Jane Doe",
    "id_type": "ID Card",
    "id_no": "B98765432",
    "gender": "Female",
    "dob": "1992-02-02",
    "address": "456 Elm St",
    "medium_acquisition": "Referral"
}
```
**Response:**
```json
{
    "success": true,
    "message": "Patient updated successfully",
    "data": {
        "patient": {
            "id": 1,
            "user_id": 1,
            "medium_acquisition": "Referral",
            "created_at": "2025-05-13T00:00:00.000000Z",
            "updated_at": "2025-05-13T00:00:00.000000Z"
        },
        "user": {
            "id": 1,
            "uuid": "123e4567-e89b-12d3-a456-426614174000",
            "name": "Jane Doe",
            "id_type": "ID Card",
            "id_no": "B98765432",
            "gender": "Female",
            "dob": "1992-02-02",
            "address": "456 Elm St"
        }
    }
}
```

#### 5. Delete a Patient
**Endpoint:** `DELETE /api/patient/{uuid}`  
**Description:** Delete a patient by UUID.  
**Response:**
```json
{
    "success": true,
    "message": "Patient deleted successfully"
}
```

### Error Responses
- **400 Bad Request:** Invalid input or UUID format.
- **404 Not Found:** Patient not found.
- **500 Internal Server Error:** Server error during processing.

### Notes
- Ensure to include the `Content-Type: application/json` header for POST and PUT requests.
- Replace `{uuid}` with the actual UUID of the patient in the endpoint URL.


### Authentication

All API requests must include a valid `token` in the request header for authentication. The token is validated against the `ACCESS_KEY` defined in the environment file (`.env`).

#### Example Header
```http
Authorization: <token>
```

#### Error Responses for Authentication
- **401 Unauthorized:** Invalid or missing token.
  ```json
  {
      "message": "Unauthorized - Invalid Token Access Key"
  }
  ```

### Testing with cURL

You can test the API endpoints using `curl`. Below is an example of how to make a request to the API:

#### Example: Update a Patient
```bash
curl --location --request PUT 'https://physio.klinikkoding.com/api/patient/{uuid}' \
--header 'Authorization: 1234567890987654321' \
--header 'Content-Type: application/json' \
--data '{
  "name": "John Doe update",
  "id_type": "KTP",
  "id_no": "1234567890",
  "gender": "male",
  "dob": "1990-01-15",
  "address": "Jakarta",
  "medium_acquisition": "Facebook Ads"
}'
```

#### Explanation:
- Replace `{uuid}` in the URL with the actual UUID of the patient.
- The `Authorization` header must contain a valid token (`1234567890987654321` in this example).
- The `Content-Type` header ensures the request body is sent as JSON.
- The `--data` flag contains the JSON payload for the request.

#### Response:
```json
{
    "success": true,
    "message": "Patient updated successfully",
    "data": {
        "patient": {
            "id": 1,
            "user_id": 1,
            "medium_acquisition": "Facebook Ads",
            "created_at": "2025-05-13T00:00:00.000000Z",
            "updated_at": "2025-05-13T00:00:00.000000Z"
        },
        "user": {
            "id": 1,
            "uuid": "123e4567-e89b-12d3-a456-426614174000",
            "name": "John Doe update",
            "id_type": "KTP",
            "id_no": "1234567890",
            "gender": "male",
            "dob": "1990-01-15",
            "address": "Jakarta"
        }
    }
}
```

### Notes
- Ensure the `ACCESS_KEY` is properly set in the `.env` file.
- Replace `{uuid}` and `<token>` with the actual values for your API.
- Host: `https://physio.klinikkoding.com`
- Authorization: `1234567890987654321`