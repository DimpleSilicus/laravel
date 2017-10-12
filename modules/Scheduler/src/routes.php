<?php

/**
 * Routes is using for urls and namespace used for give path for controller
 *
 * @name       routes
 * @category   Module
 * @package    ActivityLog
 * @author     Vivek Bansal <vivek.bansal@silicus.com>
 * @license    Silicus http://www.silicus.com/
 * @version    GIT: $Id$mynetwork
 * @link       None
 * @filesource
 */
Route::group([
    'middleware' => [
        'web',
        'auth'
    ],
    
    'namespace' => 'Modules\Scheduler\Controller'
], function () {
    
//    Route::get('profiles/mynetwork', 'ProfileController@getMyNetwork');
//    // reqests realted to Request Recived section
//    Route::post('profiles/searchPepole', 'ProfileController@searchPeopleByNameAjax');
//    Route::post('profiles/addUserRequestToConnect', 'ProfileController@addUserRequestToConnect');
//    Route::post('profiles/approveUserRequest', 'ProfileController@approveRejectUserRequest');
//    Route::post('profiles/rejectUserRequest', 'ProfileController@approveRejectUserRequest');
//    Route::post('profiles/listUserRequest', 'ProfileController@getUserRequestReceived');
//    Route::post('profiles/deleteUserSuggestion', 'ProfileController@deleteSuggestion');
//    Route::get('profiles/deleteSuggestList', 'ProfileController@DeleteSuggestionList');

    Route::get('showHomePage', 'SchedulerController@showHomePage');
    
});
