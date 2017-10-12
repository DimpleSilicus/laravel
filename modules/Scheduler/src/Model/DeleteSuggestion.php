<?php
/**
 * DeleteSuggestion class to add / edit / delete DeleteSuggestion
 *
 * @name       DeleteSuggestion.php
 * @category   Model
 * @package    Profile
 * @author     Swapnil Patil <swapnilj.patil@silicus.com>
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

class DeleteSuggestion extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'delete_suggestion';

    /**
     * User can delete suggestion ( After deleting Suggestion record ,it save into delete_suggestion table and status is 0. In future this suggestion cannot display to user until the status is not change to 1 )
     *
     * @name addUserRequestToConnect
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public static function deleteUserSuggestion($userId,$suggestionId,$status)
    {
        $deleteSuggestion = new self();
        $deleteSuggestion->user_id = $userId;
        $deleteSuggestion->suggestion_id = $suggestionId;
        $deleteSuggestion->status = $status;
        
        $success = $deleteSuggestion->save();
        return $success;
    }
    
    
    /**
     * Get list of delete suggestion
     *
     * @name getDeleteSuggestionList
     * @access public
     * @author Swapnil Patil <swapnilj.patil@silicus.com>
     *
     * @return void
     */
    public static function getDeleteSuggestionList($userId)
    {
        $arrDelSuggest = self::select('user_id','suggestion_id','status')
        ->where('user_id','=',$userId)
        ->get()
        ->toArray();        
        return $arrDelSuggest;
    }
 
}
