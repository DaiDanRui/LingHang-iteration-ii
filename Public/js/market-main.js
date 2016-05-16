/**
 * Created by raychen on 16/5/5.
 */

$(document).ready(function () {
    $(".to-detail").mouseover(function(){
        $(this).css("cursor","pointer");
    });
    $(".to-detail").click(function(){
        var width = $(document).width();
        if (width > 970) {
            $("#detail-desk").modal();
        } else {
            var id = $(this).children(".commodity_id").attr("data-id");
            //console.log(id);
            location.href = root+"skill/details/id/"+id;
        }
    });
});
