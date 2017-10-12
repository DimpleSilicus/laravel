<?php

/**
 * This will hold common static methods which required for application.
 *
 * @name       Workshop.php
 * @category   ToolKit
 * @package    Workshop
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\ToolKit;

use Illuminate\Support\Facades\Log;

/**
 * This will hold common methods which required for application.
 *
 * @name     Seo
 * @category ToolKit
 * @package  Workshop
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class Workshop
{

    /**
     * Add to log
     *
     * @name   addLog
     * @access public static
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @param string $message Log message
     * @param string $module  Module name
     * @param string $type    Type of error log emergency, alert, critical, error, warning, notice, info and debug
     * @param array  $details Message details
     *
     * @return void
     */
    public static function addLog($message, $module = 'general', $type = 'error', $details = [])
    {
        $module = strtolower($module);
        Log::$type('|' . $module . '| ' . $message, $details);
    }

}
