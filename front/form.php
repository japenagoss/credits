<form>
    <div>
        <label for="credit-kind"><?php _e('Tipo de crédito','wp_credits');?></label>
        <select name="credit-kind">
            <option></option>
            <?php foreach ($credits as $credit => $value):?>
                <option value="<?php echo $value->tax_id;?>"><?php echo $value->tax_name;?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div>
        <label for="loan-amount"><?php _e('Valor del préstamo','wp_credits');?></label>
        <input type="text" name="loan-amount">
    </div>
    <div>
        <input type="checkbox" name="send-to-agent">
        <label for="send-to-agent"><?php _e('Enviar mis datos a un asesor para obetener más información acerca del crédito.','wp_credits');?></label>
    </div>
    <div>
        <label for="number-of-months"><?php _e('Plazo (en meses)','wp_credits');?></label>
        <select name="number-of-months">
            <option></option>
        </select>
    </div>

    <div id="wp-user-information">
        <div>
            <label for="wp-user-name"><?php _e('Nombre:','wp_credits');?></label>
            <input type="text" name="wp-user-name">
        </div>

        <div>
            <label for="wp-user-email"><?php _e('Correo electrónico:','wp_credits');?></label>
            <input type="email" name="wp-user-email">
        </div>

        <div>
            <label for="wp-user-phone"><?php _e('Teléfono:','wp_credits');?></label>
            <input type="email" name="wp-user-phone">
        </div>
    </div>

    <div>
        <button id="wp_credit_calculate"><?php _e('Calcular','wp_credits');?></button>
    </div>
</form>

<div id="wp_credits_result">
</div>

<div id="wp_credits_data">
    <?php foreach ($credits as $credit => $value):?>
        <div id="wp_credit_<?php echo $value->tax_id;?>">
            <div class="tax_name"><?php echo $value->tax_name;?></div>
            <div class="rate_nmv"><?php echo $value->rate_nmv;?></div>
            <div class="rate_insurance_debtors"><?php echo $value->rate_insurance_debtors;?></div>
            <div class="rate_maximum_months"><?php echo $value->rate_maximum_months;?></div>
        </div>
    <?php endforeach;?>
</div>