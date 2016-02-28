<?php
/**
 * Created by PhpStorm.
 * User: Vuong
 * Date: 21-Feb-16
 * Time: 12:58 PM
 */

namespace Mnking\Slack\Facades;


use Illuminate\Support\Facades\Facade;

class Slack extends Facade
{
    /**
     * The name of the binding in the IoC container.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Slack';
    }
}