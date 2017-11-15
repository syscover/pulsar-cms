# Pulsar CMS App for Laravel

[![Total Downloads](https://poser.pugx.org/syscover/pulsar-cms/downloads)](https://packagist.org/packages/syscover/pulsar-cms)
[![Latest Stable Version](http://img.shields.io/github/release/syscover/pulsar-cms.svg)](https://packagist.org/packages/syscover/pulsar-cms)

Pulsar is an application that generates a control panel where you start creating custom solutions, provides the resources necessary for any web application.

---

## Installation

**1 - After install Laravel framework, execute on console:**
```
composer require syscover/pulsar-cms
```

Register service provider, on file config/app.php add to providers array
```
Syscover\Cms\CmsServiceProvider::class,
```

**2 - Execute publish command**
```
php artisan vendor:publish --provider="Syscover\Cms\CmsServiceProvider"
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
```

**3 - Execute optimize command load new classes**
```
php artisan optimize
```

**4 - And execute migrations and seed database**
```
php artisan migrate
php artisan db:seed --class="CmsTableSeeder"
```

**5 - Execute command to load all updates**
```
php artisan migrate --path=vendor/syscover/pulsar-cms/src/database/migrations/updates
```

**6 - Cms package implement Laravel Scout, you must indicate registration data or cancel Laravel Scout with the next data**
```
SCOUT_DRIVER=null
ALGOLIA_APP_ID=
ALGOLIA_SECRET=
```