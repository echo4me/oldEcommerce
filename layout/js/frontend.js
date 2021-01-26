$(function(){
    'use strict';
    
    // Switch between login | Signup
    $('#login').click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.mylogin').show();
        $('.mysignup').hide();
        
    });
    $('#signup').click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.mysignup').show();
        $('.mylogin').hide();
    });


    //Type on layout
    $('.live-name').keyup(function(){
      $('.live-preview .caption h3').text($(this).val());
        
    });
    $('.live-desc').keyup(function(){
        $('.live-preview .caption p').text($(this).val());
          
    });
    $('.live-price').keyup(function(){
        $('.live-preview .price-tag').text('$'+$(this).val());
          
    });






    // Hide Placeholder
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });

    //Confim Message on Delete Link
    $(".confirm").click(function(){
        return confirm("Are you sure to Delete User ?");
    })



    // Select box Open
     // Calls the selectBoxIt method on your HTML select box
  $("select").selectBoxIt({
    autoWidth : false
  });


});