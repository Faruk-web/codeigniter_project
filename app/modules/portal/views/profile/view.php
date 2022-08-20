
<html>
    <style>
        input[type=text], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        }
        input[type=file], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        }
        input[type=date], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        }
        input[type=number], select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        }
input[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }

input[type=submit]:hover {
        background-color: #45a049;
        }

.cart-body{
        margin-left:15px;
        margin-top: -200px;
        /* margin-right:717px;" */
        border-radius: 5px;
        /* background-color: #f2f2f2; */
        padding: 20px;
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
                    <i class="fa fa-plus" aria-hidden="true"></i> Nominee Info
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
    <div class="cart-body">
        <h3>Add Member information</h3>
        <?php
                if (isset($error)){
                    echo $error;
                }
            ?>
            <form method="post" action="<?=base_url('portal/member/Profile/store')?>" enctype="multipart/form-data">
                <label for="fname">Upload image</label>
                <input type="file" id="profile_image" name="profile_image" placeholder="Your image" />
                <br>
                <label for="fname">Name</label>
                <input type="text" id="payment_type" name="firstname" placeholder="name..">
                <label for="lname">Date of Birth</label>
                <input type="date" id="lname" name="deposit_date" placeholder="Date of Birt..">
                <label for="date">Passing years</label>
                <input type="date" id="lname" name="lastname" placeholder="Passing years..">
                <label for="date">Joining years</label>
                <input type="date" id="lname" name="lastname" placeholder="Joining years..">
                <label for="lname">NID No</label>
                <input type="number" id="lname" name="deposit_amount" placeholder="NID No..">
                <label for="lname">FB link</label>
                <input type="text" id="lname" name="lastname" placeholder="FB link..">
                <label for="lname">Twitter Link</label>
                <input type="text" id="lname" name="lastname" placeholder="Twitter Link..">
                <label for="lname">LinkedIn</label>
                <input type="text" id="lname" name="lastname" placeholder="LinkedIn..">
                <label for="country">Country</label>
                <select id="country" name="country">
                <option value="australia">Australia</option>
                <option value="canada">Canada</option>
                <option value="usa">USA</option>
                </select>
                <input type="submit" value="Submit">
            </form>
    </div>
</body>
</html>