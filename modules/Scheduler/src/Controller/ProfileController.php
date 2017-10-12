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
use Modules\Profile\Model\Mailbox;
use Modules\Profile\Model\DeleteSuggestion;
use Modules\Profile\Model\UserPrivacy;
use Modules\Profile\Model\Notifications;
use Modules\User\Model\UserPackage;
use Modules\Gedcom\Model\UserGedcomFiles;

/**
 * ProfileController class for view method.
 *
 * @category ProfileController
 * @package Activity-Log
 * @author Amol Savat <amol.savat@silicus.com>
 * @license Silicus http://google.com
 * @name ProfileController
 * @version Release:<v.1>
 * @link http://google.com
 */
class ProfileController extends Controller
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
     * edited - sending package details based on user. 
     *
     * @name getMyNetwork
     * @access public
     * @author Dimple Agarwal <dimple.agarwal@silicus.com>
     *
     * @return void
     */
    public function getMyNetwork()
    {
        $jsFiles[] = Config::get('app.url') . 'theme/' . Config::get('app.theme') . '/assets/profile/js/profile.js';
        $cssFiles[] = "";
        $this->loadJsCSS($jsFiles, $cssFiles);
        
        $arrConnectedUsers = array();
        $arrSuggestions = array();
        $arrDelSuggestion = array();
        
        // get network users for Group/Forum
        $arrConnectedUsers = UserNetwork::getNetwokUsersByUserId(Auth::id());
        $arrSuggestions = UserNetwork::getUserSuggestions(Auth::id());
        $arrUserGedcoms = UserGedcomFiles::getUserGedComFiles(Auth::id());
        $onlineUsers = User::select('id','username')->get();
        
        $arrPackages = UserPackage::getAllPackagesNotByUser();
        $arrUserPackages = UserPackage::getAllPackagesByUser(Auth::id());
        $MainArr = array(
            'arrPackages' => $arrPackages,
            'arrUserPackages' => $arrUserPackages
        );
        
        $html = view::make('Profile::my-network', compact('arrConnectedUsers', 'arrSuggestions', 'arrUserGedcoms','onlineUsers'))->with('MainArr', $MainArr);
        return $html;
    }

    /**
     * User can search pepole those on platform by thier name
     *
     * @name searchPeopleByNameAjax
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function searchPeopleByNameAjax(Request $request)
    {
        // validate inputs
        $messages = [
            'search_name.required' => 'User Name is required.'
        
        ];
        
        $this->validate($request, [
            'search_name' => 'required'
        ], $messages);
        
        $keyword = $request->search_name;
        
        // get users by name
        $arrUsers = User::select('users.id', 'users.username')->where("users.id", "<>", Auth::id())
            ->join('user_privacy', 'user_privacy.user_id', '=', 'users.id')
            ->where("users.username", "like", "%" . $keyword . "%")
            ->where("user_privacy.appear_to_my_network", "=", '0')
            ->whereNotIn('users.id', function ($q) {
            $q->select('receiver_id')
                ->where('sender_id', '=', Auth::id())
                ->from('user_network');
        })
            ->whereNotIn('users.id', function ($q) {
            $q->select('sender_id')
                ->where('receiver_id', '=', Auth::id())
                ->from('user_network');
        })
            ->get()
            ->toArray();
        
        // render data into template
        $data = [
            'view' => View::make('Profile::user_search_result')->with('arrUsers', $arrUsers)->render()
        ];
        
        // return data
        return $data;
    }

    /**
     * User can send request to another user to add his network
     *
     * @name addUserRequestToConnect
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function addUserRequestToConnect(Request $request)
    {
        // validate inputs
        $messages = [
            'toUid.required' => 'User Name is required.',
            'relation.required' => 'User Name is required.'
        ];
        
        $this->validate($request, [
            'toUid' => 'required|numeric',
            'relation' => 'required'
        
        ], $messages);
        
        // add user connect request
        $receiverId = $request->toUid;
        $relation = $request->relation;
        
        $insert = UserNetwork::addUserRequestToConnect(Auth::id(), $receiverId, $relation);
        
        if ($insert) {
            // add user connect request notification
            $objUser = Auth::user();
            $uname = $objUser->username;
            $message = "You have received new connect request from " . $uname;
            
            Notifications::addNotification($message, "con_req_sent", '0', $receiverId);
            
            return response()->json([
                'code' => 200,
                'success' => 'Request sent successfully.'
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'success' => 'Something went wrong.'
            ]);
        }
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
    public function approveRejectUserRequest(Request $request)
    {
        // validate inputs
        $messages = [
            'requestId.required' => 'User Name is required.',
            'type.required' => 'User Name is required.'
        ];
        
        $this->validate($request, [
            'requestId' => 'required|numeric',
            'type' => 'required'
        
        ], $messages);
        
        // update the status of request
        $requestId = $request->requestId;
        $type = $request->type;
        
        $update = UserNetwork::approveRejectUserRequest($requestId, $type);
        
        if ($update) {
            $msg = 'Request approved successfully.';
            
            if ("reject" == $type) {
                $msg = 'Request rejected successfully.';
            }
            
            return response()->json([
                'code' => 200,
                'success' => $msg
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'success' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * This function is used to create User Group
     *
     * @name createUserGroup
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function createUserGroup(Request $request)
    {
        // validate inputs
        $messages = [
            'groupName.required' => 'Group Name is required.',
            'inviUsers.required' => 'Users are required.',
            'groupMsg.required' => 'Introductory message is required.'
        ];
        
        $this->validate($request, [
            'groupName' => 'required',
            'inviUsers' => 'required',
            'groupMsg' => 'required'
        
        ], $messages);
        
        // add network group
        $groupId = NetworkGroups::addNetworkGroup($request->groupName, $request->groupMsg, Auth::id(), 1);
        
        if ('' != $groupId) {
            // add network group memebers
            $arrUsers = explode(",", $request->inviUsers);
            
            $addUsersData = GroupUsers::addMembersToNetworkGroup($groupId, $arrUsers, "add");
            
            if ($addUsersData) {
                return response()->json([
                    'code' => 200,
                    'success' => 'Group/Forum created successfully.'
                ]);
            } else {
                return response()->json([
                    'code' => 400,
                    'success' => 'Something went wrong.'
                ]);
            }
        }
    }

    /**
     * This function is used to get Group memebers
     *
     * @name getUsersGroups
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function getUsersGroups()
    {
        // get Group/Forum data
        $arrUsersGroup = NetworkGroups::getAllGroupsByUserId(Auth::id());
        
        $html = view::make('Profile::list_users_groups', compact('arrUsersGroup'))->render();
        return $html;
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
    public function getGroupDetailsByGroupId(Request $request)
    {
        // validate inputs
        $messages = [
            'groupId.required' => 'Group ID is required.'
        ];
        
        $this->validate($request, [
            'groupId' => 'required'
        
        ], $messages);
        
        $groupDetails = NetworkGroups::getGroupDetailsByGroupId($request->groupId);
        
        return response()->json($groupDetails);
    }

    /**
     * This function is used to edit User Group
     *
     * @name editUserGroup
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function editUserGroup(Request $request)
    {
        // validate inputs
        $messages = [
            'groupId.required' => 'Group Id is required.',
            'groupId.numeric' => 'Group Id sholud be numeric.',
            'groupName.required' => 'Group Name is required.',
            'editInviUsers.required' => 'Users are required.',
            'groupMSg.required' => 'Introductory message is required.'
        ];
        
        $this->validate($request, [
            'groupId' => 'required|numeric',
            'groupName' => 'required',
            'editInviUsers' => 'required',
            'groupMSg' => 'required'
        
        ], $messages);
        
        // update network group
        $groupId = NetworkGroups::editNetworkGroup($request->groupId, $request->groupName, $request->groupMSg, Auth::id(), 1);
        
        $arrUsers = explode(",", $request->editInviUsers);
        
        $addUsersData = GroupUsers::addMembersToNetworkGroup($groupId, $arrUsers, "edit");
        
        if ($addUsersData) {
            return response()->json([
                'code' => 200,
                'success' => 'Group/Forum updated successfully.'
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'success' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * This function is used to send message to Group members
     *
     * @name createGroupMessage
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function createGroupMessage(Request $request)
    {
        // validate inputs
        $messages = [
            'groupId.required' => 'Group Id is required.',
            'groupId.numeric' => 'Group Id sholud be numeric.',
            'groupMessage.required' => 'Message Details is required.'
        ];
        
        $this->validate($request, [
            'groupId' => 'required|numeric',
            'groupMessage' => 'required'
        ], $messages);
        
        // get all memebers of group
        $groupDetails = NetworkGroups::getGroupDetailsByGroupId($request->groupId);
        
        // add messages to all members of group
        $addMessages = Mailbox::addMessageToAllGroupMembers($groupDetails["members"], $request->groupMessage, Auth::id());
        
        if ($addMessages) {
            // add notification for group conversations
            if (0 < count($groupDetails["members"])) {
                
                $groupName = $groupDetails[0]["name"];
                $message = "You have received new message in group " . $groupName;
                
                // prepare notification data
                foreach ($groupDetails["members"] as $key => $user) {
                    $arrNotificationData[] = array(
                        'message' => $message,
                        'type' => "group_conversations",
                        'status' => '0',
                        'user_id' => $user["user_id"]
                    );
                }
                
                // add notification to group members
                Notifications::addBulkNotification($arrNotificationData);
                
                return response()->json([
                    'code' => 200,
                    'success' => 'Message sent to group successfully.'
                ]);
            }
        } else {
            return response()->json([
                'code' => 400,
                'success' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * This function is used to send message to specific Group member
     *
     * @name createParticipantMessage
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function createParticipantMessage(Request $request)
    {
        // validate inputs
        $messages = [
            'participant.required' => 'Participant is required.',
            'participant.numeric' => 'Participant Id sholud be numeric.',
            'groupMessagePrti.required' => 'Message Details is required.'
        ];
        
        $this->validate($request, [
            'participant' => 'required|numeric',
            'groupMessagePrti' => 'required'
        ], $messages);
        
        // add message to user
        
        $userMsg = Mailbox::addMessageToParticipant($request->participant, $request->groupMessagePrti, Auth::id());
        
        if ($userMsg) {
            
            // add user message received request notification
            $objUser = Auth::user();
            $uname = $objUser->username;
            $message = "You have received new message from " . $uname;
            
            Notifications::addNotification($message, "one_to_one_conversations", '0', $request->participant);
            
            return response()->json([
                'code' => 200,
                'success' => 'Message sent to participant successfully.'
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'success' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * This function is used to get messages of user
     *
     * @name getUserMessages
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function getUserMessages()
    {
        // get Group/Forum data
        $arrUsersMessages = Mailbox::getAllMessagesByUserId(Auth::id());
        
        $html = view::make('Profile::list_users_messages', compact('arrUsersMessages'))->render();
        
        return $html;
    }

    /**
     * This function is used to get User Request Received
     *
     * @name getUserRequestReceived
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function getUserRequestReceived()
    {
        // get recived user connect request for Request Received
        $arrConnectRequests = UserNetwork::getUserRequestReceived(Auth::id());
        
        $html = view::make('Profile::list_users_request_received', compact('arrConnectRequests'))->render();
        
        return $html;
    }

    /**
     * This function is used to set User Privacy Settings
     *
     * @name setUserPrivacySettings
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function setUserPrivacySettings(Request $request)
    {
        $userId = Auth::id();
        $appearToWorldMap = $request->profileAppearWorldMap;
        $appearToMyNetwork = $request->profileAppearMyNetwork;
        
        $pedigree = array(
            "public" => (isset($request->pediInfo['ToPublic']) ? $request->pediInfo['ToPublic'] : 0),
            "closeFamily" => (isset($request->pediInfo['ToCloseFamily']) ? $request->pediInfo['ToCloseFamily'] : 0),
            "relative" => (isset($request->pediInfo['ToRelative']) ? $request->pediInfo['ToRelative'] : 0),
            "researchConnection" => (isset($request->pediInfo['ToResearchConnection']) ? $request->pediInfo['ToResearchConnection'] : 0),
            "nobody" => (isset($request->pediInfo['ToNobody']) ? $request->pediInfo['ToNobody'] : 0)
        );
        
        $images = array(
            "public" => (isset($request->imageInfo['ToPublic']) ? $request->imageInfo['ToPublic'] : 0),
            "closeFamily" => (isset($request->imageInfo['ToCloseFamily']) ? $request->imageInfo['ToCloseFamily'] : 0),
            "relative" => (isset($request->imageInfo['ToRelative']) ? $request->imageInfo['ToRelative'] : 0),
            "researchConnection" => (isset($request->imageInfo['ToResearchConnection']) ? $request->imageInfo['ToResearchConnection'] : 0),
            "nobody" => (isset($request->imageInfo['ToNobody']) ? $request->imageInfo['ToNobody'] : 0)
        );
        
        $videos = array(
            "public" => (isset($request->videoInfo['ToPublic']) ? $request->videoInfo['ToPublic'] : 0),
            "closeFamily" => (isset($request->videoInfo['ToCloseFamily']) ? $request->videoInfo['ToCloseFamily'] : 0),
            "relative" => (isset($request->videoInfo['ToRelative']) ? $request->videoInfo['ToRelative'] : 0),
            "researchConnection" => (isset($request->videoInfo['ToResearchConnection']) ? $request->videoInfo['ToResearchConnection'] : 0),
            "nobody" => (isset($request->videoInfo['ToNobody']) ? $request->videoInfo['ToNobody'] : 0)
        );
        
        $journals = array(
            "public" => (isset($request->journalsInfo['ToPublic']) ? $request->journalsInfo['ToPublic'] : 0),
            "closeFamily" => (isset($request->journalsInfo['ToCloseFamily']) ? $request->journalsInfo['ToCloseFamily'] : 0),
            "relative" => (isset($request->journalsInfo['ToRelative']) ? $request->journalsInfo['ToRelative'] : 0),
            "researchConnection" => (isset($request->journalsInfo['ToResearchConnection']) ? $request->journalsInfo['ToResearchConnection'] : 0),
            "nobody" => (isset($request->journalsInfo['ToNobody']) ? $request->journalsInfo['ToNobody'] : 0)
        );
        $events = array(
            "public" => (isset($request->eventsInfo['ToPublic']) ? $request->eventsInfo['ToPublic'] : 0),
            "closeFamily" => (isset($request->eventsInfo['ToCloseFamily']) ? $request->eventsInfo['ToCloseFamily'] : 0),
            "relative" => (isset($request->eventsInfo['ToRelative']) ? $request->eventsInfo['ToRelative'] : 0),
            "researchConnection" => (isset($request->eventsInfo['ToResearchConnection']) ? $request->eventsInfo['ToResearchConnection'] : 0),
            "nobody" => (isset($request->eventsInfo['ToNobody']) ? $request->eventsInfo['ToNobody'] : 0)
        );
        
        $update = UserPrivacy::updateUserPrivacySettings($userId, $appearToWorldMap, $appearToMyNetwork, $pedigree, $images, $videos, $journals, $events);
        
        if ($update) {
            return response()->json([
                'code' => 200,
                'success' => 'Privacy Settings updated successfully.'
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'success' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * This function is used to get User Privacy Settings
     *
     * @name getUserRequestReceived
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function getPrivacySettings()
    {
        $userId = Auth::id();
        
        $arrUserPrivacySettings = UserPrivacy::getPrivacySettingsByUserId($userId);
        
        // dd($arrUserPrivacySettings);
        $html = view::make('Profile::privacy_setting')->with('appear_to_world_map', $arrUserPrivacySettings[0]["appear_to_world_map"])
            ->with('appear_to_my_network', $arrUserPrivacySettings[0]["appear_to_my_network"])
            ->with('pedigree', json_decode($arrUserPrivacySettings[0]["pedigree"], true))
            ->with('images', json_decode($arrUserPrivacySettings[0]["images"], true))
            ->with('videos', json_decode($arrUserPrivacySettings[0]["videos"], true))
            ->with('journals', json_decode($arrUserPrivacySettings[0]["journals"], true))
            ->with('event', json_decode($arrUserPrivacySettings[0]["event"], true))
            ->render();
        
        return $html;
    }

    /**
     * This function is used to get User Notifications
     *
     * @name getUserNotification
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function getUserNotification()
    {
        $arrNotifications = Notifications::getNotificationsByUserId(Auth::id());
        
        $html = view::make('Profile::list_user_notifications')->with('notifications', $arrNotifications);
        
        return $html;
    }

    
    /**
     * This function is used to mark(as read) User Notifications
     *
     * @name markUserNotification
     * @access public
     * @author Amol Savat <amol.savat@silicus.com>
     *
     * @return void
     */
    public function markUserNotification(Request $request)
    {
        
        // validate inputs
        $messages = [
            'nid.required' => 'Notification id is required.',
            'nid.numeric' => 'Notification Id sholud be numeric.'
        ];
        
        $this->validate($request, [
            'nid' => 'required|numeric'
        ], $messages);
        
        // update notification status
        $arrNotifications = Notifications::markUserNotificationById($request->nid);
    }

     /**
     * This function is used to delete Suggest user
     *
     * @name deleteSuggestion
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public function deleteSuggestion(Request $request)
    {
        $userId = Auth::id();
        $suggestionId = $request->suggestionId;
        $status = '0';
        $deleteSuggestion = DeleteSuggestion::deleteUserSuggestion($userId, $suggestionId, $status);
        
        if ($deleteSuggestion) {
            return response()->json([
                'code' => 200,
                'success' => 'Suggestion deleted successfully.'
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'success' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * This function is used to show Delete Suggestion List for login user
     *
     * @name DeleteSuggestionList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public function DeleteSuggestionList()
    {
        $arrDelSuggestion = array();
        $arrDelSuggestion = DeleteSuggestion::getDeleteSuggestionList(Auth::id());
        return response()->json($arrDelSuggestion);
        return view('Profile::my-network')->with('arrDelSuggestion', $arrDelSuggestion);
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
    public function userStatus(Request $request)
    {        
        $onlineStatus = array();
        $onlineStatus = User::userOnlineStatus();        
        return response()->json($onlineStatus);
    }
    
    
}
