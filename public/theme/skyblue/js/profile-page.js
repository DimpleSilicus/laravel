//tab with accordion
$('.panel-heading a').click(function () {
    $('.panel-heading').removeClass('actives-accordion');
    $(this).parents('.panel-heading').addClass('actives-accordion');

    $('.panel-title').removeClass('actives-accordion'); //just to make a visual sense
    $(this).parent().addClass('actives-accordion'); //just to make a visual sense
});


$(document).ready(function () {
    //tree view zoom
    //var int
    var currentZoom = 1.0;
    var ele = "#pk-family-tree"
    var wrapper = ".treeWrapper";
    var pkMenu = "#pk-popmenu";

    $('#TreeViewButton').on('click', function () {
        $('.ui-draggable').css({ 'left': '0', 'top': '0' });
        $(pkMenu).hide();
        var currentScale = $(ele).attr('scale');
        var newscale = "scale(" + currentScale + ")";
        var action = $(this).attr('data-id');
        if (action == "1") {
            $(this).attr('data-id', '0');
            $(this).text('View Vertical Tree View');
            $(wrapper).addClass('verticalTree');
            $(ele).css("transform", newscale + "rotate(-90deg)");
        }
        if (action == "0") {
            $(this).attr('data-id', '1');
            $(this).text('View Horizontal Tree View');
            $(wrapper).removeClass('verticalTree');
            $(ele).css("transform", newscale);
        }
    });


    $(ele).attr('scale', currentZoom);
    $('#zoom_in').click(
    function () {
        $(this).removeClass('deactive');
        currentZoom = currentZoom + 0.10;
        if (currentZoom < 2) {
            var scaleString = "scale(" + currentZoom + ")";
            if ($(wrapper).hasClass('verticalTree')) {
                $(ele).css("transform", scaleString + "rotate(-90deg)");
            } else {
                $(ele).css("transform", scaleString);
            }
            $(ele).attr('scale', currentZoom);
            $(pkMenu).hide();
        } else {
            $(this).addClass('deactive');
        }
    })

    $('#zoom_out').click(
    function () {
        $(this).removeClass('deactive');
        currentZoom = currentZoom - 0.10;
        if (currentZoom > 0.5) {
            var scaleString = "scale(" + currentZoom + ")";
            if ($(wrapper).hasClass('verticalTree')) {
                $(ele).css("transform", scaleString + "rotate(-90deg)");
            } else {
                $(ele).css("transform", scaleString);
            }
            $(ele).attr('scale', currentZoom);
            $(pkMenu).hide();
        } else {
            $(this).addClass('deactive');
        }
    })

    $('#zoom_reset').click(
    function () {
        $("#zoom_out, #zoom_in").removeClass('deactive');
        currentZoom = 1.0;
        $(ele).css("transform", "scale(1)");
        if ($(wrapper).hasClass('verticalTree')) {
            $(ele).css("transform", "scale(1) rotate(-90deg)");
        } else {
            $(ele).css("transform", "scale(1)");
        }
        $(ele).attr('scale', currentZoom);
    })

    //append family tree
    //$('#pk-family-tree').pk_family();

    //append family tree with structure
    //$('#pk-family-tree').pk_family_create(
    //  {
    //    data: '{"li0":{"a0":{"name":"s","age":"s","gender":"Male","relation":"Father","pic":"family-tree/images/profile.png"},"ul":{"li0":{"a0":{"name":"s","age":"s","gender":"Male","relation":"Father","pic":"family-tree/images/profile.png"},"ul":{"li0":{"a0":{"name":"sa","age":"s","gender":"Male","pic":"family-tree/images/profile.png"}},"li1":{"a0":{"name":"s","age":"s","gender":"Male","relation":"Sibling","pic":"family-tree/images/profile.png"}},"li2":{"a0":{"name":"s","age":"s","gender":"Male","relation":"Sibling","pic":"family-tree/images/profile.png"}},"li3":{"a0":{"name":"s","age":"s","gender":"Male","relation":"Sibling","pic":"family-tree/images/profile.png"}},"li4":{"a0":{"name":"s","age":"s","gender":"Male","relation":"Sibling","pic":"family-tree/images/profile.png"}},"li5":{"a0":{"name":"s","age":"s","gender":"Male","relation":"Sibling","pic":"family-tree/images/profile.png"}},"li6":{"a0":{"name":"s","age":"s","gender":"Male","relation":"Sibling","pic":"family-tree/images/profile.png"}}}}}}}'
    //  }
    // );


    //my network mailbox view details
    $('#viewEmailDetails').hide();
    $(".toggleEmailcontent").click(function () {
        $('#viewEmailDetails').toggle(300);
    });

    //datepicker autohide
    $('#memBirthDate').datepicker({
        autoclose: true
    });
    $('#memDeathDate').datepicker({
        autoclose: true
    });
});