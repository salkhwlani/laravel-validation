<?php

/*
 * Copyright (c) 2017 Salah Alkhwlani <yemenifree@yandex.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Yemenifree\Validation\Traits;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;
use Yemenifree\Validation\TranslateLoader;

trait HasValidator
{
    /** @var array */
    protected $aliases = [];
    /** @var string */
    protected $validatorLocal = 'ar';

    /** @var Validator */
    protected $validator;
    /** @var TranslateLoader */
    protected $translateLoader;

    /** @var Validation */
    protected $validation;

    /**
     * valid data.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $aliases
     *
     * @return mixed|\Rakit\Validation\Validation
     */
    protected function valid(array $data, array $rules, array $messages = [], array $aliases = [])
    {
        // load translate.
        $this->loadTranslate();

        $this->validation = $this->getValidator()->make($data, $rules, $messages);
        if (\count($aliases) > 0) {
            $this->setAliases($aliases);
        }
        $this->validation->setAliases($this->getAliases());
        $this->validation->validate();

        // if has custom invalid callback.
        if (\method_exists($this, 'InValidCallback') && $this->getValidation()->fails()) {
            return $this->InValidCallback($this->getValidation()->errors()->firstOfAll());
        }

        return !$this->getValidation()->fails();
    }

    /**
     *  load translate.
     */
    protected function loadTranslate(): self
    {
        $this->getValidator()->setMessages($this->getTranslateLoader()->load($this->getValidatorLocal()));

        return $this;
    }

    /**
     * @return Validator
     */
    protected function getValidator(): Validator
    {
        return $this->validator ?: $this->validator = new Validator();
    }

    /**
     * @return TranslateLoader
     */
    public function getTranslateLoader(): TranslateLoader
    {
        return $this->translateLoader ?: $this->translateLoader = new TranslateLoader();
    }

    /**
     * @return string
     */
    public function getValidatorLocal(): string
    {
        return $this->validatorLocal;
    }

    /**
     * set local of validation errors message.
     *
     * @param $local
     * @param null $path
     *
     * @return HasValidator
     */
    public function setValidatorLocal($local, $path = null): self
    {
        $this->validatorLocal = $local;

        if (!empty($path)) {
            $this->getTranslateLoader()->setPath($path);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * @param array $aliases
     *
     * @return self
     */
    public function setAliases($aliases): self
    {
        $this->aliases = $aliases;

        return $this;
    }

    /**
     * @return Validation
     */
    protected function getValidation(): Validation
    {
        return $this->validation;
    }

    /**
     * Get validation errors.
     *
     * @param bool $firstOfAll
     *
     * @return array|\Rakit\Validation\ErrorBag
     */
    protected function getValidErrors($firstOfAll = false)
    {
        return $firstOfAll ? $this->getValidation()->errors()->firstOfAll() : $this->getValidation()->errors();
    }
}
