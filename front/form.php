
<div id="loading"><div><img src="<?php echo URL_WP_CREDITS."/front/css/images/loading.svg";?>"></div></div>
<div id="logo"></div>

<div id="body-container">

    <div>
        <div>
            <div id="form-container">
                <div id="logo_2"></div>
                <header>
                    <h1><?php _e("Simulador de crédito Coofamiliar","wp_credits");?></h1>
                    <p><?php echo get_option("wp_top_text");?></p>
                </header>

                <form>
                    <div>
                        <select name="credit-kind">
                            <option value="0"><?php _e("Tipo de crédito","wp_credits");?></option>
                            <?php foreach ($credits as $credit => $value):?>
                                <option value="<?php echo $value->tax_id;?>"><?php echo $value->tax_name;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div>
                        <input type="text" name="loan-amount" placeholder="<?php _e("Valor del crédito","wp_credits");?>">
                    </div>
                    <div>
                        <select name="number-of-months">
                            <option value="0"><?php _e("Plazo (en meses)","wp_credits");?></option>
                        </select>
                    </div>

                    <div>
                        <button id="wp_credit_calculate" class="button"><?php _e("Calcular","wp_credits");?></button>
                    </div>

                    <div id="wp_credits_result">
                        <div>
                            <h2 id="wp_credits_result_kind_credit"><span>Crédito educativo</span></h2>
                            <div id="wp_credits_result_amount" class="one"><?php _e("Valor del préstamo","wp_credits");?><span></span></div>
                            <div id="wp_credits_result_months" class="two"><?php _e("Plazo","wp_credits");?><span></span></div>
                            <div id="wp_credits_result_quota" class="one"><?php _e("Cuota mensual","wp_credits");?><span></span></div>
                        </div>

                        <button id="wp_show_email_form" class="button"><?php _e("Enviar mis datos un asesor","wp_credits");?></button>
                    </div>
                    
                    <div id="wp-user-information">
                        <p><?php _e("Completa el siguiente formulario para enviar tu consulta a un asesor y obtener más información acerca del crédito.","wp_credits");?></p>
                        <div>
                            <div>
                                <input type="text" name="wp-user-name" class="user-contact-control" placeholder="<?php _e("Nombre completo","wp_credits");?>">
                            </div>
                            <div>
                                <input type="text" name="wp-user-phone" class="user-contact-control" placeholder="Teléfono">
                            </div>
                            <div>
                                <input type="email" name="wp-user-email" class="user-contact-control" placeholder="<?php _e("Email","wp_credits");?>">
                            </div>
                            <div>
                                <div>
                                    <input type="text" name="wp-user-city" class="user-contact-control" placeholder="<?php _e("Ciudad","wp_credits");?>">
                                </div>
                            </div>

                            <button id="wp_send_email" class="button"><?php _e("Enviar","wp_credits");?></button>

                        </div>
                    </div>
                </form>

                <div id="wp_credits_data">
                    <?php foreach ($credits as $credit => $value):?>
                        <div id="wp_credit_<?php echo $value->tax_id;?>">
                            <div class="tax_name"><?php echo $value->tax_name;?></div>
                            <div class="rate_nmv"><?php echo $value->rate_nmv;?></div>
                            <div class="rate_maximum_months"><?php echo $value->rate_maximum_months;?></div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>

</div>