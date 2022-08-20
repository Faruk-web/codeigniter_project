<section class="content-header">
    <?php
    $pageName = 'Committees';
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
                if (isset($edit)) {
                    $session = $committeeData[0]->session;
                } else {
                    $session = set_value('session');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($path.'/store'.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-12">
                        <div class="form-group <?php echo (form_error('session')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Seasson</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="session" value="<?php echo $session; ?>" required>
                            </div>
                            <?php echo form_error('session'); ?>
                        </div>

                        <?php
                        foreach ($committeeData as $com) {
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-3"><?php echo $com->designation; ?>:</label>
                            <div class="col-sm-9">
                                <input type="hidden" class="form-control" name="designation[]" value="<?php echo $com->designation; ?>">
                                <input type="hidden" class="form-control" name="id[]" value="<?php echo $com->id; ?>">
                                <input type="text" class="form-control" name="membership_number[]" value="<?php echo $com->membership_number; ?>" placeholder="Membership No.">
                            </div>
                        </div>
                        <?php
                        }
                        ?>

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
                                <th>Session</th>
                                <th>Members</th>
                                <th class="remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr>
                                <td><?php echo $serial++?></td>
                                <td><?php echo $val->session; ?></td>
                                <td><?php echo $val->total; ?></td>
                                <td class="remove">
                                    <div class="dropdown">
                                        <a class="btn btn-success btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="<?php echo base_url().$path.'/edit/'.$val->session; ?>">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            </li>

                                            <li>
                                                <a onclick="deleted('<?php echo base_url().$path.'/delete/'.$val->session; ?>')">
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