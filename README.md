<h1>Project description</h1>

API returning contacts from database.
JSON array string is always returned.
Requests must be sent as POST requests.

<h2>Version</h2>
1.1


<h1>Sending valid login data</h1>

You must always send header:
``
Content-Type: application/json
``

And login data form is:
````
[{"username":string, "password":string}]
````

<h1>Data returned</h1>

**Example of JSON array returned from API**

````
[
    ...
    {
        "id": 1,
        "name": "Name",
        "surname": "Surname",
        "nickname": "Nickname",
        "email": "name.surname@example.com",
        "mobileNumber": "064123456789",
        "imgPath": "url-to-image"
    },
    {
        "id": 2,
        "name": "Name2",
        "surname": "Surname2",
        "nickname": "Nickname2",
        "email": "name.surname2@example.com",
        "mobileNumber": "064123456788",
        "imgPath": "url-to-image2"
    },
    ...
]
````

JSON Objects packed in array have form of:
````
{
    "id": integer,
    "name": string,
    "surname": string,
    "nickname": string,
    "email": string,
    "mobileNumber": string,
    "imgPath": string
}
````

In case of user not found, API returns following JSON array:
````
[
    {
        "login": false
    },
    {
        "msg": string
    }
]
````

In case of bad request, API returns following JSON array:
````
[
    {
        "login": false
    },
    {
        "msg": "Bad request method. Must be POST",
        "requestMethod": string
    }
]
````