<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li <?php echo ($pageName=='active')?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/active'.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Active Member's List
                </a>
            </li>
            <li <?php echo ($pageName=='lifetime')?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/lifetime'.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Lifetime Member's List
                </a>
            </li>
            <li <?php echo ($pageName=='benevolent')?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/benevolent'.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Benevolent (Yes) List
                </a>
            </li>
            <li <?php echo ($pageName=='benevolentno')?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/benevolentno'.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Benevolent (No) List
                </a>
            </li>
            <li <?php echo ($pageName=='dead')?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/dead'.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Dead Member's List
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                <?php echo form_open($path.'/'.$pageName,'method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" name="enrollment_date" placeholder="Date of Enrollment" value="<?php echo $this->input->get('enrollment_date')?>">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="q" placeholder="Write your search text..." value="<?php echo $this->input->get('q')?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-flat">Search</button>
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path.'/'.$pageName); ?>">X</a>
                    </div> 
                </div>
                <?php echo form_close(); ?>

                <div class="box-body table-responsive">
                    <?php echo $paginationMsg; ?>
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden"><h3><?php echo $pageName; ?> List</h3></caption>
                       <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Reg. Date</th>
                                <th>Sanad No</th>
                                <th>Sanad Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr>
                                <td><?php echo $val->membership_number; ?></td>
                                <td><?php echo $val->member_name; ?></td>
                                <td><?php echo $val->mobile_number; ?></td>
                                <td><?php echo dateFormat($val->enrollment_date); ?></td>
                                <td><?php echo $val->sanad_number; ?></td>
                                <td><?php echo dateFormat($val->sanad_date); ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="text-right"><?php echo $paginationLinks; ?></div>
                </div>
            </div>
        </div>
    </div>
</section>