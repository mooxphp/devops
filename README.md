![Moox ForgeServer](https://github.com/mooxphp/moox/raw/main/art/banner/forge-servers.jpg)

# Moox ForgeServer

This is my package forge-servers

## Quick Installation

These two commmands are all you need to install the package:

```bash
composer require moox/forge-servers
php artisan mooxforge-servers:install
```

Curious what the install command does? See manual installation below.

## What it does

<!--whatdoes-->

Here are some things missing, like an overview with screenshots about this package, or simply a link to the package's docs.

<!--/whatdoes-->

## Manual Installation

Instead of using the install-command `php artisan mooxforge-servers:install` you are able to install this package manually step by step:

```bash
// Publish and run the migrations:
php artisan vendor:publish --tag="forge-servers-migrations"
php artisan migrate

// Publish the config file with:
php artisan vendor:publish --tag="forge-servers-config"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](https://github.com/mooxphp/moox/security/policy) on how to report security vulnerabilities.

## Credits

-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
