<section class="content-header">
    <?php
    $pageName = 'Vakalatnama Stock';
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
                    $stock_date = $dataview->stock_date;
                    $type = $dataview->type;
                    $stock_quantity = $dataview->stock_quantity;
                } else {
                    $stock_date = date('Y-m-d');
                    $type = set_value('type');
                    $stock_quantity = set_value('stock_quantity');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-8">
                        <div class="form-group <?php echo (form_error('type')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Type</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="type" required>
                                <option value="">Select Type</option>
                                <?php
                                foreach (['Vakalatnama', 'Court Fee', 'Stamp'] as $typ) {
                                    $sel = ($type==$typ)?'selected':'';
                                    echo '<option value="'.$typ.'" '.$sel.'>'.$typ.'</option>';
                                }
                                ?>
                                </select>
                            </div>
                            <?php echo form_error('type'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('stock_date')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control datepicker" name="stock_date" value="<?php echo $stock_date; ?>" required>
                            </div>
                            <?php echo form_error('stock_date'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('stock_quantity')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Quantity</label>
                            <div class="col-sm-9">
                                <input type="number" step="1" min="0" class="form-control" name="stock_quantity" value="<?php echo $stock_quantity; ?>" required>
                            </div>
                            <?php echo form_error('stock_quantity'); ?>
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
                                <th>Date</th>
                                <th>Type</th>
                                <th class="text-right">Quantity</th>
                                <th class="remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr>
                                <td><?php echo $serial++?></td>
                                <td><?php echo dateFormat($val->stock_date)?></td>
                                <td><?php echo $val->type?></td>
                                <td align="right"><?php echo numberFormat($val->stock_quantity, 1)?></td>
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