<?php

namespace Zoutapps\Laravel\Lang\VendorNamespace\Loader;

use Illuminate\Filesystem\Filesystem;

class TranslationLoader
{
    /**
     * All of the vendor namespace hints.
     *
     * @var array
     */
    protected $vendorHints = [];

    protected $files;

    protected $translator;

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->translator = app('translator');
    }

    public function addVendorNamespace($namespace, $path)
    {
        if (!isset($this->vendorHints[$namespace])) {
            $this->vendorHints[$namespace] = [];
        }

        array_push($this->vendorHints[$namespace], $path);
        $this->generateLinks($namespace, $path);
    }

    private function generateLinks($namespace, $path)
    {
        $languages = $this->loadLanguages($path);
        $base = __DIR__.'/../../resources/lang/'.$namespace;

        foreach($languages as $language) {
            $dir = $base.'/'.$language;
            $this->files->makeDirectory($base.'/'.$language, 0755, true, true);
            $groups = $this->files->files($path.'/'.$language);

            foreach ($groups as $file) {
                if ($this->files->exists($path = $dir.'/'.$file->getFilename())) {
                    $this->files->delete($path);
                }
                $this->files->link($file->getPathname(), $path);
            }
        }

        $this->translator->addNamespace($namespace, $base);
    }

    private function loadLanguages($path) {
        return array_map('basename', $this->files->directories($path));
    }
}