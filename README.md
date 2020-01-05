# Code Test

**Please document any assumptions and limitations for all of your given solutions.**

## Part A

Given a string with mixed delimiters and unknown order as input, return a JSON string as the output. 

Output should be structured and values should be type coerced and rounded as shown below in the *Example output*. 
The exact values shown are not representative of the example input.

##### Example Input:
```
elapsed_time=0.0022132396697998047, type-CNC,radius-1-15,position-1=0.000000000000014,position-1//90,position-2=0%direction-1=-2.0816681711721685e-16
```

##### Example Output:
```json
{
  "data": {
    "features": [
      {
        "id": "1",
        "radius": 43,
        "direction": -1.0415681311891685e-16,
        "position": [0, 90, 90]
      },
      {
        "id": "2",
        "position": [0]
      }
    ],
   "elapsed_time": 0.001581,
   "type": "cnc",
   "feature_count": 2
  }
}
```

You can complete the above test in your choice of language. Bear in mind internally we use PHP (Laravel), Python (Flask)
 & JavaScript (Vue).
 
You will be marked based on your adherence to the example output and the robustness of your answer. 
To allow us to get a good understanding of your professional work please provide a solution you would be happy for a 
colleague to continue to maintain and scale.

### Extension

Code, or describe how you would, implement your given solution as an API endpoint.

## Part B

Given the following tables, using a MySQL Query, produce the result shown in the *Desired Output*.

*This should be a raw MySQL Query and not make use of any ORM.*

##### Desired Output:

Result Table:
```
id      name                role    email                   company_name        registered_on        last_login
4       Myrtis Klein        buyer   myrtis@yahoo.com        Wilderman-Heller    2018-07-15 13:08:57  2019-09-13 09:42:21
2       Candelario Rempel   vendor  c.rempel@hotmail.com    Mertz-Bradtke       2018-04-20 14:59:21  2019-09-12 16:20:55
3       Nelson Powlowski    buyer   nelson.pow@gmail.com    Kertzmann LLC       2018-05-29 15:14:50  2019-09-12 10:66:12
1       Viva Ratke          admin   viva.ratke@gmail.com    Hartmann-Wiegand    2018-04-08 16:53:43  2019-08-10 09:11:34
```

##### Provided Tables

*Note that you are not allowed to add additional records to the tables.*

Users Table:
```
id      name                email                   password            created_at           last_login
1       Viva Ratke          viva.ratke@gmail.com    $2y$10$7j8Wcokg     2018-04-08 16:53:43  2019-08-10 09:11:34
2       Candelario Rempel   c.rempel@hotmail.com    $2y$10$7j8Wcokg     2018-04-20 14:59:21  2019-09-12 16:20:55
3       Nelson Powlowski    nelson.pow@gmail.com    $2y$10$7j8Wcokg     2018-05-29 15:14:50  2019-09-12 10:66:12
4       Myrtis Klein        myrtis@yahoo.com        $2y$10$7j8Wcokg     2018-07-15 13:08:57  2019-09-13 09:42:21
```

Profiles Table
```
id      user_id     company_name        created_at 
1       1           Hartmann-Wiegand    2018-04-08 16:53:43
2       2           Mertz-Bradtke       2018-04-20 14:59:21
3       3           Kertzmann LLC       2018-05-29 15:14:50
4       4           Wilderman-Heller    2018-07-15 13:08:57
```

Roles Table
```
id      name     created_at 
1       admin    2017-04-08 16:53:43
2       vendor   2017-04-20 14:59:21
```

Model Has Roles Table
```
role_id     model_type          model_id    created_at
1           App\Models\User     1           2017-04-08 16:53:43
2           App\Models\User     2           2017-04-20 14:59:21
```

### Extension

Code, or describe how you would, implement your given solution as a response to a CLI command. Assume that it will be 
run daily, by multiple developers, and so should be convenient.
