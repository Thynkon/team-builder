# team-builder
## Setup
In order to be automatically logged-in, you have to add to **.env.php** your database id. Here is an example of how to do it:
```php
define('USER_ID', <YOUR_DATABASE_ID>);
```

The HomePageController loads it, looks for a member with that USER_ID