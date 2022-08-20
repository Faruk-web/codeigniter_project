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
            <li>
                <a href="<?php echo base_url().$path.'/unapproved'.qString(); ?>">
                    <i class="fa fa-eye-slash" aria-hidden="true"></i> Unapproved <?php echo $pageName; ?>
                </a>
            </li>
            <li class="active">
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
                <?php echo form_open($path.'/approved','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <input type="text" class="form-control" name="receipt" placeholder="Receipt ID" value="<?php echo $this->input->get('receipt')?>">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="member" placeholder="Member ID" value="<?php echo $this->input->get('member')?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-flat">Search</button>
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path.'/approved'); ?>">X</a>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <div class="box-body table-responsive">
                    <?php echo $paginationMsg; ?>
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden"><h3><?php echo $pageName; ?> List</h3></caption>
                        <thead>
                            <tr>
                                <th>SL</th>
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
                                <td><?php echo $serial++?></td>
                                <td><?php echo dateFormat($val->approved_date); ?></td>
                                <td><?php echo bankNames($val->receipt_bank); ?></td>
                                <td><?php echo $val->recepit_number; ?></td>
                                <td><?php echo $val->recepit_date; ?></td>
                                <td><?php echo $val->membership_number; ?></td>
                                <td><?php echo ($val->member_id>0)?$val->member_name:$val->receipt_member; ?></td>
                                <td><?php echo $val->start_date; ?></td>
                                <td><?php echo $val->finish_date; ?></td>
                                <td><?php echo $val->total_amount; ?></td>
                                <td><a class="btn btn-primary btn-xs btn-flat" onclick="setUnApprove(<?php echo $key.','.$val->id; ?>)">Unapprove</a></td>
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
                function setUnApprove(key, id) {
                    if (id>0) {
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            data: {csrf_name:csrf_hash, 'id' : id},
                            url: base_url+'receipt/unApprovedSingle',
                            success: function(response) {
                                $('input[name="'+response.csrf_name+'"]').val(response.csrf_hash);

                                if (response.status==1) {
                                    $('#receiptTr'+key).remove();
                                    alerts('Receipt Unapproved');
                                } else {
                                    alerts('Receipt Unapproved Failed! '+response.error);
                                }
                            }
                        });
                    } else {
                        alerts('Receipt ID not Found!');
                    }
                }
            </script>
        </div>
    </div>
</section>