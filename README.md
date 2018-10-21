# laravel-lang-vendornamespace

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This package is aimed at package developers that want multiple packages translations under one namespace.

It's currently not easily possible to gather all your packages translations under one namespace 
which can bloat up the calls to your translations as well as your _resources/lang/vendor_ folder
when publishing the files.

For example having packages:
* `zoutapps/awesome-package`
* `zoutapps/nice-package`

you can't register the translations to be able to use them like this:
```php
trans('zoutapps::awesome-package')
trans('zoutapps::nice-package')
```

**With this package you now can do this!**

## Installation

Via Composer

``` bash
$ composer require zoutapps/laravel-lang-vendornamespace
```

## Usage

In your `PackageServiceProvider` instead of using  
`$this->loadTranslationsFrom(__DIR__ . '/../resources/lang', '<your-vendor-name>')`  
make a call to  
`VendorNamespace::loadTranslationsFrom(__DIR__ . '/../resources/lang', '<your-vendor-name>')` 
in your `boot()` method.

Publishing your translations is the same as before:

```php
$this->publishes([
    __DIR__ . '/../resources/lang' => resource_path('lang/vendor/<your-vendor-name>'),
], 'lang');
```

## What it does

We will create a folder for every namespace and in this folder all loaded translations will be symlinked.
After that this folder will be linked as the namespace folder in the laravel TranslationLoader. 

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email oliver.ziegler@zoutapps.de instead of using the issue tracker.

## Credits

- [Oliver Ziegler][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/zoutapps/laravel-lang-vendornamespace.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/zoutapps/laravel-lang-vendornamespace.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/zoutapps/laravel-lang-vendornamespace/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/zoutapps/laravel-lang-vendornamespace
[link-downloads]: https://packagist.org/packages/zoutapps/laravel-lang-vendornamespace
[link-travis]: https://travis-ci.org/zoutapps/laravel-lang-vendornamespace
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/zoutapps
[link-contributors]: ../../contributors]