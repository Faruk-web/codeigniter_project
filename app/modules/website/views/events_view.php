<?php
if (isset($single)) {
?>
<main id="tg-main" class="tg-main tg-haslayout">
    <div class="container">
        <div class="row">
            <div id="tg-twocolumns-upper" class="tg-twocolumns tg-haslayout">
                <div class="col-sm-8">
                    <div id="tg-content" class="tg-content tg-haslayout">
                        <div class="tg-section-heading">
                            <h2>News & Events Details</h2>
                        </div>

                        <div class="tg-haslayout tg-latest-technology">
                            <article class="tg-theme-post tg-category-full">
                                <div class="tg-box">
                                    <div class="tg-postcontent">
                                        <h3>
                                            <a><?php echo $eventsRow->event_head; ?></a>
                                        </h3>
                                        <ul class="tg-postmetadata">
                                            <li>
                                                <a>
                                                    <i class="fa fa-clock-o"></i>
                                                    <span><?php echo dateFormat($eventsRow->event_date); ?></span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tg-description">
                                            <?php echo viewImg('events', $eventsRow->event_image);?>
                                            <?php echo $eventsRow->event_details; ?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
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
                                        <div class="row">
                                            <div class="col-sm-8">
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
                                            </div>
                                            <div class="col-sm-4">
                                                <?php echo viewImg('events', 'thumb_'.$ev->event_image);?>
                                            </div>
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
<?php
} else {
?>
<main id="tg-main" class="tg-main tg-haslayout">
    <div class="container">
        <div class="row">
            <div id="tg-twocolumns-upper" class="tg-haslayout">
                <div class="col-sm-12">
                    <div id="tg-content" class="tg-content tg-haslayout">
                        <div class="tg-section-heading">
                            <h2>News & Events</h2>
                        </div>

                        <div class="tg-haslayout tg-latest-technology">
                            <?php
                            foreach ($events as $ev) {
                            ?>
                            <article class="tg-theme-post tg-category-full">
                                <div class="tg-box">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="tg-postcontent">
                                                <h3>
                                                    <a href="<?php echo base_url().'news-event-details/'.$ev->id; ?>"><?php echo $ev->event_head; ?></a>
                                                </h3>
                                                <ul class="tg-postmetadata">
                                                    <li>
                                                        <a href="<?php echo base_url().'news-event-details/'.$ev->id; ?>">
                                                            <i class="fa fa-clock-o"></i>
                                                            <span><?php echo dateFormat($ev->event_date); ?></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="tg-description">
                                                    <?php echo $ev->event_details; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php echo viewImg('events', 'thumb_'.$ev->event_image);?>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
}
?>