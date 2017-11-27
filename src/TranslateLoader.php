<?php

/*
 * Copyright (c) 2017 Salah Alkhwlani <yemenifree@yandex.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
        $this->path = __DIR__ . '/lang';
    }

    /**
     * load lang.
     *
     * @param $locale
     *
     * @return array
     */
    public function load($locale): array
    {
        // if file not exists
        if (!\file_exists($this->getFilePath($locale))) {
            // if local support build in get translate from package.
            if ($this->isSupportLocal($locale)) {
                return include $this->getFilePath($locale, true);
            }

            return [];
        }

        return include $this->getFilePath($locale);
    }

    /**
     * @param $locale
     * @param bool $default
     *
     * @return string
     */
    protected function getFilePath($locale, $default = false): string
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

    /**
     * Check if local support build in with package.
     *
     * @param $locale
     *
     * @return bool
     */
    private function isSupportLocal($locale): bool
    {
        return \in_array($locale, $this->supportLang, true);
    }
}
