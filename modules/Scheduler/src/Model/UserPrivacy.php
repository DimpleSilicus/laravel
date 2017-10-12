<?php
/**
 * Mailbox class to add / edit / delete user privacy settings
 *
 * @name       UserPrivacy.php
 * @category   UserPrivacy
 * @package    Profile
 * @author     Amol Savat <amol.savat@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version
 * @link       None
 * @filesource
 */
namespace Modules\Profile\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserPrivacy extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'user_privacy';

    public $timestamps = false;

    /**
     * Function to add user privacy settings
     *
     * @name addUserPrivacySettings
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addUserPrivacySettings($userId, $appearToWorldMap, $appearToMyNetwork, $pedigree, $images, $videos, $journals, $events)
    {
        $objUserPrivacy = new self();
        
        $objUserPrivacy->user_id = $userId;
        $objUserPrivacy->appear_to_world_map = $appearToWorldMap;
        $objUserPrivacy->appear_to_my_network = $appearToMyNetwork;
        $objUserPrivacy->pedigree = json_encode($pedigree);
        $objUserPrivacy->images = json_encode($images);
        $objUserPrivacy->videos = json_encode($videos);
        $objUserPrivacy->journals = json_encode($journals);
        $objUserPrivacy->event = json_encode($events);
        
        $success = $objUserPrivacy->save();
    }

    /**
     * Function to get user privacy settings
     *
     * @name getPrivacySettingsByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getPrivacySettingsByUserId($userId)
    {
        $arrUserPrivacySettings = self::select('*')->where('user_id', '=', $userId)
            ->get()
            ->toArray();
        
        return $arrUserPrivacySettings;
    }

    /**
     * Function to update user privacy settings
     *
     * @name updateUserPrivacySettings
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function updateUserPrivacySettings($userId, $appearToWorldMap, $appearToMyNetwork, $pedigree, $images, $videos, $journals, $events)
    {
        // get reocrd id
        $objUserPrivacySetting = self::select('id')->where('user_id', '=', $userId)->get();
        
        $userPrivacySettingId = $objUserPrivacySetting[0]->id;
        
        // update record
        $objUserPrivacy = self::find($userPrivacySettingId);
        
        $objUserPrivacy->user_id = $userId;
        $objUserPrivacy->appear_to_world_map = $appearToWorldMap;
        $objUserPrivacy->appear_to_my_network = $appearToMyNetwork;
        $objUserPrivacy->pedigree = json_encode($pedigree);
        $objUserPrivacy->images = json_encode($images);
        $objUserPrivacy->videos = json_encode($videos);
        $objUserPrivacy->journals = json_encode($journals);
        $objUserPrivacy->event = json_encode($events);
        
        $success = $objUserPrivacy->save();
        
        return $objUserPrivacy->id;
    }
    
    /**
     * Function to get user privacy settings by Modules
     *
     * @name getPrivacySettingsByModule
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public static function getPrivacySettingsByModule($profileID,$module)
    {
        $arrModulePrivacySettings = self::select('user_id',$module)->where('user_id','=',$profileID)->first();  
        return $arrModulePrivacySettings;
    }
    
       
}
