<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php
    echo $this->session->flashdata('flash_msg');
    if(isset($error_message)){
        echo $error_message;
    }
    ?>

    <?php echo form_open('auth/login'); ?>
        <div class="form-group has-feedback <?php echo (form_error('username'))?'has-error':''?>">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <?php echo form_error('username')?>
        </div>

        <div class="form-group has-feedback <?php echo (form_error('password'))?'has-error':''?>">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <?php echo form_error('password')?>
        </div>

        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox">
                    <label> <input type="checkbox"> Remember Me</label>
                </div>
            </div>
            <div class="col-xs-4">
                <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In <i class="fa fa-arrow-circle-o-right"></i></button>
            </div>
        </div>
    <?php echo form_close(); ?>
    
    <a class="btn-link" href="<?php echo base_url('password/reset'); ?>">Forgot Your Password?</a>      
</div>