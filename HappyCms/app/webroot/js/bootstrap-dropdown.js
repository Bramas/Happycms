
!function( $ ){

  "use strict"


  $.fn.dropdown = function () {
    return this.each(function () {
      
      $(this).mouseover(function(){
        
        $(this).addClass('open');

      });
      $(this).mouseout(function(){
        
        $(this).removeClass('open');

      });
    })
  }



  $(function () {
    $('li.dropdown').dropdown()
  })

}( window.jQuery || window.ender );
