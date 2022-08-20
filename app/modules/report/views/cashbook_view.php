<section class="content-header">
    <?php
    $pageName = 'Cash book';
    echo $this->session->flashdata('flash_msg');
    if (isset($error_message)) {
        echo $error_message;
    }
    ?>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active">
                <a>
                    <i class="fa fa-list" aria-hidden="true"></i> <?php echo $pageName; ?>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                <?php echo form_open($path.'/cashbook','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" id="date" name="date" placeholder="As On Date" value="<?php echo $this->input->get('date')?>" onchange="chkDate(1)">
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="year" onchange="chkDate(2)">
                            <option value="">Select Year</option>
                            <?php
                            foreach (yearArr() as $year) {
                                $sel = ($this->input->get('year')==$year)?'selected':'';
                                echo '<option value="'.$year.'" '.$sel.'>'.$year.'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="month" onchange="chkDate(2)">
                            <option value="">Select Month</option>
                            <?php
                            foreach (monthArr() as $mk => $mv) {
                                $sel = ($this->input->get('month')==$mk)?'selected':'';
                                echo '<option value="'.$mk.'" '.$sel.'>'.$mv.'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-flat">Search</button>
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path.'/cashbook'); ?>">X</a>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <div class="box-body table-responsive">
                    <h3 class="text-center">
                        <p><?php echo $this->input->get('month')?monthArr($this->input->get('month')):date('M');?>-<?php echo $this->input->get('year')?:date('Y');?></p>

                        <p><?php echo ($this->input->get('category') && !empty($records))?$records[0]->category_name:'';?></p>

                        <p><?php echo $this->input->get('bank')?bankNames($this->input->get('bank')):'';?></p>
                    </h3>
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden">
                            <h3>
                                <?php echo $pageName; ?><br>

                                <p><?php echo $this->input->get('month')?monthArr($this->input->get('month')):date('M');?> - 
                        <?php echo $this->input->get('year')?: date('Y');?></p>

                        <p><?php echo ($this->input->get('category') && !empty($records))?$records[0]->category_name:'';?></p>

                        <p><?php echo $this->input->get('bank')?bankNames($this->input->get('bank')):'';?></p>
                            </h3>
                        </caption>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Particular</th>
                                <th>Amount</th>
                            </tr>  
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            foreach ($dateArr as $date => $bankArr) {
                            ?>
                            <tr>
                                <th><?php echo date('M-d', strtotime($date)); ?></th>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                                <?php
                                foreach ($bankArr as $bank => $catArr) {
                                ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <th><?php echo bankNames($bank); ?></th>
                                    <td>&nbsp;</td>
                                </tr>
                                    <?php
                                    $total = 0;
                                    foreach ($catArr as $cat) {
                                    ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?php echo $cat['category']; ?></td>
                                        <td align="right"><?php echo intFormat($cat['amount']); ?></td>
                                    </tr>
                                    <?php
                                    $total += $cat['amount'];
                                    $grandTotal += $cat['amount'];
                                    }
                                    ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <th align="right" class="text-right"><?php echo intFormat($total); ?></th>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th align="right" class="text-right"><?php echo intFormat($grandTotal); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <script>
                function chkDate(key) {
                    if (key==1) {
                        $('#from_date').val('');
                        $('#to_date').val('');
                    } else {
                        $('#date').val('');
                    }
                }
            </script>
        </div>
    </div>
</section>