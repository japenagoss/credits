jQuery(document).ready(function($){

    /**
     * Show and hide content for each item on menu 
     * ----------------------------------------------------
     */
    $('#wp_credits_container .of-nav li a').click(function(e){
        e.preventDefault();
        var element = $(this),
            id      = element.attr('href');

        $(id).show();
        $(id).siblings('.content-hide').hide();
        element.parent().addClass('current');
        element.parent().siblings('li').removeClass('current');
    });

    /**
     * Save by ajax form data
     * ----------------------------------------------------
     */
    $('#wp_credits_save').click(function(){
        var form                = $('#wp-create-credits form'),
            tax_name            = $("input[name='tax-name']",form).val(),
            rate_nmv            = $("input[name='rate-nmv']",form).val(),
            insurance_debtors   = $("input[name='rate-insurance-debtors']",form).val(),
            maximum_months      = $("input[name='maximum-months']",form).val();

        $validated = validate(tax_name,rate_nmv,insurance_debtors,maximum_months);

        if($validated){
            var data = form.serialize()+'&action=wp_credits_settings_save';
            send_data_by_ajax(data,false);
        }
    });

    /**
     * Delete credit
     * ----------------------------------------------------
     */
    $(".wp_credit_delete").click(function(e){
        e.preventDefault();
        var id = $(this).attr("href");
            id = id.replace("#","");
        
        var data = "id="+id+"&action=wp_credit_delete";
        send_data_by_ajax(data,false);
    });

    /**
     * Select credit
     */
    $(".wp_select_credit").click(function(e){
        e.preventDefault();
        var id = $(this).attr("href");
            id = id.replace("#","");
        
        var data    = "id="+id+"&action=wp_select_credit";
        send_data_by_ajax(data,true);
    });

    /**
     * Update credit
     * ----------------------------------------------------
     */
    $('#wp_credits_update').click(function(){
        var form                = $('#wp-edit-credits form'),
            tax_name            = $("input[name='tax-name']",form).val(),
            rate_nmv            = $("input[name='rate-nmv']",form).val(),
            insurance_debtors   = $("input[name='rate-insurance-debtors']",form).val(),
            maximum_months      = $("input[name='maximum-months']",form).val();

        $validated = validate(tax_name,rate_nmv,insurance_debtors,maximum_months);

        if($validated){
            var data =  form.serialize()+'&action=wp_credits_settings_update';
            send_data_by_ajax(data,false);
        }
    });


    /**
     * Save agents
     * ----------------------------------------------------
     */
    $('#wp_agents_create').click(function(){
        var data =  $('#wp-create-agents form').serialize()+'&action=wp_credits_create_agent';
        send_data_by_ajax(data,false);
    });

    /**
     * Send data by ajax
     * ----------------------------------------------------
     */
    function send_data_by_ajax(data, select){
        $.ajax({
            type:"POST",
            url:ajaxurl,
            data:data,
            dataType:"json",
            async: true,
            success:function(response){
                if(!response.error){
                    if(!select){
                        alert(response.message);
                        location.href = "";
                    }
                    else{
                        var form = $('#wp-edit-credits form');

                        $("input[name='tax-id']",form).val(response.data.tax_id);
                        $("input[name='tax-name']",form).val(response.data.tax_name);
                        $("input[name='rate-nmv']",form).val(response.data.rate_nmv);
                        $("input[name='rate-insurance-debtors']",form).val(response.data.rate_insurance_debtors);
                        $("input[name='maximum-months']",form).val(response.data.rate_maximum_months);
                        $("input[name='maximum-months']",form).val(response.data.rate_maximum_months);
                    }
                }
                else{
                    alert(response.message);
                }
            }
        });   
    }

    /**
     * Don't allow write characters diferents to numbers in numbers fields
     * ----------------------------------------------------
     */
    $('.filter_float').keypress(function(eve) {

        console.log(eve.which);

        if ((eve.which != 46 || $(this).val().indexOf(',') != -1) && (eve.which < 48 || eve.which > 57) || (eve.which == 46 && $(this).caret().start == 0) ) {
            eve.preventDefault();
        }
        // this part is when left part of number is deleted and leaves a . in the leftmost position. For example, 33.25, then 33 is deleted
        $('.filter_float').keyup(function(eve){
            if($(this).val().indexOf('.') == 0) {$(this).val($(this).val().substring(1));}
        });
    });


    $('.filter_int').keypress(function(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    });

    /**
     * Validate data of forms
     * ----------------------------------------------------
     */
    function validate(tax_name,rate_nmv,insurance_debtors,maximum_months){
        if(tax_name.length == 0){
            alert("Debe diligenciar el campo nombre");
        }
        else{
            if(rate_nmv.length == 0){
                alert("Debe diligenciar el campo Tasa NMV");
            } 
            else{
                if(!is_numeric(rate_nmv)){
                    alert("El campo Tasa NMV debe ser númerico");
                }
                else{
                    if(insurance_debtors.length == 0){
                        alert("Debe diligenciar el campo Tasa de seguro de deudores");
                    } 
                    else{
                        if(!is_numeric(insurance_debtors)){
                            alert("El campo Tasa de seguro de deudores debe ser númerico");
                        }
                        else{
                            if(maximum_months.length == 0){
                                alert("Debe diligenciar el campo Máximo de meses");  
                            }
                            else{
                                if(!is_int(maximum_months)){
                                    alert("El campo Máximo de meses debe ser entero");
                                }
                                else{
                                    return true;
                                }
                            }
                        }
                    }
                }
            }           
        }
    }

    /**
     * Function for validate if numeric
     * ----------------------------------------------------
     */
    function is_numeric(value){
        var numerics = [".","0","1","2","3","4","5","6","7","8","9"];
        var reply    = true;
        for(var i = 0;i < value.length; i++){
            if(numerics.indexOf(value[i]) == -1){
                reply = false;
            }
        }
        return reply;
    }

    /**
     * Function for validate if is int
     * ----------------------------------------------------
     */
    function is_int(value){
        var numerics = ["0","1","2","3","4","5","6","7","8","9"];
        var reply    = true;
        for(var i = 0;i < value.length; i++){
            if(numerics.indexOf(value[i]) == -1){
                reply = false;
            }
        }
        return reply;
    }
});

