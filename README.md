# Phequel

[![Build Status](https://travis-ci.org/ejacobs/querybuilder.svg?branch=master)](https://travis-ci.org/ejacobs/querybuilder)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/ejacobs/querybuilder/master/LICENSE.md)

## About Phequel

Phequel is a framework agnostic query builder for PHP. 

## Examples

### SELECT
```php
use Ejacobs\QueryBuilder\Query\Postgres\PostgresSelectQuery;

$select = new PostgresSelectQuery();
$select->select('foo')
    ->from('mytable')
    ->where('foo = ?', 'bar');
    
echo $select;
print_r($select->getParams());
```

### UPDATE
```php
use Ejacobs\QueryBuilder\Query\Postgres\PostgresUpdateQuery;

$update = new PostgresUpdateQuery();
$update->update('table1')
    ->set('foo', 'bar')
    ->where('somecolumn = ?', 'x');
    
echo $update;
print_r($update->getParams());
```

### INSERT
```php
use Ejacobs\QueryBuilder\Query\Postgres\PostgresInsertQuery;

$insert = new PostgresInsertQuery();
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
use Ejacobs\QueryBuilder\Query\Postgres\PostgresDeleteQuery;

$delete = new PostgresSDeleteQuery();
$delete->from('mytable')
    ->where('foo = ?', 'bar');
    
echo $delete;
print_r($delete->getParams());
```