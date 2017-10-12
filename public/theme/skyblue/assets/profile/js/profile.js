

$(document).ready(function () {
	getGroups();
	getUserRequest();
	getMessages();
 $('#search_name').keypress(function(e) {
	SearchUser(e);	
  });

 $('#search_name_icon').click(function(e) {
     SearchUser(e);
 });
 
 function SearchUser(e)
 {
    
//    var key = e.which;
    var searchData = $('#search_name').val();
    $('#form-errors-searchname').html("");
    $("#searchname-div").removeClass("has-error");
    $("#search_result_table").removeClass("hide");
                  $.ajax({
                                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                      url: '/profiles/searchPepole',
                      type: 'POST',
                      data: {search_name: searchData},
                      success: function(data) {            
                          $("#search_result_div").removeClass("hide");
                          $("#search_result_table tbody").html('');
                          $("#search_result_table tbody").append(data.view)
                      },
                      error: function(data) {            	
                           var obj = jQuery.parseJSON(data.responseText);
                           if (obj.search_name) {
                                  $("#search_result_div").addClass("hide");
                                  $("#searchname-div").addClass("has-error");
                                  $('#form-errors-searchname').html(obj.search_name);
                           }
                      }
              });
 }
$(document).on("click", ".addUser", function() {
	var uid = $(this).attr("uid");
	var relation = $(this).text();
	var $tr = $(this).closest('tr'); 
	
	if('' != uid){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/profiles/addUserRequestToConnect',
			type: 'POST',
			data: {toUid: uid,relation: relation},
			success: function(data) {
				$tr.remove();
				$("#addUsersuccMsg").removeClass("hide");
				$("#addUsersuccMsg").html(data.success);
				$("#addUsersuccMsg").fadeTo(2000, 500).slideUp(600, function(){
		               $("#addUsersuccMsg").slideUp(600);
		        });   
				$("#search_result_table").addClass("hide");
			},
			error: function(data) {            	
				$("#addUserfailMsg").removeClass("hide");
				$("#addUserfailMsg").html("Something went wrong!");
				$("#addUserfailMsg").fadeTo(2000, 500).slideUp(600, function(){
		               $("#addUserfailMsg").slideUp(600);
		        });   
			}
		});
	}
});

/**  
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : function to send request to suggsted users
*/
$(document).on("click", ".suggestUser", function() {
	var uid = $(this).attr("uid");
	var relation = $(this).text();
	var $tr = $(this).closest('tr'); 
	
	if('' != uid){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/profiles/addUserRequestToConnect',
			type: 'POST',
			data: {toUid: uid,relation: relation},
			success: function(data) {
				$tr.remove();
				$("#suggestion_table #addUsersuccMsg").removeClass("hide");
				$("#suggestion_table #addUsersuccMsg").html(data.success);
				$("#suggestion_table #addUsersuccMsg").fadeTo(2000, 500).slideUp(600, function(){
		               $("#suggestion_table #addUsersuccMsg").slideUp(600);
		        });   
			},
			error: function(data) {            	
				$("#suggestion_table #addUserfailMsg").removeClass("hide");
				$("#suggestion_table #addUserfailMsg").html("Something went wrong!");
				$("#suggestion_table #addUserfailMsg").fadeTo(2000, 500).slideUp(600, function(){
		               $("#suggestion_table #addUserfailMsg").slideUp(600);
		        });   
			}
		});
	}
});

/**  
*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
*@description : function to delete user from suggestion list 
*/

$(document).on("click",'#deleteSuggestion', function() {
	
	var deleteId  = $(this).attr("deleteId");
	var $tr       = $(this).closest('tr'); 
	
	BootstrapDialog.confirm({	
		title: 'CONFIRM',
		message: 'Are you sure you want to delete this Suggestion?',
		type: BootstrapDialog.TYPE_DANGER, 
		closable: true, 
		draggable: true,
		btnCancelLabel: 'Cancel', 
		btnOKLabel: 'Ok', 
		btnOKClass: '', 
		callback: function (result) 
		{
			// result will be true if button was click, while it will be false if users close the dialog directly.
			if (result) 
				{
	
	
	    if('' != deleteId){
							$.ajax({
								headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
								url: '/profiles/deleteUserSuggestion',
								type: 'POST',
								data: {suggestionId:deleteId},
								success: function(data) {
									$tr.remove();
									$("#deleteSuggestionMsg").removeClass("hide");
									$("#deleteSuggestionMsg").html(data.success);
									$("#deleteSuggestionMsg").fadeTo(2000, 500).slideUp(600, function(){
							               $("#deleteSuggestionMsg").slideUp(600);
							        });   
								},
								error: function(data) {            	
									$("#deleteSuggestionfailMsg").removeClass("hide");
									$("#deleteSuggestionfailMsg").html("Something went wrong!");
									$("#deleteSuggestionfailMsg").fadeTo(2000, 500).slideUp(600, function(){
							               $("#deleteSuggestionfailMsg").slideUp(600);
							        });   
								}
							});
	     } 
	    
	    
				}
		}
	});
	    
	
});


$(document).on("click", ".approveReq", function() {
	var reqId = $(this).attr("reqId");	
	var $tr = $(this).closest('tr'); 
	
	BootstrapDialog.confirm({
        title: 'CONFIRM',
        message: 'Are you sure you want to approve this request?',
        type: BootstrapDialog.TYPE_SUCCESS, 
        closable: true, 
        draggable: true,
        btnCancelLabel: 'Cancel', 
        btnOKLabel: 'Ok', 
        btnOKClass: '', 
        callback: function (result) {
            // result will be true if button was click, while it will be false if users close the dialog directly.
            if (result) {
            	$.ajax({
        			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        			url: '/profiles/approveUserRequest',
        			type: 'POST',
        			data: {requestId: reqId,type: 'approve'},
        			success: function(data) {
        				$tr.remove();
        				$("#reqSuccMsg").removeClass("hide");
        				$("#reqSuccMsg").html(data.success);
        				$("#reqSuccMsg").fadeTo(2000, 500).slideUp(600, function(){
        		               $("#reqSuccMsg").slideUp(600);
        		        }); 
        				getUserRequest();
        			},
        			error: function(data) {            	
        				$("#reqFailMsg").removeClass("hide");
        				$("#reqFailMsg").html("Something went wrong!");
        				$("#reqFailMsg").fadeTo(2000, 500).slideUp(600, function(){
        		               $("#reqFailMsg").slideUp(600);
        		        });   
        			}
        		});
            } else {
                return false;
            }
        }
    });
	/**
	if('' != reqId){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/profiles/approveUserRequest',
			type: 'POST',
			data: {requestId: reqId,type: 'approve'},
			success: function(data) {
				$tr.remove();
				$("#reqSuccMsg").removeClass("hide");
				$("#reqSuccMsg").html(data.success);
				$("#reqSuccMsg").fadeTo(2000, 500).slideUp(600, function(){
		               $("#reqSuccMsg").slideUp(600);
		        });   
			},
			error: function(data) {            	
				$("#reqFailMsg").removeClass("hide");
				$("#reqFailMsg").html("Something went wrong!");
				$("#reqFailMsg").fadeTo(2000, 500).slideUp(600, function(){
		               $("#reqFailMsg").slideUp(600);
		        });   
			}
		});
	}
	**/
});

$(document).on("click", ".rejectReq", function() {
	var reqId = $(this).attr("reqId");	
	var $tr = $(this).closest('tr'); 
	
	BootstrapDialog.confirm({
        title: 'CONFIRM',
        message: 'Are you sure you want to reject this request?',
        type: BootstrapDialog.TYPE_DANGER, 
        closable: true, 
        draggable: true,
        btnCancelLabel: 'Cancel', 
        btnOKLabel: 'Ok', 
        btnOKClass: '', 
        callback: function (result) {
            // result will be true if button was click, while it will be false if users close the dialog directly.
            if (result) {
            	$.ajax({
        			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        			url: '/profiles/rejectUserRequest',
        			type: 'POST',
        			data: {requestId: reqId,type: 'reject'},
        			success: function(data) {
        				$tr.remove();
        				$("#reqSuccMsg").removeClass("hide");
        				$("#reqSuccMsg").html(data.success);
        				$("#reqSuccMsg").fadeTo(2000, 500).slideUp(600, function(){
        		               $("#reqSuccMsg").slideUp(600);
        		        });   
        			},
        			error: function(data) {            	
        				$("#reqFailMsg").removeClass("hide");
        				$("#reqFailMsg").html("Something went wrong!");
        				$("#reqFailMsg").fadeTo(2000, 500).slideUp(600, function(){
        		               $("#reqFailMsg").slideUp(600);
        		        });   
        			}
        		});
            } else {
                return false;
            }
        }
    });
	
});


var loginForm = $("#frmCreateGroup");
loginForm.submit(function(e) {
	
	e.preventDefault();
	
	var formData = loginForm.serialize();
	
	$('#form-errors-groupname').html("");
	$("#form-errors-inviusers").html("");
	$("#form-errors-groupmsg").html("");
	
	$("#groupname-div").removeClass("has-error");
	$("#inviusers-div").removeClass("has-error");
	$("#groupmsg-div").removeClass("has-error");
          
    $.ajax({
    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    	url: '/group/create',
        type: 'POST',
        data: formData,
        success: function(data) {
        	
        	$("#grpSuccMsg").removeClass("hide");
			$("#grpSuccMsg").html(data.success);
			$("#grpSuccMsg").fadeTo(2000, 500).slideUp(600, function(){
	               $("#grpSuccMsg").slideUp(600);
	        });
			getGroups();
			$("#groupName").val('');
			$("#groupUsers").val('');
			$("#selGrpUsers").html('');
			$("#groupMsg").val('');
			$("#inviUsers").val('');
			$("#CreateGroup").modal('hide');
        },
        error: function(data) {            	
        	$(".login-link").addClass("open");
            console.log(data.responseText);
            var obj = jQuery.parseJSON(data.responseText);
            
            if (obj.groupName) {
            	$("#groupname-div").addClass("has-error");
            	$('#form-errors-groupname').html(obj.groupName);
            }
            if (obj.inviUsers) {
                $("#inviusers-div").addClass("has-error");
                $("#form-errors-inviusers").html(obj.inviUsers);
            }
            if (obj.groupMsg) {
                $("#groupmsg-div").addClass("has-error");
                $("#form-errors-groupmsg").html(obj.groupMsg);
            }
            if (obj.error) {
            	$("#grpFailMsg").removeClass("hide");
				$("#grpFailMsg").html("Something went wrong!");
				$("#grpFailMsg").fadeTo(2000, 500).slideUp(600, function(){
		               $("#grpFailMsg").slideUp(600);
		        });   
				$("#CreateGroup").modal('hide');
            }
            $("#groupName").val('');
			$("#groupUsers").val('');
			$("#selGrpUsers").html('');
			$("#groupMsg").val('');
			$("#inviUsers").val('');
           
        }
    });
});


	$(document).on("change", "#groupUsers", function() {		
		var listOfNumbers = $("#inviUsers").val();		
		var uid = $(this).val();
		var uname = $("#groupUsers option:selected").html();
		var link ='';
		
		if('' != uid){
			var numbers = listOfNumbers.split(',');
			if('' == listOfNumbers){			
				$("#inviUsers").val(uid);
				 link ='<a href="#" class="removeSelUser" id="'+uid+'"><i class="fa fa-remove"></i>'+uname+'</a>';
			}
			else if(numbers.indexOf(uid)==-1) {
			  numbers.push(uid);
			  listOfNumbers = numbers.join(',');
			  $("#inviUsers").val(listOfNumbers);
			   link ='<a href="#" class="removeSelUser" id="'+uid+'"><i class="fa fa-remove"></i>'+uname+'</a>';
			}
			
			if('' != link){
				$("#selGrpUsers").append(link);
			}
		}		
	});
	

	$(document).on("click", ".removeSelUser", function() {	
			var listOfNumbers = $("#inviUsers").val();		
			var ids = remove(listOfNumbers,$(this).attr("id"));
			$("#inviUsers").val(ids);	
			$(this).remove();
	});
	
	$(document).on("change", "#editGroupUsers", function() {		
		var listOfNumbers = $("#EditGroup #editInviUsers").val();
		var uid = $(this).val();
		var uname = $("#editGroupUsers option:selected").html();
		var link ='';
		
		if('' != uid){
			var numbers = listOfNumbers.split(',');
			if('' == listOfNumbers){			
				$("#EditGroup #editInviUsers").val(uid);
				 link ='<a href="#" class="removeExSelUser" id="'+uid+'"><i class="fa fa-remove"></i>'+uname+'</a>';
			}
			else if(numbers.indexOf(uid)==-1) {
			  numbers.push(uid);
			  listOfNumbers = numbers.join(',');
			  $("#EditGroup #editInviUsers").val(listOfNumbers);
			   link ='<a href="#" class="removeExSelUser" id="'+uid+'"><i class="fa fa-remove"></i>'+uname+'</a>';
			}
			
			if('' != link){
				$("#EditGroup #selGrpUsers").append(link);
			}
		}		
	});
	
	
	$(document).on("click", ".removeExSelUser", function() {	
		var listOfNumbers = $("#EditGroup #editInviUsers").val();
		var ids = remove(listOfNumbers,$(this).attr("id"));
		$("#EditGroup #editInviUsers").val(ids);
		$(this).remove();
	});
	
	function remove(string,to_remove)
	{
			var elements=string.split(",");
			var remove_index=elements.indexOf(to_remove);
			elements.splice(remove_index,1);
			var result=elements.join(",");
			return result;	  
	}
	
	function getGroups(){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/group/list',
			type: 'POST',
			data: {},
			success: function(data) {
				$("#grpTable > tbody").html("");
				$(data).appendTo("#grpTable tbody");				
			},
			error: function(data) {            	
				
			}
		});
		
	}
	
	$(document).on("click", ".editGrp", function() {	
		$('#EditGroup').modal('show');
		var grpId = $(this).attr("grpId");
				
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/group/details',
			type: 'POST',
			data: {groupId:grpId},
			success: function(data) {
				
				$("#EditGroup #groupId").val(data[0].id);
				$("#EditGroup #groupName").val(data[0].name);
				$("#EditGroup #groupMSg").val(data[0].description);
				$("#EditGroup #selGrpUsers").html('');
				var uids = '';
				$.each(data["members"], function( index, value ) {					 
					var link = '<a href="#" class="removeExSelUser" id="'+value.user_id+'"><i class="fa fa-remove"></i>'+value.username+'</a>';					
					$("#EditGroup #selGrpUsers").append(link);
					if('' != uids){
						uids = uids+','+value.user_id;
					}else{
						uids = value.user_id;
					}
					
				});
				$("#EditGroup #editInviUsers").val(uids);
			},
			error: function(data) {            	
				
			}
		});
	});
	
	var editGroupForm = $("#frmEditGroup");
	editGroupForm.submit(function(e) {
		
		e.preventDefault();
		
		var formData = editGroupForm.serialize();
		
		$('#EditGroup #form-errors-groupname').html("");
		$("#EditGroup #form-errors-inviusers").html("");
		$("#EditGroup #form-errors-groupmsg").html("");
		
		$("#EditGroup #groupname-div").removeClass("has-error");
		$("#EditGroup #inviusers-div").removeClass("has-error");
		$("#EditGroup #groupmsg-div").removeClass("has-error");
	          
	    $.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/group/edit',
	        type: 'POST',
	        data: formData,
	        success: function(data) {
	        	
	        	$("#grpSuccMsg").removeClass("hide");
				$("#grpSuccMsg").html(data.success);
				$("#grpSuccMsg").fadeTo(2000, 500).slideUp(600, function(){
		        $("#grpSuccMsg").slideUp(600);
		        });
				
				getGroups();
				
				$("#EditGroup").modal('hide');
	        },
	        error: function(data) {
	            console.log(data.responseText);
	            var obj = jQuery.parseJSON(data.responseText);
	            
	            if (obj.groupName) {
	            	$("#EditGroup #groupname-div").addClass("has-error");
	            	$('#EditGroup #form-errors-groupname').html(obj.groupName);
	            }
	            if (obj.editInviUsers) {
	                $("#EditGroup #inviusers-div").addClass("has-error");
	                $("#EditGroup #form-errors-inviusers").html(obj.editInviUsers);
	            }
	            if (obj.groupMSg) {
	                $("#EditGroup #groupmsg-div").addClass("has-error");
	                $("#EditGroup #form-errors-groupmsg").html(obj.groupMSg);
	            }
	            if (obj.error) {
	            	$("#grpFailMsg").removeClass("hide");
					$("#grpFailMsg").html("Something went wrong!");
					$("#grpFailMsg").fadeTo(2000, 500).slideUp(600, function(){
			        $("#grpFailMsg").slideUp(600);
			        });   
					
					$("#EditGroup").modal('hide');
	            }	          
	        }
	    });
	});
	
	$(document).on("click", ".btnComposeGroupMail", function() {	
		$("#ComposeGroupMail").modal('show');
		var grpoupId = $(this).attr("grpid");
		var grpName = $(this).attr("grpName");
		$("#composeGroupName").html(grpName);
		$("#ComposeGroupMail #groupId").val(grpoupId);
	});
	
	$(document).on("click", ".btnComposePartiMail", function() {	
		$("#ComposeUserMail").modal('show');
		var grpoupId = $(this).attr("grpid");
		$("#participant").val('');
		$("#ComposeUserMail #groupMessagePrti").val(grpoupId);
	});
	
	var participantMessageForm = $("#frmComposeParticipantMessage");
	participantMessageForm.submit(function(e) {
		e.preventDefault();		
		var formData = participantMessageForm.serialize();
		
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/message/participant/compose',
	        type: 'POST',
	        data: formData,
	        success: function(data) {
	        	$("#partiMailSuccMsg").removeClass("hide");
				$("#partiMailSuccMsg").html(data.success);
				$("#partiMailSuccMsg").fadeTo(2000, 500).slideUp(600, function(){
		        $("#partiMailSuccMsg").slideUp(600);
		        });
				$("#ComposeUserMail").modal('hide');
	        },
	        error: function(data) {      
		        	console.log(data.responseText);
		            var obj = jQuery.parseJSON(data.responseText);
	        	  if (obj.participant) {
		            	$("#ComposeUserMail #participant-div").addClass("has-error");
		            	$('#ComposeUserMail #form-errors-participant').html(obj.participant);
		            }
		            if (obj.groupMessagePrti) {		            	
		            	$("#ComposeUserMail #groupMessagePrti-div").addClass("has-error");
		            	$('#ComposeUserMail #form-errors-groupMessagePrti').html(obj.groupMessagePrti);
		            }
		            if (obj.error) {
		            	$("#partiMailFailMsg").removeClass("hide");
						$("#partiMailFailMsg").html("Something went wrong!");
						$("#partiMailFailMsg").fadeTo(2000, 500).slideUp(600, function(){
				        $("#partiMailFailMsg").slideUp(600);
				        });   
						$("#ComposeUserMail").modal('hide');
		            }
	        }
	    });
		
	});
	
	var groupMessageForm = $("#frmComposeGroupMessage");
	groupMessageForm.submit(function(e) {
		e.preventDefault();		
		var formData = groupMessageForm.serialize();
		
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/message/group/compose',
	        type: 'POST',
	        data: formData,
	        success: function(data) {
	        	$("#grpSuccMsg").removeClass("hide");
				$("#grpSuccMsg").html(data.success);
				$("#grpSuccMsg").fadeTo(2000, 500).slideUp(600, function(){
		        $("#grpSuccMsg").slideUp(600);
		        });
				$("#ComposeGroupMail").modal('hide');
	        },
	        error: function(data) {  
        	 	console.log(data.responseText);
	            var obj = jQuery.parseJSON(data.responseText);
	            
	            if (obj.groupId) {
	            	$("#ComposeGroupMail #groupMessage-div").addClass("has-error");
	            	$('#ComposeGroupMail #form-errors-groupMessage').html(obj.groupId);
	            }
	            if (obj.groupMessage) {	            	
	            	$("#ComposeGroupMail #groupMessage-div").addClass("has-error");
	            	$('#ComposeGroupMail #form-errors-groupMessage').html(obj.groupMessage);
	            }
	            if (obj.error) {
	            	$("#grpFailMsg").removeClass("hide");
					$("#grpFailMsg").html("Something went wrong!");
					$("#grpFailMsg").fadeTo(2000, 500).slideUp(600, function(){
			        $("#grpFailMsg").slideUp(600);
			        });   
					$("#ComposeGroupMail").modal('hide');
	            }
	        }
	    });
	});
	
	function getMessages(){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/message/list',
			type: 'POST',
			data: {},
			success: function(data) {
				$("#mailboxTable > tbody").html("");
				$(data).appendTo("#mailboxTable tbody");				
			},
			error: function(data) {            	
				
			}
		});
	}
	
	function getUserRequest(){
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/profiles/listUserRequest',
			type: 'POST',
			data: {},
			success: function(data) {
				$("#userRequestsTable > tbody").html("");
				$(data).appendTo("#userRequestsTable tbody");				
			},
			error: function(data) {            	
				
			}
		});
	}
	
	var changePassForm = $("#frmChangePass");
	changePassForm.submit(function(e) {
		e.preventDefault();		
		var formData = changePassForm.serialize();
		
		$('#form-errors-oldPass').html("");
		$('#form-errors-newPass').html("");
		$('#form-errors-newConfPass').html("");
		
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/account/updatePassword',
	        type: 'POST',
	        data: formData,
	        success: function(data) {
	        	if (data.old_password_error) {
	            	$("#oldPass-div").addClass("has-error");
	            	$('#form-errors-oldPass').html(data.old_password_error);
	            }
	        	
	        	if (data.old_password) {
	        		$("#changePassSuccMsg").removeClass("hide");
					$("#changePassSuccMsg").html(data.old_password);
					$("#changePassSuccMsg").fadeTo(2000, 500).slideUp(600, function(){
			        $("#changePassSuccMsg").slideUp(600);
			        });
	            }	        	
	        },
	        error: function(data) {  
        		var obj = jQuery.parseJSON(data.responseText);        		
        		if (obj.old_password) {
	            	$("#oldPass-div").addClass("has-error");
	            	$('#form-errors-oldPass').html(obj.old_password);
	            }
        		if (obj.password) {
	            	$("#newPass-div").addClass("has-error");
	            	$('#form-errors-newPass').html(obj.password);
	            }
        		if (obj.password_confirmation) {
	            	$("#newConfPass-div").addClass("has-error");
	            	$('#form-errors-newConfPass').html(obj.password_confirmation);
	            }
	        }
	    });
	});
	
	var privacySettingForm = $("#frmPrivacySetting");
	privacySettingForm.submit(function(e) {
		e.preventDefault();		
		var formData = privacySettingForm.serialize();		
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/user/privacySettings',
	        type: 'POST',
	        data: formData,
	        success: function(data) {
	        		
	        },
	        error: function(data) {  
        		
	        }
	    });
	});
	
	
	$('#privacy-setting').on('submit', 'form', function(event) {
		var privacySettingForm = $("#frmPrivacySetting");		
		var formData = privacySettingForm.serialize();		
		$.ajax({
	    	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    	url: '/user/privacySettings',
	        type: 'POST',
	        data: formData,
	        success: function(data) {
	        	$("#privSetiSuccMsg").removeClass("hide");
				$("#privSetiSuccMsg").html(data.success);
				$("#privSetiSuccMsg").fadeTo(2000, 500).slideUp(600, function(){
		        $("#privSetiSuccMsg").slideUp(600);
		        });
	        },
	        error: function(data) {  
        		
	        }
	    });
		
		return false;
	});
	
	$(document).on('change', $("input[name='pediInfo[ToNobody]']"), function() {
		checkUncheck("pediInfo[ToNobody]","pediInfo");
	});
	
	$(document).on('change', $("input[name='imageInfo[ToNobody]']"), function() {
		checkUncheck("imageInfo[ToNobody]","imageInfo");
	});
	
	$(document).on('change', $("input[name='videoInfo[ToNobody]']"), function() {
		checkUncheck("videoInfo[ToNobody]","videoInfo");
	});
	
	$(document).on('change', $("input[name='journalsInfo[ToNobody]']"), function() {
		checkUncheck("journalsInfo[ToNobody]","journalsInfo");
	});
	$(document).on('change', $("input[name='eventsInfo[ToNobody]']"), function() {
		checkUncheck("eventsInfo[ToNobody]","eventsInfo");
	});
	
	function checkUncheck($parentEleName, $eleName){		
		if($("input[name='"+$parentEleName+"']").prop("checked")){
			$('input[name^="'+$eleName+'"]').each(function() {
				if("nobody" != $(this).val()){
					$(this).removeAttr("checked");
					$(this).attr("disabled", true);
				}				
			});
		}else{
			$('input[name^="'+$eleName+'"]').each(function() {
				if("nobody" != $(this).val()){
					$(this).attr("disabled", false);
				}				
			});	
		}		
	}
	
	$( ".tabPrivacySetting" ).click(function() {		
		$(".privacy-setting-content").html('');
		
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/user/getPrivacySettings',
		    type: 'POST',
		    success: function(data) {
		    	$(".privacy-setting-content").html(data);
		    },
		    error: function(data) {  
				
		    }
		});
	});
	
	$( ".tabNotifications" ).click(function() {		
		$(".notification-content").html('');
		
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/notifications/list',
		    type: 'POST',
		    success: function(data) {
		    	$(".notification-content").html(data);
		    },
		    error: function(data) {  
				
		    }
		});
	});
	
	$(document).on("click", ".dismissNotification", function() {
		var did = $(this).attr("did");
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/notifications/mark',
		    type: 'POST',
		    data: {nid:did},
		    success: function(data) {
		    	$(".notification-content").html(data);
		    },
		    error: function(data) {  
				
		    }
		});
	});	
	
	$(document).on("change", "#userGedcom", function() {
		var gedid = $(this).val();		
		$.ajax({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			url: '/gedcom/family/tree',
		    type: 'POST',
		    data: {gedid:gedid},
		    success: function(data) {	
		    	$("#pk-family-tree #treeGround").html('');	
		    	$("#pk-family-tree #treeGround").html(data);
		    	
		    },
		    error: function(data) {  
				
		    }
		});
	});	
	
});


//for show menu
$('ul li.test-dropdown').on('click', function (e) {
    $('.tree-action-menu').hide();
    $('ul.tree-action-menu', this).show();
});

//for hide menu when click on cancel
$('.tree-action-menu .cancelBtn').on('click', function (e) {
    e.stopPropagation();
    $(this).closest('.tree-action-menu').hide();
});

//for hide menu when open modal
$('.tree-action-menu .addModal').on('click', function (e) {
    e.stopPropagation();
    $(this).closest('ul.tree-action-menu').hide();
    $('#AddMemberModal').modal('show')
});


//for view details modal
$('.tree-action-menu .viewDetailsModal').on('click', function(e) {
    e.stopPropagation();
    $(this).closest('ul.tree-action-menu').hide();
    $('#memberDetailContent').modal('show')
});


//vertical to horizontal
$('#TreeViewButton').on('click', function () {               
    $('#treeGround ul.setHorizontalView').toggleClass('treeHorizontalView');
    $('#treeGround ul.setHorizontalView a').toggleClass('rotate-90deg');
    $('ul.tree-action-menu').toggleClass('rotate-90deg');
    $('ul.tree-action-menu a').toggleClass('rotate-0');
});



		/** 
		 *@author      : Swapnil Patil <swapnilj.patil@silicus.com>
		 *@description : function to get delete suggestion list of users
		 */
		
		DeleteSuggestionList();
		function DeleteSuggestionList()
		{	 	
				
					$.ajax({
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						url: '/profiles/deleteSuggestList',
						type:'get',
						dataType:'json',
						success: function(data) {
		
								$.each(data, function(key,value) {	
								var rowId = $('#suggest_id').attr('sid');
								if(value.suggestion_id==rowId)
									{
									//$('#sid').attr(rowId).hide();
									}
								});	
										
						}
					}); 
						
		} 


		/**  
		*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
		*@description : function to get Profile user and Auth Relation
		*/
		
		getProfileRelation();
		function getProfileRelation()
		{
		    var profID = $('#profID').val(); 

			$.ajax({   
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/profiles/getProfileRelation',
				type: 'post',		
				data: {'profileID':profID},
				success: function(data) 
				{ 	
					    $.each(data, function( index, value ) 
					    {			
							$('#profRelation').val(value.relation);   	
						});
					
				}
			});  
		
		}
		
		
		/**  
		*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
		*@description : function to get Profile user personal details
		*/
		
		getProfilerDetails();
		function getProfilerDetails()
		{
		    var profID = $('#profID').val(); 

			$.ajax({   
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/profiles/getProfilerInfo',
				type: 'post',		
				data: {'profileID':profID},
				success: function(data) 
				{ 	
					$('#proID').text(data.name);   	
				}
			});  
		
		}
		
		/**  
		*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
		*@description : function to get user privacy settings for Journal Modules
		*/
		
		getJournalPrivacySettings();
		function getJournalPrivacySettings()
		{
		    var profID = $('#profID').val(); 
		  
		  

			$.ajax({   
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/profiles/getJournalSettings',
				type: 'post',		
				data: {'profileID':profID},
				success: function(data) 
				{ 		
					    var ralation 				= $('#profRelation').val();
						var userID				    = data.user_id;
						var parseData 				= JSON.parse(data.journals);  
						var setPublic 			    = parseData.public; 
						var setCloseFamily  		= parseData.closeFamily; 
						var setRelative  			= parseData.relative; 
						var setResearchConnection   = parseData.researchConnection; 
						var setNobody  			    = parseData.nobody; 	
			
						$('#journal_body').show();	
						$('#journal_msg').hide();
						
						//  journal nobody condition check here
						if(setNobody==1)
						{
							$('#journal_body').hide();
							$('#journal_msg').show();
						}
						else
						{
									// journal public condition check here
									if(setPublic==1)
									{
										$('#journal_body').show();
										$('#journal_msg').hide();
									}
									else
									{           
												if(ralation=='Close Family' && setCloseFamily==1)   // journal Close Family condition check here
												{	
														$('#journal_body').show();		
														$('#journal_msg').hide();
												}
												else if(ralation=='Relative' && setRelative==1)     // journal Relative check here
												{	
														$('#journal_body').show();	
														$('#journal_msg').hide();
												}
												else if(ralation=='Research Connection' && setResearchConnection==1)   // journal Research Connection check here
												{	
														$('#journal_body').show();	
														$('#journal_msg').hide();
												}
		
									}
							
						}
								
				}
			});  
		
		}
		
		
		/**  
		*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
		*@description : function to get user privacy settings for Event Modules
		*/
		
		getEventPrivacySettings();
		function getEventPrivacySettings()
		{
		    var profID = $('#profID').val(); 	    
			$.ajax({   
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					url: '/profiles/getEventSettings',
					type: 'post',		
					data: {'profileID':profID},
					success: function(data) 
					{ 		
						var ralation 				= $('#profRelation').val();
						var userID 					= data.user_id;
						var parseData 				= JSON.parse(data.event);  
						var setPublic 				= parseData.public; 
						var setCloseFamily  		= parseData.closeFamily; 
						var setRelative  			= parseData.relative; 
						var setResearchConnection   = parseData.researchConnection; 
						var setNobody  				= parseData.nobody; 	
						
						
					    //  event nobody condition check here
						if(setNobody==1)
						{
							$('#event_body').hide();  
						}
						else
						{
							// event public condition check here
							if(setPublic==1)
							{
								$('#event_body').show();
							}
							else
							{									
										if(ralation=='Close Family' && setCloseFamily==1)   // event Close Family condition check here
										{	
												$('#event_body').show();		
										}
										else if(ralation=='Relative' && setRelative==1)     // event Relative condition check here
										{	
												$('#event_body').show();		
										}
										else if(ralation=='Research Connection' && setResearchConnection==1)    // event Research Connection condition check here
										{	
												$('#event_body').show();		
										}

							}							
						}		
						
					}
			});  
		
		}
		
		
		/**  
		*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
		*@description : function to get user privacy settings for Picture Modules
		*/
		
		getPicturePrivacySettings();
		function getPicturePrivacySettings()
		{
		    var profID = $('#profID').val();     
			$.ajax({   
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/profiles/getPictureSettings',
				type: 'post',		
				data: {'profileID':profID},
				success: function(data) 
				{ 		
					var ralation 				= $('#profRelation').val();
					var userID 					= data.user_id;
					var parseData 				= JSON.parse(data.images);  
					var setPublic 				= parseData.public; 
					var setCloseFamily  		= parseData.closeFamily; 
					var setRelative  			= parseData.relative; 
					var setResearchConnection   = parseData.researchConnection; 
					var setNobody  				= parseData.nobody; 	
					
					 $('#picture_msg').show();
					
					//  images nobody condition check here
					if(setNobody==1)
					{
						$('#picture_body').hide();  
						$('#picture_msg').show();
					}
					else
					{
						// images public condition check here
						if(setPublic==1)
						{
							$('#picture_body').show();
							$('#picture_msg').hide();
						}
						else
						{									
									if(ralation=='Close Family' && setCloseFamily==1)   // images Close Family condition check here
									{	
											$('#picture_body').show();		
											$('#picture_msg').hide();
									}
									else if(ralation=='Relative' && setRelative==1)     // images Relative condition check here
									{	
											$('#picture_body').show();		
											$('#picture_msg').hide();
									}
									else if(ralation=='Research Connection' && setResearchConnection==1)    // images Research Connection condition check here
									{	
											$('#picture_body').show();	
											$('#picture_msg').hide();
									}

						}							
					}		
					
					
				}
			});  
		
		}
		
		
		/**  
		*@author      : Swapnil Patil <swapnilj.patil@silicus.com>
		*@description : function to get user privacy settings for Video Modules
		*/
		
		getVideoPrivacySettings();
		function getVideoPrivacySettings()
		{
		    var profID = $('#profID').val();    
			$.ajax({   
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: '/profiles/getVideoSettings',
				type: 'post',		
				data: {'profileID':profID},
				success: function(data) 
				{ 		
					var ralation 				= $('#profRelation').val();
					var userID 					= data.user_id;
					var parseData 				= JSON.parse(data.videos);  
					var setPublic 				= parseData.public; 
					var setCloseFamily  		= parseData.closeFamily; 
					var setRelative  			= parseData.relative; 
					var setResearchConnection   = parseData.researchConnection; 
					var setNobody  				= parseData.nobody; 
					
					    $('#video_msg').show();	
					    
						//  video nobody condition check here
						if(setNobody==1)
						{
							$('#video_body').hide();
							$('#video_msg').show();	
						}
						else
						{
							// video public condition check here
							if(setPublic==1)
							{
								$('#video_body').show();
								$('#video_msg').hide();	
							}
							else
							{									
										if(ralation=='Close Family' && setCloseFamily==1)   // video Close Family condition check here
										{	
												$('#video_body').show();
												$('#video_msg').hide();	
										}
										else if(ralation=='Relative' && setRelative==1)     // video Relative condition check here
										{	
												$('#video_body').show();	
												$('#video_msg').hide();	
										}
										else if(ralation=='Research Connection' && setResearchConnection==1)    // video Research Connection condition check here
										{	
												$('#video_body').show();	
												$('#video_msg').hide();	
										}
	
							}							
						}		
				}
			});  
		
		}
		
		tableRowCount();
		function tableRowCount()
		{
			var rowCount = $('#online_connection tr').length;   
			if(rowCount==2)
			{
				$('#MsgNotOnline').show();
			}
			else
			{
				
			}
		}
		
