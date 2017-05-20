<?php 
function wp_credits($atts){
    ob_start();
    global $wpdb;
    $credits = $wpdb->get_results("SELECT * FROM wp_credits");

    wp_enqueue_style("credits-fonts", "https://fonts.googleapis.com/css?family=Exo+2:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext", array(), null);
    wp_enqueue_style("wp_credits-alerts",URL_WP_CREDITS."/front/css/sweetalert.css", array(),"");
    wp_enqueue_style("wp_credits-css",URL_WP_CREDITS."/front/css/styles.css", array(),"1.0");

    wp_enqueue_script("wp_credits-alerts",URL_WP_CREDITS."/front/js/sweetalert.min.js", array("jquery"), "",false);
    wp_enqueue_script("wp_credits-js",URL_WP_CREDITS."/front/js/custom.js", array("jquery","wp_credits-alerts"), "1.0",false);
    wp_localize_script("wp_credits-js", "my_ajax_object",array( "ajaxurl" => admin_url("admin-ajax.php" )));

    require DIR_WP_CREDITS."/front/form.php";
    
    return ob_get_clean();
}
add_shortcode("wp_credits", "wp_credits");