# Pulsar CMS App for Laravel

[![Total Downloads](https://poser.pugx.org/syscover/pulsar-cms/downloads)](https://packagist.org/packages/syscover/pulsar-cms)
[![Latest Stable Version](http://img.shields.io/github/release/syscover/pulsar-cms.svg)](https://packagist.org/packages/syscover/pulsar-cms)

Pulsar is an application that generates a control panel where you start creating custom solutions, provides the resources necessary for any web application.

---

## Installation

Before install syscover/pulsar-cms, you need install syscover/pulsar-core and syscover/pulsar-admin

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

**3 - And execute migrations and seed database**
```
php artisan migrate
php artisan db:seed --class="CmsTableSeeder"
```

**4 - Execute command to load all updates**
```
php artisan migrate --path=vendor/syscover/pulsar-cms/src/database/migrations/updates
```

**5 - Cms package implement Laravel Scout, you must indicate registration data or cancel Laravel Scout with the next data**
```
SCOUT_DRIVER=null
ALGOLIA_APP_ID=
ALGOLIA_SECRET=
```

**6 - Add graphQL routes to graphql/schema.graphql file**
```
# Cms
#import ./../vendor/syscover/pulsar-cms/src/Syscover/Cms/GraphQL/inputs.graphql
#import ./../vendor/syscover/pulsar-cms/src/Syscover/Cms/GraphQL/types.graphql

type Query {
    // others imports

    # Cms
    #import ./../vendor/syscover/pulsar-cms/src/Syscover/Cms/GraphQL/queries.graphql
}

type Mutation {
    // others imports

    # Cms
    #import ./../vendor/syscover/pulsar-cms/src/Syscover/Cms/GraphQL/mutations.graphql
}
```
