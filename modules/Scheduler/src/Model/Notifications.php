<?php
/**
 * Mailbox class to add / edit / delete notifications
 *
 * @name       Notifications.php
 * @category   Notifications
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
use Illuminate\Notifications\Notification;

class Notifications extends Model
{

    protected $primaryKey = 'id';

    protected $table = 'notifications';

    public $timestamps = false;

    /**
     * Function to get user notifications
     *
     * @name getNotificationsByUserId
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function getNotificationsByUserId($userId)
    {
        $arrNotifications = self::select('id', 'message')->where('user_id', '=', $userId)
            ->where('status', '=', '0')
            ->get()
            ->toArray();
        
        return $arrNotifications;
    }

    /**
     * Function to add user notification
     *
     * @name addNotification
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addNotification($message, $type, $status, $userId)
    {
        $objNotification = new self();
        
        $objNotification->message = $message;
        $objNotification->type = $type;
        $objNotification->status = $status;
        $objNotification->user_id = $userId;
        
        $success = $objNotification->save();
        
        return $success;
    }

    /**
     * Function to add bulk user notification
     *
     * @name addBulkNotification
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function addBulkNotification($arrNotificationData)
    {
        // insert bulk notification data
        if (0 < count($arrNotificationData)) {
            return self::insert($arrNotificationData);
        }
    }

    /**
     * Function to update the notification status
     *
     * @name markUserNotificationById
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public static function markUserNotificationById($notificationId)
    {
        if ('' != $notificationId) {
            
            $objNotification = Notifications::find($notificationId);
            $objNotification->status = '1';
            
            $success = $objNotification->save();
            
            return $success;
        }
    }
}
