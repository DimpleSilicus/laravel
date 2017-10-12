<?php
/**
 * GroupUsers class to add / edit / delete UserNetwork
 *
 * @name       GroupUsers.php
 * @category   GroupUsers
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

class GroupUsers extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'group_users';

    /**
     * Function to add memebers to network group
     *
     * @name addMembersToNetworkGroup
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addMembersToNetworkGroup($groupId, $arrUsers, $action)
    {
        // if edit group delete exiting members
        if ("edit" == $action) {
            GroupUsers::where('network_group_id', $groupId)->delete();
        }
        
        $arrUserData = array();
        
        // prepare data to insert into this table
        if (0 < count($arrUsers) && '' != $groupId) {
            foreach ($arrUsers as $key => $user) {
                $arrUserData[] = array(
                    'network_group_id' => $groupId,
                    'user_id' => $user
                );
            }
        }
        
        // insert bulk data
        if (0 < count($arrUserData)) {
            return self::insert($arrUserData);
        }
    }
}
