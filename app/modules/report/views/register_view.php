<section class="content-header">
    <?php
    $pageName = 'Register';
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
                <?php echo form_open($path.'/register','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" id="date" name="date" placeholder="As On Date" value="<?php echo $this->input->get('date')?>" onchange="chkDate(1)">
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">From</span>
                            <input type="text" class="form-control" id="from_date" name="from" placeholder="Date Range From" value="<?php echo $this->input->get('from')?>" onchange="chkDate(2)">

                            <span class="input-group-addon">To</span>
                            <input type="text" class="form-control" id="to_date" name="to" placeholder="Date Range To" value="<?php echo $this->input->get('to')?>" onchange="chkDate(2)">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-flat">Search</button>
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path.'/register'); ?>">X</a>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden"><h3><?php echo $pageName; ?></h3></caption>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>M. No.</th>
                                <th>R. No.</th>
                                <?php
                                $catTotal = [];
                                foreach ($records['categoryData'] as $c => $cat) {
                                    echo '<th>'.$cat.'</th>';
                                    $catTotal[$c] = 0;
                                }
                                ?>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records['memberData'] as $k => $val) {
                            ?>
                            <tr>
                                <td><?php echo $val[2]?></td>
                                <td><?php echo $val[1]?></td>
                                <td><?php echo $val[0]?></td>
                                <?php
                                $colTotal = 0;
                                foreach ($records['categoryData'] as $c => $cat) {
                                    $amount = (isset($records['amountData'][$k][$c]))?$records['amountData'][$k][$c]:0;
                                    echo '<td>'.intFormat($amount).'</td>';
                                    $colTotal += $amount;

                                    $catTotal[$c] += $amount;
                                }
                                ?>
                                <td><?php echo intFormat($colTotal); ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <?php
                                $total = 0;
                                foreach ($records['categoryData'] as $c => $cat) {
                                    echo '<th>'.intFormat($catTotal[$c]).'</th>';
                                    $total += $catTotal[$c];
                                }
                                ?>
                                <th><?php echo intFormat($total); ?></th>
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