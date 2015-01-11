TwitterContestScore
========

Almost realtime scoring aggregation via twitter for the Connichi Exclusive AMV contest but can most possibly used for other contest related stuff 


Minimal requirements
========
PHP 5.4+ with curl and PDO (mysql) extension
MYSQL 5.4+

The application might work with a lower version of php/mysql, but I will never test against those legacy versions.

Install
========
Change the database configuration in ./config/db.php

Run:

```
composer global require "fxp/composer-asset-plugin:1.0.0-beta4"
composer install
yiic migrate
```

Regex Examples
========
http://regex101.com/r/tL0xJ5/2 - ID matching
http://regex101.com/r/cB6oU6/7 - Rating matching


License
========

Aside from the Framework and Plugins all the code is released under the following license

/*
* ----------------------------------------------------------------------------
* "THE BEER-WARE LICENSE" (Revision 42):
* <fg@code-works.de> wrote this file. As long as you retain this notice you
* can do whatever you want with this stuff. If we meet some day, and you think
* this stuff is worth it, you can buy me a beer in return. Frank Gehann
* ----------------------------------------------------------------------------
*/