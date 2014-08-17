php-spinxsearch
===============

PHP wrapper to sphinx search pecl extension. Wotking with search results as objects.

Basic Usage
-----------

```php
$qf = new QueryFactory('127.0.0.1', '23023');
        
$resultSet = $qf->find()
    ->in('idx_posts')
    ->match('If you can')
    ->fetch();
```
