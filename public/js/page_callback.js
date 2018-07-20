(function(jQuery){
    samo.page_ready = false; jQuery(function() { samo.page_ready = true;});
    samo.page_callback = function(page, samo_action, params) {
        if (!samo.page_ready) { setTimeout(function() {samo.page_callback(page, samo_action, params);}, 0); return;}
        // Your custom callback here
        /*
         console.log(arguments);
         switch (page) {
         case 'search_tour':
         if (samo_action == 'TOWNFROMINC' || samo_action == 'default_action') {
         if (params.TOWNFROMINC == 2) {
         jQuery.notify('Добро пожаловать в Москву!');
         }
         }
         break;
         default:
         break;
         }
         */
        return;
    };
})(samo.jQuery);
