<main id="tg-main" class="tg-main tg-haslayout">
    <div class="container">
        <div class="row">
            <div id="tg-twocolumns-upper" class="tg-haslayout">
                <div class="col-sm-5">
                    <aside id="tg-sidebar-upper" class="tg-content">
                        <div class="tg-widget tg-slider-widget">
                            <div class="tg-section-heading">
                                <h2>Address</h2>
                            </div>

                            <p>Rajashaw Bhaban, Ground Floor, 2nd Phase, Segun Bagicha,<br>
                            Dhaka, Bangladesh<br>
                            <strong>Phone</strong>: +88-02-9358925<br>
                            <strong>E-mail:</strong> info@dtba.org.bd<br>
                            <strong>Website:</strong> www.dtba.org.bd<br>
                            <strong>Working Days/Hours:</strong> Sunday - Thursday 9am to 5pm</p>
                            <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116812.69857236205!2d90.290682014105!3d23.804483943858163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xfd570b99826399b5!2sNational+Board+Of+Revenue%2CRajashaw+Bhaban!5e0!3m2!1sen!2sbd!4v1548782845302" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe></iframe></p>
                        </div>
                    </aside>
                </div>

                <div class="col-sm-7">
                    <div id="tg-content-upper" class="tg-content">
                        <div class="tg-section-heading">
                            <h2>Contact Form</h2>
                        </div>
                        <?php echo form_open('send-mail','class="tg-form-register"'); ?>
                            <fieldset>
                                <?php echo $this->session->flashdata('flash_msg'); ?>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="message" placeholder="Message" rows="8"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="tg-btn tg-btn-lg" type="submit">Send</button>
                                </div>
                            </fieldset>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>