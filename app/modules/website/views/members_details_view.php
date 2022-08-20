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
                        <h2>View Member Details</h2>
                    </div>

                    <div class="tg-haslayout" style="padding-top: 10px;">
                        <div class="tg-paddingbottomzero tg-haslayout tg-categories-posts">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3 class="text-center" style="border-bottom:1px solid #acacac;">Information</h3>
                                    <p>
                                        Member ID : <?php echo $members->membership_number; ?><br>
                                        Name : <?php echo $members->member_name; ?><br>
                                        Father's/Husband Name : <?php echo $members->father_name; ?><br>
                                        Date of Birth : <?php echo dateFormat($members->birth_date); ?><br>
                                        Gender : <?php echo $members->gender ?: '-'; ?><br>
                                        Religion : <?php echo $members->religion ?: '-'; ?><br>
                                        Nationality : <?php echo $members->nationality ?: '-'; ?><br>
                                        Blood Group : <?php echo $members->blood_group ?: '-'; ?><br>
                                    </p>

                                    <h3 class="text-center" style="border-bottom:1px solid #acacac;">Address</h3>
                                    <p>
                                        Permanent Address : <?php echo nl2br($members->permanent_address); ?><br>
                                        Residential Address : <?php echo nl2br($members->residential_address); ?><br>
                                        Office Address : <?php echo nl2br($members->office_address); ?><br>
                                        District : <?php echo $members->practicing_district; ?>
                                    </p>

                                    <h3 class="text-center" style="border-bottom:1px solid #acacac;">Details</h3>
                                    <p>
                                        Sanad No : <?php echo $members->sanad_number; ?><br>
                                        Sanad Date : <?php echo dateFormat($members->sanad_date); ?><br>
                                        Date of Enrollment : <?php echo dateFormat($members->enrollment_date); ?><br>
                                        Lifetime Member : <?php echo ($members->lifetime_member==1)?'Yes':'No'; ?><br>
                                        Status : <?php echo memberStatus($members->status); ?>

                                        <?php
                                        if ($members->status==2) {
                                            echo '<br>Death Date : '.dateFormat($members->death_date); 
                                        }
                                        ?>
                                    </p>
                                </div>

                                <div class="col-sm-4">
                                    <?php  $image = viewImg('members', $members->member_image, 'style="height:200px; border:1px solid #acacac;"'); ?>
                                    <?php echo ($image!='')?$image:'<img src="'.base_url().'web-assets/img/no-image.jpg" style="height:200px; border:1px solid #acacac;">'; ?>
                                </div>

                                <div class="col-sm-8 text-center">
                                    <a class="tg-btn tg-btn-lg" href="<?php echo base_url().'membership/change-details/'.$members->membership_number;?>">Change Request Form</a>
                                </div>
                                <div class="col-sm-12 clearfix">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>