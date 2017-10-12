<?php

/**
 * Facades class for Seo.
 *
 * @name       Seo
 * @category   Facades
 * @package    ToolKit
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\ToolKit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facades class for Seo.
 *
 * @name     Seo
 * @category Facades
 * @package  ToolKit
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class Seo extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'seo';
    }

}
