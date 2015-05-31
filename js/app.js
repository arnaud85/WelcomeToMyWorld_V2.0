(function($){

     $('#header_icon').click(function(e){
        e.preventDefault();
        $('body').toggleClass('hidden-menu');
    });


    $('#hidden-site').click(function(e){
        $('body').removeClass('hidden-menu');
    })

})(jQuery);

