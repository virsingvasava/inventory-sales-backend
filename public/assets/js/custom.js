(function() {


    'use strict';

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    var fullHeight = function() {
        if (!isMobile.any()) {
            $('.js-fullheight').css('height', $(window).height());
            $(window).resize(function() {
                $('.js-fullheight').css('height', $(window).height());
            });
        }
    };




    $(function() {
        fullHeight();
    });
}());


$(function() {
    $(".fold-table tr.view").on("click", function() {
        if ($(this).hasClass("open")) {
            $(this).removeClass("open").next(".fold").removeClass("open");
        } else {
            $(".fold-table tr.view").removeClass("open").next(".fold").removeClass("open");
            $(this).addClass("open").next(".fold").addClass("open");
        }
    });
});
$(document).ready(function() {
    // $('select:not(.ignore)').niceSelect();      
    // FastClick.attach(document.body);
  });    
$ =  jQuery;
$(document).ready(function(){

// $('select').niceSelect();


}); 


// $(document).ready(function(){
//     $(window).resize(function(){
//         $(".main-content-padd").height($(document).height());
//     });
// });

// $(document).ready(function()
// {
//         $('.main-content-padd') .css({'height': (($(window).height()))});
//     });

