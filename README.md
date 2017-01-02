# Phequel
A fluent PHP query builder
[![Build Status](https://travis-ci.org/ejacobs/querybuilder.svg?branch=master)](https://travis-ci.org/ejacobs/querybuilder)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/ejacobs/querybuilder/master/LICENSE.md)

Phequel is a framework agnostic query builder for PHP. 

## Examples

```php
use Ejacobs\QueryBuilder\Query\Postgres\PostgresSelectQuery;

$query = new PostgresSelectQuery();

$query->select('foo')
    ->from('mytable')
    ->where('foo = ?', 'bar');
    
echo $query;
print_r($query->getParams());

```