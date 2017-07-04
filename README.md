php-sphinxsearch
===============

PHP wrapper to sphinx search pecl extension. Working with search results as objects.

Installation
------------

You need to have sphinx pecl extension installed. For Ubuntu or Debian based distributives:
```
$ sudo apt-get install php5-dev php-pear libsphinxclient-dev
$ sudo pecl install sphinx
```

Add requirement to your composer:
```javascript
{
    "require": {
        "sokil/php-sphinxsearch": "dev-master"
    }
}
```


Basic Usage
-----------

```php
$qf = new QueryFactory('127.0.0.1', '23023');
        
$resultSet = $qf->find()
    ->in('idx_posts')
    ->match('If you can')
    ->fetch();
```
