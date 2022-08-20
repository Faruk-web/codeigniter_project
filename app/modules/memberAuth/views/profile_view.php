<section class="content-header">
    <?php
    echo $this->session->flashdata('flash_msg');
    if (isset($error_message)) {
        echo $error_message;
    }
    ?>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li <?php echo (isset($show))?'class="active"':''; ?>>
                <a href="<?php echo base_url().'profile'; ?>">
                    <i class="fa fa-user" aria-hidden="true"></i> Profile Info
                </a>
            </li>
            <li <?php echo (isset($edit))?'class="active"':''; ?>>
                <a href="<?php echo base_url().'profile/edit'; ?>">
                    <i class="fa fa-edit" aria-hidden="true"></i> Edit
                </a>
            </li>
            <li <?php echo (isset($password))?'class="active"':''; ?>>
                <a href="<?php echo base_url().'profile/password'; ?>">
                    <i class="fa fa-key" aria-hidden="true"></i> Change Password
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <?php
            if (isset($show)) {
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php
                    if (isset($dataview)) {
                    ?>
                    <div class="col-md-6">
                        <div class="box-profile">
                            <h3 class="profile-username text-center">
                                <?php echo $dataview->username;?>
                            </h3>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Name:</b> <a class="pull-right"><?php echo ($dataview->user_name!='')?$dataview->user_name:'N/A';?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email:</b> <a class="pull-right"><?php echo ($dataview->user_email!='')?$dataview->user_email:'N/A';?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Contact No:</b> <a class="pull-right"><?php echo ($dataview->user_contact!='')?$dataview->user_contact:'N/A';?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Role:</b> <a class="pull-right"><?php echo ($dataview->account_role!=1)?$accountRole[$dataview->account_role]:'Super Admin';?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php
                    } else {
                        echo notFoundText();
                    }
                    ?>
                </div>
            </div>
            <?php
            } elseif (isset($edit)) {
            ?>
            <div class="tab-pane active">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $dataview->user_name;?>'s Profile Change</h3>
                </div>

                <div class="box-body">
                    <?php echo form_open('profile/update','class="form-horizontal"'); ?>
                    <div class="col-md-6">
                        <div class="form-group <?php echo (form_error('username')!='')?'has-error has-danger':''?>">
                            <label class="control-label col-sm-3 required">Username</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username" value="<?php echo $dataview->username; ?>" required>
                            </div>
                            <?php echo form_error('username'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('user_email')!='')?'has-error has-danger':''?>">
                            <label class="control-label col-sm-3 required">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="user_email" value="<?php echo $dataview->user_email; ?>" required>
                            </div>
                            <?php echo form_error('user_email'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('user_name')!='')?'has-error has-danger':''?>">
                            <label class="control-label col-sm-3 required">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="user_name" value="<?php echo $dataview->user_name; ?>" required>
                            </div>
                            <?php echo form_error('user_name'); ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Contact No</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="user_contact" value="<?php echo $dataview->user_contact; ?>">
                            </div>
                            <?php echo form_error('user_contact'); ?>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-flat">Update</button>
                            <button type="reset" class="btn btn-warning btn-flat">Clear</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php
            } elseif (isset($password)) {
            ?>
            <div class="tab-pane active">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $dataview->user_name;?>'s Password Change</h3>
                </div>

                <div class="box-body">
                    <?php echo form_open('profile/change','class="form-horizontal"'); ?>
                    <div class="col-md-6">
                        <div class="form-group <?php echo (form_error('old_password')!='')?'has-error has-danger':''?>">
                            <label class="control-label col-sm-4 required">Old Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="old_password" class="form-control" required>
                            </div>
                            <?php echo form_error('old_password'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('password')!='')?'has-error has-danger':''?>">
                            <label class="control-label col-sm-4 required">New Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <?php echo form_error('password')?>
                        </div>

                        <div class="form-group <?php echo (form_error('confirm_password')!='')?'has-error has-danger':''?>">
                            <label class="control-label col-sm-4 required">Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <?php echo form_error('confirm_password')?>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-flat">Update</button>
                            <button type="reset" class="btn btn-warning btn-flat">Clear</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>