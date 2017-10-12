<?php
/**
 * Mailbox class to add / edit / delete mesaages
 *
 * @name       Mailbox.php
 * @category   Mailbox
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

class Mailbox extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'mailbox';

    public $timestamps = false;

    /**
     * Function to add message to all group members
     *
     * @name addMessageToAllGroupMembers
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addMessageToAllGroupMembers($arrGroupUsers, $groupMessage, $senderId)
    {
        if (0 < count($arrGroupUsers)) {
            $arrUserData = array();
            
            // add message to each member
            foreach ($arrGroupUsers as $key => $user) {
                
                $arrUserData[] = array(
                    'description' => $groupMessage,
                    'sender_id' => $senderId,
                    'receiver_id' => $user["user_id"]
                );
            }
            
            // insert bulk data
            if (0 < count($arrUserData)) {
                return self::insert($arrUserData);
            }
            
            return true;
        }
        return false;
    }

    /**
     * Function to add message to Participant
     *
     * @name addMessageToAllGroupMembers
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addMessageToParticipant($receiverId, $groupDesc, $senderId)
    {
        $objMailBox = new self();
        
        $objMailBox->description = $groupDesc;
        $objMailBox->sender_id = $senderId;
        $objMailBox->receiver_id = $receiverId;
        
        $success = $objMailBox->save();
        
        return $objMailBox->id;
    }

    /**
     * Function to add message to get all users messages
     *
     * @name addMessageToAllGroupMembers
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getAllMessagesByUserId($userId)
    {
        $arrMessages = self::select('id', 'description')->where('receiver_id', '=', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        
        return $arrMessages;
    }
}
