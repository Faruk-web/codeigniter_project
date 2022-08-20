<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo constant("SITENAME")?></title>
    <style>
        .buttonBox {
            width: 100%; 
            height: 21px;
        }
        @media print {
            @page {
                page: A4;
                margin: 10mm 10mm 10mm 10mm;
            }
            .buttonBox {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="buttonBox">
        <button onclick="prints()" style="float:right;">Print</button>
    </div>
    <div id="printBody" style="width:210mm;">
    <?php
    for ($i=0; $i <= 1; $i++) { 
    ?>
        <table cellpadding="3" cellspacing="0" border="0" align="center">
        <tr>
            <td><img src="<?php echo base_url('assets/img/icon.png');?>" style="height:18mm;"></td>
            <td><span style="font-size: 20px">Dhaka Taxes Bar Association</span><br>Segunbagicha, Dhaka, Bangladesh. Phone: 02-8392471</td>
        </tr>
        </table>
        <div style="width:100%; clear:both; height:40px;">&nbsp;</div>

        <table cellpadding="3" cellspacing="0" border="0" style="width:100%;">
            <tr>
                <td style="width:140px;">Receipt No :</td>
                <td><?php echo $dataRow->sale_number; ?></td>
                
                <td style="width:90px;">Date :</td>
                <td style="width:110px;"><?php echo dateFormat($dataRow->created_at); ?></td>
            </tr>
            <tr>
                <td>Member ID :</td>
                <td colspan="3"><?php echo ($dataRow->membership_number!='')?$dataRow->membership_number:'N/A'; ?></td>
            </tr>
            <tr>
                <td>Name :</td>
                <td colspan="3"><?php echo ($dataRow->member_name != null)?$dataRow->member_name:'N/A'; ?></td>
            </tr>
        </table>
        <div style="width:100%; clear:both; height:40px;">&nbsp;</div>

        <table cellpadding="3" cellspacing="0" border="1" style="width:100%;">
            <thead>
                <tr>
                    <th align="center" style="width:50px;">SL.</th>
                    <th align="center">Particulars</th>
                    <th align="center" style="width:100px;">Quantity</th>
                    <th align="center" style="width:100px;">Rate</th>
                    <th align="center" style="width:100px;">Amount</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td valign="top" align="center" style="height: 120px;">1</td>
                    <td valign="top" align="left"><?php echo $dataRow->type; ?></td>
                    <td valign="top" align="center"><?php echo $dataRow->sale_quantity; ?></td>
                    <td valign="top" align="center">100</td>
                    <td valign="top" align="center"><?php echo ($dataRow->sale_quantity*100); ?></td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <th align="left" colspan="4">In Word: <?php echo convertNumber(($dataRow->sale_quantity*100)); ?> Taka.</th>
                    <th align="center"><?php echo numberFormat(($dataRow->sale_quantity*100),2); ?></th>
                </tr>
            </tfoot>
        </table>
        <div style="width:100%; clear:both; height:80px;">&nbsp;</div>

        <table cellpadding="3" cellspacing="0" border="0" style="width:100%;">
        <tr>
            <td align="left">------------------------<br><span style="margin-left:20px">Received By</span></td>
            <td align="right">------------------<br><span style="margin-right:20px">Accounts</span></td>
        </tr>
        </table>
        <?php
        if ($i == 0) {
            echo '<div style="width:100%; clear:both; height:40px;">&nbsp;</div>
            <hr>
            <div style="width:100%; clear:both; height:20px;">&nbsp;</div>';
        }
        }
        ?>
    </div>
    <script>
        window.print();

        function prints() {
            window.print();
        }
    </script>
</body>
</html>
