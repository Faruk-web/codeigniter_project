<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url();?>web-assets/img/favicon.png" type="image/x-icon" />
    <title>Dhaka Taxes Bar Association</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/transitions.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/owl.theme.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/swiper.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/color.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>web-assets/css/responsive.css">
    <script src="<?php echo base_url(); ?>web-assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body>
    <div id="status">
        <div id="preloader" class="preloader">
            <img src="<?php echo base_url(); ?>web-assets/img/AjaxLoader.gif" alt="Preloader" />
        </div>
    </div>

    <div id="tg-wrapper" class="tg-wrapper tg-haslayout tg-boxed">
        <header id="tg-header" class="tg-header tg-header-versionthree tg-haslayout tg-header1">
            <div class="tg-logoarea tg-haslayout">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong class="tg-logo">
                                <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>web-assets/img/logo.png" alt="Logo"></a>
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="tg-navigationarea tg-haslayout">
                    <div class="col-xs-12">
                        <nav id="tg-nav" class="tg-nav">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#tg-navigation" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="tg-navigation collapse navbar-collapse" id="tg-navigation">
                                <ul>
                                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="tg-hasdropdown">
                                        <a href="javascript:void(0);">About Us</a>
                                        <ul class="tg-dropdownmenu">
                                            <li><a href="<?php echo base_url(); ?>history">History</a></li>
                                            <li><a href="<?php echo base_url(); ?>constitution">Constitution</a></li>
                                            <li><a href="<?php echo base_url(); ?>activities">Activities</a></li>
                                            <li><a href="<?php echo base_url(); ?>president-message">President Message</a></li>
                                            <li><a href="<?php echo base_url(); ?>secretary-message">Secretary Message</a></li>
                                        </ul>
                                    </li>
                                    <li class="tg-hasdropdown">
                                        <a href="javascript:void(0);">Committee</a>
                                        <ul class="tg-dropdownmenu">
                                            <li><a href="<?php echo base_url(); ?>present-committee">Present Committee</a></li>
                                            <li><a href="<?php echo base_url(); ?>previous-committees">Previous Committees</a></li>
                                            <li><a href="<?php echo base_url(); ?>office-staff">Office staff</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo base_url(); ?>membership">Membership</a></li>
                                    <li><a href="<?php echo base_url(); ?>news-event">News & Event</a></li>
                                    <li><a href="<?php echo base_url(); ?>gallery">Gallery</a></li>
                                    <li><a href="<?php echo base_url(); ?>admission-form">Admission Form</a></li>
                                    <li><a href="<?php echo base_url(); ?>contact-us">Contact Us</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>

        <?php $this->load->view($templateView); ?>


        <footer id="tg-footer" class="tg-footer tg-haslayout">
            <div class="container">
                <div class="row">
                    <div class="tg-four-column tg-haslayout">
                        <div class="col-sm-4">
                            <div class="tg-col tg-about-us">
                                <div class="tg-section-heading">
                                    <h2>Contact Us</h2>
                                </div>
                                <div class="tg-description">
                                    <p>Rajashaw Bhaban, Ground Floor, 2nd Phase, Segun Bagicha, Dhaka, Bangladesh<br>
                                    Phone: +88-02-9358925<br>
                                    E-mail: info@dtba.org.bd<br>
                                    Website: www.dtba.org.bd<br>
                                    Working Days/Hours:<br>
                                    Sunday - Thursday 9am to 5pm</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="tg-col">
                                <div class="tg-section-heading">
                                    <h2>Importent Link</h2>
                                </div>
                                <div class="tg-importantlink">
                                    <ul>
                                        <li>
                                            <a href="http://www.barcouncil.gov.bd/" taget="_blank">Bangladesh Bar Council</a>
                                        </li>
                                        <li>
                                            <a href="http://www.supremecourt.gov.bd/nweb/" taget="_new">Supreme Court of Bangladesh</a>
                                        </li>
                                        <li>
                                            <a href="http://www.bangladeshsupremecourtbar.com/" taget="_new">Supreme Court Bar Association</a>
                                        </li>
                                        <li>
                                            <a href="http://bdlaws.minlaw.gov.bd/" taget="_new">Laws of Bangladesh</a>
                                        </li>
                                        <li>
                                            <a href="http://lawjusticediv.gov.bd/" taget="_new">Law and Justice Division</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="tg-col">
                                <div class="tg-section-heading">
                                    <h2>We are Social</h2>
                                </div>
                                <ul class="tg-socialicons">
                                    <li><a target="_blank" class="tg-fb-bg" href="https://www.facebook.com/DhakaTaxesBarAssociation"><i class="fa fa-facebook-f"></i></a></li>
                                    <li><a target="_blank" class="tg-twitter-bg" href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a target="_blank" class="tg-linkdin-bg" href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a target="_blank" class="tg-google-bg" href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a target="_blank" class="tg-pintrest-bg" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                </ul>
                                <div class="clearfix">&nbsp;</div>
                                <strong class="tg-logo">
                                    <a href="http://ascentict.com" target="_blank">
                                    </a>
                                    <img src="<?php echo base_url(); ?>web-assets/img/powered_by.png" width="100" height="100" alt="ascentict.com">
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tg-copyrights">
                <div class="container">
                    <ul class="tg-footer-nav pull-right">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li><a href="<?php echo base_url(); ?>news-event">News &amp; Event</a></li>
                        <li><a href="<?php echo base_url(); ?>gallery">Gallery</a></li>
                        <li><a href="<?php echo base_url(); ?>admission-form">Admission Form</a></li>
                        <li><a href="<?php echo base_url(); ?>contact-us">Contact Us</a></li>
                    </ul>
                    <p class="pull-left">© 2019 Dhaka Taxes Bar Association.  All Rights Reserved</p>
                </div>
            </div>
        </footer>
    </div>
    <script src="<?php echo base_url(); ?>web-assets/js/vendor/jquery-library.js"></script>
    <script src="<?php echo base_url(); ?>web-assets/js/vendor/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>web-assets/js/jquery.cycle2.min.js"></script>
    <script src="<?php echo base_url(); ?>web-assets/js/jquery.cycle2.carousel.min.js"></script>
    <script src="<?php echo base_url(); ?>web-assets/js/owl.carousel.js"></script>
    <script src="<?php echo base_url(); ?>web-assets/js/isotope.pkgd.js"></script>
    <script src="<?php echo base_url(); ?>web-assets/js/parallax.js"></script>
    <script src="<?php echo base_url(); ?>web-assets/js/swiper.js"></script>
    <script src="<?php echo base_url(); ?>web-assets/js/main.js"></script>
</body>
</html>