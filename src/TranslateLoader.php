<?php

namespace Yemenifree\WordPressValidation;

class TranslateLoader
{
    protected $path;
    protected $defaultPath;
    protected $supportLang = ['ar'];

    /**
     * TranslateLoader constructor.
     */
    public function __construct()
    {
        $this->defaultPath = __DIR__ . '/lang';
    }

    /**
     * load lang.
     *
     * @param $locale
     *
     * @return array|mixed
     */
    public function load($locale)
    {
        // if file not exists
        if (!file_exists($this->getFilePath($locale))) {
            // if local support build in get translate from package.
            if ($this->isSupportLocal($locale)) {
                return include($this->getFilePath($locale, true));
            }

            return [];
        }

        return include($this->getFilePath($locale));
    }

    /**
     * @param $locale
     * @param bool $default
     *
     * @return string
     */
    protected function getFilePath($locale, $default = false)
    {
        return $this->getPath($default) . '/' . $locale . '.php';
    }

    /**
     * get path lang.
     *
     * @param bool $default
     *
     * @return string
     */
    public function getPath($default = false): string
    {
        return $default ? $this->getDefaultPath() : $this->path;
    }

    /**
     * @param string $path
     *
     * @return TranslateLoader
     */
    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultPath(): string
    {
        return $this->defaultPath;
    }

    private function isSupportLocal($locale): bool
    {
        return in_array($locale, $this->supportLang, true);
    }
}