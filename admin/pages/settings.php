<section id="wp_credits_container">
    <header class="header">
        <div class="logo">
            <h2><?php _e("CRÉDITOS","wp_credits");?></h2>
        </div>
        <div class="icon-option"></div>
    </header>
    
     <!-- Print menu of sections -->
    <section class="main">
        <section class="of-nav">
            <ul>
                <li>
                    <a title="" href="#wp-create-credits"><?php _e("Crear créditos","wp_credits");?></a>
                </li>
                <li>
                    <a title="" href="#wp-edit-credits"><?php _e("Editar créditos","wp_credits");?></a>
                </li>
                <li>
                    <a title="" href="#wp-settings"><?php _e("Configuraciones","wp_credits");?></a>
                </li>
            </ul>
        </section>

        <section class="content">
            <!-- Print content of sections -->
            <div id="wp-create-credits" class="content-hide">
                
                <form>
                    <?php wp_nonce_field("save_wp_credits_settings", "wp_credits_settings");?>

                    <div class="fieldset">
                        <label for="tax-name"><b><?php _e("Nombre","wp_credits");?></b></label><br />
                        <input type="text" name="tax-name" class="regular-text">
                    </div>
                    <div class="fieldset">
                        <label for="rate-nmv"><b><?php _e("Tasa NMV","wp_credits");?></b></label><br />
                        <input type="text" name="rate-nmv" class="regular-text filter_float" placeholder="0.00">
                    </div>
                    <div class="fieldset">
                        <label for="maximum-months"><b><?php _e("Máximo de meses","wp_credits");?></b></label><br />
                        <input type="text" name="maximum-months" class="regular-text filter_int">
                    </div>
                    <div class="fieldset">
                        <button id="wp_credits_save" type="button" class="button-primary">
                            <?php _e("Guardar","wp_credits");?>
                        </button>
                    </div>
                </form>

            </div>

            <div id="wp-edit-credits" class="content-hide">
                <table>
                    <tbody>
                        <tr>
                            <th><?php _e("ID","wp_credits");?></th>
                            <th><?php _e("Nombre","wp_credits");?></th>
                            <th><?php _e("Usuario","wp_credits");?></th>
                            <th><?php _e("Fecha","wp_credits");?></th>
                            <th><?php _e("Acciones","wp_credits");?></th>
                        </tr>
                        <?php foreach ($credits as $key => $value): ?>
                            <tr>
                                <td><?php echo $value->tax_id;?></td>
                                <td><?php echo $value->tax_name;?></td>
                                <td>
                                    <?php 
                                    $user = get_user_by("ID",$value->user);
                                    print_r($user->data->user_nicename);
                                    ?>
                                </td>
                                <td><?php echo $value->time;?></td>
                                <td>
                                    <a href="#<?php echo $value->tax_id;?>" class="wp_credit_delete"><?php _e("Eliminar","wp_credits");?></a>
                                    <a href="#<?php echo $value->tax_id;?>" class="wp_select_credit"><?php _e("Editar","wp_credits");?></a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

                <form>
                    <?php wp_nonce_field("update_wp_credits_settings", "wp_credits_settings");?>
                    
                    <input type="hidden" name="tax-id" value="">
                    <div class="fieldset">
                        <label for="tax-name"><b><?php _e("Nombre","wp_credits");?></b></label><br />
                        <input type="text" name="tax-name" class="regular-text">
                    </div>
                    <div class="fieldset">
                        <label for="rate-nmv"><b><?php _e("Tasa NMV","wp_credits");?></b></label><br />
                        <input type="text" name="rate-nmv" class="regular-text filter_float">
                    </div>
                    <div class="fieldset">
                        <label for="maximum-months"><b><?php _e("Máximo de meses","wp_credits");?></b></label><br />
                        <input type="text" name="maximum-months" class="regular-text filter_int">
                    </div>
                    <div class="fieldset">
                        <button id="wp_credits_update" type="button" class="button-primary">
                            <?php _e("Actualizar","wp_credits");?>
                        </button>
                    </div>
                </form>
                
            </div>

            <div id="wp-settings" class="content-hide">
                <form>
                    <div class="fieldset">
                        <label for="agents"><b><?php _e("Registrar agentes","wp_credits");?></b></label><br />
                        <span><?php _e("Registrar los correos electrónicos uno debajo de otro","wp_credits");?></span>
                        <?php 
                            $agents_emails  = get_option("wp_credit_agents");
                            $agents_emails  = maybe_unserialize($agents_emails);
                            $emails         = "";
                            $em_counter     = 1;
                            foreach ($agents_emails as $email) {
                                if($em_counter < count($agents_emails)){
                                    $emails .= $email."\r\n";
                                }
                                else{
                                    $emails .= $email;
                                }
                                $em_counter++;
                            }
                        ?>
                        <textarea name="agents" cols="40" rows="10"><?php echo $emails;?></textarea>
                    </div>
                    
                    <div class="fieldset">
                        <label for="top-text"><b><?php _e("Texto en el encabezado","wp_credits");?></b></label><br />
                        <textarea name="top-text" cols="40" rows="10"><?php echo get_option("wp_top_text");?></textarea>
                    </div>
                    
                    <div class="fieldset">
                        <label for="top-text"><b><?php _e("Términos y condiciones","wp_credits");?></b></label><br />
                        <textarea name="cond-terms" cols="40" rows="10"><?php echo get_option("wp_cont_terms");?></textarea>
                    </div>

                    <div class="fieldset">
                        <button id="wp_save_settings" type="button" class="button-primary">
                            <?php _e("Guardar","wp_credits");?>
                        </button>
                    </div>
                </form>
            </div>

        </section>
    </section>

</section>