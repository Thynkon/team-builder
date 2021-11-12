# team-builder
## Setup

Install project's dependencies using composer:
```shell
composer install
npm install -g sass
```

And compile scss files thanks to a script I wrote. It will compile all scss files and launch a file
watcher so you can modify files and get them automatically compiled to css.

Type the following at the project's root:
```shell
composer build-css
```

Or, if you want to delete all the old css files, type:
```sh
composer clean-css
```

**IMPORTANT - The command above will only work on UNIX-like operating systems since it executes a bash script.**

Finally, populate the database:
```sh
composer populate-db
```

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

## Hacks used in this project
As you can see in every folder under **resources/<folder_name>** there is a file called **style.php**.
This file is used to only load the stylesheets required by a specific view. So, every time we want to
render a view, we have to load it and store id in **$data["head"]["css"]**.

The stylesheet is stored under 'head' because html link tags can only be at html request's header.
For data that should be in header, I store it in **$data["head"]** and for data that should be in the
response's body, I store it in **$data["body"]**.
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data["head"]["title"] ?></title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/pure-min.css"
          integrity="sha384-Uu6IeWbM+gzNVXJcM9XV3SohHtmWE+3VGi496jvgX1jyvDTXfdK+rfZc8C1Aehk5" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.6/build/grids-responsive-min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/assets/css/lib/lib.css"/>

    <?= $data["head"]["css"] ?>
</head>
<body>
<?= $data["body"]["content"] ?>
</body>
</html>
```

### Member status
First of all, create the database
```sql
CREATE DATABASE teambuilder;
```

Load database by typing: 
```sh
mysql -u <USER> -p teambuilder < ./backup/teambuilder.sql
```

**IMPORTANT - As you can see above, I used to call 'composer populate-db' to populate the database. But, during the examn I had many SQL errors
so I decided to manually load the database.
Also, since unit tests are not required for the exam, it was not so important to fix the migrations problems.**


There are the modifications that were made to the database in order to
implement the first user story.
```sql
CREATE TABLE IF NOT EXISTS `teambuilder`.`status` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(10) NOT NULL,
    `value` VARCHAR(45) NOT NULL,
    PRIMARY KEY (`id`));

ALTER TABLE `teambuilder`.`members`
    ADD COLUMN `status_id` INT(11) NOT NULL AFTER `role_id`,
ADD INDEX `fk_members_status1_idx` (`status_id` ASC) VISIBLE;

INSERT INTO `teambuilder`.`status` (`slug`, `value`) VALUES ('ACT', 'Active');
INSERT INTO `teambuilder`.`status` (`slug`, `value`) VALUES ('INA', 'Inactive');
INSERT INTO `teambuilder`.`status` (`slug`, `value`) VALUES ('BAN', 'Banned');


SET SQL_SAFE_UPDATES = 0;
UPDATE `teambuilder`.`members` SET status_id = 1;
SET SQL_SAFE_UPDATES = 1;

```

## Hacking on the project
If you want to add features to this project, make sure that you add unit test
and run them by typing the following:
```sh
composer test
```