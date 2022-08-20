<section class="content-header">
    <?php
    $pageName = 'Member';
    echo $this->session->flashdata('flash_msg');
    if (isset($error_message)) {
        echo $error_message;
    }
    ?>
</section>

<section class="content">
    <div class="row">
        <h3 class="text-center">Welcome to <?php echo constant("SITENAME")?> Software!<br><small>Mr. <?php echo $this->session->userdata['logged_in']->username;?></small></h3>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li <?php echo (isset($lists))?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Change Request
                </a>
            </li>
            <?php
            if (isset($show)) {
            ?>
            <li class="active">
                <a href="#">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> Change Request Details
                </a>
            </li>
            <?php
            }
            ?>
        </ul>

        <div class="tab-content">
            <?php
            if (isset($show)) {
            ?>

            <div class="tab-pane active">
                <div class="box-body table-responsive" id="toprint">
                    <?php
                    if (isset($data)) {
                        $json = json_decode($data->json_data);
                    ?>
                    <table class="table table-bordered" border="1" cellpadding="5" cellspacing="0">
                        <caption class="hidden"><h3>Change Request Details</h3></caption>
                        <thead>
                            <tr>
                                <td>Type</td>
                                <td>Existing Data</td>
                                <td>Changed Request</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Status</td>
                                <td colspan="2"><?php echo ($data->status==1)?'Approved':'Pending';; ?></td>
                            </tr>
                            <tr>
                                <td style="width:200px;">Membership No</td>
                                <td colspan="2"><?php echo $data->membership_number; ?></td>
                            </tr>
                            <tr>
                                <td>Member Name</td>
                                <td><?php echo $data->member_name; ?></td>
                                <td class="text-success"><?php echo ($data->member_name!=$json->member_name)?$json->member_name:''; ?></td>
                            </tr>
                            <tr>
                                <td>Father Name</td>
                                <td><?php echo $data->father_name; ?></td>
                                <td class="text-success"><?php echo ($data->father_name!=$json->father_name)?$json->father_name:''; ?></td>
                            </tr>
                            <tr>
                                <td>Mother Name</td>
                                <td><?php echo $data->mother_name; ?></td>
                                <td class="text-success"><?php echo ($data->mother_name!=$json->mother_name)?$json->mother_name:''; ?></td>
                            </tr>
                            <tr>
                                <td>Spouce Name</td>
                                <td><?php echo $data->spouse_name; ?></td>
                                <td class="text-success"><?php echo ($data->spouse_name!=$json->spouse_name)?$json->spouse_name:''; ?></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td><?php echo $data->gender; ?></td>
                                <td class="text-success"><?php echo ($data->gender!=$json->gender)?$json->gender:''; ?></td>
                            </tr>
                            <tr>
                                <td>Religion</td>
                                <td><?php echo $data->religion; ?></td>
                                <td class="text-success"><?php echo ($data->religion!=$json->religion)?$json->religion:''; ?></td>
                            </tr>

                            <tr>
                                <td>Permanent Address</td>
                                <td><?php echo nl2br($data->permanent_address); ?></td>
                                <td class="text-success"><?php echo ($data->permanent_address!=$json->permanent_address)?nl2br($json->permanent_address):''; ?></td>
                            </tr>
                            <tr>
                                <td>Residential Address</td>
                                <td><?php echo nl2br($data->residential_address); ?></td>
                                <td class="text-success"><?php echo ($data->residential_address!=$json->residential_address)?nl2br($json->residential_address):''; ?></td>
                            </tr>
                            <tr>
                                <td>Office Address</td>
                                <td><?php echo nl2br($data->office_address); ?></td>
                                <td class="text-success"><?php echo ($data->office_address!=$json->office_address)?nl2br($json->office_address):''; ?></td>
                            </tr>
                            <tr>
                                <td>District (where practicing)</td>
                                <td><?php echo $data->practicing_district; ?></td>
                                <td class="text-success"><?php echo ($data->practicing_district!=$json->practicing_district)?$json->practicing_district:''; ?></td>
                            </tr>
                            <tr>
                                <td>National ID Copy</td>
                                <td><?php echo viewFile('members-nid', $data->nationalid_copy); ?></td>
                                <td class="text-success"><?php 
                                if(isset($json->nationalid_copy)) { echo viewFile('requests-nid', $json->nationalid_copy); }?></td>
                            </tr>
                            <tr>
                                <td>Certificate</td>
                                <td>
                                <?php 
                                if ($data->certificate!='') {
                                    $certificate = explode('|', $data->certificate);
                                    foreach ($certificate as $cer) {
                                        echo viewFile('members-certificate', $cer).'<br>';
                                    }
                                }
                                ?>
                                </td>
                                <td class="text-success">
                                <?php 
                                if (!empty($json->certificate)) {
                                    foreach ($json->certificate as $cer) {
                                        echo viewFile('requests-certificate', $cer).'<br>';
                                    }
                                }
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Nominee</th>
                                <td style="padding:0;">
                                    <?php
                                    if(!empty($nomineeData)) {
                                    ?>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>NID</th>
                                            <th>Photo</th>
                                            <th>NID Copy</th>
                                            <th>Percentage</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($nomineeData as $k => $nom) {
                                        ?>
                                        <tr>
                                            <td><?php echo $nom->nominee_name?></td>
                                            <td><?php echo $nom->nominee_nid?></td>
                                            <td><?php echo viewFile('members-nominee', $nom->nominee_image); ?></td>
                                            <td><?php echo viewFile('members-nominee', $nom->nominee_nid_copy); ?></td>
                                            <td><?php echo $nom->percentage?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(!empty($json->nominee)) {
                                    ?>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>NID</th>
                                            <th>Photo</th>
                                            <th>NID Copy</th>
                                            <th>Percentage</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                        foreach ($json->nominee as $k => $nom) {
                                        ?>
                                        <tr>
                                            <td><?php echo $nom->nominee_name?></td>
                                            <td><?php echo $nom->nominee_nid?></td>
                                            <td><?php echo viewFile('requests-nominee', $nom->nominee_image); ?></td>
                                            <td><?php echo viewFile('requests-nominee', $nom->nominee_nid_copy); ?></td>
                                            <td><?php echo $nom->percentage?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    } else {
                        echo notFoundText();
                    }
                    ?>
                </div>

                <div class="box-footer">
                    <?php
                    if ($data->status != 1) {
                    ?>
                    <a class="btn btn-success btn-xs btn-flat" href="<?php echo base_url().$path.'/approval/'.$data->id.qString(); ?>"><i class="fa fa-check"></i> Approve</a>
                    <?php   
                    }

                    if ($data->status != 2) {
                    ?>
                    <a class="btn btn-danger btn-xs btn-flat" href="<?php echo base_url().$path.'/reject/'.$data->id.qString(); ?>"><i class="fa fa-times"></i> Reject</a>
                    <?php   
                    }
                    ?>
                    <?php
                    if ($data->status == 0) {
                    ?>
                    <a class="btn btn-info btn-xs btn-flat" onclick="window.printpart()"><i class="fa fa-print"></i> Print</a>
                    <?php   
                    }
                    ?>

                    <a class="pull-right" href="<?php echo base_url().$path.qString(); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
            <script>
                function printpart () {
                    var printwin = window.open("");
                    printwin.document.write(document.getElementById("toprint").innerHTML);
                    printwin.stop();
                    printwin.print();
                    printwin.close();
                }
            </script>
            <?php    
            } elseif (isset($lists)) {
            ?>
            <div class="tab-pane active">
                <?php echo form_open($path.'/lists','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <select name="status" class="form-control">
                        <option value="0" <?php echo ($this->input->get('status')==0)?'selected':''; ?>>Pending</option>
                        <option value="1" <?php echo ($this->input->get('status')==1)?'selected':''; ?>>Approved</option>
                        <option value="2" <?php echo ($this->input->get('status')==2)?'selected':''; ?>>Rejected</option>
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
                        <caption class="hidden"><h3>Change Request List</h3></caption>
                       <thead>
                            <tr>
                                <th>Member ID</th>
                                <th>Requested At</th>
                                <th>Status</th>
                                <th class="remove">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($records as $key => $val) {
                            ?>
                            <tr>
                                <td><?php echo $val->membership_number; ?></td>
                                <td><?php echo dateFormat($val->created_at); ?></td>
                                <td><?php echo ($val->status==1)?'Approved':'Pending'; ?></td>
                                <td class="remove">
                                    <a class="btn btn-success btn-flat btn-xs" href="<?php echo base_url().$path.'/show/'.$val->id; ?>"><i class="fa fa-eye"></i> Show</a>
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