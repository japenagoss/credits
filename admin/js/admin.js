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
        send_data_by_ajax(data);
    });

    /**
     * Delete credit
     */
    $(".wp_credit_delete").click(function(e){
        e.preventDefault();
        var id = $(this).attr("href");
            id = id.replace("#","");
        
        var data = "id="+id+"&action=wp_credit_delete";
        send_data_by_ajax(data);
    });

    /**
     * Send data by ajax
     */
    function send_data_by_ajax(data){
        $.ajax({
            type:"POST",
            url:ajaxurl,
            data:data,
            dataType:"json",
            success:function(response){
                if(!response.error){
                    alert(response.message);
                    location.href = "";
                }
                else{
                    alert(response.message);
                }
            }
        });   
    }
});