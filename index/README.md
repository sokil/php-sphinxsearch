This files used to initialise test environment.

First initialise mysql db. This loads content of dump.sql to sphinx database. 
User "sphinx" with password "sphinx" must be created before
```
$ ./initdb.sh
```

Then reinder database to sphinx index:
```
$ ./reindex.sh
```

Then start server:
```
$ ./runserver.sh
```
