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

### Testing
**Host:** `https://physio.klinikkoding.com`
**token:** `1234567890987654321`