<?php
/*
 * Copyright (c) 2017 Salah Alkhwlani <yemenifree@yandex.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Yemenifree\WordPressValidation;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator as BaseValidator;

class Validator extends BaseValidator
{
    /** @var Validation */
    protected $validate;
    protected $messagesDefault = [
        'required' => 'الحقل :attribute مطلوب',
        'numeric' => 'الحقل :attribute يجب ان يكون رقم صحيح',
        'alpha' => 'الحقل :attribute يجب ان يكون حروف فقط',
        'date' => 'الحقل :attribute يجب ان يكون تاريخ صحيحا',
        'after' => ':attribute يجب ان يكون بعد تاريخ :time.',
    ];

    public function __construct(array $messages = [])
    {
        $messages = \array_merge($messages, $this->messagesDefault);
        parent::__construct($messages);
    }

    public function make(
        array $inputs,
        array $rules,
        array $messages = [],
        $aliases = [],
        $failsCallback = null
    ) {
        return tap(parent::make($inputs, $rules, $messages), function ($validation) use ($aliases, $failsCallback) {
            $this->validate = $validation;
            $this->validate->setAliases($aliases);

            if ($failsCallback) {
                $this->validate->validate();
                if ($this->validate->fails()) {
                    /** @var \Closure $failsCallback */
                    $failsCallback($this->validate->errors()->firstOfAll());
                }
            }
        });
    }
}
