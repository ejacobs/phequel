# Phequel

[![Build Status](https://travis-ci.org/ejacobs/phequel.svg?branch=master)](https://travis-ci.org/ejacobs/phequel)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/ejacobs/phequel/master/LICENSE.md)

## About Phequel

Phequel is a framework agnostic query builder for PHP. 

## Examples

### SELECT
```php
use Ejacobs\Phequel\Query\Psql\PsqlSelectQuery;

$select = new PsqlSelectQuery();
$select->select('foo')
    ->from('mytable')
    ->where('foo', '=', 'bar');
    
echo $select;
print_r($select->getParams());

$select = new PsqlSelectQuery();
$select->whereAny(function($conditions) {
    $condition->where('foo', '=', 'bar');
    $condition->where('bar', '=', 'baz');
    $condition->whereAll(function($conditions) {
        $conditions->where('age', '>', 30);
        $conditions->where('rank', '<', 10);
    });
});

```

### UPDATE
```php
use Ejacobs\Phequel\Query\Psql\PsqlUpdateQuery;

$update = new PsqlUpdateQuery();
$update->update('table1')
    ->set('foo', 'bar')
    ->where('somecolumn', '=', 'x');
    
echo $update;
print_r($update->getParams());
```

### INSERT
```php
use Ejacobs\Phequel\Query\Psql\PsqlInsertQuery;

$insert = new PsqlInsertQuery();
$insert->into('table1')
    ->columns(['column1', 'column2'])
    ->addRow([
      'column1' => 'value1',
      'column2' => 'value2'
    ]);
    
echo $insert;
print_r($insert->getParams());
```

### DELETE
```php
use Ejacobs\Phequel\Query\Psql\PsqlDeleteQuery;

$delete = new PsqlDeleteQuery();
$delete->from('mytable')
    ->where('foo', '=', 'bar');
    
echo $delete;
print_r($delete->getParams());
```

### Running queries
Phequel comes with its own connector to run the generated queries and return the result.
```php
use Ejacobs\Phequel\Query\Psql\PsqlSelectQuery;
use Ejacobs\Phequel\Connector\PdoConnector;

$select = new PsqlSelectQuery();
$select->from('mytable')->where('id', '=', 94);

$conn = new PdoConnector(<driver>, [
    'host'     => '<host>',
    'port'     => '<port>',
    'dbname'   => '<dbname>',
    'user'     => '<user>',
    'password' => '<password>'
]);

print_r($conn->firstRow($select));
```