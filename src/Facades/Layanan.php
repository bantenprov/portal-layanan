<?php

namespace Bantenprov\Layanan\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Layanan facade.
 *
 * @package Bantenprov\Layanan
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class LayananFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'layanan';
    }
}
