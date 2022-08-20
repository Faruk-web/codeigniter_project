<section class="content-header">
    <?php echo $this->session->flashdata('flash_msg'); ?>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li <?php echo ($pageName=='voter')?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/voter'.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Voter's List
                </a>
            </li>
            <li <?php echo ($pageName=='defaulter')?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/defaulter'.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Defaulter Member's List
                </a>
            </li>
            <li <?php echo ($pageName=='stuckoff')?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/stuckoff'.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Stuck off Member's List
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                <?php
                if ($pageName!='stuckoff') {
                echo form_open($path.'/'.$pageName,'method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" name="date" placeholder="Paid up to" value="<?php echo $this->input->get('date')?>">
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
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path.'/'.$pageName); ?>">X</a>
                    </div> 
                </div>
                <?php
                echo form_close();
                }
                ?>


                <?php
                if (!empty($records)) {
                echo form_open($path.'/makeStuckoff'.qString());
                ?>
                <div class="box-body table-responsive">
                    <?php echo $paginationMsg; ?>
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden"><h3><?php echo $pageName; ?> List</h3></caption>
                       <thead>
                            <tr>
                                <th>
                                <?php
                                if ($pageName=='defaulter') {
                                    echo '<input type="checkbox" id="all" value="1" onclick="chkAll()">';
                                }
                                ?>
                                #
                                </th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Paid Date</th>
                                <th>Payment Clear</th>
                            </tr>
                        </thead>
                        <tbody id="allRow">
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr>
                                <td>
                                    <?php
                                    if ($pageName=='defaulter') {
                                        echo '<input type="checkbox" name="id[]" value="'.$val->id.'">';
                                    }
                                    ?>
                                    <?php echo $serial++; ?>
                                </td>
                                <td><?php echo $val->membership_number; ?></td>
                                <td><?php echo $val->member_name; ?></td>
                                <td><?php echo $val->mobile_number; ?></td>
                                <td><?php echo dateFormat($val->recepit_date); ?></td>
                                <td><?php echo dateFormat($val->finish_date); ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <?php
                        if ($pageName=='defaulter') {
                            echo '<tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><button type="submit" class="btn btn-danger btn-flat">Make Stuck-off</button>
                                </td>
                            </tr>
                            </tfoot>';
                        }
                        ?>
                    </table>
                    <div class="text-right">
                        <?php echo $paginationLinks; ?>
                    </div>
                </div>
                <?php 
                echo form_close(); 
                } else {
                    if ($pageName=='stuckoff') {
                        echo '<h3 class="text-center">No Stuck-off Member Found.</h3>';
                    } else {
                        echo '<h3 class="text-center">Please Select year and month than click search to show list.</h3>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
<script>
    function chkAll() {
        if (document.getElementById('all').checked==true) {
            $('#allRow input').prop('checked', true);
        } else {
            $('#allRow input').prop('checked', false);
        }
    }
</script>