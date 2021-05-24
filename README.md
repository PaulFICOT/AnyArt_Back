# AnyArt_Back

### Run the server
```shell
php -S localhost:8080 -t public public/index.php
```

### Requirements
- PHP >= 7.3
- MySQL >= 8.0.22
- Composer >= 2.0.9

### Init the project

```shell
composer install
cp .env.example .env
```
Edit .env to set the values corresponding to your device:
- DB_HOST: The database's host  
- DB_USER: The database's user  
- DB_PASS: The database's user's password  
- DB_NAME: The database name
- IMAGES_DEFAULT_LOCATION: The path where the pictures are stored  
_Depending on where the files must be stored, you may have to run the server as root_

#### Database

```
mysql -u [DB_USER] -p
CREATE DATABASE anyart;
quit;
mysql -u [DB_USER] -p < sql/initDB.sql
```

Replace [DB_USER] with your database user

Once done, you can run the server
