<?php

namespace Revolution\Soracom\Facades;

use Illuminate\Support\Facades\Facade;

use Revolution\Soracom\Contracts\Factory;

class Soracom extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
