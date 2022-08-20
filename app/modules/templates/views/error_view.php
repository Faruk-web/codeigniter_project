<?php
if ($session==1) {
?>
<section class="content">
    <div class="error-page text-center">
        <h2 class="headline text-yellow" style="float:none;"> 404</h2>

        <div class="error-content" style="margin-left:0;">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

            <p>We could not find the page you were looking for.<br>
            Meanwhile, you may <a href="<?php echo base_url().'dashboard'?>">return to dashboard</a>.`</p>
        </div>
    </div>
</section>
<?php
} else {
?>
<section class="content">
    <div class="error-page text-center" style="width:auto;">
        <h2 class="headline text-yellow" style="float:none;"> 404</h2>

        <div class="error-content" style="margin-left:0;">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

            <p>We could not find the page you were looking for.<br>
            Meanwhile, you may <a href="<?php echo base_url().'auth'?>">return to login</a>.`</p>
        </div>
    </div>
</section>
<?php
}
?>