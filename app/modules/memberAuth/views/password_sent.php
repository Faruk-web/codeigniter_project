<div class="box box-success">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php
                if ($this->session->flashdata('flash_email')!='') {
                    echo 'Password reset email sent in your mail ('.$this->session->flashdata('flash_email').'). Check your email account\'s inbox/junk folder.';
                } else {
                    echo 'Link was broken. <a href="'.base_url('auth').'">Click here to login</a>.';
                }
                ?>
            </div>
        </div>
    </div>
</div>