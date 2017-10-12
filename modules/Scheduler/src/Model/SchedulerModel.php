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
namespace Modules\Scheduler\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Scheduler extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'scheduler';

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
//    public static function addUserPrivacySettings($userId, $appearToWorldMap, $appearToMyNetwork, $pedigree, $images, $videos, $journals, $events)
//    {
//        $objUserPrivacy = new self();
//        
//        $objUserPrivacy->user_id = $userId;
//        $objUserPrivacy->appear_to_world_map = $appearToWorldMap;
//        $objUserPrivacy->appear_to_my_network = $appearToMyNetwork;
//        $objUserPrivacy->pedigree = json_encode($pedigree);
//        $objUserPrivacy->images = json_encode($images);
//        $objUserPrivacy->videos = json_encode($videos);
//        $objUserPrivacy->journals = json_encode($journals);
//        $objUserPrivacy->event = json_encode($events);
//        
//        $success = $objUserPrivacy->save();
//    }
//
//    /**
//     * Function to get user privacy settings
//     *
//     * @name getPrivacySettingsByUserId
//     * @access public
//     * @author Amol Savat <amol.savat@silicus.com>
//     *
//     * @return void
//     */
//    public static function getPrivacySettingsByUserId($userId)
//    {
//        $arrUserPrivacySettings = self::select('*')->where('user_id', '=', $userId)
//            ->get()
//            ->toArray();
//        
//        return $arrUserPrivacySettings;
//    }

       
       
}
