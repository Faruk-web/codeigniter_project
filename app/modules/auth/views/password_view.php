<div class="login-box-body">
    <p class="login-box-msg">Write email address to set new password</p>
    <?php
    echo $this->session->flashdata('flash_msg');
    if(isset($error_message)){
        echo $error_message;
    }
    ?>

    <?php echo form_open('password/email'); ?>
        <div class="form-group has-feedback <?php echo (form_error('email'))?'has-error':''?>">
            <input type="email" name="email" class="form-control" placeholder="E-Mail Address" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <?php echo form_error('email')?>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Send Password Reset Link</button>
            </div>
        </div>
    <?php echo form_close(); ?>

    <a class="btn btn-link" href="<?php echo base_url('auth')?>">Back To Login?</a><br>
</div>