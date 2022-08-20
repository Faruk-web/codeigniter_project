<section class="content-header">
    <?php
    $pageName = 'Income';
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
                    $income_number = $dataview->income_number;
                    $income_date = $dataview->income_date;
                    $income_note = $dataview->income_note;
                    $income_amount = $dataview->income_amount;
                } else {
                    $income_number = '';
                    $income_date = set_value('income_date');
                    $income_note = set_value('income_note');
                    $income_amount = set_value('income_amount');
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="control-label col-sm-3">No</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo $income_number; ?>" placeholder="Auto Generated" readonly>
                            </div>
                        </div>

                        <div class="form-group <?php echo (form_error('income_date')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Date</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control datepicker" name="income_date" value="<?php echo $income_date; ?>" required>
                            </div>
                            <?php echo form_error('income_date'); ?>
                        </div>

                        <div class="form-group <?php echo (form_error('income_note')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Note</label>
                            <div class="col-sm-9">
                                <textarea type="text" class="form-control" name="income_note" rows="4"><?php echo $income_note?></textarea>
                            </div>
                            <?php echo form_error('income_note'); ?>
                        </div>
                    
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th style="width:40px;"><a class="btn btn-success btn-flat" onclick="addRow()"><i class="fa fa-plus"></i></a></th>
                                    <th>Head</th>
                                    <th style="width:130px;">Amount</th>
                                </tr>
                                </thead>

                                <tbody id="subBody">
                                <?php
                                foreach ($dataSub as $k => $sub) {
                                ?>
                                <tr id="row<?php echo $k; ?>">
                                    <td><a class="btn btn-danger btn-flat" onclick="removeRw(<?php echo $k; ?>)"><i class="fa fa-minus"></i></a><input type="hidden" name="row_id[]" value="<?php echo $sub->id?>"></td>
                                    <td>
                                        <select class="form-control" name="head_id[]" id="head_id<?php echo $k; ?>" required>
                                            <option value="">Select Head</option>
                                            <?php
                                            foreach ($headData as $hd) {
                                                $sel = ($hd->id==$sub->head_id)?'selected':'';
                                                echo '<option value="'.$hd->id.'" '.$sel.'>'.$hd->head_name.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" step="1" min="0" class="form-control" name="amount[]" id="amount<?php echo $k; ?>" value="<?php echo $sub->amount?>" required autocomplete="off" onkeyup="getTotal()">
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                    <th colspan="2" class="text-right">Total: </th>
                                    <th><input type="text" class="form-control readonly" name="income_amount" id="income_amount" value="<?php echo $income_amount?>" required></th>
                                </tfoot>
                            </table>
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
                function addRow() {
                    var k = $('#subBody tr').length;
                    var headOption = $('#head_id0').html();

                    var html = '<tr id="row'+k+'">'+
                        '<td><a class="btn btn-danger btn-flat" onclick="removeRw('+k+')"><i class="fa fa-minus"></i></a><input type="hidden" name="row_id[]"></td>'+
                        '<td>'+
                            '<select class="form-control" name="head_id[]" id="head_id'+k+'" required>'+headOption+'</select>'+
                        '</td>'+
                        '<td>'+
                            '<input type="number" step="1" min="0" class="form-control" name="amount[]" id="amount'+k+'" required autocomplete="off" onkeyup="getTotal()">'+
                        '</td>'+
                    '</tr>';
                    $('#subBody').append(html);
                    $('#head_id'+k).val('');
                }

                function removeRw(k) {
                    $('#row'+k).remove();
                    getTotal();
                }

                function getTotal() {
                    var income_amount = 0;
                    $("input[id^='amount']").each(function(){
                        income_amount += +$(this).val();
                    });
                    $('#income_amount').val(income_amount);
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
                        <select name="head" class="form-control select2">
                            <option value="">Select Head</option>
                            <?php
                            $headArr = [];
                            foreach ($headData as $hd) {   
                                $sel = ($this->input->get('head')==$hd->id)?'selected':'';
                                echo '<option value="'.$hd->id.'" '.$sel.'>'.$hd->head_name.'</option>';

                                $headArr[$hd->id] = $hd->head_name;
                            }
                            ?>
                        </select>
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
                                <th>No.</th>
                                <th>Date</th>
                                <th>Head</th>
                                <th>Amount</th>
                                <th class="remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr>
                                <td><?php echo $serial++?></td>
                                <td><?php echo $val->income_number; ?></td>
                                <td><?php echo dateFormat($val->income_date); ?></td>
                                <td>
                                    <?php
                                    $headAll = explode('|',$val->headId);
                                    foreach ($headAll as $hK => $hV) {
                                        echo ($hK!=0)?', ':'';
                                        echo $headArr[$hV];
                                    }
                                    ?>
                                </td>
                                <td align="right"><?php echo numberFormat($val->totalAmount, 1)?></td>
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