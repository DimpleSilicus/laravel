<?php

/**
 * FlxZipArchive class to set application meta data.
 *
 * @name       FlxZipArchive.php
 * @category   ToolKit
 * @package    FlxZipArchive
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\ToolKit;

use ZipArchive;

/**
 * FlxZipArchive class to set application meta data.
 *
 * @name       FlxZipArchive.php
 * @category   ToolKit
 * @package    FlxZipArchive
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    Release:<v.1>
 * @link       None
 * @filesource
 */
class FlxZipArchive extends ZipArchive
{

    /**
     * This will create an empty directory or folder if not exhists.
     *
     * @name   addDir
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param string $location description
     * @param string $name     description
     *
     * @return void
     */
    public function addDir($location, $name)
    {
        $this->addEmptyDir($name);
        $this->_addDirDo($location, $name);
    }

    /**
     * This will open the created directory and add the files into it and creates a zip file.
     *
     * @name   addDirDo
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @param string $location description
     * @param string $name     description
     * 
     * @return void
     */
    private function _addDirDo($location, $name)
    {
        $name .= '/';
        $location .= '/';
        $dir  = opendir($location);
        while ($file = readdir($dir)) {
            if ($file == '.' || $file == '..')
                continue;
            $do = (filetype($location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    }

}

?>