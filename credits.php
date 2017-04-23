<?php
/*
Plugin Name: WP Credits
Plugin URI: #
Description: This a plugin for calculate credits
Version: 1.0
Author: Jhony Penagos
Author URI: #
License: GPLv2 or later
Text Domain: wp_credits
*/


/**
 * All Constants for use in the plugin
 * ------------------------------------------------------------------------
 */
define(URL_WP_CREDITS,plugins_url("/",__FILE__));
define(DIR_WP_CREDITS,plugin_dir_path(__FILE__));

function wp_credits_admin_menu(){
    add_menu_page('Créditos', 'Créditos', 'manage_options', 'credits-settings','wp_credits_settings_page');
}

function wp_credits_settings_page(){
    if (!current_user_can('manage_options')){
        wp_die(__('You do not have sufficient permissions to access this page.','wp_credits'));
    } 

    global $wpdb;
    $credits = $wpdb->get_results("SELECT * FROM wp_credits");
    require DIR_WP_CREDITS.'/admin/pages/settings.php';
}

add_action('admin_menu','wp_credits_admin_menu'); 

/*
 * Load js scripts and css files
 * --------------------------------------------------------------------
 */
add_action('admin_enqueue_scripts', 'wp_credits_styles_scripts'); 
function wp_credits_styles_scripts(){
    wp_enqueue_style('wp-credits-admin-css', URL_WP_CREDITS.'/admin/css/admin-style.css', false, '1.0');
    wp_enqueue_script('wp-credits-admin-js',URL_WP_CREDITS.'/admin/js/admin.js',array('jquery'),'1.0');
}

/*
 * Save settings data send it by ajax
 * --------------------------------------------------------------------
 */
add_action('wp_ajax_wp_credits_settings_save', 'wp_credits_settings_save');
function wp_credits_settings_save(){
    $reply   = array();

    if(!current_user_can('manage_options')){
        $reply["error"]     = true;
        $reply["message"]   = __('No tienes permisos suficientes para acceder a esta página.','wp_credits');
    }
    else{
        if(!isset($_POST['wp_credits_settings'])){
            $reply["error"]     = true;
            $reply["message"]   = __("Hay un error al procesar el formulario.","wp_credits");
        }
        else{
            if (!wp_verify_nonce($_POST['wp_credits_settings'], 'save_wp_credits_settings')){
                $reply["error"]     = true;
                $reply["message"]   = __("Hay un error al procesar el formulario.","wp_credits");
            }
            else{
                $data = array(
                    "tax_name"                  => $_POST["tax-name"],
                    "rate_nmv"                  => $_POST["rate-nmv"],
                    "rate_insurance_debtors"    => $_POST["rate-insurance-debtors"],
                    "rate_maximum_months"       => $_POST["maximum-months"],
                    "user"                      => get_current_user_id()
                );
                
                global $wpdb;
                $results = $wpdb->insert("wp_credits",$data,array("%s","%f","%f","%d","%d"));

                if(!$results){
                    $reply["error"]     = true;
                    $reply["message"]   = __("Hay un error al procesar el formulario.","wp_credits");
                }
                else{
                    $reply["error"]     = false;
                    $reply["message"]   = __("El crédito fue creado con éxito","wp_credits");
                }
            }
        }
    }

    echo json_encode($reply);
    wp_die();
}


/*
 * Delete credit
 * --------------------------------------------------------------------
 */
add_action('wp_ajax_wp_credit_delete', 'wp_credit_delete');
function wp_credit_delete(){
    $reply   = array();

    if(!current_user_can('manage_options')){
        $reply["error"]     = true;
        $reply["message"]   = __('No tienes permisos suficientes para acceder a esta página.','wp_credits');
    }
    else{
        global $wpdb;
        $result = $wpdb->delete("wp_credits",array('tax_id' => $_POST["id"] ),array('%d'));

        if(!$result){
            $reply["error"]     = true;
            $reply["message"]   = __("Hay un error eliminando el crédito.","wp_credits");
        }
        else{
            $reply["error"]     = false;
            $reply["message"]   = __("El crédito fue eliminado","wp_credits");
        }
    }

    echo json_encode($reply);
    wp_die();
}
