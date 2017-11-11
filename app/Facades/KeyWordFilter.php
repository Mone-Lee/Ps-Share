<?php
/**
 * Created by PhpStorm.
 * User: 苏锐佳
 * Date: 2016/8/24
 * Time: 10:24
 */

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class KeywordFilter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'keywordFilter';
    }
}