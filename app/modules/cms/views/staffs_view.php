<section class="content-header">
    <?php
    $pageName = 'Staff';
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
                    $staff_name = $dataview->staff_name;
                    $staff_designation = $dataview->staff_designation;
                    $staff_mobile = $dataview->staff_mobile;
                    $staff_image = $dataview->staff_image;
                    $status = $dataview->status;
                } else {
                    $staff_name = set_value('staff_name');
                    $staff_designation = set_value('staff_designation');
                    $staff_mobile = set_value('staff_mobile');
                    $staff_image = set_value('staff_image');
                    $status = set_value('status');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-12">
                        <div class="form-group <?php echo (form_error('staff_name')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2 required">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="staff_name" value="<?php echo $staff_name; ?>" required>
                            </div>
                            <?php echo form_error('staff_name'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('staff_designation')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2 required">Designation</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="staff_designation" value="<?php echo $staff_designation; ?>" required>
                            </div>
                            <?php echo form_error('staff_designation'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('staff_mobile')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2">Mobile</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="staff_mobile" value="<?php echo $staff_mobile; ?>">
                            </div>
                            <?php echo form_error('staff_mobile'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('staff_image')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2">Image (200x200)</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="staff_image">
                                <?php echo viewImg('staffs', 'thumb_'.$staff_image);?>
                            </div>
                            <?php echo form_error('staff_image'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('status')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2">Status</label>
                            <div class="col-sm-10">
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
                                <th>Designation</th>
                                <th>Mobile</th>
                                <th>Image</th>
                                <th class="remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr>
                                <td><?php echo $serial++?></td>
                                <td><?php echo $val->staff_name; ?></td>
                                <td><?php echo $val->staff_designation; ?></td>
                                <td><?php echo $val->staff_mobile; ?></td>
                                <td><?php echo viewImg('staffs', 'thumb_'.$val->staff_image);?></td>
                                <td class="remove">
                                    <div class="dropdown">
                                        <a class="btn btn-success btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="<?php echo base_url().$path.'/edit/'.$val->id; ?>">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            </li>

                                            <li>
                                                <a onclick="deleted('<?php echo base_url().$path.'/delete/'.$val->id; ?>')">
                                                    <i class="fa fa-close"></i> Remove
                                                </a>
                                            </li>
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