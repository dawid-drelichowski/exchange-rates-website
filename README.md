# Exchange rates website [![Build Status](https://travis-ci.org/dawid-drelichowski/exchange-rates-website.png?branch=master)](https://travis-ci.org/dawid-drelichowski/exchange-rates-website)

An exchange rates website with possibility to present, add, remove or change currencies and rates.  
Build upon [Silex](http://silex.sensiolabs.org/), [Angular](https://angularjs.org/) and [Bootstrap](http://getbootstrap.com/).

## Requirements

* Web server - e.g. [Nginx](http://nginx.org/) or [Apache](http://httpd.apache.org/)
* [PHP 5.3.3 or later](http://php.net/)
* [MySQL 5.0 or later](https://www.mysql.com/)
* [Node.js 0.10.0 or later](https://nodejs.org/)
* [Composer](https://getcomposer.org/)

## Installation

1. [Clone](https://help.github.com/articles/importing-a-git-repository-using-the-command-line/) repository.
2. Install database structure with **db/dump.sql file**. E.g. `mysql -u <user> - p < db/dump.sql`
3. Install dependencies with [Composer](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies).  
   [NPM](https://www.npmjs.com/) and [Bower](http://bower.io/) dependencies will install automatically with [Composer post install scripts](https://getcomposer.org/doc/articles/scripts.md)
4. Change configuration file:
    1. Copy default configuration **config/default.json.dist** and rename it to **default.json**. E.g. `cp config/default.json.dist config/default.json`
    2. Edit copied and renamed **config/default.json** file as required (e.g. database authentication details, locale).
    3. You can change admin authentication details as described in [Silex HTTP authentication manual](http://silex.sensiolabs.org/doc/providers/security.html#securing-a-path-with-http-authentication).
5. Configure Your web server. [Silex manual](http://silex.sensiolabs.org/doc/web_servers.html) can be helpful.  
   **web** is document root directory. [Nginx example](https://gist.github.com/dawid-drelichowski/f546532ce3a3d4340cce)

## Routes

Available routes:

* **/** - Presents retail and wholesale exchange rates.
* **/admin** - Exchange rates administration. HTTP based authentication (default login: 'admin', password: 'foo').  
  Allows to add, remove, modify currencies and countries, update exchange rates

## Tests

####PHP

Unit tests based on [PHPUnit](https://phpunit.de/).  
Functional tests based on [Silex/Symfony 2](http://silex.sensiolabs.org/doc/testing.html#webtestcase).

Command: `vendor/bin/phpunit` in main application directory.

####JavaScript

Unit tests based on [Karma](http://karma-runner.github.io/0.12/index.html), [PhantomJS](http://phantomjs.org/), [Jasmine](http://jasmine.github.io/) and [Angular mocks](https://docs.angularjs.org/api/ngMock).

Command: `node_modules/karma/bin/karma start` in main application directory.