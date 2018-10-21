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

    protected $basePath = __DIR__ . '/../../resources/lang/';

    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        $this->translator = app('translator');

        app()->booted(function () {
            $this->bootedHandler();
        });
    }

    public function addVendorNamespace($namespace, $path)
    {
        if (!isset($this->vendorHints[$namespace])) {
            $this->vendorHints[$namespace] = [];
        }

        array_push($this->vendorHints[$namespace], $path);
    }

    private function bootedHandler()
    {
        if ($this->shouldGenerate()) {
            $this->clear();
            $this->generate();
        }
    }

    private function shouldGenerate(): bool
    {
        if (app()->environment() == 'local') {
            return true;
        }

        return !$this->files->isDirectory($this->basePath);
    }

    private function clear()
    {
        $this->files->deleteDirectory($this->basePath);
    }

    private function generate()
    {
        foreach ($this->vendorHints as $namespace => $paths) {
            // add namespace directory
            $this->files->makeDirectory($this->basePath, 0755, true, true);

            // register directory
            $this->translator->addNamespace($namespace, $this->basePath);

            foreach ($paths as $path) {
                $this->generateLinks($namespace, $path);
            }
        }
    }

    private function generateLinks($namespace, $path)
    {
        $languages = $this->loadLanguages($path);

        foreach ($languages as $language) {
            $dir = $this->basePath . $namespace . '/' . $language;
            $this->files->makeDirectory($dir, 0755, true, true);
            $groups = $this->files->files($path . '/' . $language);

            foreach ($groups as $file) {
                if ($this->files->exists($filePath = $dir . '/' . $file->getFilename())) {
                    $this->files->delete($filePath);
                }
                $this->files->link($file->getPathname(), $filePath);
            }
        }
    }

    private function loadLanguages($path)
    {
        return array_map('basename', $this->files->directories($path));
    }
}