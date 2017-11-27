<?php

/*
 * Copyright (c) 2017 Salah Alkhwlani <yemenifree@yandex.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Yemenifree\Validation;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator as BaseValidator;

class Validator extends BaseValidator
{
    /** @var Validation */
    protected $validation;
    /** @var array */
    protected $messagesDefault = [];
    /** @var \Closure */
    protected $failsCallback = false;

    /**
     * check if data is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        $this->getValidate()->validate();

        if ($this->getFailsCallback() instanceof \Closure && $this->validation->fails()) {
            ($this->getFailsCallback())($this->validation->errors()->firstOfAll());
        }

        return !$this->getValidate()->fails();
    }

    /**
     * get current validation.
     *
     * @return Validation
     */
    public function getValidate(): Validation
    {
        return $this->validation;
    }

    /**
     * @return \Closure
     */
    public function getFailsCallback(): \Closure
    {
        return $this->failsCallback;
    }

    /**
     * @param \Closure $failsCallback
     *
     * @return Validator
     */
    public function setFailsCallback(\Closure $failsCallback): self
    {
        $this->failsCallback = $failsCallback;

        return $this;
    }

    public function make(
        array $inputs,
        array $rules,
        array $messages = [],
        array $aliases = [],
        \Closure $failsCallback = null
    ): Validation {
        $this->failsCallback = $failsCallback;
        $this->validation = parent::make($inputs, $rules, $messages);
        $this->validation->setAliases($aliases);

        return $this->validation;
    }

    /**
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (!\method_exists($this, $method) && $this->getValidate()) {
            return \call_user_func_array([$this->getValidate(), '__call'], [$method, $arguments]);
        }

        return parent::__call($method, $arguments);
    }
}
