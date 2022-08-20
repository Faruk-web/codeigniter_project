<section class="content-header">
    <?php
    $pageName = 'Received Payment';
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
                <?php echo form_open($path.'/received','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
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
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path.'/received'); ?>">X</a>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden"><h3><?php echo $pageName; ?></h3></caption>
                        <thead>
                              <tr>
                                <th>Receipt</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>  
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records['categoryData'] as $c => $cat) {
                            ?>
                            <tr>
                                <th><?php echo $cat; ?></th>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                                <?php
                                $total = 0;
                                $x = 0;
                                foreach ($records['receipts'][$c] as $key => $amt) {
                                    $total += $amt;
                                ?>
                                <tr>
                                    <td><?php echo bankNames($key); ?></td>
                                    <td><?php echo intFormat($amt); ?></td>
                                    <td><?php echo (count($records['receipts'][$c])-1==$x)?intFormat($total):''; ?></td>
                                </tr>
                                <?php
                                $x++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>