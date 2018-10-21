<?php

namespace Zoutapps\Laravel\Lang\VendorNamespace;

use Illuminate\Filesystem\Filesystem;
use Zoutapps\Laravel\Lang\VendorNamespace\Loader\TranslationLoader;

class VendorNamespace
{
    protected $loader;

    public function __construct(Filesystem $files)
    {
        $this->loader = new TranslationLoader($files);
    }

    public function loadTranslationsFrom($path, $namespace)
    {
        $this->loader->addVendorNamespace($namespace, $path);
    }
}
