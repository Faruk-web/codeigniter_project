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
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li <?php echo (isset($lists))?'class="active active-success"':''; ?>>
                <a href="<?php echo base_url().$path.qString(); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> <?php echo $pageName; ?> List
                </a>
            </li>
            <li <?php echo (isset($create))?'class="active"':''; ?>>
                <a href="<?php echo base_url().$path.'/create'.qString(); ?>">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add <?php echo $pageName; ?>
                </a>
            </li>
            <?php
            if (isset($edit)) {
            ?>
            <li class="active">
                <a href="#">
                    <i class="fa fa-edit" aria-hidden="true"></i> Edit <?php echo $pageName; ?>
                </a>
            </li>
            <?php
            }

            if (isset($show)) {
            ?>
            <li class="active">
                <a href="#">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> <?php echo $pageName; ?> Details
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
                <div class="box-body table-responsive">
                    <?php
                    if (isset($data)) {
                    ?>
                    <table class="table">
                        <caption class="hidden"><h3><?php echo $pageName;?> Details</h3></caption>
                        <thead>
                            <tr class="hide">
                                <th style="width:150px;"></th>
                                <th style="width:10px;"></th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3"><?php echo viewImg('members', $data->member_image, 'style="width:200px;"'); ?></td>
                            </tr>
                            <tr>
                                <th style="width:200px;">Membership No</th>
                                <th style="width:10px;">:</th>
                                <td><?php echo $data->membership_number; ?></td>
                            </tr>
                            <tr>
                                <th>Member Name</th>
                                <th>:</th>
                                <td><?php echo $data->member_name; ?></td>
                            </tr>
                            <tr>
                                <th>Father Name</th>
                                <th>:</th>
                                <td><?php echo $data->father_name; ?></td>
                            </tr>
                            <tr>
                                <th>Mother Name</th>
                                <th>:</th>
                                <td><?php echo $data->mother_name; ?></td>
                            </tr>
                            <tr>
                                <th>Spouce Name</th>
                                <th>:</th>
                                <td><?php echo $data->spouse_name; ?></td>
                            </tr>
                            <tr>
                                <th>Birth Date</th>
                                <th>:</th>
                                <td><?php echo dateFormat($data->birth_date); ?></td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <th>:</th>
                                <td><?php echo $data->gender; ?></td>
                            </tr>
                            <tr>
                                <th>Religion</th>
                                <th>:</th>
                                <td><?php echo $data->religion; ?></td>
                            </tr>
                            <tr>
                                <th>Nationality</th>
                                <th>:</th>
                                <td><?php echo $data->nationality; ?></td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <th>:</th>
                                <td><?php echo $data->blood_group; ?></td>
                            </tr>
                            <tr>
                                <th>Mobile Number</th>
                                <th>:</th>
                                <td><?php echo $data->mobile_number; ?></td>
                            </tr>
                            <tr>
                                <th>Email Address</th>
                                <th>:</th>
                                <td><?php echo $data->email; ?></td>
                            </tr>
                            <tr>
                                <th>Permanent Address</th>
                                <th>:</th>
                                <td><?php echo nl2br($data->permanent_address); ?></td>
                            </tr>
                            <tr>
                                <th>Residential Address</th>
                                <th>:</th>
                                <td><?php echo nl2br($data->residential_address); ?></td>
                            </tr>
                            <tr>
                                <th>Office Address</th>
                                <th>:</th>
                                <td><?php echo nl2br($data->office_address); ?></td>
                            </tr>
                            <tr>
                                <th>District (where practicing)</th>
                                <th>:</th>
                                <td><?php echo $data->practicing_district; ?></td>
                            </tr>
                            <tr>
                                <th>Firm Name/Address</th>
                                <th>:</th>
                                <td><?php echo nl2br($data->practicing_firm); ?></td>
                            </tr>
                            <tr>
                                <th>National ID Number</th>
                                <th>:</th>
                                <td><?php echo $data->nationalid_number; ?></td>
                            </tr>
                            <tr>
                                <th>National ID Copy</th>
                                <th>:</th>
                                <td><?php echo viewFile('members-nid', $data->nationalid_copy); ?></td>
                            </tr>
                            <tr>
                                <th>Certificate</th>
                                <th>:</th>
                                <td>
                                <?php 
                                if ($data->certificate!='') {
                                    $certificate = explode('|', $data->certificate);
                                    foreach ($certificate as $cer) {
                                        echo viewFile('members-certificate', $cer).'<br>';
                                    }
                                }
                                ?></td>
                            </tr>
                            <tr>
                                <th>Sanad No</th>
                                <th>:</th>
                                <td><?php echo $data->sanad_number; ?></td>
                            </tr>
                            <tr>
                                <th>Sanad Date</th>
                                <th>:</th>
                                <td><?php echo dateFormat($data->sanad_date); ?></td>
                            </tr>
                            <tr>
                                <th>Date of Enrollment</th>
                                <th>:</th>
                                <td><?php echo dateFormat($data->enrollment_date); ?></td>
                            </tr>
                            <tr>
                                <th>Lifetime Member</th>
                                <th>:</th>
                                <td><?php echo ($data->lifetime_member==1)?'Yes':'No'; ?></td>
                            </tr>
                            <tr>
                                <th>Date of Lifetime Member</th>
                                <th>:</th>
                                <td><?php echo dateFormat($data->lifetime_member_date); ?></td>
                            </tr>
                            <tr>
                                <th>Benevolent Fund</th>
                                <th>:</th>
                                <td><?php echo ($data->benevolent_fund==1)?'Yes':'No'; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <th>:</th>
                                <td><?php echo memberStatus($data->status); ?></td>
                            </tr>
                            <tr>
                                <th>Death Date</th>
                                <th>:</th>
                                <td><?php echo $data->death_date; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <caption>Nominee Details</caption>
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
                        if(isset($nomineeData)) {
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
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    } else {
                        echo notFoundText();
                    }
                    ?>

                    <a class="pull-right" href="<?php echo base_url().$path.qString(); ?>"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
            <?php
            } elseif (isset($edit) || isset($create)) {
                if (isset($data)) {
                    $membership_number = $data->membership_number;
                    $member_image = $data->member_image;
                    $member_name = $data->member_name;
                    $father_name = $data->father_name;
                    $mother_name = $data->mother_name;
                    $spouse_name = $data->spouse_name;
                    $birth_date = ($data->birth_date>0)?date("d/m/Y", strtotime($data->birth_date)):'';
                    $gender = $data->gender;
                    $religion = $data->religion;
                    $nationality = $data->nationality;
                    $blood_group = $data->blood_group;
                    $mobile_number = $data->mobile_number;
                    $email = $data->email;
                    $permanent_address = $data->permanent_address;
                    $residential_address = $data->residential_address;
                    $office_address = $data->office_address;
                    $practicing_district = $data->practicing_district;
                    $practicing_firm = $data->practicing_firm;
                    $nationalid_number = $data->nationalid_number;
                    $nationalid_copy = $data->nationalid_copy;
                    $sanad_number = $data->sanad_number;
                    $sanad_date = ($data->sanad_date>0)?date("d/m/Y", strtotime($data->sanad_date)):'';
                    $enrollment_date = ($data->enrollment_date>0)?date("d/m/Y", strtotime($data->enrollment_date)):'';
                    $lifetime_member = $data->lifetime_member;
                    $lifetime_member_date = ($data->lifetime_member_date>0)?date("d/m/Y", strtotime($data->lifetime_member_date)):'';
                    $benevolent_fund = $data->benevolent_fund;
                    $death_date = ($data->death_date>0)?date("d/m/Y", strtotime($data->death_date)):'';
                    $status = $data->status;

                    $certificate = explode('|', $data->certificate);
                } else {
                    $membership_number = set_value('membership_number');
                    $member_image = set_value('member_image');
                    $member_name = set_value('member_name');
                    $father_name = set_value('father_name');
                    $mother_name = set_value('mother_name');
                    $spouse_name = set_value('spouse_name');
                    $birth_date = set_value('birth_date');
                    $gender = set_value('gender');
                    $religion = set_value('religion');
                    $nationality = 'Bangladeshi';
                    $blood_group = set_value('blood_group');
                    $mobile_number = set_value('mobile_number');
                    $email = set_value('email');
                    $permanent_address = set_value('permanent_address');
                    $residential_address = set_value('residential_address');
                    $office_address = set_value('office_address');
                    $practicing_district = set_value('practicing_district');
                    $practicing_firm = set_value('practicing_firm');
                    $nationalid_number = set_value('nationalid_number');
                    $nationalid_copy = set_value('nationalid_copy');
                    $sanad_number = set_value('sanad_number');
                    $sanad_date = set_value('sanad_date');
                    $enrollment_date = set_value('enrollment_date');
                    $lifetime_member = set_value('lifetime_member');
                    $lifetime_member_date = set_value('lifetime_member_date');
                    $benevolent_fund = set_value('benevolent_fund');
                    $death_date = set_value('death_date');
                    $status = set_value('status');

                    $certificate = [];
                }
            ?>
            <div class="tab-pane active">
                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group <?php echo (form_error('member_image')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Image</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="member_image">
                                        <span class="input-group-addon strong"><?php echo viewFile('members',$member_image); ?></span>
                                    </div>
                                </div>
                                <?php echo form_error('member_image'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('membership_number')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3 required">Membership No</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="membership_number" value="<?php echo $membership_number; ?>" required>
                                </div>
                                <?php echo form_error('membership_number'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('member_name')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3 required">Member Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="member_name" value="<?php echo $member_name; ?>" required>
                                </div>
                                <?php echo form_error('member_name'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('father_name')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Father Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="father_name" value="<?php echo $father_name; ?>">
                                </div>
                                <?php echo form_error('father_name'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('mother_name')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Mother Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="mother_name" value="<?php echo $mother_name; ?>">
                                </div>
                                <?php echo form_error('mother_name'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('spouse_name')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Spouce Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="spouse_name" value="<?php echo $spouse_name; ?>">
                                </div>
                                <?php echo form_error('spouse_name'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('birth_date')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Birth Date</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="birth_date" value="<?php echo $birth_date; ?>" date-mask>
                                </div>

                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon strong">Gender</span>
                                        <select class="form-control" name="gender">
                                            <option <?php echo ($gender=='Male')?'selected':''; ?>>Male</option>
                                            <option <?php echo ($gender=='Female')?'selected':''; ?>>Female</option>
                                            <option <?php echo ($gender=='Others')?'selected':''; ?>>Others</option>
                                        </select>
                                    </div>
                                </div>
                                <?php echo form_error('birth_date'); ?>
                                <?php echo form_error('gender'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('religion')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Religion</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="religion">
                                    <?php
                                    foreach (['Islam', 'Hinduism', 'Christian', 'Buddhism'] as $rg) {
                                        $sel = ($rg==$religion)?'selected':'';
                                        echo '<option value="'.$rg.'" '.$sel.'>'.$rg.'</option>';
                                    }
                                    ?>
                                    </select>
                                </div>

                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon strong">Nationality</span>
                                        <input type="text" class="form-control" name="nationality" value="<?php echo $nationality; ?>">
                                    </div>
                                </div>
                                <?php echo form_error('religion'); ?>
                                <?php echo form_error('nationality'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('mobile_number')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Mobile Number</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="mobile_number" value="<?php echo $mobile_number; ?>">
                                </div>

                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <span class="input-group-addon strong">Blood Group</span>
                                        <select class="form-control" name="blood_group">
                                        <?php
                                        foreach (['A+', 'A-', 'O+', 'O-', 'B+', 'B-', 'AB+', 'AB-'] as $bld) {
                                            $sel = ($bld==$blood_group)?'selected':'';
                                            echo '<option value="'.$bld.'" '.$sel.'>'.$bld.'</option>';
                                        }
                                        ?>
                                        </select>
                                        
                                    </div>
                                </div>
                                <?php echo form_error('mobile_number'); ?>
                                <?php echo form_error('blood_group'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('email')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Email Address</label>
                                <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                                </div>
                                <?php echo form_error('email'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('permanent_address')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Permanent Address</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="permanent_address"><?php echo $permanent_address; ?></textarea>
                                </div>
                                <?php echo form_error('permanent_address'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('residential_address')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Residential Address</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="residential_address"><?php echo $residential_address; ?></textarea>
                                </div>
                                <?php echo form_error('residential_address'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('office_address')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Office Address</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="office_address"><?php echo $office_address; ?></textarea>
                                </div>
                                <?php echo form_error('office_address'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('practicing_district')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">District<br><small>(where practicing)</small></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="practicing_district" value="<?php echo $practicing_district; ?>">
                                </div>
                                <?php echo form_error('practicing_district'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('practicing_firm')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Firm Name/Address<br><small>(If have any firm)</small></label>
                                <div class="col-sm-9">
                                <textarea class="form-control" name="practicing_firm"><?php echo $practicing_firm; ?></textarea>
                                </div>
                                <?php echo form_error('practicing_firm'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('nationalid_number')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">National ID</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nationalid_number" value="<?php echo $nationalid_number; ?>">
                                </div>
                                <?php echo form_error('nationalid_number'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('nationalid_copy')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">NID Copy</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="nationalid_copy">
                                        <span class="input-group-addon strong"><?php echo viewFile('members-nid', $nationalid_copy); ?></span>
                                    </div>
                                </div>
                                <?php echo form_error('nationalid_copy'); ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3">Certificate Copy</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" name="certificate[]" multiple>

                                    <?php
                                    if (!empty($certificate)) {
                                        foreach ($certificate as $cer) {
                                            echo viewFile('members-certificate', $cer).'<br>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group <?php echo (form_error('sanad_number')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Sanad No</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="sanad_number" value="<?php echo $sanad_number; ?>">
                                </div>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon strong">Date</span>
                                        <input type="text" class="form-control" name="sanad_date" value="<?php echo $sanad_date; ?>" date-mask>
                                    </div>
                                </div>
                                <?php echo form_error('sanad_number'); ?>
                                <?php echo form_error('sanad_date'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('enrollment_date')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3 required">Date of Enrollment</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="enrollment_date" required value="<?php echo $enrollment_date; ?>" date-mask>
                                </div>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon strong">Benevolent Fund</span>
                                        <select class="form-control" name="benevolent_fund">
                                            <option value="1" <?php echo ($benevolent_fund==1)?'selected':''; ?>>Yes</option>
                                            <option value="2" <?php echo ($benevolent_fund==2)?'selected':''; ?>>No</option>
                                        </select>
                                    </div>
                                </div>
                                <?php echo form_error('enrollment_date'); ?>
                                <?php echo form_error('benevolent_fund'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('lifetime_member')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Lifetime Member</small></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="lifetime_member">
                                        <option value="2" <?php echo ($lifetime_member==2)?'selected':''; ?>>No</option>
                                        <option value="1" <?php echo ($lifetime_member==1)?'selected':''; ?>>Yes</option>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon strong">Date</span>
                                        <input type="text" class="form-control" name="lifetime_member_date" value="<?php echo $lifetime_member_date; ?>" date-mask>
                                    </div>
                                </div>
                                <?php echo form_error('lifetime_member'); ?>
                                <?php echo form_error('lifetime_member_date'); ?>
                            </div>

                            <div class="form-group <?php echo (form_error('status')!='')?'has-error has-danger':''; ?>">
                                <label class="control-label col-sm-3">Status</small></label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="status">
                                    <?php
                                    foreach (memberStatus() as $st => $status) {
                                        $sel = ($st==$status)?'selected':'';
                                        echo '<option value="'.$st.'" '.$sel.'>'.$status.'</option>';
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon strong">Death Date</span>
                                        <input type="text" class="form-control" name="death_date" value="<?php echo $death_date; ?>" date-mask>
                                    </div>
                                </div>
                                <?php echo form_error('status'); ?>
                                <?php echo form_error('death_date'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-bordered">
                                <caption>Nominee Details</caption>
                                <thead>
                                <tr>
                                    <th style="width:40px;"><a class="btn btn-success btn-flat" onclick="addRow()"><i class="fa fa-plus"></i></a></th>
                                    <th>Name</th>
                                    <th>NID</th>
                                    <th>Photo</th>
                                    <th>NID Copy</th>
                                    <th>Percentage</th>
                                </tr>
                                </thead>

                                <tbody id="subBody">
                                <?php
                                if(isset($nomineeData)) {
                                foreach ($nomineeData as $k => $nom) {
                                ?>
                                <tr id="row<?php echo $k; ?>">
                                    <td><a class="btn btn-danger btn-flat" onclick="removeRw(<?php echo $k; ?>)"><i class="fa fa-minus"></i></a><input type="hidden" name="row_id[]" value="<?php echo $nom->id?>"></td>
                                    <td>
                                        <input type="text" class="form-control" name="nominee_name[]" required value="<?php echo $nom->nominee_name?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="nominee_nid[]" value="<?php echo $nom->nominee_nid?>">
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" name="n_image[]" value="<?php echo $nom->nominee_image?>">
                                        <?php echo viewFile('members-nominee', $nom->nominee_image); ?>
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" name="n_nid_copy[]" value="<?php echo $nom->nominee_nid_copy?>">
                                        <?php echo viewFile('members-nominee', $nom->nominee_nid_copy); ?>
                                    </td>
                                    <td>
                                        <input type="number" step="1" min="0" class="form-control" name="percentage[]" autocomplete="off" value="<?php echo $nom->percentage?>">
                                    </td>
                                </tr>
                                <?php
                                }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center submit">
                            <?php
                            if(isset($edit)) {
                                echo '<button type="submit" class="btn btn-lg btn-warning btn-flat"><i class="fa fa-edit"></i> Update</button>';
                            } else {
                                echo '<button type="submit" class="btn btn-lg btn-success btn-flat"><i class="fa fa-plus"></i> Add</button>';
                            }
                            ?>
                            <a href="<?php echo base_url().$path.qString(); ?>" class="btn btn-lg btn-danger btn-flat"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <script>
                function addRow() {
                    var k = $('#subBody tr').length;
                    var headOption = $('#head_id0').html();

                    var html = '<tr id="row'+k+'">'+
                        '<td><a class="btn btn-danger btn-flat" onclick="removeRw('+k+')"><i class="fa fa-minus"></i></a><input type="hidden" name="row_id[]"></td>'+
                        '<td>'+
                            '<input type="text" class="form-control" name="nominee_name[]" required>'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" class="form-control" name="nominee_nid[]">'+
                        '</td>'+
                        '<td>'+
                            '<input type="file" class="form-control" name="n_image[]">'+
                        '</td>'+
                        '<td>'+
                            '<input type="file" class="form-control" name="n_nid_copy[]">'+
                        '</td>'+
                        '<td>'+
                            '<input type="number" step="1" min="0" class="form-control" name="percentage[]" autocomplete="off">'+
                        '</td>'+
                    '</tr>';
                    $('#subBody').append(html);
                }

                function removeRw(k) {
                    $('#row'+k).remove();
                    getTotal();
                }
            </script>
            <?php
            } elseif (isset($lists)) {
            ?>
            <div class="tab-pane active">
                <?php echo form_open($path.'/lists','method="get" class="form-inline"'); ?>
                <div class="box-header text-right">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" name="birth_date" placeholder="Birth Date" value="<?php echo $this->input->get('birth_date')?>">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control datepicker" name="enrollment_date" placeholder="Date of Enrollment" value="<?php echo $this->input->get('enrollment_date')?>">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" name="q" placeholder="Write your search text..." value="<?php echo $this->input->get('q')?>">
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
                        <caption class="hidden"><h3><?php echo $pageName; ?> List</h3></caption>
                       <thead>
                            <tr>
                                <th>ID</th>
                                <th>Reg. Date</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Sanad No</th>
                                <th>Sanad Date</th>
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
                                <td><?php echo dateFormat($val->enrollment_date); ?></td>
                                <td><?php echo viewImg('members', $val->member_image, 'style="height:30px;"'); ?></td>
                                <td><?php echo $val->member_name; ?></td>
                                <td><?php echo $val->mobile_number; ?></td>
                                <td><?php echo $val->sanad_number; ?></td>
                                <td><?php echo dateFormat($val->sanad_date); ?></td>
                                <td><?php echo memberStatus($val->status); ?></td>
                                <td class="remove">
                                    <div class="dropdown">
                                        <a class="btn btn-success btn-flat btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="<?php echo base_url().$path.'/show/'.$val->id; ?>">
                                                    <i class="fa fa-eye"></i> Show
                                                </a>
                                            </li>
                                            
                                            <li>
                                                <a href="<?php echo base_url().$path.'/edit/'.$val->id; ?>">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            </li>
                                           
                                            <li>
                                                <a onclick="deleted('<?php echo base_url().$path.'/delete/'.$val->id; ?>')">
                                                    <i class="fa fa-close"></i> Remove
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
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