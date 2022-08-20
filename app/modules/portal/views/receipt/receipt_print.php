<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo constant("SITENAME")?></title>

    <!-- jQuery 3 -->
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-migrate-1.0.0.js"></script>

    <!-- Print JS -->
    <script src="<?php echo base_url();?>assets/plugins/printJs/print.js"></script>
</head>
<body style="margin: 0;">
    <button onclick="prints()" style="float:right;">Print</button>
    <div id="printBody" style="width:530px;">
        <table cellpadding="3" cellspacing="0" border="0" style="width:100%;">
            <tr>
                <td style="width:140px;">Receipt No :</td>
                <td><?php echo $dataRow->recepit_number; ?></td>
                
                <td style="width:90px;">Date :</td>
                <td style="width:110px;"><?php echo dateFormat($dataRow->recepit_date); ?></td>
            </tr>
            <tr>
                <td>Member ID :</td>
                <td><?php echo ($dataRow->membership_number!='')?$dataRow->membership_number:'N/A'; ?></td>
                
                <td>Start Date :</td>
                <td><?php echo dateFormat($dataRow->start_date); ?></td>
            </tr>
            <tr>
                <td>Name :</td>
                <td><?php echo ($dataRow->member_id>0)?$dataRow->member_name:$dataRow->receipt_member; ?></td>
                
                <td>End Date :</td>
                <td><?php echo dateFormat($dataRow->finish_date); ?></td>
            </tr>

            <?php
            if ($dataRow->father_name!='') {
            ?>
            <tr>
                <td>Father :</td>
                <td colspan="3"><?php echo $dataRow->father_name; ?></td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <td>Date of Enrollment :</td>
                <td colspan="3"><?php echo $dataRow->enrollment_date; ?></td>
            </tr>
        </table>
        <div style="width:100%; clear:both; height:40px;">&nbsp;</div>

        <table cellpadding="3" cellspacing="0" border="0" style="width:100%;">
            <thead>
                <tr>
                    <th align="left" style="border-top:1px solid #ccc; border-bottom:1px solid #ccc; width:50px;">SL.</th>
                    <th align="left" style="border-top:1px solid #ccc; border-bottom:1px solid #ccc; ">Particulars</th>
                    <th align="right" style="border-top:1px solid #ccc; border-bottom:1px solid #ccc; width:100px;">Amount</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $totalAmount = 0;
                foreach ($catData as $k => $cat) {
                ?>
                <tr>
                    <td><?php echo ($k+1); ?></td>
                    <td><?php echo $cat->category_name; ?></td>
                    <td align="right"><?php echo $cat->amount; ?></td>
                </tr>
                <?php
                $totalAmount += ($cat->amount>0)?$cat->amount:0;
                }
                ?>
            </tbody>

            <tfoot>
                <tr>
                    <th align="right" colspan="2" style="border-bottom:1px dotted #ccc;">Total Taka:</th>
                    <th align="right" style="border-bottom:1px dotted #ccc;"><?php echo numberFormat($totalAmount,2); ?></th>
                </tr>
                <tr>
                    <th align="left" colspan="3">Amount in Words: <?php echo convertNumber($totalAmount); ?> Taka.</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <script>
        $(function () {
            $('#printBody').printElement({printMode:'popup'});
        });

        function prints() {
            $('#printBody').printElement({printMode:'popup'});
        }
    </script>
</body>
</html>
