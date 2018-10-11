# Wingu PHP SDK

[![Build Status](https://travis-ci.org/wingu-GmbH/wingu-sdk-php.png?branch=master)](https://travis-ci.org/wingu-GmbH/wingu-sdk-php)
[![Code Coverage](https://codecov.io/gh/wingu-GmbH/wingu-sdk-php/branch/master/graph/badge.svg)](https://codecov.io/gh/wingu-GmbH/wingu-sdk-php)
[![GitHub license](https://img.shields.io/github/license/wingu-GmbH/wingu-sdk-php.svg)](https://github.com/wingu-GmbH/wingu-sdk-php/blob/master/LICENSE.md)
[![GitHub tag](https://img.shields.io/github/tag/wingu-GmbH/wingu-sdk-php.svg)](https://github.com/wingu-GmbH/wingu-sdk-php/tags)
[![Packagist](https://img.shields.io/packagist/v/wingu/wingu-sdk-php.svg)](https://packagist.org/packages/wingu/wingu-sdk-php)

Welcome to Wingu PHP SDK. It will help you connect to the API of Wingu Proximity Platform.  
Documentation is avaliable at [Wingu Engine API Doc](https://wingu-engine.de/api/doc).

## Installation

### API key

To use the SDK you need to have valid **Wingu API Key**.  
To obtain one log in to your account on [Wingu Portal](https://wingu-portal.de).  
Once logged in go to **Settings** section and create your API Key there.

### Prerequisites

* PHP **7.1** or above
* **curl**, **json** extensions must be enabled

Add the Wingu PHP SDK as a dependency to your `composer.json` file:
```bash
composer require wingu/wingu-sdk-php
```

Provide the implementation for the virtual package `php-http/client-implementation`. 
It's up to you to decide which specific implementation you want to use. Here is an example with curl client:
```bash
composer require php-http/curl-client
```

## Usage examples

### Initial configuration

```php
<?php

declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

$configuration = new \Wingu\Engine\SDK\Api\Configuration('e2d5f36a-c2f5-11e8-a355-529269fb1459');

$winguApi = new \Wingu\Engine\SDK\Api\WinguApi($configuration);
```

### Use Channel service to fetch your private Beacon or any other type of Trigger by ID

```php
$beacon   = $winguApi->beacon()->myBeacon('8c798a67-0000-4000-a000-000000000001');
$geofence = $winguApi->geofence()->myGeofence('0a0b190a-0000-4000-a000-000000000001');
$nfc      = $winguApi->nfc()->myNfc('44da7d7e-0000-4000-a000-000000000001');
$qrCode   = $winguApi->qrCode()->myQrCode('9a8798c6-0000-4000-a000-000000000001');
```

### Iterate over all of your channels

```php
$channels = $winguApi->channel()->myChannels();

while ($channels->valid()) {
    $id      = $channels->current()->id();
    $name    = $channels->current()->name();
    $content = $channels->current()->content() ? $channels->current()->content()->id() : 'No content attached';

    $all_channels[] = new DummyChannel($id, $name, $content);
   
    $channels->next();
}
```

### Exception handling

It is developers' responsibility to handle exceptions. In case of failing validation BadRequest will occur. In example below `dash` instead of the valid `dashed` is given as first parameter to update Separator component method.

```php
try {
    $winguApi->component()->separator()->update('ac111efa-96f5-45ae-9bd2-c32c82c5c6c7',
    new \Wingu\Engine\SDK\Model\Request\Component\Separator\Update(
        'dash',
        '6d6099'
    ));
} catch (\Exception $exception)
{
    echo $exception->getMessage();
}
```

### Quick overview of Wingu Channels aka Triggers structure before you delve deeper into the SDK

> Channels can have one Content attached at a time  
> Each Content can have multiple ContentPacks, ie different language versions  
> Each ContentPack consists of Deck that may hold multiple Cards  
> Each Card holds only one Component  

> TL;DR:  
> Channel -> Content -> ContentPack[] -> Deck -> Card[] -> Component

### You can find more examples in the **examples/** directory of this repository.

## Versioning

This project implements the Semantic Versioning guidelines.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bumps the patch

For more information on SemVer, please visit http://semver.org/
