<section class="content-header">
    <?php
    $pageName = 'Category';
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
            ?>
        </ul>

        <div class="tab-content">
            <?php
            if (isset($edit) || isset($create)) {
                if (isset($dataview)) {
                    $category_name = $dataview->category_name;
                    $category_amount = $dataview->category_amount;
                    $category_serial = $dataview->serial;
                    $category_details = $dataview->category_details;
                    $monthlyin_receipt = $dataview->monthlyin_receipt;
                    $yearlyin_receipt = $dataview->yearlyin_receipt;
                    $benevolent_status = $dataview->benevolent_status;
                    $applied_lifemember = $dataview->applied_lifemember;
                    $status = $dataview->status;
                } else {
                    $category_name = set_value('category_name');
                    $category_amount = set_value('category_amount');
                    $category_serial = 100;//set_value('category_serial');
                    $category_details = set_value('category_details');
                    $monthlyin_receipt = set_value('monthlyin_receipt');
                    $yearlyin_receipt = set_value('yearlyin_receipt');
                    $benevolent_status = set_value('benevolent_status');
                    $applied_lifemember = set_value('applied_lifemember');
                    $status = set_value('status');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-8">
                        <div class="form-group <?php echo (form_error('category_name')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="category_name" value="<?php echo $category_name; ?>" required>
                            </div>
                            <?php echo form_error('category_name'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('category_amount')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Amount</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="category_amount" value="<?php echo $category_amount; ?>" required>
                            </div>
                            <?php echo form_error('category_amount'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('serial')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3">Display At</label>
                            <div class="col-sm-9">
                                <input type="text" pattern="\d*" maxlength="3" minlength="1" class="form-control"
                                       name="serial" value="<?php echo $category_serial; ?>" >
                            </div>
                            <?php echo form_error('serial'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('category_details')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3">Details</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="category_details" value="<?php echo $category_details; ?>">
                            </div>
                            <?php echo form_error('category_details'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('monthlyin_receipt')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3">Amount In Receipt</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="monthlyin_receipt">
                                <?php
                                foreach ([2=>'No', 1=>'Yes'] as $rck => $rct) {
                                    $sel = ($monthlyin_receipt==$rck)?'selected':'';
                                    echo '<option value="'.$rck.'" '.$sel.'>'.$rct.'</option>';
                                }
                                ?>
                                </select>
                            </div>
                            <?php echo form_error('monthlyin_receipt'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('yearlyin_receipt')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3">Yearly In Receipt</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="yearlyin_receipt">
                                <?php
                                foreach ([2=>'No', 1=>'Yes'] as $rck => $rct) {
                                    $sel = ($yearlyin_receipt==$rck)?'selected':'';
                                    echo '<option value="'.$rck.'" '.$sel.'>'.$rct.'</option>';
                                }
                                ?>
                                </select>
                            </div>
                            <?php echo form_error('yearlyin_receipt'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('benevolent_status')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3">Benevolent</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="benevolent_status">
                                <option value="2" <?php echo ($benevolent_status==2)?'selected':''; ?>> No </option>
                                <option value="1" <?php echo ($benevolent_status==1)?'selected':''; ?>> Yes </option>
                                </select>
                            </div>
                            <?php echo form_error('benevolent_status'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('applied_lifemember')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3">Applicable LifeMember</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="applied_lifemember">
                                <option value="2" <?php echo ($applied_lifemember==2)?'selected':''; ?>> No </option>
                                <option value="1" <?php echo ($applied_lifemember==1)?'selected':''; ?>> Yes </option>
                                </select>
                            </div>
                            <?php echo form_error('applied_lifemember'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('status')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3">Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status">
                                <?php
                                foreach ([1=>'Active', 2=>'Inactive'] as $sk => $sts) {
                                    $sel = ($status==$sk)?'selected':'';
                                    echo '<option value="'.$sk.'" '.$sel.'>'.$sts.'</option>';
                                }
                                ?>
                                </select>
                            </div>
                            <?php echo form_error('status'); ?>
                        </div>

                        <div class="form-group text-center submit">
                            <?php
                            if(isset($edit)) {
                                echo '<button type="submit" class="btn btn-lg btn-warning btn-flat"><i class="fa fa-edit"></i> Update</button>';
                            } else {
                                echo '<button type="submit" class="btn btn-lg btn-success btn-flat"><i class="fa fa-plus"></i> Add</button>';
                            }
                            ?>
                            <a href="<?php echo base_url().$path.qString(); ?>" class="btn btn-lg btn-danger btn-flat"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
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
                                <th>Name</th>
                                <th>Amount</th>
                                <th>On Receipt</th>
                                <th>On Yearly</th>
                                <th>Benevolent</th>
                                <th>Details</th>
                                <th class="remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr>
                                <td><?php echo $serial++?></td>
                                <td><?php echo $val->category_name; ?></td>
                                <td><?php echo $val->category_amount; ?></td>
                                <td><?php echo ($val->monthlyin_receipt==1)?'Yes':''; ?></td>
                                <td><?php echo ($val->yearlyin_receipt==1)?'Yes':''; ?></td>
                                <td><?php echo ($val->benevolent_status==1)?'Yes':''; ?></td>
                                <td><?php echo $val->category_details; ?></td>
                                <td class="remove">
                                    <div class="dropdown">
                                        <a class="btn btn-success btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="<?php echo base_url().$path.'/edit/'.$val->id; ?>">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            </li>
                                            
                                            <?php
                                            if ($val->countId==0) {
                                            ?>
                                            <li>
                                                <a onclick="deleted('<?php echo base_url().$path.'/delete/'.$val->id; ?>')">
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
                    <div class="text-right"><?php echo $paginationLinks; ?></div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>