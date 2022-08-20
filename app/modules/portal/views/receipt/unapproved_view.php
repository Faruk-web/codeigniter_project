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
            <li>
                <a href="<?php echo base_url().$path.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> <?php echo $pageName; ?> List
                </a>
            </li>
            <li class="active">
                <a href="<?php echo base_url().$path.'/unapproved'.qString(); ?>">
                    <i class="fa fa-eye-slash" aria-hidden="true"></i> Unapproved<?php echo $pageName; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url().$path.'/approved'.qString(); ?>">
                    <i class="fa fa-check" aria-hidden="true"></i> Approved <?php echo $pageName; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url().$path.'/create'.qString(); ?>">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add <?php echo $pageName; ?>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                <?php echo form_open($path.'/unapproved','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <input type="text" class="form-control" name="receipt" placeholder="Receipt ID" value="<?php echo $this->input->get('receipt')?>">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="member" placeholder="Member ID" value="<?php echo $this->input->get('member')?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-flat">Search</button>
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path.'/unapproved'); ?>">X</a>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <div class="box-body table-responsive">
                    <?php echo $paginationMsg; ?>
                    <?php echo form_open($path.'/approvedAll'.qString()); ?>
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden"><h3><?php echo $pageName; ?> List</h3></caption>
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check_all" onclick="chkAll()"></th>
                                <th>Date</th>
                                <th>Bank</th>
                                <th>Recepit ID</th>
                                <th>Date</th>
                                <th>Member ID</th>
                                <th>Member Name</th>
                                <th>Start Date</th>
                                <th>Finish Date</th>
                                <th>Amount</th>                                <th>Approve</th>
                            </tr>
                        </thead>
                        <tbody id="unBody">
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr id="receiptTr<?php echo $key; ?>">
                                <td><input type="checkbox" name="id[<?php echo $key; ?>]" value="<?php echo $val->id; ?>"></td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="date[<?php echo $key; ?>]" id="date<?php echo $key; ?>" class="form-control datepicker" style="width:100px;">
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <select name="bank[<?php echo $key; ?>]" id="bank<?php echo $key; ?>" class="form-control" style="width:90px;">
                                            <?php
                                            foreach(bankNames() as $bK => $bN) {
                                                echo '<option value="'.$bK.'">'.$bN.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                <td><?php echo $val->recepit_number; ?></td>
                                <td><?php echo $val->recepit_date; ?></td>
                                <td><?php echo $val->membership_number; ?></td>
                                <td><?php echo ($val->member_id>0)?$val->member_name:$val->receipt_member; ?></td>
                                <td><?php echo $val->start_date; ?></td>
                                <td><?php echo $val->finish_date; ?></td>
                                <td><?php echo $val->total_amount; ?></td>
                                <td><a class="btn btn-primary btn-xs btn-flat" onclick="setApprove(<?php echo $key.','.$val->id; ?>)">Approve</a></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-success btn-flat"><i class="fa fa-edit"></i> Approved</button>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="text-right"><?php echo $paginationLinks; ?></div>
                </div>
            </div>
            <script>
                function chkAll() {
                    if (document.getElementById('check_all').checked==true) {
                        $('#unBody input[type=checkbox]').prop('checked', true);
                        $('#unBody input[type=text]').prop('required', true);
                    } else {
                        $('#unBody input[type=checkbox]').prop('checked', false);
                        $('#unBody input[type=text]').prop('required', false);
                    }
                }

                function setApprove(key, id) {
                    var date = $('#date'+key).val();
                    var bank = $('#bank'+key).val();
                    if (id>0 && bank>0) {
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            data: {csrf_name:csrf_hash, 'id' : id, 'date' : date, 'bank' : bank},
                            url: base_url+'receipt/approvedSingle',
                            success: function(response) {
                                //$('input[name="'+response.csrf_name+'"]').val(response.csrf_hash);
                                csrf_name = response.csrf_name;
                                csrf_hash = response.csrf_hash;

                                if (response.status==1) {
                                    $('#receiptTr'+key).remove();
                                    alerts('Receipt Approved');
                                } else {
                                    alerts('Receipt Approve Failed! '+response.error);
                                }
                            }
                        });
                    } else {
                        alerts('Receipt ID/Bank not Found!');
                    }
                }
            </script>
        </div>
    </div>
</section>