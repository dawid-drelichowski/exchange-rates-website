# Exchange rates website [![Build Status](https://travis-ci.org/dawid-drelichowski/exchange-rates-website.png?branch=master)](https://travis-ci.org/dawid-drelichowski/exchange-rates-website)

An exchange rates website with possibility to add, remove or change currencies and rates.  
Build upon [Silex](http://silex.sensiolabs.org/) and [Angular](https://angularjs.org/) frameworks.

## Requirements

* Web server - e.g. [Nginx](http://nginx.org/) or [Apache](http://httpd.apache.org/)
* [PHP 5.3.3 or later](http://php.net/)
* [MySQL 5.0 or later](https://www.mysql.com/)
* [Node.js 0.10.0 or later](https://nodejs.org/)
* [Composer](https://getcomposer.org/)

## Installation

1. [Clone](https://help.github.com/articles/importing-a-git-repository-using-the-command-line/) repository.
2. Install database structure with db/dump.sql file. E.g. `mysql -u <user> - p < db/dump.sql`
3. Install dependencies with [Composer](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies).  
   [NPM](https://www.npmjs.com/) and [Bower](http://bower.io/) dependencies will install automatically with [Composer post install scripts](https://getcomposer.org/doc/articles/scripts.md)
4. Change configuration file:
    1. Copy default configuration config/default.json.dist and rename it to default.json E.g. `cp config/default.json.dist config/default.json`
    2. Edit copied and renamed config/default.json file as required (e.g. database credentials, admin credentials, locale). 
