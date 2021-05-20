/**
 * Chat Widget plugin for Craft CMS
 *
 * Chat Widget JS
 *
 * @author    BRIX Plugins
 * @copyright Copyright (c) 2021 BRIX Plugins
 * @link      https://brixplugins.com/
 * @package   ChatWidget
 * @since     1.0.0
 */


jQuery(document).ready(function() {


  if( $('#bp-chat-widget').attr('data-inactive') !== '1' ) {
    setTimeout(function() {
      $(this).attr('data-click-state', 1);
      showElements();
    }, 
      $('#bp-chat-widget').attr('data-delay')
    );
  }


  $('#bp-chat-widget-icon').on('click', function(){

    if( $(this).attr('data-click-state') == 1 ) {
        $(this).attr('data-click-state', 0);
        document.cookie = "bp-chat-open=1; max-age=86400; path=/";
        
        hideElements();
    } else {
        $(this).attr('data-click-state', 1);
        showElements();
    }

  });

  function hideElements() {

    $( "#bp-chat-widget-agent" ).hide(200); 

    setTimeout(function() {
        $( "#bp-chat-widget-message" ).hide(200); 
    }, 150);
        
    setTimeout(function() {
        $( "#bp-chat-widget-button" ).hide(200);
    }, 280);

  }

  function showElements() {

    $('#bp-chat-widget-icon').attr('data-click-state', 1);

    $( "#bp-chat-widget-button" ).show(200);

    setTimeout(function() {
        $( "#bp-chat-widget-message" ).show(200); 
    }, 140);

    setTimeout(function() {
        $( "#bp-chat-widget-agent" ).show(150); 
    }, 320);

  }


});

