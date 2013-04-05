localdevhost
============

Localhost dashboard written in PHP and Javascript

Features
--------
 - Markdown display
 - File browser

![Localdevhost screenshot](https://github.com/drola/localdevhost/raw/master/img/screenshot.jpg "Localdevhost screenshot")

Dependencies
------------
- PHP 5.4
- Composer

Usage
-----
1. Configure paths in `index.php`
2. Go to backend and install dependencies using Composer:

        cd backend/
        php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
        php composer.phar install

3. Open `index.php` via browser