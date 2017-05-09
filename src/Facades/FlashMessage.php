<?php

namespace App\Library\FlashMessage\Facades;

use Illuminate\Support\Facades\Facade;

class FlashMessage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kaoken.flash_message';
    }
}