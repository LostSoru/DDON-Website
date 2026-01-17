First off I'm pretty new to creating my own git repo's so please bare with me.

I created this repo to help with managing users on hosted Dragon's Dogma Online servers as there is currently no way to set your emails or even reset your passwords.
With this you set it up on a webserver and connect it to your database which gives you the ability to have your players reset on their own. It has also been a while since I have
coded anything and any help along the way is welcomed.

The current setup should work on PHP Version 7.2 to the latest. My Test server was setup with PHP 8.3
You will need to make sure you have the required PHP Modules installed as well for your php version: curl, pgsql, and pdo-pgsql

You will also need Composer to install the external libraries used in this project

All your main global settings will be located in files/config/global_data.php
This is for settings like your site title, layout, and email settings
Your database connection settings are located in files/config/db_connect.php

By default I have HTML based emails enabled. You can disable it to just send out text based emails which can be set inside files/functions/email_func.php
To change how your HTML emails look, just change the email.html and reset_email.html inside of templates/DDO/pages/email


Just a reminder that this is an early version of this project and that it still needs work done on it.
