# Dragon's Dogma Online -- User Management Tool

> A simple PHP-based user management utility for hosted Dragon's Dogma
> Online servers.

## Overview

This repository was created to help server administrators manage user
accounts for hosted **Dragon's Dogma Online** servers.

At the moment, DDO servers do not provide a built-in way for users to:

-   Set or update their username and email address
-   Reset forgotten passwords

This project aims to solve that problem by providing a **self-service
password reset system** that can be hosted on your own web server and
connected directly to your database.

⚠️ **Note:** I'm relatively new to creating and maintaining GitHub
repositories, and it's also been a while since I last worked extensively
with PHP. Feedback, suggestions, and contributions are very welcome!

## Features

-   User password reset functionality
-   Email-based reset flow (HTML or plain text)
-   PostgreSQL database support
-   Compatible with modern PHP versions

## Requirements

### PHP

-   **PHP 7.2 or newer**
-   Tested with **PHP 8.3**

### Required PHP Extensions

Make sure the following PHP modules are installed and enabled:

-   curl
-   pgsql
-   pdo-pgsql

### Composer

This project relies on external libraries managed through **Composer**.

``` bash
composer install
```

## Configuration

### Global Settings

All global site configuration options are located in:

    files/config/global_data.php

This includes settings such as:

-   Site title
-   Layout options
-   Email configuration

### Database Connection

Database connection settings can be found in:

    files/config/db_connect.php

## Email Configuration

### Email Format

-   HTML emails are enabled by default
-   You can switch to plain-text emails if preferred

Edit the following file to change this behavior:

    files/functions/email_func.php

### Customizing HTML Emails

HTML email templates are located at:

    templates/DDO/pages/email/email.html
    templates/DDO/pages/email/reset_email.html

## Installation (Basic)

1.  Upload the project to your web server
2.  Install dependencies using Composer
3.  Configure database and global settings
4.  Ensure required PHP extensions are installed
5.  Test email delivery and password reset flow

## Project Status

🚧 **Early Development**

This project is still in an early stage and requires additional work and
refinement.

## Contributing

Contributions are welcome! Bug reports, feature suggestions, and pull
requests are appreciated.
