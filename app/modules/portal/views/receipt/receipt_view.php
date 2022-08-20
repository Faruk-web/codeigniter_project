<section class="content-header">
    <?php
    $pageName = 'Receipt';
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
            <li>
                <a href="<?php echo base_url().$path.'/unapproved'.qString(); ?>">
                    <i class="fa fa-eye-slash" aria-hidden="true"></i> Unapproved <?php echo $pageName; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url().$path.'/approved'.qString(); ?>">
                    <i class="fa fa-check" aria-hidden="true"></i> Approved <?php echo $pageName; ?>
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
            if (isset($show)) {
            ?>
            <div class="tab-pane active">
                <div class="box-body table-responsive">
                    <?php
                    if (isset($dataRow)) {
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
                                <th style="width:200px;">Date</th>
                                <th style="width:10px;">:</th>
                                <td><?php echo dateFormat($dataRow->recepit_date); ?></td>
                            </tr>
                            <tr>
                                <th>Receipt No.</th>
                                <th>:</th>
                                <td><?php echo $dataRow->recepit_number; ?></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <th>:</th>
                                <td><?php echo $dataRow->recepit_description; ?></td>
                            </tr>
                            <tr>
                                <th>Membership No</th>
                                <th>:</th>
                                <td><?php echo $dataRow->membership_number; ?></td>
                            </tr>
                            <tr>
                                <th>Member Name</th>
                                <th>:</th>
                                <td><?php echo ($dataRow->member_id>0)?$dataRow->member_name:$dataRow->receipt_member; ?></td>
                            </tr>
                            <tr>
                                <th>Month</th>
                                <th>:</th>
                                <td><?php echo $dataRow->month_period; ?> Months</td>
                            </tr>
                            <tr>
                                <th>Start Date</th>
                                <th>:</th>
                                <td><?php echo dateFormat($dataRow->start_date); ?></td>
                            </tr>
                            <tr>
                                <th>Finish Date</th>
                                <th>:</th>
                                <td><?php echo dateFormat($dataRow->finish_date); ?></td>
                            </tr>
                            <tr>
                                <th colspan="3">&nbsp;</th>
                            </tr>
                            <?php
                            $totalAmount = 0;
                            foreach ($catData as $k => $cat) {
                            ?>
                            <tr>
                                <td><?php echo $cat->category_name; ?></td>
                                <th>:</th>
                                <td><?php echo $cat->amount; ?></td>
                            </tr>
                            <?php
                            $totalAmount += ($cat->amount>0)?$cat->amount:0;
                            }
                            ?>
                            <tr>
                                <th>Total Amount</th>
                                <th>:</th>
                                <td><?php echo numberFormat($totalAmount,2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    } else {
                        echo notFoundText();
                    }
                    ?>

                    <a class="pull-right" href="<?php echo base_url().$path.qString(); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
            <?php
            } elseif (isset($edit) || isset($create)) {
                if (isset($dataRow)) {
                    $recepit_number = $dataRow->recepit_number;
                    $member_id = $dataRow->member_id;
                    $recepit_description = $dataRow->recepit_description;
                    $month_period = $dataRow->month_period;
                    $recepit_date = date("d/m/Y", strtotime($dataRow->recepit_date));
                    $start_date = date("d/m/Y", strtotime($dataRow->start_date));
                    $finish_date = date("d/m/Y", strtotime($dataRow->finish_date));

                    $member_id = $dataRow->member_id;
                    $member_name = $dataRow->member_name;
                    $membership_number = $dataRow->membership_number;
                } else {
                    $recepit_number = set_value('recepit_number');
                    $member_id = set_value('member_id');
                    $recepit_description = set_value('recepit_description');
                    $month_period = set_value('month_period');
                    $recepit_date = date('d/m/Y');
                    $start_date = set_value('start_date');
                    $finish_date = set_value('finish_date');

                    $member_id = set_value('member_id');
                    $member_name = set_value('member_name');
                    $membership_number = set_value('membership_number');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-8">
                        <div class="form-group <?php echo (form_error('membership_number')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Member ID</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="membership_number" id="membership_number" value="<?php echo $membership_number; ?>" required onkeyup="setEmpty()">
                                    <label class="input-group-addon">
                                        <input type="checkbox" name="new" id="new" value="1" <?php echo (isset($edit) && $member_id==0)?'checked':''; ?> onclick="newMember()"> New Member
                                    </label>
                                </div>
                            </div>
                            <?php echo form_error('membership_number'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('month_period')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Select Month</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="month_period" id="month_period" required onchange="setEmpty()">
                                <?php
                                foreach (monthPeriod() as $mp) {
                                    $sel = ($month_period==$mp)?'selected':'';
                                    echo '<option value="'.$mp.'" '.$sel.'>'.$mp.' Months</option>';
                                }
                                ?>
                                </select>
                            </div>
                            <?php echo form_error('month_period'); ?>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-3">&nbsp;</label>
                            <div class="col-sm-9">
                                <button type="button" class="btn btn-success btn-block btn-flat" onclick="getMember()">Search</button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-3">Member Name</label>
                            <div class="col-sm-9">
                                <input type="hidden" class="form-control" name="member_id" id="member_id" value="<?php echo $member_id; ?>">
                                <input type="text" class="form-control" name="receipt_member" id="member_name" value="<?php echo $member_name; ?>" readonly>

                                <input type="hidden" class="form-control" id="benevolentFund">
                                <input type="hidden" class="form-control" id="lifemember">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-3">Receipt No.</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="recepit_number" value="<?php echo $recepit_number; ?>" readonly placeholder="Auto Generate">
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('recepit_date')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="recepit_date" id="recepit_date" value="<?php echo $recepit_date; ?>" required date-mask>
                            </div>
                            <?php echo form_error('recepit_date'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('start_date')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Start Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="start_date" id="start_date" value="<?php echo $start_date; ?>" required date-mask>
                            </div>
                            <?php echo form_error('start_date'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('finish_date')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Finish Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="finish_date" id="finish_date" value="<?php echo $finish_date; ?>" required date-mask>
                            </div>
                            <?php echo form_error('finish_date'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('recepit_description')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3">Description</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="recepit_description" value="<?php echo $recepit_description; ?>">
                            </div>
                            <?php echo form_error('recepit_description'); ?>
                        </div>

                        <div id="categoryBox">
                            <div class="alert alert-warning" role="alert" id="unapproved_msg" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                This Member have Unapproved Receipt!
                            </div>

                            <h4 class="bottom-line" style="margin-top:40px;">Category:</h4>
                            <?php
                            $totalAmount = 0;
                            foreach ($catData as $k => $cat) {
                            ?>
                            <div class="form-group">
                                <label class="control-label col-sm-6"><?php echo $cat->category_name; ?> : </label>

                                <div class="col-sm-6">
                                    <input type="hidden" class="form-control" name="data_id[]" value="<?php echo $cat->data_id; ?>">
                                    <input type="hidden" class="form-control" name="category_id[]" value="<?php echo $cat->id; ?>">
                                    <input type="number" step="1" min="0" class="form-control lifemember<?php echo $cat->applied_lifemember; ?> <?php echo ($cat->benevolent_status==1)?'benevolent':''; ?>" name="amount[]" id="amount<?php echo $k; ?>" value="<?php echo $cat->amount; ?>" onkeyup="getTotal()">


                                    <input type="hidden" id="monthlyin_receipt<?php echo $k; ?>" value="<?php echo $cat->monthlyin_receipt; ?>">
                                    <input type="hidden" id="yearlyin_receipt<?php echo $k; ?>" value="<?php echo $cat->yearlyin_receipt; ?>">

                                    <input type="hidden" id="category_amount<?php echo $k; ?>" value="<?php echo $cat->category_amount; ?>">
                                </div>

                            </div>
                            <?php
                            $totalAmount += ($cat->amount>0)?$cat->amount:0;
                            }
                            ?>
                        </div>

                        <div class="form-group <?php echo (form_error('total_amount')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-6">Total Amount</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="total_amount" id="total_amount" value="<?php echo $totalAmount; ?>" readonly>
                            </div>
                            <?php echo form_error('total_amount'); ?>
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
            <script>
                function setEmpty() {
                    $("#categoryBox input[id^='amount']").val('');
                    $("#categoryBox input[id^='amount']").prop('disabled', true);
                    $('.submit button').prop('disabled', true);
                }

                function newMember() {
                    if (document.getElementById('new').checked==true) {
                        $("#membership_number").val('');
                        $("#membership_number").prop('disabled', true);
                        $("#membership_number").prop('required', false);

                        $("#categoryBox input[id^='amount']").val('');
                        $("#categoryBox input[id^='amount']").prop('disabled', false);
                        $('.submit button').prop('disabled', false);
                        
                        $("#member_name").prop('readonly', false);
                    } else {
                        $("#membership_number").prop('disabled', false);
                        $("#membership_number").prop('required', true);
                        setEmpty();
                        
                        $("#member_name").prop('readonly', true);
                    }
                    getTotal();
                }

                function getMember() {
                    var membership_number = $('#membership_number').val();
                    var month_period = $('#month_period').val();
                    if (membership_number!='' && month_period!='') {
                        $.ajax({
                            type: "GET",
                            dataType: "JSON",
                            data: {'membership_number' : membership_number, 'month_period' : month_period},
                            url: base_url+'receipt/memberCheck',
                            success: function(data) {
                                if (data.status==1) {
                                    $('#member_id').val(data.id);
                                    $('#member_name').val(data.member_name);
                                    $('#start_date').val(data.start_date);
                                    $('#finish_date').val(data.finish_date);
                                    $('#benevolentFund').val(data.benevolentFund);
                                    $('#lifemember').val(data.lifemember);

                                    if (data.unapproved_count>0) {
                                        $('#unapproved_msg').show();
                                    } else {
                                        $('#unapproved_msg').hide();
                                    }

                                    if (data.yearlyin>0) {
                                        yearlyInAmount();
                                    }

                                    $("#categoryBox input[id^='amount']").prop('disabled', false);
                                    $('.submit button').prop('disabled', false);

                                    periodAmount();
                                } else {
                                    $('#member_id').val('');
                                    $('#member_name').val('');
                                    $('#start_date').val('');
                                    $('#finish_date').val('');
                                    $('#benevolentFund').val('');
                                    $('#lifemember').val('');
                                    
                                    setEmpty();

                                    alerts('Member ID not Found!');
                                }
                            }
                        });
                    } else {
                        setEmpty();
                        alerts('Please select Member ID, Month, Start Date & Finish Date');
                    }
                }

                function periodAmount() {
                    var month_period = Number($('#month_period').val());
                    var payFor = (month_period/3);
                    var catLength = $("input[id^='amount']").length;
                    for (var i = 0; i < catLength; i++) {
                        var catRecipt = Number($('#monthlyin_receipt'+i).val());
                        var catAmount = Number($('#category_amount'+i).val());
                        if (catAmount>0 && catRecipt==1) {
                            var amount = (catAmount*payFor);
                            $('#amount'+i).val(amount.toFixed(2));
                        }
                    }

                    var benevolentFund = Number($('#benevolentFund').val());
                    if (benevolentFund>0) {
                        $('.benevolent').prop('readonly', false);
                        var benevolent = (benevolentFund*payFor);
                        $('.benevolent').val(benevolent.toFixed(2));
                    } else {
                        $('.benevolent').val('');
                        $('.benevolent').prop('readonly', true);
                    }

                    var lifemember = Number($('#lifemember').val());
                    if (lifemember==1) {
                        $('.lifemember2').val('');
                    }

                    getTotal();
                }

                function yearlyInAmount() {
                    var catLength = $("input[id^='amount']").length;
                    for (var i = 0; i < catLength; i++) {
                        var yearRcpt = Number($('#yearlyin_receipt'+i).val());
                        var catAmount = Number($('#category_amount'+i).val());
                        if (catAmount>0 && yearRcpt==1) {
                            $('#amount'+i).val(catAmount.toFixed(2));
                        }
                    }
                }

                function getTotal() {
                    var totalAmount = 0;
                    $("input[id^='amount']").each(function(){
                        totalAmount += +$(this).val();
                    });
                    $('#total_amount').val(totalAmount.toFixed(2));
                }

                <?php
                if(isset($create)) {
                ?>
                    $( document ).ready(function() {
                        setEmpty();
                    });
                <?php
                }
                
                if(isset($edit) && $member_id==0) {
                ?>
                    $( document ).ready(function() {
                        $("#membership_number").val('');
                        $("#membership_number").prop('disabled', true);
                        $("#membership_number").prop('required', false);
                        
                        $("#member_name").prop('readonly', false);
                    });
                <?php
                }
                ?>
            </script>
            <?php
            } elseif (isset($lists)) {
            ?>
            <div class="tab-pane active">
                <?php echo form_open($path.'/lists','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <input type="text" class="form-control" name="receipt" placeholder="Receipt ID" value="<?php echo $this->input->get('receipt')?>">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="member" placeholder="Member ID" value="<?php echo $this->input->get('member')?>">
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
                                <th>Recepit ID</th>
                                <th>Date</th>
                                <th>Member ID</th>
                                <th>Member Name</th>
                                <th>Month</th>
                                <th>Start Date</th>
                                <th>Finish Date</th>
                                <th>Amount</th>
                                <th class="remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr id="receiptTr<?php echo $key; ?>" <?php echo ($val->approved==0)?'class="bg-warning"':'';?>>
                                <td><?php echo $serial++?></td>
                                <td><?php echo $val->recepit_number; ?></td>
                                <td><?php echo $val->recepit_date; ?></td>
                                <td><?php echo $val->membership_number; ?></td>
                                <td><?php echo ($val->member_id>0)?$val->member_name:$val->receipt_member; ?></td>
                                <td><?php echo $val->month_period; ?></td>
                                <td><?php echo $val->start_date; ?></td>
                                <td><?php echo $val->finish_date; ?></td>
                                <td><?php echo $val->total_amount; ?></td>
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
                                                <a href="<?php echo base_url().$path.'/show/'.$val->id; ?>">
                                                    <i class="fa fa-eye"></i> Show
                                                </a>
                                            </li>

                                            <?php
                                            if ($val->approved!=1) {
                                            ?>
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
            <script>
                function prints(id) {
                    window.open(base_url+'receipt/prints/'+id, "_blank", "toolbar=yes,scrollbars=yes,width=540,height=520");
                }
            </script>
            <?php
            }
            ?>
        </div>
    </div>
</section>