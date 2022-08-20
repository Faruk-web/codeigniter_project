<section class="content-header">
    <?php
    $pageName = 'Ledger';
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
                <?php echo form_open($path.'/ledger','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <select class="form-control" name="category" required>
                            <option value="">Select Category</option>
                            <?php
                            foreach ($catData as $cat) {
                                $sel = ($this->input->get('category')==$cat->id)?'selected':'';
                                echo '<option value="'.$cat->id.'" '.$sel.'>'.$cat->category_name.'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="bank" required>
                            <option value="">Select Bank</option>
                            <?php
                            foreach (bankNames() as $bk => $bnk) {
                                $sel = ($this->input->get('bank')==$bk)?'selected':'';
                                echo '<option value="'.$bk.'" '.$sel.'>'.$bnk.'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="year">
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
                        <select class="form-control" name="month">
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
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path.'/ledger'); ?>">X</a>
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
                                <th>Category</th>
                                <th>Bank</th>
                                <th>Amount</th>
                            </tr>  
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($records as $val) {
                            ?>
                            <tr>
                                <td><?php echo date('d', strtotime($val->approved_date)); ?></td>
                                <td><?php echo $val->category_name; ?></td>
                                <td><?php echo bankNames($val->receipt_bank); ?></td>
                                <td align="right"><?php echo intFormat($val->sumAmount); ?></td>
                            </tr>
                            <?php
                            $total += $val->sumAmount;
                            }
                            ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th align="right" class="text-right"><?php echo intFormat($total); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>