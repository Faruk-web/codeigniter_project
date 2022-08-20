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
    <style>
        @page {
            page: legal;
            margin: 0mm 0mm 0mm 0mm;
            font-size:8px;
        }
    </style>
</head>
<body style="margin: 0; padding:0;">
    <div style="width: 100%; height: 21px;">
        <button onclick="prints()" style="float:right;">Print</button>
        <button onclick="javascript:window.location.href='<?php echo base_url('vakalatnama/sale/create');?>'" style="float:right; margin-right:10px;">Create Another</button>
    </div>
    <div id="printBody">
        <?php
        $serial = explode('-', $dataRow->serial_number);
        for($x = $serial[0]; $x <= $serial[1]; $x++) {
        ?>
        <div style="height:14in;">
            <div style="width:43mm; height:69mm; border:3px dashed #000; padding:5px; float:right; margin-top:20px; margin-right:5px;">
                <table cellpadding="0" cellspacing="0" border="0" style="width:100%;">
                    <tr>
                        <td style="width:15px; height:18mm;"><span style="writing-mode: vertical-lr; transform: rotate(-180deg); font-size:10px;"> SL No : <?php echo $x; ?></span></td>
                        <td align="center"><img src="<?php echo base_url('assets/img/icon.png');?>" style="height:18mm;"></td>
                        <td style="width:15px; height:18mm;"><span style="writing-mode: vertical-lr; transform: rotate(-180deg); font-size:10px;"> Tk. : 120/=</span></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="font-weight:bold; font-size:12px;">
                            <p style="margin-top:5px; height:40px;">
                                Member ID: <?php echo $dataRow->membership_number; ?><br>
                                Name: <?php echo $dataRow->member_name; ?>
                            </p>
                            <div style="text-align:center;">
                                <?php echo viewImg('members', $dataRow->member_image, 'style="width:80px; height:80px; border:1px solid #000;"'); ?>
                            </div>
                            <div style="margin-top:5px;">
                                <img src="<?php echo base_url('assets/img/sign.png');?>" style="height: 30px;"><br>
                                <span style="border-top:1px solid #000; font-size:9px;">General Secretary</span>
                            </div>
                            <div style="margin-top:5px; font-size:7px;">
                                Powered by: Ascent (http://ascentict.com)
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <script>
        $(function () {
            //prints();
        });

        function prints() {
            $('#printBody').printElement({printMode:'popup'});
        }
    </script>
</body>
</html>
