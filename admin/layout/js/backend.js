$(function(){
    'use strict';
    // Hide Placeholder
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });
    //add Asterisk* For Required Field
    $('input').each(function(){
        if($(this).attr('required') == 'required')
        {
            $(this).after('<span class="asterisk">*</span>');
        };
    });
    // Show and hide Pass
    $('.show-pass').hover(function(){
        $('.password').attr('type','text');
    },function(){
        $('.password').attr('type','password');
    });
    //Confim Message on Delete Link
    $(".confirm").click(function(){
        return confirm("Are you sure to Delete User ?");
    })

    //category view option
    $('.cate h3').click(function(){
        $(this).next('.full-view').fadeToggle();
    });
    $('.option span').click(function(){
        $(this).addClass('active').siblings('span').removeClass('active');
        if($(this).data('view') == 'full'){
            $('.cate .full-view').fadeIn(200);
        }else{
            $('.cate .full-view').fadeOut(200);
        }
    });

    // DashboardPage 
    $('.toggle-info').click(function(){
        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle();
        if($(this).hasClass('selected')){
            //change the icon from + to -
            $(this).html('<i class="fa fa-minus fa-lg"></i>')
        }else{
            $(this).html('<i class="fa fa-plus fa-lg"></i>')
        }
    });

    // Select box Open
     // Calls the selectBoxIt method on your HTML select box
  $("select").selectBoxIt({
    autoWidth : false
  });


});