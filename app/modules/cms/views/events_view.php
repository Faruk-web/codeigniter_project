<section class="content-header">
    <?php
    $pageName = 'News & Event';
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
                    $event_date = $dataview->event_date;
                    $event_head = $dataview->event_head;
                    $event_details = $dataview->event_details;
                    $event_image = $dataview->event_image;
                    $status = $dataview->status;
                } else {
                    $event_date = set_value('event_date');
                    $event_head = set_value('event_head');
                    $event_details = set_value('event_details');
                    $event_image = set_value('event_image');
                    $status = set_value('status');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-12">
                        <div class="form-group <?php echo (form_error('event_date')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2 required">Date</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control datepicker" name="event_date" value="<?php echo $event_date; ?>" required>
                            </div>
                            <?php echo form_error('event_date'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('event_head')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2 required">Head</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="event_head" value="<?php echo $event_head; ?>" required>
                            </div>
                            <?php echo form_error('event_head'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('event_details')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2 required">Details</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="editor" name="event_details" required><?php echo $event_details; ?></textarea>
                            </div>
                            <?php echo form_error('event_details'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('event_image')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="event_image">
                                <?php echo viewImg('events', 'thumb_'.$event_image);?>
                            </div>
                            <?php echo form_error('event_image'); ?>
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
                                <th>Date</th>
                                <th>Head</th>
                                <th>Details</th>
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
                                <td><?php echo dateFormat($val->event_date); ?></td>
                                <td><?php echo $val->event_head; ?></td>
                                <td><?php echo $val->event_details; ?></td>
                                <td><?php echo viewImg('events', 'thumb_'.$val->event_image);?></td>
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