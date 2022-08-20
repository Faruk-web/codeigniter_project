<div class="box box-success">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php
                if ($this->session->flashdata('flash_success')!='') {
                    echo 'Successfully update your password. Go to the <a href="'.base_url('auth').'">login page</a> for login your panel.';
                } else {
                    echo 'Link was broken. <a href="'.base_url('auth').'">Click here to login</a>.';
                }
                ?>
            </div>
        </div>
    </div>
</div>