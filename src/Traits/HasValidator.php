<?php

/*
 * Copyright (c) 2017 Salah Alkhwlani <yemenifree@yandex.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Yemenifree\WordPressValidation\Traits;

use Yemenifree\WordPressValidation\TranslateLoader;
use Yemenifree\WordPressValidation\Validator;

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
    public function valid(array $data, array $rules, array $messages = [], array $aliases = [])
    {
        // load translate.
        $this->loadTranslate();

        $this->getValidator()->make($data, $rules, $messages, $this->getAliases());

        if (\count($aliases) > 0) {
            $this->setAliases($aliases);
        }

        // if has custom invalid callback.
        if (\method_exists($this, 'InValidCallback')) {
            $this->getValidator()->setFailsCallback(function ($error) {
                return $this->InValidCallback($error);
            });
        }

        return $this->getValidator()->isValid();
    }

    /**
     *  load translate.
     */
    public function loadTranslate(): self
    {
        $this->translateLoader = new TranslateLoader();

        $this->getValidator()->setMessages($this->translateLoader->load($this->getValidatorLocal()));

        return $this;
    }

    /**
     * @return Validator
     */
    public function getValidator() : Validator
    {
        return $this->validator ?: $this->validator = new Validator();
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
     *
     * @return $this
     */
    public function setValidatorLocal($local): self
    {
        $this->validatorLocal = $local;

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
}
