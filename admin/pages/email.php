<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        table{
            border-collapse: collapse;
        }
        .data-header,
        .data-intro,
        .credit-title,
        .credit-data,
        .personal-title{
            width: 600px;
            text-align: center;
        }

        .data-header img{
            width: 400px;
        }

        .data-intro p{
            font-size: 18px;
            font-style: italic;
            font-weight: 500;
            margin:0px;
        }

        .credit-title p,
        .credit-data p,
        .personal-title p{
            margin: 7px 0px;
            color: #ffffff;
            font-weight: 600;
            font-size: 18px;
            font-style: italic;
        }

        .credit-data p{
            text-align: left;
            color: #848484;
            font-size: 16px;
            padding: 0px 15px;
        }

        .credit-data p a{
            color: #848484; 
        }
    </style>
</head>
<body>
    <table style="width: 100%;" border="0">
        <tbody>
            <tr>
                <td>
                    <table class="data-header" align="center"  border="0">
                        <tr>
                            <td><img src="http://talentocreativo.co/creditos/wp-content/plugins/credits/front/css/images/logo.png"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="data-intro" align="center"  border="0">
                        <tr height="70">
                            <td><p><?php _e("Un usuario desea información sobre un crédito.","wp_credits");?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="credit-title" align="center"  border="0">
                        <tr style="background-color:#68D16D;">
                            <td><p><?php echo $credit_name;?></p></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="credit-data" align="center"  border="0">
                        <tr style="background-color:#F9F9F9;">
                            <td><p><?php _e("Valor del préstamo","wp_credits");?></p></td>
                            <td><p><?php echo $loan_amount;?></p></td>
                        </tr>
                        <tr style="background-color:#E9EEEF;">
                            <td><p><?php _e("Plazo","wp_credits");?></p></td>
                            <?php if($number_months == 1):?>
                                <td><p><?php echo $number_months." ".__("mes","wp_credits");?></p></td>
                            <?php else:?>
                                <td><p><?php echo $number_months." ".__("meses","wp_credits");?></p></td>
                            <?php endif;?>
                        </tr>
                        <tr style="background-color:#F9F9F9;">
                            <td><p><?php _e("Cuota mensual","wp_credits");?></p></td>
                            <td><p><?php echo $quota;?></p></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr height="30"><td></td></tr>
            <tr>
                <td>
                    <table class="personal-title" align="center"  border="0">
                        <tr style="background-color:#22AFEC;">
                            <td><p><?php _e("Datos personales","wp_credits");?></p></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="credit-data" align="center"  border="0">
                        <tr style="background-color:#F9F9F9;">
                            <td><p><?php _e("Nombre","wp_credits");?></p></td>
                            <td><p><?php echo $user_name;?></p></td>
                        </tr>
                        <tr style="background-color:#E9EEEF;">
                            <td><p><?php _e("Email","wp_credits");?></p></td>
                            <td><p><?php echo $user_email;?></p></td>
                        </tr>
                        <tr style="background-color:#F9F9F9;">
                            <td><p><?php _e("Télefono","wp_credits");?></p></td>
                            <td><p><?php echo $user_phone;?></p></td>
                        </tr>
                        <tr style="background-color:#E9EEEF;">
                            <td><p><?php _e("Ciudad","wp_credits");?></p></td>
                            <td><p><?php echo $user_city;?></p></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>