<?php

/**
 * Backup class to set application meta data.
 *
 * @name       Backup.php
 * @category   ToolKit
 * @package    Backup
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\ToolKit;

use Illuminate\Support\Facades\Config;
use ZipArchive;
use Illuminate\Support\Facades\DB;

/**
 * Backup class to set application meta data.
 *
 * @name       Backup.php
 * @category   ToolKit
 * @package    Seo
 * @author     Vivek Kale <vivek.kale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    Release:<v.1>
 * @link       None
 * @filesource
 */
class Backup extends ZipArchive
{

    /**
     * Creates a zip file contains the file specified with the source path from config file i.e. backup.php file
     *
     * @name   createZipFolder
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public function getFolderBackup()
    {

        print('Initializing' . PHP_EOL);

        $source      = Config::get('backup.SOURCE');                  // Source folder path
        $destination = Config::get('backup.DESTINATION') . time() . '.zip';     // Destination Folder path with file name

        if (!is_dir($source)) {
            print('Source Folder : "' . $source . '" Not Found!');  // This code will check for the specified source folder is present or not
            die();
        }

        print('Creating Zip To The Destination Folder' . PHP_EOL);

        if (Config::get('backup.THROUGH_EXEC_FOLDER') == 'true') {
            exec('zip - r / ' . $destination . ' / ' . $source . '');
        } else {
            $result = $this->open($destination, ZipArchive::CREATE);

            if ($result === true) {
                $this->addDir($source, basename($source));
                $this->close();
            } else {
                echo 'Could not create a zip archive';
            }
        }
        print('Backup Completed' . PHP_EOL);
    }

    /**
     * This will create a .sql file containing the db backup and store it to the destination.
     *
     * @name   getDatabaseBackup
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public static function getDatabaseBackup()
    {
        print('Initializing' . PHP_EOL);


        $databaseConnections = Config::get('database.connections');
        $defaultDatabase     = Config::get('backup.DATABASES');
        $cnt                 = count($defaultDatabase);
        for ($i = 0; $i < $cnt; $i++) {
            $databaseName     = $databaseConnections[$defaultDatabase[$i]]['database'];
            $databaseUserName = $databaseConnections[$defaultDatabase[$i]]['username'];
            $databasePassword = $databaseConnections[$defaultDatabase[$i]]['password'];
            $destination      = Config::get('backup.DESTINATION');     // Destination Folder path with file name
            $mysqlPath        = Config::get('backup.MYSQL_PATH');     // For windows users set your mysql path
            $outputFile       = $databaseName . '_' . time();
            $passwords        = trim($databasePassword) != '' ? ' -p' . $databasePassword : '';
            //$mysqlPath        = $mysqlPath . ' -u' . $databaseUserName . $passwords . ' ' . $databaseName . '>' . $destination . '' . $outputFile . '.sql';
            chdir($mysqlPath);
            $mysqlPath        = 'mysqldump -u' . $databaseUserName . $passwords . ' ' . $databaseName . '>' . $destination . '' . $outputFile . '.sql';
            print('Getting Database Backup' . PHP_EOL);
            if (Config::get('backup.THROUGH_EXEC_DB') == 'true') {
                exec('zip - r / ' . $destination . ' / ' . $source . '');
            } else {
                if (PHP_OS == 'WINNT') {
                    exec(str_replace("'", "", $mysqlPath));  // for windows users set your mysql path
                } else {
                    exec('mysqldump -u ' . $databaseUserName . ' -p ' . $databaseName . ' > ' . $destination . $outputFile . '.sql');
                }
            }
            print('Database Backup Completed For: ' . $databaseName . PHP_EOL);
        }
    }

    /**
     * This will sync the source folder with destination folder.
     *
     * @name   getIncrementalBackupFolder
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public function getIncrementalBackupFolder()
    {
        print('Initializing' . PHP_EOL);

        $source      = Config::get('backup.SOURCE');                            // Source folder path
        $destination = Config::get('backup.DESTINATION') . time() . '.zip';     // Destination Folder path with file name

        if (!is_dir($source)) {
            print('Source Folder : "' . $source . '" Not Found!');  // This code will check for the specified source folder is present or not
            die();
        }

        if (Config::get('backup.THROUGH_EXEC_FOLDER') == 'true') {
            exec('rsync -r -a --delete ' . $source . ' ' . $destination . '');
        } else {
            if (PHP_OS == 'WINNT') {
                $result = $this->open($destination, ZipArchive::CREATE);

                if ($result === true) {
                    $this->addDir($source, basename($source));
                    $this->close();
                    print('Creating Zip To The Destination Folder' . PHP_EOL);
                } else {
                    print('Could not create a zip archive');
                }
            } else {
                exec('rsync -r -a --delete ' . $source . ' ' . $destination . '');
            }
        }

        print('Backup Completed' . PHP_EOL);
    }

    /**
     * This will create an incremental backup of database and creates a zip file.
     *
     * @name   getIncrementalBackupDB
     * @access public
     * @author Vivek Kale <vivek.kale@silicus.com>
     *
     * @return void
     */
    public static function getIncrementalBackupDB()
    {
        print('Initializing' . PHP_EOL);

        $databaseConnections = Config::get('database.connections');
        $defaultDatabase     = Config::get('backup.DATABASES');
        $cnt                 = count($defaultDatabase);
        for ($i = 0; $i < $cnt; $i++) {

            $databaseName      = $databaseConnections[$defaultDatabase[$i]]['database'];
            $databaseUserName  = $databaseConnections[$defaultDatabase[$i]]['username'];
            $databasePassword  = $databaseConnections[$defaultDatabase[$i]]['password'];
            $sourceFolder      = Config::get('backup.SOURCE');     // Destination Folder path with file name
            $destinationFolder = Config::get('backup.DESTINATION');     // Destination Folder path with file name
            $mysqlPath         = Config::get('backup.MYSQL_PATH');     // For windows users set your mysql path
            $outputFile        = $databaseName . '_' . time();
            $passwords         = trim($databasePassword) != '' ? ' -p' . $databasePassword : '';
            //$mysqlPath         = $mysqlPath . ' -u' . $databaseUserName . $passwords . ' ' . $databaseName . '>' . $destinationFolder . '' . $outputFile . '.sql';
            chdir($mysqlPath);
            $mysqlPath         = 'mysqldump -u' . $databaseUserName . $passwords . ' ' . $databaseName . '>' . $destinationFolder . '' . $outputFile . '.sql';
            print('Getting Database Backup' . PHP_EOL);
            if (Config::get('backup.THROUGH_EXEC_DB') == 'true') {
                exec('mysqldump -u ' . $databaseUserName . ' -p ' . $databaseName . ' > ' . $destinationFolder . $outputFile . '.sql');
                exec('rsync -r -a --delete ' . $sourceFolder . ' ' . $destinationFolder);
            } else {
                if (PHP_OS == 'WINNT') {
                    exec(str_replace("'", "", $mysqlPath));  // for windows users set your mysql path
                } else {
                    exec('mysqldump -u ' . $databaseUserName . ' -p ' . $databaseName . ' > ' . $destinationFolder . $outputFile . '.sql');
                    exec('rsync -r -a --delete ' . $sourceFolder . ' ' . $destinationFolder);
                }
            }
            print('Database Backup Completed For: ' . $databaseName . PHP_EOL);
        }
    }

    /**
     * This will create an empty directory or folder if not exists.
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
