<?php

/**
 *  Controller for public profile
 *
 * @name       PublicProfileController
 * @category   controller
 * @package    PublicProfileController
 * @author     Swapnil Patil <swapnilj.patil@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$
 * @link       None
 * @filesource
 */
namespace Modules\Profile\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\User;
use Modules\Profile\Model\UserNetwork;
use Modules\Profile\Model\NetworkGroups;
use Modules\Profile\Model\GroupUsers;

use Modules\Profile\Model\UserPrivacy;
use Modules\MyApps\Model\Pictures;
use Modules\MyApps\Model\Videos;
use Modules\MyApps\Model\Journal;
use Modules\MyApps\Model\Events;
use Modules\MyApps\Model\SharedResources;


/**
 * PublicProfileController class for view method.
 *
 * @category PublicProfileController
 * @package Activity-Log
 * @author Amol Savat <amol.savat@silicus.com>
 * @license Silicus http://google.com
 * @name PublicProfileController
 * @version Release:<v.1>
 * @link http://google.com
 */
class PublicProfileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * display  User public Profile page
     *
     * @name getUserProfile
     * @access public
     * @author     Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public $profileID;
    
    public function getUserProfile(Request $request)
    {
        $jsFiles[] = Config::get('app.url') . 'theme/' . Config::get('app.theme') . '/assets/profile/js/profile.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
        
        $authID =  Auth::id();
        $this->profileID = $request->userid;  
        $profileID = $this->profileID; 
        
        $arrNetworkUsers = array();
        $arrPictures = array();
        $arrVideos = array();
        $arrJournal = array();
        $arrEvents = array();
        $arrProfiler = array();
       
        // array for network users
        //$arrNetworkUsers = UserNetwork::getNetwokUsersByUserId($authID); 
        $appUrl = Config::get('app.url');
        
        
        // display pictures/videos/journals/events in user public profile
        $arrPictures = Pictures::getPicturesByUsedId($profileID);  
        $arrVideos = Videos::getVideosByUsedId($profileID);
        $arrJournal = Journal::getAllJournal($profileID);  
        $arrEvents = Events::getAllEventList($profileID);
              
        return view('Profile::user-profile')->with('arrPictures', $arrPictures)->with('arrVideos', $arrVideos)->with('arrJournal',$arrJournal)->with('arrEvents',$arrEvents)
        ->with('arrProfiler',$arrProfiler)
        ->with('arrNetworkUsers', $arrNetworkUsers)
        ->with('appUrl', $appUrl)->with('profileID',$profileID);            
    }  
 
    
    /**
     * This will get Relation With Profile User and Auth
     *
     * @name getRelationWithProfile
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getRelationWithProfile(Request $request)
    {
        $profileRelation = array();
        $authID =  Auth::id();
        $profileID = $request->profileID;
        $profileRelation = UserNetwork::getNetwokUsersRelation($authID,$profileID); 
        return response()->json($profileRelation);
        return view('Profile::user-profile');
    }
    
    /**
     * This will get Profiler Details
     *
     * @name getProfilerDetails
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getProfilerDetails(Request $request)
    {
        $arrProfiler = array();
        $profileID = $request->profileID;
        $arrProfiler = User::getProfiler($profileID);
        return response()->json($arrProfiler);
        return view('Profile::user-profile');
    }

    
    /**
     * This will get Journal Settings by Profile User
     *
     * @name getJournalPrivacySettings
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getJournalPrivacySettings(Request $request)
    {
        $journalPrivacySettings = array();
        $profileID = $request->profileID;   
        $module = 'journals';
        $journalPrivacySettings = UserPrivacy::getPrivacySettingsByModule($profileID,$module);
        return response()->json($journalPrivacySettings);
        return view('Profile::user-profile');   
    }
    
    
    /**
     * This will get Events Settings by Profile User
     *
     * @name getEventsPrivacySettings
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getEventsPrivacySettings(Request $request)
    {
        $eventPrivacySettings = array();
        $profileID = $request->profileID; 
        $module = 'event';
        $eventPrivacySettings = UserPrivacy::getPrivacySettingsByModule($profileID,$module);
        return response()->json($eventPrivacySettings);
        return view('Profile::user-profile');
        
    }
    
    
    /**
     * This will get Pictures Settings by Profile User
     *
     * @name getPicturePrivacySettings
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getPicturePrivacySettings(Request $request)
    {
        $picturePrivacySettings = array();
        $profileID = $request->profileID; 
        $module = 'images';
        $picturePrivacySettings = UserPrivacy::getPrivacySettingsByModule($profileID,$module);
        return response()->json($picturePrivacySettings);
        return view('Profile::user-profile');
        
    }
    
    
    /**
     * This will get Videos Settings by Profile User
     *
     * @name getVideoPrivacySettings
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     * @return void
     */
    public function getVideoPrivacySettings(Request $request)
    {
        $videoPrivacySettings = array();
        $profileID = $request->profileID; 
        $module = 'videos';
        $videoPrivacySettings = UserPrivacy::getPrivacySettingsByModule($profileID,$module);
        return response()->json($videoPrivacySettings);
        return view('Profile::user-profile');
        
    }

   
    
}
