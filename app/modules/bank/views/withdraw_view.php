<section class="content-header">
    <?php
    $pageName = 'Bank Withdraw';
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
                    $withdraw_purpose = $dataview->withdraw_purpose;
                    $cheque_number = $dataview->cheque_number;
                    $withdraw_date = $dataview->withdraw_date;
                    $withdraw_amount = $dataview->withdraw_amount;
                } else {
                    $withdraw_purpose = set_value('withdraw_purpose');
                    $cheque_number = set_value('cheque_number');
                    $withdraw_date = date('Y-m-d');
                    $withdraw_amount = set_value('withdraw_amount');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-8">
                        <div class="form-group <?php echo (form_error('withdraw_purpose')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Purpose of Withdraw</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="withdraw_purpose" value="<?php echo $withdraw_purpose; ?>" required>
                            </div>
                            <?php echo form_error('withdraw_purpose'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('cheque_number')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Cheque No.</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="cheque_number" value="<?php echo $cheque_number; ?>" required>
                            </div>
                            <?php echo form_error('cheque_number'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('withdraw_date')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control datepicker" name="withdraw_date" value="<?php echo $withdraw_date; ?>" required>
                            </div>
                            <?php echo form_error('withdraw_date'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('withdraw_amount')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Amount</label>
                            <div class="col-sm-9">
                                <input type="number" step="1" min="0" class="form-control" name="withdraw_amount" value="<?php echo $withdraw_amount; ?>" required>
                            </div>
                            <?php echo form_error('withdraw_amount'); ?>
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
                                <th>Purpose of Withdraw</th>
                                <th>Cheque No.</th>
                                <th class="text-right">Amount</th>
                                <th class="remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr>
                                <td><?php echo $serial++?></td>
                                <td><?php echo dateFormat($val->withdraw_date)?></td>
                                <td><?php echo $val->withdraw_purpose?></td>
                                <td><?php echo $val->cheque_number?></td>
                                <td align="right"><?php echo numberFormat($val->withdraw_amount, 1)?></td>
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