<div class="container">
    <div class="tg-blog-grid tg-haslayout">
        <main id="tg-main" class="tg-main tg-haslayout">
            <div class="row">
                <div class="col-sm-3">
                    <aside id="tg-sidebar-upper" class="tg-sidebar tg-haslayout">
                        <div class="tg-widget">
                            <div class="search-box">
                                <h3>Search Member</h3>
                                <form method="get" action="<?php echo base_url().'membership'; ?>">
                                    <div class="form-group">
                                        <input type="text" name="id" class="form-control" placeholder="Enter Membership ID..." value="<?php echo $this->input->get('id')?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Enter Member Name..." value="<?php echo $this->input->get('name')?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="mobile" class="form-control" placeholder="Enter Member Mobile No..." value="<?php echo $this->input->get('mobile')?>">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-search"></i> Search</button>
                                </form>
                            </div>
                        </div>

                        <?php
                        if (!empty($events)) {
                        ?>
                        <div class="tg-widget tg-slider-widget">
                            <div class="tg-section-heading">
                                <h2>News & Events</h2>
                            </div>
                            <div id="tg-widget-slider" class="tg-widget-slider tg-haslayout">
                                <div class="item">
                                    <?php
                                    foreach ($events as $ev) {
                                    ?>
                                    <article class="tg-theme-post tg-category-small">
                                        <div class="tg-postdata">
                                            <h3><a href="<?php echo base_url().'news-event-details/'.$ev->id; ?>"><?php echo $ev->event_head; ?></a></h3>
                                            <ul class="tg-postmetadata">
                                                <li>
                                                    <a href="<?php echo base_url().'news-event-details/'.$ev->id; ?>">
                                                        <i class="fa fa-clock-o"></i>
                                                        <span><?php echo dateFormat($ev->event_date); ?></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </article>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </aside>
                </div>

                <div class="col-sm-9">
                    <div class="tg-breadcrumbs tg-haslayout">
                        <h2>Member Details Change Request</h2>
                    </div>

                    <div class="tg-haslayout" style="padding-top: 10px;">
                        <div class="tg-paddingbottomzero tg-haslayout tg-categories-posts">
                            <?php echo $this->session->flashdata('flash_msg'); ?>

                            <?php echo form_open_multipart('membership/update-details/'.$members->membership_number); ?>
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3 class="text-center" style="border-bottom:1px solid #acacac;">Information</h3>
                                    <p>Member ID : <?php echo $members->membership_number; ?></p>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Name:*</span>
                                            <input type="text" class="form-control" name="data[member_name]" value="<?php echo $members->member_name; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Father's Name:*</span>
                                            <input type="text" class="form-control" name="data[father_name]" value="<?php echo $members->father_name; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Mother's Name:</span>
                                            <input type="text" class="form-control" name="data[mother_name]" value="<?php echo $members->mother_name; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Spouce's Name:</span>
                                            <input type="text" class="form-control" name="data[spouse_name]" value="<?php echo $members->spouse_name; ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Gender:*</span>
                                            <input type="text" class="form-control" name="data[gender]" value="<?php echo $members->gender; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Religion:*</span>
                                            <input type="text" class="form-control" name="data[religion]" value="<?php echo $members->religion; ?>" required>
                                        </div>
                                    </div>

                                    <h3 class="text-center" style="border-bottom:1px solid #acacac;">Address</h3>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Permanent Address:*</span>
                                            <textarea class="form-control" name="data[permanent_address]" required><?php echo $members->permanent_address; ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Residential Address:*</span>
                                            <textarea class="form-control" name="data[residential_address]" required><?php echo $members->residential_address; ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Office Address:</span>
                                            <textarea class="form-control" name="data[office_address]"><?php echo $members->office_address; ?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">District:</span>
                                            <input type="text" class="form-control" name="data[practicing_district]" value="<?php echo $members->practicing_district; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <?php  $image = viewImg('members', $members->member_image, 'style="height:200px; border:1px solid #acacac;"'); ?>
                                    <?php echo ($image!='')?$image:'<img src="'.base_url().'web-assets/img/no-image.jpg" style="height:200px; border:1px solid #acacac;">'; ?>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Image:</span>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">NID Copy:</span>
                                            <input type="file" class="form-control" name="nid">
                                        </div>
                                    </div>

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width:40px;"><a class="btn btn-success btn-flat" onclick="addCertRow()"><i class="fa fa-plus"></i></a></th>
                                            <th>Certificate Copies</th>
                                        </tr>
                                        </thead>

                                        <tbody id="certBody">
                                        <tr id="cert0">
                                            <td><a class="btn btn-danger btn-flat" onclick="removeCertRw(0)"><i class="fa fa-minus"></i></a></td>
                                            <td>
                                                <input type="file" class="form-control" name="certif[]">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
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
                                            <th>%</th>
                                        </tr>
                                        </thead>

                                        <tbody id="subBody">
                                        <tr id="row0">
                                            <td><a class="btn btn-danger btn-flat" onclick="removeRw(0)"><i class="fa fa-minus"></i></a></td>
                                            <td>
                                                <input type="text" class="form-control" name="n_name[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="n_nid[]">
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="n_image[]">
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="n_nid_copy[]">
                                            </td>
                                            <td>
                                                <input type="number" step="1" min="0" class="form-control" name="n_per[]" autocomplete="off">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="tg-btn tg-btn-lg">Send Change Request</button>
                                </div>
                                <div class="col-sm-12 clearfix">&nbsp;</div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
    function addRow() {
        var k = $('#subBody tr').length;
        var headOption = $('#head_id0').html();

        var html = '<tr id="row'+k+'">'+
            '<td><a class="btn btn-danger btn-flat" onclick="removeRw('+k+')"><i class="fa fa-minus"></i></a></td>'+
            '<td>'+
                '<input type="text" class="form-control" name="n_name[]">'+
            '</td>'+
            '<td>'+
                '<input type="text" class="form-control" name="n_nid[]">'+
            '</td>'+
            '<td>'+
                '<input type="file" class="form-control" name="n_image[]">'+
            '</td>'+
            '<td>'+
                '<input type="file" class="form-control" name="n_nid_copy[]">'+
            '</td>'+
            '<td>'+
                '<input type="number" step="1" min="0" class="form-control" name="n_per[]" autocomplete="off">'+
            '</td>'+
        '</tr>';
        $('#subBody').append(html);
    }

    function removeRw(k) {
        $('#row'+k).remove();
        getTotal();
    }
    function addCertRow() {
        var k = $('#certBody tr').length;

        var html = '<tr id="cert'+k+'">'+
            '<td><a class="btn btn-danger btn-flat" onclick="removeCertRw('+k+')"><i class="fa fa-minus"></i></a></td>'+
            '<td>'+
                '<input type="file" class="form-control" name="certif[]">'+
            '</td>'+
        '</tr>';
        $('#certBody').append(html);
    }

    function removeCertRw(k) {
        $('#cert'+k).remove();
        getTotal();
    }
</script>