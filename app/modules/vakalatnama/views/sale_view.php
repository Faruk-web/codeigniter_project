<section class="content-header">
    <?php
    $pageName = 'Vakalatnama Sale';
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
                    $membership_number = $dataview->membership_number;
                    $type = $dataview->type;
                    $serial_number = $dataview->serial_number;
                    $sale_date = $dataview->sale_date;
                    $sale_quantity = $dataview->sale_quantity;
                } else {
                    $membership_number = set_value('membership_number');
                    $type = set_value('type');
                    $serial_number = set_value('serial_number');
                    $sale_date = date('Y-m-d');
                    $sale_quantity = set_value('sale_quantity');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <div class="col-md-8">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                        <div class="form-group <?php echo (form_error('membership_number')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Member ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="membership_number" id="membership_number" value="<?php echo $membership_number; ?>" required>
                            </div>
                            <?php echo form_error('membership_number'); ?>
                        </div>

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

                        <div class="form-group <?php echo (form_error('serial_number')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Serial</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="serial_number" value="<?php echo $serial_number; ?>" required placeholder="0-0">
                            </div>
                            <?php echo form_error('serial_number'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('sale_date')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control datepicker" name="sale_date" value="<?php echo $sale_date; ?>" required>
                            </div>
                            <?php echo form_error('sale_date'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('sale_quantity')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Quantity</label>
                            <div class="col-sm-9">
                                <input type="number" step="1" min="0" class="form-control" name="sale_quantity" value="<?php echo $sale_quantity; ?>" required>
                            </div>
                            <?php echo form_error('sale_quantity'); ?>
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
                    <?php echo form_close(); ?>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-sm-12 text-center">Image</label>
                                <div class="col-sm-12" style="border:1px solid #000; height:120px;" id="image">
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-12 text-center">QR Code</label>
                                    <textarea type="text" class="form-control" id="member_qr" rows="5" onkeyup="pressed()" autofocus></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table">
                                    <tr>
                                        <th style="width: 80px;">Name</th>
                                        <th style="width: 10px;">:</th>
                                        <td id="name"></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <th>:</th>
                                        <td id="mobile"></td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <th>:</th>
                                        <td id="address"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                var x = 0;
                function pressed() {
                    if (x == 0) {
                        x = 1;
                        setTimeout(function(){ getMemberQR() }, 1000);
                    }
                }

                function getMemberQR() {
                    x = 0;
                    var member_qr = getText($('#member_qr').val());
                    if (member_qr != '') {
                        $.ajax({
                            type: "GET",
                            dataType: "JSON",
                            data: {'member_qr' : member_qr},
                            url: base_url+'member/memberCheckByQrCode',
                            success: function(data) {
                                $('#member_qr').val('');
                                if (data != null) {
                                    $('#membership_number').val(data.membership_number);
                                    $('#name').html(data.member_name);
                                    $('#mobile').html(data.mobile_number);
                                    $('#address').html(data.residential_address);
                                    if (data.member_image != '') {
                                        $('#image').html('<img src="'+base_url+'uploads/members/'+data.member_image+'" style="height:120px;">');
                                    } else {
                                        $('#image').html('');
                                    }
                                } else {
                                    $('#membership_number').val('');
                                    $('#name').html('');
                                    $('#mobile').html('');
                                    $('#address').html('');
                                    $('#image').html('');
                                    alerts('Member not Found!');
                                }
                            }
                        });
                    } else {
                        alerts('Please Scan QR code!');
                    }
                }

                function getText(str) {
                    str = str.replace("Membership ID:", "\nMembership ID:");
                    str = str.replace("Date", "\nDate");
                    str = str.replace(/^\s*\n/gm, ""); //remove empty line.
                    return str;
                }
            </script>
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
                                <th>Number</th>
                                <th>Type</th>
                                <th>Member ID</th>
                                <th>Serial</th>
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
                                <td><?php echo dateFormat($val->sale_date)?></td>
                                <td><?php echo $val->sale_number?></td>
                                <td><?php echo $val->type?></td>
                                <td><?php echo $val->membership_number?></td>
                                <td><?php echo $val->serial_number?></td>
                                <td align="right"><?php echo numberFormat($val->sale_quantity, 1)?></td>
                                <td class="remove">
                                    <div class="dropdown">
                                        <a class="btn btn-success btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a onclick="prints(<?php echo $val->id; ?>)">
                                                    <i class="fa fa-print"></i> Print
                                                </a>
                                            </li>
                                            <li>
                                                <a onclick="printReceipts(<?php echo $val->id; ?>)">
                                                    <i class="fa fa-print"></i> Receipt Print
                                                </a>
                                            </li>
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
            <script>
                function prints(id) {
                    window.open(base_url+'vakalatnama/sale/prints/'+id, "_blank", "toolbar=yes,scrollbars=yes,width=540,height=520");
                }
                function printReceipts(id) {
                    window.open(base_url+'vakalatnama/sale/receipt/'+id, "_blank", "toolbar=yes,scrollbars=yes,width=540,height=520");
                }
            </script>
            <?php
            }
            ?>
        </div>
    </div>
</section>