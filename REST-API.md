# REST-API

## Contacts

### Get Contact List

#### Request

`GET /api/contact`

```sh
curl -X GET http://localhost:8000/api/contact \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d "name=" \
    -d "email=" \
    -d "limit=10"
```

#### Response

```sh
HTTP/1.1 200 OK
Content-Type: application/json;
Date: Fri, 01 Jul 2022 21:40:18 GMT

{
    "data": [
        {
            "id": 1,
            "name": "Daphney Swaniawski",
            "email": "ledner.reed@boyle.biz",
            "created_at": "2024-03-20T07:24:05.000000Z",
            "updated_at": "2024-03-20T07:24:05.000000Z"
        }
    ],
    "links": {
        "first": "http://localhost:8000/api/contact?page=1",
        "last": null,
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "path": "http://localhost:8000/api/contact",
        "per_page": 10,
        "to": 1
    }
}
```

### Create Contact

#### Request

`POST /api/contact`

```sh
curl -X POST http://localhost:8000/api/contact \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{
        "name": "Lanaya",
        "email": "lanaya@mail.com"
    }'
```

#### Response

```sh
HTTP/1.1 201 Created
Content-Type: application/json;
Date: Fri, 01 Jul 2022 21:40:18 GMT

{
    "data": {
        "id": 2,
        "name": "Lanaya",
        "email": "lanaya@mail.com",
        "created_at": "2024-03-20T07:44:53.000000Z",
        "updated_at": "2024-03-20T07:44:53.000000Z"
    }
}
```

### Update Contact

#### Request

`PUT /api/contact/:id`

```sh
curl -X PUT http://localhost:8000/api/contact/2 \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{
        "name": "Lanaya the Templar Assassin",
        "email": "lanaya@mail.com"
    }'
```

#### Response

```sh
HTTP/1.1 204 No Content
Content-Type: application/json;
Date: Fri, 01 Jul 2022 21:40:18 GMT
```

### Delete Contact

#### Request

`DELETE /api/contact/:id`

```sh
curl -X DELETE http://localhost:8000/api/contact/2 \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
```

#### Response

```sh
HTTP/1.1 204 No Content
Content-Type: application/json;
Date: Fri, 01 Jul 2022 21:40:18 GMT
```
