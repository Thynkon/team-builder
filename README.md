# team-builder
## Setup

### Database credentials
This projects uses PDO as the database connector. In order to connect to a database, you must
set the DSN, the username and his password.

I.e:

```php
DEFINE('DSN', 'mysql:dbname=<YOUR_DATABASE_NAME>;host=127.0.0.1');
DEFINE('USERNAME', '<USERNAME>');
DEFINE('PASSWORD', '<PASSWORD>');
```

### Auto-loggin

In order to be automatically logged-in, you have to add to **.env.php** your database id. Here is an example of how to do it:
```php
define('USER_ID', <YOUR_DATABASE_ID>);
```

The HomePageController loads it, looks for a member with that USER_ID