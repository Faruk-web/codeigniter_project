
<html>
<style>
body {background: #ececec;}
h1, h2, h3, h4, h5 {
  border-bottom: 1px solid #ccc;
  color: #3F51B5;
  padding-bottom: 8px
}
.container {
  margin: auto;
  width: 350px;
  text-align: center;
}
.listFlex {display: flex; justify-content: center;}

img {
  width: 100%;
}
</style>
<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li>
                <a >
                    <i class="fa fa-list" aria-hidden="true"></i>  List
                </a>
            </li>
            <li>
            <a href="<?php echo base_url().'portal/member/Profile/recieptlist'.qString(); ?>">
                    <i class="fa fa-eye-slash" aria-hidden="true"></i> Reciept List
                </a>
            </li>
            <li>
            <a href="<?php echo base_url().'portal/member/Profile/change'.qString(); ?>">
                    <i class="fa fa-check" aria-hidden="true"></i> Change Member Profile 
                </a>
            </li>
            <li <?php echo (isset($create))?'class="active"':''; ?>>
                <a href="<?php echo base_url().'portal/member/Profile/view'.qString(); ?>">
                    <i class="fa fa-plus" aria-hidden="true"></i>Nominee Info 
                </a>
            </li>
            <?php
            if (isset($edit)) {
            ?>
            <li class="active">
                <a href="#">
                    <i class="fa fa-edit" aria-hidden="true"></i> Edit 
                </a>
            </li>
            <?php
            }
            ?>
        </ul>
     </div>
</section>
<body>
    <div style="margin-left: 70px;margin-top: -165px;">
        <?php
                if (isset($error)){
                    echo $error;
                }
            ?>
           
    </div> 
    <div class="container">
   <h1>Dan Englishby</h1>
   <h3>Personal Profile</h3>
   <a href="https://imgbb.com/"><img src="https://i.ibb.co/pdJfzx9/profile-picture.jpg" alt="profile-picture" border="0" /></a>
   <h4>About Me</h4>
   <p>Hi, I'm Dan Englishby, I have a huge passion for web-development and programming. I love to learn and thrive from challenges.</p>
   <h4>My Skills</h4>
   <div class="listFlex">
      <div>
         <ul>
            <li>PHP</li>
            <li>HTML</li>
            <li>CSS</li>
         </ul>
      </div>
      <div>
         <ul>
            <li>JavaScript</li>
            <li>JQuery</li>
            <li>C#</li>
         </ul>
      </div>
   </div>
   <h4>Social Media</h4>
   Catch me on Twitter - <a href="https://twitter.com/DanEnglishby">@DanEnglishby</a><br><br>
</div>
</body>
</html>