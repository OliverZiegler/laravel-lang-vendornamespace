<?php

namespace Zoutapps\Laravel\Lang\VendorNamespace\Facades;

use Illuminate\Support\Facades\Facade;

class VendorNamespace extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Zoutapps\Laravel\Lang\VendorNamespace\VendorNamespace::class;
    }
}
