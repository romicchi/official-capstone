$(document).ready(function() {
    $('.preview-image').on('click', function() {
      var src = $(this).attr('src');
      $('<div>').css({
        background: 'rgba(0,0,0,0.5) url('+src+') no-repeat center',
        backgroundSize: 'contain',
        width:'100%', 
        height:'100%',
        position:'fixed',
        zIndex:'999999',
        top:'0', 
        left:'0',
        cursor: 'zoom-out'
      }).click(function(){
          $(this).remove();
      }).appendTo('body');
    });
  });
  