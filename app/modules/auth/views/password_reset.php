<?php
if (isset($form)) {
?>
    <div class="login-box-body">
        <p class="login-box-msg">Password reset form</p>
        <?php
        echo $this->session->flashdata('flash_msg');
        if (isset($error_message)) {
            echo $error_message;
        }
        ?>

        <?php echo form_open('password/update'); ?>
            <div class="form-group has-feedback <?php echo (form_error('email'))?'has-error':''?>">
                <input type="email" name="email" class="form-control" placeholder="E-Mail Address">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <?php echo form_error('email')?>
            </div>

            <div class="form-group has-feedback <?php echo (form_error('password'))?'has-error':''?>">
                <input type="password" name="password" class="form-control" placeholder="New Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php echo form_error('password')?>
            </div>

            <div class="form-group has-feedback <?php echo (form_error('password_confirmation'))?'has-error':''?>">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php echo form_error('password_confirmation')?>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
<?php
} elseif (isset($expire)) {
?>
    <div class="box box-success">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12 text-center">Link was expire. <a href="<?php echo base_url('auth');?>">Click here to login</a></div>
            </div>
        </div>
    </div>
<?php
}
?>