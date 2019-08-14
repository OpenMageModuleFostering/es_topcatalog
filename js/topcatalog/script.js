$tc=jQuery.noConflict();

$tc(function() {
    var activeItem;
    $tc('#nav li.level0').mouseover(function(){
        var classNameArray = $tc(this).attr('class').split(' ');
        var className = classNameArray[1];
        $tc('#nav li.level0.'+className+' ul').css('display', 'block');
        $tc(this).addClass('selected');
        if (!activeItem) {
            var activeItemObj = $tc('#nav li.active');
            if (activeItemObj)
                activeItem = activeItemObj;
        }
        if (activeItem) {
            activeItem.removeClass('active');
        }

    }).mouseout(function(){
        var classNameArray = $tc(this).attr('class').split(' ');
        var className = classNameArray[1];
        $tc('#nav li.level0.'+className+' ul').css('display', 'none');
        $tc(this).removeClass('selected');
        if (activeItem) {
            activeItem.addClass('active');
        }
    });

});