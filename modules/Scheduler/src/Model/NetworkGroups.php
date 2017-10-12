<?php
/**
 * NetworkGroups class to add / edit / delete UserNetwork
 *
 * @name       NetworkGroups.php
 * @category   NetworkGroups
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

class NetworkGroups extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'network_groups';

    /**
     * Function to add network group
     *
     * @name addNetworkGroup
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addNetworkGroup($groupName, $groupDesc, $userId, $status)
    {
        $userNetworkGroup = new self();
        
        $userNetworkGroup->name = $groupName;
        $userNetworkGroup->description = $groupDesc;
        $userNetworkGroup->user_id = $userId;
        $userNetworkGroup->status = '0';
        
        $success = $userNetworkGroup->save();
        
        return $userNetworkGroup->id;
    }

    /**
     * Function to edit network group
     *
     * @name addNetworkGroup
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function editNetworkGroup($groupId, $groupName, $groupDesc, $userId, $status)
    {
        $userNetworkGroup = NetworkGroups::find($groupId);
        
        $userNetworkGroup->name = $groupName;
        $userNetworkGroup->description = $groupDesc;
        $userNetworkGroup->user_id = $userId;
        $userNetworkGroup->status = '0';
        
        $success = $userNetworkGroup->save();
        
        return $userNetworkGroup->id;
    }

    /**
     * Function to get groups by user id
     *
     * @name getAllGroupsByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getAllGroupsByUserId($userId)
    {
        $arrMemberGroups = array();
        $arrOwnGroups = array();
        $arrAllGroups = array();
        
        // get user memeber groups
        $arrMemberGroups = self::select('network_groups.id', 'network_groups.name', 'network_groups.user_id')->join('group_users', 'group_users.network_group_id', '=', 'network_groups.id')
            ->where('group_users.user_id', '=', $userId)
            ->get()
            ->toArray();
        
        // get users own groups
        $arrOwnGroups = self::select('network_groups.id', 'network_groups.name', 'network_groups.user_id')->join('group_users', 'group_users.network_group_id', '=', 'network_groups.id')
            ->where('network_groups.user_id', '=', $userId)
            ->groupBy('network_groups.id')
            ->get()
            ->toArray();
        
        // merge all
        $arrAllGroups = array_merge($arrMemberGroups, $arrOwnGroups);
        
        return $arrAllGroups;
    }

    /**
     * This function is used to get Group details
     *
     * @name getGroupDetails
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getGroupDetailsByGroupId($groupID)
    {
        // get group details
        $arrGroupDetails = self::select('id', 'name', 'description', 'user_id')->where('id', '=', $groupID)
            ->get()
            ->toArray();
        
        // get user memeber groups
        $arrGroupMemberDetails = self::select('users.username', 'users.id as user_id')->join('group_users', 'group_users.network_group_id', '=', 'network_groups.id')
            ->join('users', 'users.id', '=', 'group_users.user_id')
            ->where('network_groups.id', '=', $groupID)
            ->where('users.status', '=', '1')
            ->get()
            ->toArray();
        
        $arrGroupDetails['members'] = $arrGroupMemberDetails;
        
        return $arrGroupDetails;
    }
}
