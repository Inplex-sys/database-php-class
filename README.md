# Mysql Database Class

```php
require 'class/database.class.php'

// Init the database object
$GLOBALS['MYSQL'] = new Database(
	"localhost",
	"database",
	"username",
	"password"
);
```
```php
// Getting data from SQL tables

// returning an array of all the table content
$GLOBALS['MYSQL']->getContent("table");

// returning an array of all the table content where exemple_colum is equal to 30
$GLOBALS['MYSQL']->getContent("table", ["exemple_colum" => 30]);
```
