# Prerequirements

This setup uses docker to spin up php 7.3 container

Requirements:

- [Docker + docker-compose installed](https://docs.docker.com/install/)

## Setting up

### 1. Building the app

This step will:

- build images for php container
- install dependencies for the PHP app

Execute:

```bash
./run.sh install
```

### 2. Running the app

Execute:

```bash
./run.sh dev
```

# About

This repository contains solutions for technical tasks for Geomiq interview.

## Why PHP?

This test is for a Senior PHP engineer position, thus PHP was chosen for the solution

## Why Lumen?

- Geomiq uses Laravel internally
- ...Laravel however introduces too much overhead for such a small application. Which is why I chose Lumen as it's significantly smaller than Laravel (performance overhead, cognitive overhead), uses Laravel components - mainly the console components which help out a ton with the tasks presented.
- If I didn't use Lumen I would have to handle CLI input myself or through the usage of another library. Lumen does not have much of an overhead in comparison to such libraries at the same time saving me time; thus the choice.

## Task A
To execute the command make sure the container is running, then ssh into it
```
docker-exec -it geomiq-service /bin/bash
```
Then run the command like
```
php artisan php artisan features:map-to-json "string-to-parse"
```

You can also execute the tests, like so:
```
./vendor/bin/phpunit
```
### Extension - implementing an API endpoint
Since Laravel nor Lumen implements PSR7 we can:

1. Either Fetch string from the request input and call FeaturesListBuilder::build with the string
2. Implement PSR7 in commands and controllers, in which case the handler is the same - we don't have to change anything, just pass the handler to router

If we are following RESTful API design could be as follows (swagger docs):
```
swagger: "2.0"
info:
  description: "Documentation for BookLovr API"
  version: "1.0.0"
  title: "Geomiq Features API"
host: "booklovr.local"
basePath: "/"
paths:
  /geofeatures:
    get:
      tags:
      - "geo"
      summary: "Get mapped GeoFeatures"
      description: ""
      operationId: "getGeoFeatures"
      consumes:
      - "application/json"
      produces:
      - "application/json"
      parameters:
        - in: query
          name: input_string
          type: string
          description: Input string to do mapping for
      responses:
        200:
          description: OK
          schema:
            $ref: "#/definitions/MappedGeofeatures"
definitions:
  MappedGeofeatures:
    type: "object"
    properties:
      data:
        type: "object"
        
```
 
## Task B
The following query can be used to produce a view as desired:
```
SELECT DISTINCT users.id,
                users.name,
                CASE
                	WHEN roles.name is null THEN 'buyer'
                	ELSE roles.name
                END as role,
                users.email,
                profiles.company_name,
                users.created_at AS registered_on,
                users.last_login AS last_login
FROM users
LEFT JOIN profiles ON (users.id = profiles.user_id)
LEFT JOIN roles ON (roles.id = profiles.id)
LEFT JOIN model_has_roles ON (users.id = model_has_roles.model_id)
ORDER BY profiles.company_name DESC
```

### Extension - implementing a CLI command
How would I implement this for daily use:
1. Using Eloquent query builder:
    - query builder has little to no overhead in comparison to raw PDO statements. If we cannot use models I would at least try to convince the team to go for Repository pattern & QueryBuilder inside of it generating the query
    - I would inject the repository to the command via constructor injection
    - I would display the results using inbuild Lumen/Laravel CLI output **table()** function

This has the following benefits instead of using prepared statements ourselves:
- eloquent does actually use prepared statements in the background, however using QueryBuilder will add a layer of abstraction and security. There's less of a chance engineer that works on it next time will introduce a security issue, eg. SQL injection
- less cognitive load on the engineers, as the query is written semantically with the builder pattern that QueryBuilder implements
- more easilly testable, as QueryBuilder is easilly mockable
## Limitations & assumptions for task A
### Assumptions
1. The first word in the string is a key name (as called in the code: feature name)
2. Assumptions about values:

    ⋅⋅1. N elements from the feature value until next string are treated as feature values
    
    ⋅⋅2. If there are more than 1 values for the feature name - first value is treated as a key 
    
    Eg. 
    
   ```
   feature_name-1-2=3-second_one%2.21 
   ```
   Translates into
   ```
   {
      'data' : {
          'features' => [
                {
                    'id': '1',
                    'feature_name': [2, 3]
                }
          ],
          second_one: 2.21
      }
   }
   ```
### Limitations
It's quite difficult to sanitize the input string, considering I do not have enough information to assume it's format.

- until further instructions about potential formats are provided, or for example metadata to validate the mapping with, the solution will never be too robust as we do not have a way to validate
- given the beforementioned we could easilly enhance the solution by implementing, for example, factory pattern for sanitizers
- To be honest I am not that great with Regexp, sadly my solution does not work with ScientificNotation for floats. There's a test for it, but it's failing right now. Given the sanitization regexp to be improved the test would pass as well 😅 

