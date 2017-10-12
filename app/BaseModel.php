<?php

/**
 * This is a middleware between main Model and application Model.
 *
 * @name       BaseModel
 * @category   Model
 * @package    Model
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id: 77961921658b971ce1279691af01f4757b0eaf40 $
 * @link       None
 * @filesource
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\ToolKit\Workshop;

/**
 * This is a middleware between main Model and application Model.
 *
 * @name     ClassName
 * @category Model
 * @package  Model
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class BaseModel extends Model
{

    /**
     * Add to log
     *
     * @name   addToLog
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
    public function addToLog($message, $module = 'general', $type = 'error', $details = [])
    {
        Workshop::addLog($message, $module, $type, $details);
    }

    /**
     * Allow for camelCased attribute access
     *
     * @name   getAttribute
     * @access public
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param int $key key attribute
     *
     * @return $contact record set
     */
    public function getAttribute($key)
    {
        return parent::getAttribute(snake_case($key));
    }

    /**
     * Allow for camelCased attribute access
     *
     * @name   paginateRecords
     * @access setAttribute
     * @author Swati Jadhav <swati.jadhav@silicus.com>
     *
     * @param int $key   key attribute
     * @param int $value key attribute
     *
     * @return $contact record set
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }

    /* // This is required for MsSQL
      public function getDateFormat()
      {
      return 'Y-m-d H:i:s.u';
      }

      // This is required for MsSQL
      public function fromDateTime($value)
      {
      return substr(parent::fromDateTime($value), 0, -3);
      }
     */
}
