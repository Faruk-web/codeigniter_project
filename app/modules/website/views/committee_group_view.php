<main id="tg-main" class="tg-main tg-haslayout">
    <div class="container">
        <div class="row">
            <div id="tg-twocolumns-upper" class="tg-twocolumns tg-haslayout">
                <div class="col-sm-8">
                    <div id="tg-content-upper" class="tg-content">
                        <?php
                        if (!empty($committeeG)) {
                        ?>
                            <div class="tg-section-heading">
                                <h2>All Executive Committee</h2>
                            </div>

                            <div class="tg-description">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>SL.</th>
                                                <th>Seassion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($committeeG as $key => $val) {
                                            ?>
                                            <tr>
                                                <td><?php echo $key+1?></td>
                                                <td><a href="<?php echo base_url().'committee/'.$val->session; ?>"><?php echo $val->session; ?></a></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php    
                        } else {
                        ?>
                            <div class="tg-description text-center">
                                <h3>This page has no content.</h3>
                            </div>
                        <?php   
                        }
                        ?>
                    </div>
                </div>

                <div class="col-sm-4">
                    <aside id="tg-sidebar-upper" class="tg-content">
                        <div class="tg-widget tg-slider-widget">
                            <div class="tg-section-heading">
                                <h2>News & Events</h2>
                            </div>
                            <div id="tg-widget-slider" class="tg-widget-slider">
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
                    </aside>
                </div>
            </div>
        </div>
    </div>
</main>