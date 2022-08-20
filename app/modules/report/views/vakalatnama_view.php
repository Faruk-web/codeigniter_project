<section class="content-header">
    <?php
    $pageName = 'Vakalatnama';
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
                <?php echo form_open($path.'/vakalatnama','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" id="date" name="date" placeholder="As On Date" value="<?php echo $this->input->get('date')?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-flat">Search</button>
                        <a class="btn btn-warning btn-flat" href="<?php echo base_url($path.'/vakalatnama'); ?>">X</a>
                    </div>
                </div>
                <?php echo form_close(); ?>

                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover dataTable">
                        <caption class="hidden"><h3><?php echo $pageName; ?></h3></caption>
                        <thead>
                            <tr>
                                <th>Stock</th>
                                <th>Sale</th>
                                <th>Remaining</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $records[0]->quantity?></td>
                                <td><?php echo $records[1]->quantity?></td>
                                <td><?php echo ($records[0]->quantity-$records[1]->quantity)?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>