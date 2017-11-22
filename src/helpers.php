<?php

if (!function_exists('tap')) {
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