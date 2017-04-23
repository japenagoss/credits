<?php 
function wp_credits($atts){
    ob_start();
    global $wpdb;
    $credits = $wpdb->get_results("SELECT * FROM wp_credits");

    wp_enqueue_style('wp_credits-css',URL_WP_CREDITS.'/front/css/styles.css', array(),'1.0');
    wp_enqueue_script('amortisation-js',URL_WP_CREDITS.'/front/js/amortisation.js', array("jquery"), '1.0',false);
    wp_enqueue_script('wp_credits-js',URL_WP_CREDITS.'/front/js/custom.js', array("jquery","amortisation-js"), '1.0',false);

    require DIR_WP_CREDITS.'/front/form.php';
    
    return ob_get_clean();
}
add_shortcode('wp_credits', 'wp_credits');