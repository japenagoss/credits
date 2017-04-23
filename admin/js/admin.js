jQuery(document).ready(function($){

    /**
     * Show and hide content for each item on menu 
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
     */
    $('#wp_credits_save').click(function(){
        var data =  $('#wp-create-credits form').serialize()+'&action=wp_credits_settings_save';
        send_data_by_ajax(data,false);
    });

    /**
     * Delete credit
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
     */
    $('#wp_credits_update').click(function(){
        var data =  $('#wp-edit-credits form').serialize()+'&action=wp_credits_settings_update';
        send_data_by_ajax(data,false);
    });

    /**
     * Send data by ajax
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
                        $("input[name='tax-id']").val(response.data.tax_id);
                        $("input[name='tax-name']").val(response.data.tax_name);
                        $("input[name='rate-nmv']").val(response.data.rate_nmv);
                        $("input[name='rate-insurance-debtors']").val(response.data.rate_insurance_debtors);
                        $("input[name='maximum-months']").val(response.data.rate_maximum_months);
                        $("input[name='maximum-months']").val(response.data.rate_maximum_months);
                    }
                }
                else{
                    alert(response.message);
                }
            }
        });   
    }
});