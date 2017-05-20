jQuery(document).ready(function($){

    var tax_name            = "";
    var rate_nmv            = 0;
    var maximum_months      = 0;
    var quota               = 0;

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
    $("#wp_show_email_form").click(function(e){
        e.preventDefault();
        $("#wp-user-information").show();
    });
        

    /*
     * Calculate amount of money to pay each month
     * ----------------------------------------------------------------------------
     */
    $("#wp_credit_calculate").click(function(e){
        e.preventDefault();

        var credit_kind         = $("select[name='credit-kind']").val();
        var loan_amount         = $("input[name='loan-amount']").val();
        var number_months       = $("select[name='number-of-months']").val();
        var credit_kind_name    = $("select[name='credit-kind'] option:selected").html();

        if(credit_kind == 0){
            swal("Debe elegir el tipo de crédito")
        }
        else{
            if(!isint(loan_amount)){
                swal("Valor del préstamo debe ser un número entero");
            }
            else{
                if(loan_amount < 0 || loan_amount == 0){
                    swal("El número debe ser mayor a cero.");
                }
                else{
                    calculation(credit_kind_name,parseInt(loan_amount),parseInt(number_months)); 
                }
            }
        }
    });

    /*
     * Validate int number
     * ----------------------------------------------------------------------------
     */
    function isint(value){
        var reply    = true;
        if(value.length == 0){
            reply = false;
        }
        else{
            var numerics = ["0","1","2","3","4","5","6","7","8","9"];
            for(var i = 0;i < value.length; i++){
                if(numerics.indexOf(value[i]) == -1){
                    reply = false;
                }
            }
        }
        return reply;
    }

    /*
     * Do the calculation
     * ------------------------------------------------------------------------------
     */
    function calculation(credit_kind_name,loan_amount,number_months){
        var rate   = rate_nmv / 100;
        if(rate > 0){
            quota  = loan_amount * (rate * Math.pow((rate + 1),number_months))/(Math.pow((rate+1),number_months)-1);
            
            $("#wp_credits_result_kind_credit span").html(credit_kind_name);
            $("#wp_credits_result_amount span").html(loan_amount);
            $("#wp_credits_result_months span").html(number_months);
            $("#wp_credits_result_quota span").html(Math.round(quota));             
            $("#wp_credits_result").show();
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
     * Send email to agent
     * ----------------------------------------------------------------------------
     */
    $("body").on("click","#wp_send_email",function(e){
        e.preventDefault();
        var user_name       = $("input[name='wp-user-name']").val();
        var user_email      = $("input[name='wp-user-email']").val();
        var user_phone      = $("input[name='wp-user-phone']").val();
        var user_city       = $("input[name='wp-user-city']").val();
        var loan_amount     = $("input[name='loan-amount']").val();
        var number_months   = $("select[name='number-of-months']").val();

        if(user_name.length == 0){
            swal("Debe diligenciar el nombre");
        }
        else{
            if(!validate_email(user_email)){
                swal("Ingrese un correo electrónico válido"); 
            }
            else{
                if(user_phone.length == 0){
                    swal("Debe diligenciar el teléfono");
                }
                else{
                    if(user_city.length == 0){
                        swal("Debe diligenciar la ciudad");
                    }
                    else{
                        send_email(loan_amount,number_months,user_name,user_email,user_phone,user_city);
                    }
                }
            }
        }
    });
       

    /*
     * Send the email
     * ----------------------------------------------------------------------------
     */
    function send_email(loan_amount,number_months,user_name,user_email,user_phone,user_city){
         $.ajax({
            type:"POST",
            url:my_ajax_object.ajaxurl,
            data:{
                credit_kind_name:tax_name,
                loan_amount:loan_amount,
                number_months:number_months,
                quota:quota,
                user_name:user_name,
                user_email:user_email,
                user_phone:user_phone,
                user_city:user_city,
                action:"wp_credit_send_email",
            },
            dataType:"json",
            success:function(response){
                alert(response.error);
                if(response.error){
                    sweetAlert("Buen trabajo!", response.message, "error");
                }
                else{
                    sweetAlert("Buen trabajo!", response.message, "success");
                }
            }
        });
    }
}); 