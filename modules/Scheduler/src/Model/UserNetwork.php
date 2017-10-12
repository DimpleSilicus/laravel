<?php
/**
 * UserNetwork class to add / edit / delete UserNetwork
 *
 * @name       UserNetwork.php
 * @category   UserNetwork
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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserNetwork extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'user_network';

    /**
     * User can send request to another user to add his network
     *
     * @name addUserRequestToConnect
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addUserRequestToConnect($senderId, $receiverId, $relation)
    {
        $userNetwork = new self();
        
        $userNetwork->sender_id = $senderId;
        $userNetwork->receiver_id = $receiverId;
        $userNetwork->relation = $relation;
        $userNetwork->status = '0';
        
        $success = $userNetwork->save();
        
        return $success;
    }

    /**
     * Get list of user recevied requests
     *
     * @name getUserRequestReceived
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getUserRequestReceived($userId)
    {
        $arrRequests = self::select('user_network.id', 'users.id as userid', 'users.username','user_network.relation')->join('users', 'users.id', '=', 'user_network.sender_id')
            ->where('user_network.status', '=', '0')
            ->where('user_network.receiver_id', '=', $userId)
            ->get()
            ->toArray();
        
        return $arrRequests;
    }
	
    /**
     * User can send approve and reject user request
     *
     * @name approveRejectUserRequest
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function approveRejectUserRequest($requestId, $type)
    {
        $status = '1';
        
        if ("reject" == $type) {
            $status = '2';
        }
        
        $objRequest = UserNetwork::find($requestId);
        $objRequest->status = $status;
        
        $success = $objRequest->save();
        
        // add user accepted connect request notification
        if ($success && "reject" != $type) {
            
            $objUser = Auth::user();
            $uname = $objUser->username;
            $message = $uname . " accepted your connect request";
            $receiverId = $objRequest->sender_id;
            
            Notifications::addNotification($message, "con_req_accepted", '0', $receiverId);
        }
        
        return $success;
    }

		public function isOnline()
	{
		return Cache::has('user-is-online-' . $this->id);
	}
	
    /**
     * Get all users those are in the users network
     *
     * @name getNetwokUsersByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getNetwokUsersByUserId($userId)
    {
            $arrUsers = self::select('users.id as userid', 'users.username','users.is_online','user_network.relation')->join('users', 'users.id', '=', 'user_network.sender_id')
            ->where('user_network.receiver_id', '=', $userId)
            ->where('user_network.status', '=', '1')
            ->get()
            ->toArray();
            
            $arrUsers2 = self::select('users.id as userid', 'users.username','users.is_online','user_network.relation')->join('users', 'users.id', '=', 'user_network.receiver_id')
            ->where('user_network.sender_id', '=', $userId)
            ->where('user_network.status', '=', '1')
            ->get()
            ->toArray();
        
        $arrAllUsers = array_merge($arrUsers, $arrUsers2);        
        return $arrAllUsers;
    } 
    
    
    /**
     * Get personal relation by network user 
     *
     * @name getNetwokUsersRelation
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public static function getNetwokUsersRelation($userId,$profileID)
    {
        $arrUsersRel = self::select('users.id as userid', 'users.username','user_network.relation')->join('users', 'users.id', '=', 'user_network.sender_id')
        ->where('user_network.sender_id', '=', $userId)
        ->where('user_network.receiver_id', '=', $profileID)
        ->where('user_network.status', '=', '1')
        ->get()
        ->toArray();
        
        $arrUsersRel2 = self::select('users.id as userid', 'users.username','user_network.relation')->join('users', 'users.id', '=', 'user_network.receiver_id')
        ->where('user_network.sender_id', '=', $profileID)
        ->where('user_network.receiver_id', '=', $userId)
        ->where('user_network.status', '=', '1')
        ->get()
        ->toArray();
        
        $arrRelation = array_merge($arrUsersRel, $arrUsersRel2);
        return $arrRelation;
    } 
    
    /**
     * Get all Friends suggestion as per login user
     *
     * @name getUserSuggestions
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public static function getUserSuggestions($userId)
    {        
        $arrSuggestions = DB::select( DB::raw(" SELECT DISTINCT userid,Suggestfriend,Suggestfriendname,name,email,username,password,status,type FROM
        (
              SELECT A1.userid,A1.friend,A1.Suggestfriend,A1.Suggestfriendname,A1.name,A1.email,A1.username,A1.password,A1.status,A1.type,A1.cnt FROM (
                   SELECT userid,friend,Suggestfriend,Suggestfriendname,name,email,username,password,status,type,cnt FROM (
                      SELECT userid,friend,Suggestfriend,(
                           SELECT name FROM users WHERE id=AD.Suggestfriend) AS Suggestfriendname,name,email,username,password,status,type,(userid+friend+Suggestfriend)cnt FROM (
                              SELECT A.id As userid,A.friend,( CASE WHEN A.friend=B.receiver_id THEN B.sender_id ELSE B.receiver_id END) 
                           AS Suggestfriend,A.name,A.email,A.username,A.password,A.status,A.type FROM (
                      SELECT users.*,( CASE WHEN users.id=user_network.receiver_id THEN user_network.sender_id ELSE user_network.receiver_id END) AS friend FROM users  INNER JOIN user_network On users.id=user_network.sender_id OR users.id=user_network.receiver_id )A
                   INNER JOIN user_network B On A.friend=B.sender_id OR A.friend=B.receiver_id )AD 
              WHERE userid <> Suggestfriend and  userid='".$userId."' limit 10 )AAD
        )A1
        INNER JOIN
        (
              SELECT userid,cnt FROM ( 
                  SELECT userid,cnt,COUNT(cnt)cnt1 FROM (
                      SELECT userid,(userid+friend+Suggestfriend)cnt FROM (
                          SELECT A.id As userid,A.friend, ( CASE WHEN A.friend=B.receiver_id THEN B.sender_id ELSE B.receiver_id END) AS Suggestfriend,A.name,A.email,A.username,A.password,A.status,A.type FROM (
                              SELECT users.*,( CASE WHEN users.id=user_network.receiver_id THEN user_network.sender_id ELSE user_network.receiver_id END) AS friend FROM users INNER JOIN user_network  On users.id=user_network.sender_id OR users.id=user_network.receiver_id )A
                              INNER JOIN user_network B On A.friend=B.sender_id OR A.friend=B.receiver_id )
                          AD WHERE userid <> Suggestfriend and  userid='".$userId."' limit 10)
                      AAD Group By userid,cnt Having COUNT(cnt)=1)
                  A3)
              A2 ON A1.userid= A2.userid AND A1.cnt= A2.cnt )AD1
        Order By userid ASC ")); 
        
        return $arrSuggestions;
    } 
    
}
