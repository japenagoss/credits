jQuery(document).ready(function($){

    var tax_name            = "";
    var rate_nmv            = 0;
    var insurance_debtors   = 0;
    var maximum_months      = 0;
    var send_to_agent       = false;

    /*
     * Select the kind of credit
     * ----------------------------------------------------------------------------
     */
    $("select[name='credit-kind']").change(function(){
        var id              = $(this).val();
        
        if(id.length > 0){
            var credit          = $("#wp_credit_"+id);
            tax_name            = credit.children(".tax_name").text();
            rate_nmv            = parseFloat(credit.children(".rate_nmv").text());
            insurance_debtors   = parseFloat(credit.children(".rate_insurance_debtors").text());
            maximum_months      = parseInt(credit.children(".rate_maximum_months").text());

            var months = "";
            for(i = 1;i<= maximum_months;i++){
                months += "<option value='"+i+"'>"+i+"</option>";
            }
            $("select[name='number-of-months']").html(months);
        }

    });

    /*
     * Select option for send email to a agent
     * ----------------------------------------------------------------------------
     */
    $("input[name='send-to-agent']").click(function(){
        if($(this).is(":checked")){
            $("#wp-user-information").show();
            send_to_agent = true;
        }
        else{
            $("#wp-user-information").hide();
            send_to_agent = false;
        }
    });
        

    /*
     * Calculate amount of money to pay each month
     * ----------------------------------------------------------------------------
     */
    $("#wp_credit_calculate").click(function(e){
        e.preventDefault();

        var credit_kind     = $("select[name='credit-kind']").val();
        var loan_amount     = parseInt($("input[name='loan-amount']").val());
        var number_months   = parseInt($("select[name='number-of-months']").val());

        if(credit_kind.length == 0){
            alert("Debe elegir el tipo de crédito");
        }
        else{
            if(!isint(loan_amount)){
                alert("Valor del préstamo debe ser un número entero");
            }
            else{
                if(loan_amount < 0 || loan_amount == 0){
                    alert("El número debe ser mayor a cero.");
                }
                else{
                    if(send_to_agent){
                        var user_name   = $("input[name='wp-user-name']").val();
                        var user_email  = $("input[name='wp-user-email']").val();
                        var user_phone  = $("input[name='wp-user-phone']").val();

                        if(user_name.length == 0){
                            alert("Debe diligenciar el nombre");
                        }
                        else{
                            if(!validate_email(user_email)){
                                alert("Ingrese un correo electrónico válido"); 
                            }
                            else{
                                if(user_phone.length == 0){
                                    alert("Debe diligenciar el teléfono");
                                }
                                else{
                                    calculation(credit_kind,loan_amount,number_months);
                                    send_email(user_name,user_email,user_phone);
                                }
                            }
                        }
                    }
                    else{
                        calculation(credit_kind,loan_amount,number_months); 
                    }
                }
            }
        }
    });

    function isint(n){
        return Number(n) === n && n % 1 === 0;
    }

    /*
     * Do the calculation
     ------------------------------------------------------------------------------
     */
    function calculation(credit_kind,loan_amount,number_months){
        var rate   = (rate_nmv + insurance_debtors) / 100;
        if(rate > 0){
            var quota  = loan_amount * (rate * Math.pow((rate + 1),number_months))/(Math.pow((rate+1),number_months)-1);
            $("#wp_credits_result").html("Debe pagar mensualmente: "+Math.round(quota));
        }
    }

    /*
     * Validate email
     * ----------------------------------------------------------------------------
     */
    function validate_email(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    /*
     * Send the email
     * ----------------------------------------------------------------------------
     */
    function send_email(user_name,user_email,user_phone){
        $.ajax({
            type:"POST",
            url:my_ajax_object.ajaxurl,
            data:"?user_name="+user_name+"&user_email="+user_email+"&user_phone="+user_phone+"&action=wp_credit_send_email",
            dataType:"json",
            success:function(response){
                
            }
        });
    }
}); 