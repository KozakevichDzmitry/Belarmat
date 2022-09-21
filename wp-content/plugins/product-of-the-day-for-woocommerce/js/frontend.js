(function ($){
    $(document).ready( function () {
        products_of_day_execute_func( the_products_of_day_js_data.script.js_page_load );
        jQuery(document).trigger('berocket_product_of_day-js_page_load');
        $('.br_pod_slider').unslider({
        arrows: {
            prev: '<a class="unslider-arrow prev"></a>',
            next: '<a class="unslider-arrow next"></a>',
        },
        autoplay: true});
    });
})(jQuery);
function products_of_day_execute_func ( func ) {
    if( the_products_of_day_js_data.script != 'undefined'
        && the_products_of_day_js_data.script != null
        && typeof func != 'undefined' 
        && func.length > 0 ) {
        try{
            eval( func );
        } catch(err){
            alert('You have some incorrect JavaScript code (Product Of The Day)');
        }
    }
}
