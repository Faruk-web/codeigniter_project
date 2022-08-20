<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITENAME; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="<?php echo base_url();?>assets/img/favicon.png" type="image/x-icon" />

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.min.css">

    <style>
        .auth-poweredby {
            position: fixed;
            bottom: 5px;
            right: 5px;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="<?php echo base_url();?>assets/img/logo.png"><br>
            <!-- <a><?php echo constant("SITENAME")?></a> -->
        </div>

        <?php $this->load->view($content_view);?>
    </div>

<img src="<?php echo base_url();?>assets/img/powered_by.png" width="120" alt="Ascent Corporation" class="auth-poweredby">
    <!-- jQuery 3 -->
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- Form validator -->
    <script src="<?php echo base_url();?>assets/plugins/validator/validator.min.js"></script>
    <script> $('form').validator(); </script>
</body>
</html>