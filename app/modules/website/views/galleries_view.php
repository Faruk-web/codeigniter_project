<main id="tg-main" class="tg-main tg-haslayout">
    <div class="container">
        <div class="row">
            <div id="tg-twocolumns-upper" class="tg-haslayout">
                <div class="col-sm-12">
                    <div id="tg-content-upper" class="tg-content tg-haslayout">
                        <section class="tg-haslayout tg-whatshot">
                            <div class="tg-section-heading">
                                <h2>Photo Gallery</h2>
                            </div>
                            <div id="tg-filtermasonry" class="tg-filtermasonry">
                                <?php
                                foreach ($galleries as $gl) {
                                ?>
                                <article class="tg-theme-post tg-griditem fashion">
                                    <figure>
                                        <a>
                                            <img src="<?php echo base_url().'uploads/galleries/'.$gl->image; ?>" alt="<?php echo $gl->caption; ?>">
                                        </a>
                                        <figcaption>
                                            <div class="tg-box">
                                                <div class="tg-postcontent">
                                                    <div class="tg-theme-tags">
                                                        <a class="tg-tag tg-tag-category tg-color-pink"><?php echo $gl->caption; ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </figcaption>
                                    </figure>
                                </article>
                                <?php
                                }
                                ?>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>