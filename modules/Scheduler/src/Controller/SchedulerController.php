<?php

/**
 *  Controller for viewing all users logs
 *
 * @name       ProfileController
 * @category   Plugin
 * @package    Profile
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\Scheduler\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

use Modules\Scheduler\Model\Scheduler;

use Modules\ToolKit\Workshop;

/**
 * SchedulerController class for view method.
 *
 * @category SchedulerController
 * @package Activity-Log
 * @author Amol Savat <amol.savat@silicus.com>
 * @license Silicus http://google.com
 * @name ProfileController
 * @version Release:<v.1>
 * @link http://google.com
 */
class SchedulerController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $jsFiles[] = $this->url . 'theme/' . Config::get('app.theme') . '/assets/scheduler/js/scheduler.js';
//        print_r($jsFiles);
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
    }
    
    /**
     * Showing Scheduler details.
     *
     * @name showHomePage
     * @access public
     * @author Dimple Agarwal <dimple.agarwal@silicus.com>
     *
     * @return void
     */
    
    public function showHomePage() {
        
        return view('Scheduler::scheduler_home');
        
    }
  
    /**
     * This function is used to get user online status
     *
     * @name userStatus
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
//    public function userStatus(Request $request)
//    {        
//        $onlineStatus = array();
//        $onlineStatus = User::userOnlineStatus();        
//        return response()->json($onlineStatus);
//    }
    
    
}
