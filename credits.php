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

/**
 * Shortcodes
 * ------------------------------------------------------------------------
 */
require DIR_WP_CREDITS.'/shortcodes/index.php';

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
    wp_enqueue_script('wp-jquery.caret',URL_WP_CREDITS.'/admin/js/jquery.caret.js',array('jquery'),'1.0');
    wp_enqueue_script('wp-credits-admin-js',URL_WP_CREDITS.'/admin/js/admin.js',array('jquery','wp-jquery.caret'),'1.0');
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

/*
 * Select credit
 * --------------------------------------------------------------------
 */
add_action('wp_ajax_wp_select_credit', 'wp_select_credit');
function wp_select_credit(){
    $reply   = array();

    if(!current_user_can('manage_options')){
        $reply["error"]     = true;
        $reply["message"]   = __('No tienes permisos suficientes para acceder a esta página.','wp_credits');
    }
    else{
        global $wpdb;
        $credit = $wpdb->get_row("select * from wp_credits where tax_id = ".$_POST["id"]."",OBJECT);
        if(!$credit){
            $reply["error"]     = true;
            $reply["message"]   = __('hubo un error consultando el crédito.','wp_credits');
        }
        else{
            $reply["error"]  = false;
            $reply["data"]   = $credit;
        }
    }

    echo json_encode($reply);
    wp_die();
}

/*
 * Update credits
 * --------------------------------------------------------------------
 */
add_action('wp_ajax_wp_credits_settings_update', 'wp_credits_settings_update');
function wp_credits_settings_update(){
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
            if (!wp_verify_nonce($_POST['wp_credits_settings'], 'update_wp_credits_settings')){
                $reply["error"]     = true;
                $reply["message"]   = __("Hay un error al procesar el formulario.","wp_credits");
            }
            else{
                $data = array(
                    "tax_name"                  => $_POST["tax-name"],
                    "rate_nmv"                  => $_POST["rate-nmv"],
                    "rate_insurance_debtors"    => $_POST["rate-insurance-debtors"],
                    "rate_maximum_months"       => $_POST["maximum-months"]
                );
                
                global $wpdb;
                $results = $wpdb->update(
                    "wp_credits",
                    $data,
                    array('tax_id' => $_POST["tax-id"]),
                    array("%s","%f","%f","%d")
                );

                if(!$results){
                    $reply["error"]     = true;
                    $reply["message"]   = __("No se actualizó.","wp_credits");
                }
                else{
                    $reply["error"]     = false;
                    $reply["message"]   = __("El crédito fue actualizado","wp_credits");
                }
            }
        }
    }

    echo json_encode($reply);
    wp_die();
}

/*
 * Send email to agent
 * --------------------------------------------------------------------
 */
add_action('wp_ajax_wp_credit_send_email', 'wp_credit_send_email');
function wp_credit_send_email(){
    $html  = "<h2>".__("Tipo de crédito: ","wp_credits").$_POST["credit_kind_name"]."</h2>";
    $html .= "<div>".__("Valor del préstamo: ","wp_credits").$_POST["loan_amount"]."</div>";
    $html .= "<div>".__("Número de meses: ","wp_credits").$_POST["number_months"]."</div>";
    $html .= "<div>".__("Cuota mensual: ","wp_credits").$_POST["quota"]."</div>";
    $html .= "<br /><br />";
    $html .= "<h2>".__("Datos de la persona","wp_credits")."</h2>";
    $html .= "<div>".__("Nombre: ","wp_credits").$_POST["user_name"]."</div>";
    $html .= "<div>".__("Email: ","wp_credits").$_POST["user_email"]."</div>";
    $html .= "<div>".__("Teléfono: ","wp_credits").$_POST["user_phone"]."</div>";

    $agents_emails  = get_option("wp_credit_agents");
    $agents_emails  = maybe_unserialize($agents_emails);
    $emails         = array();

    foreach ($agents_emails as $email) {
        array_push($emails, $email);
    }

    wp_mail(
        $emails, 
        __("Un usuario desea más información acerca de un crédito","wp_credits"), 
        $html
    );
    
    wp_die();
}

function email_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','email_set_content_type' );

/*
 * Save agents
 * --------------------------------------------------------------------
 */
add_action('wp_ajax_wp_credits_create_agent', 'wp_credits_create_agent');
function wp_credits_create_agent(){
    $reply      = array();
    $agents     = explode("\r\n", $_POST["agents"]);
    $emails     = array();

    foreach($agents as $key => $value){
        if(!filter_var(trim($value), FILTER_VALIDATE_EMAIL) === false){
            array_push($emails,trim($value));
        }
    }

    $emails = maybe_serialize($emails);
    update_option("wp_credit_agents",$emails);

    $reply["error"]     = false;
    $reply["message"]   = __("Se guardaron los agentes","wp_credits");

    echo json_encode($reply);
    wp_die();
}