

$(document).ready(function () {
	console.log('hello');
        
        $('#checkbox1').mousedown(function() {
        if (!$(this).is(':checked')) {
            this.checked = confirm("Are you sure?");
            $(this).trigger("change");
        }
    });
});



function addScheduler()
{
    alert('addScheduler');
}

function GetSchedulerTime(scheduler_type)
{
    var html='';
    alert("type:::"+scheduler_type);
    if(scheduler_type== 'daily')
    {
        alert('daily');
        $('#schedulerDate').append('<div class="input-group"><input type="text" class="form-control" id="schedulerDate" name="schedulerDate" /><span class="form-highlight"></span><span class="form-bar"></span><label class="hasdrodown" for="personDob">Date</label><label class="input-group-addon modal-datepicker-ico" for="schedulerDate"><span class="glyphicon glyphicon-th"></span></label><span class="text-danger" id="personEvents-div"><strong id="form-errors-personEvents"></strong></div>');
    }
    else if(scheduler_type == 'weekly')
    {
        alert('weekly');
        var daysOfWeekHtml=gernerateDayofWeek();
        $('#schedulerDate').append(daysOfWeekHtml);
    }
}

function gernerateDayofWeek()
{
    var daysOfWeek = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    var html ='<div class="checkbox">';
    for(i=0;i<7;i++)
    {
        html+='<label><input type="checkbox" name="day_'+daysOfWeek[i]+'" id="day_'+daysOfWeek[i]+'" value="'+daysOfWeek[i]+'" onchange="StoreDaysOfWeek("'+daysOfWeek[i]+'")">'+daysOfWeek[i]+'</label>';
    }
    html+='</div>';
    return html;
}

function StoreDaysOfWeek(day)
{
    alert(day);
}