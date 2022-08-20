<section class="content-header">
    <?php
    $pageName = 'Gallery';
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
                    $caption = $dataview->caption;
                    $image = $dataview->image;
                    $status = $dataview->status;
                } else {
                    $caption = set_value('caption');
                    $image = set_value('image');
                    $status = set_value('status');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-12">
                        <div class="form-group <?php echo (form_error('caption')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2 required">Caption</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="caption" value="<?php echo $caption; ?>" required>
                            </div>
                            <?php echo form_error('caption'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('image')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-2">Image (600x600)</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="image">
                                <?php echo viewImg('galleries', 'thumb_'.$image);?>
                            </div>
                            <?php echo form_error('image'); ?>
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
                <div class="box-body table-responsive">
                    <?php echo $paginationMsg; ?>
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden"><h3><?php echo $pageName; ?> List</h3></caption>
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Caption</th>
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
                                <td><?php echo $val->caption;?></td>
                                <td><?php echo viewImg('galleries', 'thumb_'.$val->image);?></td>
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