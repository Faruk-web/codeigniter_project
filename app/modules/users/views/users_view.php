<section class="content-header">
    <?php
    $pageName = 'User';
    echo $this->session->flashdata('flash_msg');
    if (isset($error_message)) {
        echo $error_message;
    }
    ?>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li <?php echo (isset($lists))?'class="active active-success"':''; ?>>
                <a href="<?php echo base_url().$path.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> <?php echo $pageName; ?> List
                </a>
            </li>
            <li <?php echo (isset($create))?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/create'.qString(); ?>">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add <?php echo $pageName; ?>
                </a>
            </li>
            <?php
            if (isset($edit)) {
            ?>
            <li class="active">
                <a href="#">
                    <i class="fa fa-edit" aria-hidden="true"></i> Edit <?php echo $pageName; ?>
                </a>
            </li>
            <?php
            }

            if (isset($show)) {
            ?>
            <li class="active">
                <a href="#">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> <?php echo $pageName; ?> Details
                </a>
            </li>
            <?php
            }
            ?>
        </ul>

        <div class="tab-content">
            <?php
            if (isset($show)) {
            ?>
            <div class="tab-pane active">
                <div class="box-body table-responsive">
                    <?php
                    if (isset($dataView)) {
                    ?>
                    <table class="table">
                        <caption class="hidden"><h3><?php echo $pageName;?> Details</h3></caption>
                        <thead>
                            <tr class="hide">
                                <th style="width:150px;"></th>
                                <th style="width:10px;"></th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="width:150px;">Full Name</th>
                                <th style="width:10px;">:</th>
                                <td><?php echo $dataView->user_name; ?></td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <th>:</th>
                                <td><?php echo $dataView->user_email; ?></td>
                            </tr>
                            <tr>
                                <th>Contact No :</th>
                                <th>:</th>
                                <td><?php echo $dataView->user_contact; ?></td>
                            </tr>
                            <tr>
                                <th>Role :</th>
                                <th>:</th>
                                <td><?php echo $accountRole[$dataView->account_role]; ?></td>
                            </tr>
                            <tr>
                                <th>Username :</th>
                                <th>:</th>
                                <td><?php echo $dataView->username; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    } else {
                        echo notFoundText();
                    }
                    ?>
                </div>
            </div>
            <?php
            } elseif (isset($edit) || isset($create)) {
                if (isset($dataView)) {
                    $user_name = $dataView->user_name;
                    $user_email = $dataView->user_email;
                    $user_contact = $dataView->user_contact;
                    $account_role = $dataView->account_role;
                    $username = $dataView->username;
                    $password = $dataView->password;
                } else {
                    $user_name = set_value('user_name');
                    $user_email = set_value('user_email');
                    $user_contact = set_value('user_contact');
                    $account_role = set_value('account_role');
                    $username = set_value('username');
                    $password = set_value('password');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'id="are_you_sure" class="form-horizontal"'); ?>
                        <div class="form-group col-sm-6">
                            <h4 style="border-bottom:1px solid #ccc;">Personal Details</h4>

                            <div class="form-group <?php echo (form_error('user_name')!='')?'has-error has-danger':''?>">
                                <?php echo form_error('user_name')?>
                                <label class="required control-label col-sm-5">Name</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="user_name" value="<?php echo $user_name?>" required>
                                </div>
                            </div>

                            <div class="form-group <?php echo (form_error('user_email')!='')?'has-error has-danger':''?>">
                                <?php echo form_error('user_email')?>
                                <label class="required control-label col-sm-5">Email Address</label>
                                <div class="col-sm-7">
                                    <input type="email" class="form-control" name="user_email" value="<?php echo $user_email?>" required>
                                </div>
                            </div>

                            <div class="form-group <?php echo (form_error('user_contact')!='')?'has-error has-danger':''?>">
                                <?php echo form_error('user_contact')?>
                                <label class="control-label col-sm-5">Contact No.</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="user_contact" value="<?php echo $user_contact?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-1">&nbsp;</div>

                        <div class="form-group col-sm-5">
                            <h4 style="border-bottom:1px solid #ccc;">Login Details</h4>

                            <div class="form-group <?php echo (form_error('account_role')!='')?'has-error has-danger':''?>">
                                <?php echo form_error('account_role')?>
                                <label class="required control-label col-sm-5">Role</label>
                                <div class="col-sm-7">
                                    <select name="account_role" class="form-control select2" required>
                                    <option value="">Select Role</option>
                                    <?php
                                    foreach ($accountRole as $rk => $role) {
                                        if ($rk >= $this->session->userdata['logged_in']->account_role) {
                                            $sel = ($account_role==$rk)?'selected':'';
                                            echo '<option value="'.$rk.'" '.$sel.'>'.$role.'</option>';
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group <?php echo (form_error('username')!='')?'has-error has-danger':''?>">
                                <?php echo form_error('username')?>
                                <label class="required control-label col-sm-5">Username</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="username" value="<?php echo $username?>" required>
                                </div>
                            </div>

                            <div class="form-group <?php echo (form_error('password')!='')?'has-error has-danger':''?>">
                                <?php echo form_error('password')?>
                                <label class="control-label col-sm-5 <?php echo isset($create)?'required':''; ?>"">Password</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control" name="password" <?php echo isset($create)?'required':''; ?>>
                                </div>
                            </div>

                            <div class="form-group <?php echo (form_error('confirm_password')!='')?'has-error has-danger':''?>">
                                <?php echo form_error('confirm_password')?>
                                <label class="control-label col-sm-5 <?php echo isset($create)?'required':''; ?>"">Confirm Password</label>
                                <div class="col-sm-7">
                                    <input type="password" class="form-control" name="confirm_password" <?php echo isset($create)?'required':''; ?>>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-12 text-center submit">
                            <?php
                            if(isset($edit)) {
                                echo '<button type="submit" class="btn btn-lg btn-warning btn-flat"><i class="fa fa-edit"></i> Update</button>';
                            } else {
                                echo '<button type="submit" class="btn btn-lg btn-success btn-flat"><i class="fa fa-plus"></i> Add</button>';
                            }
                            ?>
                            <a href="<?php echo base_url().$path.qString(); ?>" class="btn btn-lg btn-danger btn-flat"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <?php
            } elseif (isset($lists)) {
            ?>
            <div class="tab-pane active">
                <?php echo form_open($path.'/lists','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <select name="status" class="form-control select2">
                        <option value="">Any User Status</option>
                        <option value="1" <?php echo ($this->input->get('status')==1)?'selected':''; ?>>Active</option>
                        <option value="2" <?php echo ($this->input->get('status')==2)?'selected':''; ?>>Blocked</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="q" placeholder="Write your search text..." value="<?php echo $this->input->get('q')?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-flat">Search</button>
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path); ?>">X</a>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <div class="box-body table-responsive">
                    <?php echo $paginationMsg; ?>
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden"><h3><?php echo $pageName; ?> List</h3></caption>
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Contact No.</th>
                                <th>Role</th>
                                <th>Username</th>
                                <th class="remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr <?php echo ($val->status!=1)?'class="warning"':''; ?>>
                                <td><?php echo $serial++?></td>
                                <td><?php echo $val->user_name; ?></td>
                                <td><?php echo $val->user_email; ?></td>
                                <td><?php echo $val->user_contact; ?></td>
                                <td><?php echo $accountRole[$val->account_role]; ?></td>
                                <td><?php echo $val->username; ?></td>
                                <td class="remove">
                                    <div class="dropdown">
                                        <a class="btn btn-success btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="<?php echo base_url().$path.'/show/'.$val->user_id; ?>">
                                                    <i class="fa fa-eye"></i> Show
                                                </a>
                                            </li>
                                            <?php
                                            if ($val->account_role >= $this->session->userdata['logged_in']->account_role) {
                                            ?>
                                            <li>
                                                <a href="<?php echo base_url().$path.'/edit/'.$val->user_id; ?>">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <?php
                                                if ($val->status==1) {
                                                ?>
                                                    <a onclick="activity('<?php echo base_url().$path.'/activity/'.$val->user_id.'/2'; ?>')">
                                                        <i class="fa fa-lock"></i> Block
                                                    </a>
                                                <?php   
                                                } else {
                                                ?>
                                                    <a onclick="activity('<?php echo base_url().$path.'/activity/'.$val->user_id.'/1'; ?>')">
                                                        <i class="fa fa-unlock"></i> Unblock
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                            </li>
                                            <li>
                                                <a onclick="deleted('<?php echo base_url().$path.'/delete/'.$val->user_id; ?>')">
                                                    <i class="fa fa-close"></i> Remove
                                                </a>
                                            </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="text-right">
                        <?php echo $paginationLinks; ?>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>