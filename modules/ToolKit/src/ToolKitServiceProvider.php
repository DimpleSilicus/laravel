<?php

/**
 * Common libraries which required for project
 *
 * @name       ToolKitServiceProvider.php
 * @category   ServiceProvider
 * @package    ToolKit
 * @author     Ajay Bhosale <ajay.bhosale@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */

namespace Modules\ToolKit;

use Illuminate\Support\ServiceProvider;

/**
 * Common libraries which required for project
 *
 * @name     ToolKitServiceProvider
 * @category ServiceProvider
 * @package  ToolKit
 * @author   Ajay Bhosale <ajay.bhosalesilicus.com>
 * @license  Silicus http://www.silicus.com
 * @version  Release:<v.1>
 * @link     None
 */
class ToolKitServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @name   boot
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @name   register
     * @access public
     * @author Ajay Bhosale <ajay.bhosale@silicus.com>
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('seo', function ($app) {
            return new Seo($app);
        });
    }

}
