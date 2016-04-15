/**
 * Created by raychen on 16/4/9.
 */

$(document).ready(function(){
    var square_height = $('.img-square').width();
    $('.img-square').css('height', square_height);

    var times = 0;
    $('.select').click(function(){
        times++;
        if(times%2==0){
            $('#pad-1').animate({
                height: "0px"
            },'fast');
        }else{
            $('#pad-1').animate({
                height: "50px"
            },'fast');
        }
    });

    $(".datepicker").datepicker();
    $("#boots-file").fileinput();
});