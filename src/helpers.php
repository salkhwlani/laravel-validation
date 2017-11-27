<?php

/*
 * Copyright (c) 2017 Salah Alkhwlani <yemenifree@yandex.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

if (!\function_exists('tap')) {
    /**
     * "Tap" a method on the provided instance either by callback or proxy.
     *
     * @param $instance
     * @param callable|null $callback
     *
     * @return mixed
     */
    function tap($instance, $callback = null)
    {
        $callback($instance);

        return $instance;
    }
}
