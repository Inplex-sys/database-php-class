# Mysql Database Class

#### Init the database object
```php
require 'class/database.class.php'

$GLOBALS['MYSQL'] = new Database(
	"localhost",
	"database",
	"username",
	"password"
);
```

#### Getting data from SQL tables
```php
// returning an array of all the table content
$GLOBALS['MYSQL']->getContent("table");

// returning an array of all the table content where exemple_colum is equal to 30
$GLOBALS['MYSQL']->getContent("table", ["exemple_colum" => 30]);
```

#### Inserting data into database
```php
// Inserting a new line to the table with exemple_colum equal to 30
$GLOBALS['MYSQL']->Insert("table", [
	"exemple_colum" => 30
]);

// Inserting a new line to the table with exemple_colum equal to 30 without the XSS filter
$GLOBALS['MYSQL']->Insert("table", [
	"exemple_colum" => 30
], false);
```

#### Updating data into database
```php
// Put 60 in the column exemple_colum whre exemple_colum equal to 30
$GLOBALS['MYSQL']->update("table", [
	"exemple_colum" => 30
], [
	"exemple_colum" => 60
]);

// Put 60 in the column exemple_colum whre exemple_colum equal to 30 without the XSS filter
$GLOBALS['MYSQL']->update("table", [
	"exemple_colum" => 30
], [
	"exemple_colum" => 60
], false);
```


#### Delete a line
```php
// Delete lines where exemple_colum equal to 60
$GLOBALS['MYSQL']->delete("table", [
	"exemple_colum" => 60
]);
```
