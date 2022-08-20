<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin-top:-274px;
  margin-left: 20px;
  margin-right: 500px;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
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
</head>
<body>

<table id="customers" style="margin-top: -174px;">

  <tr>
    <th>File List</th>
    <th>NID</th>
    <th>Certificate</th>
  </tr>
  <tr>
    <td>Alfreds Futterkiste</td>
    <td>54124545</td>
    <td>Germany</td>
  </tr>
  <tr>
    <td>Berglunds snabbköp</td>
    <td>54124545</td>
    <td>Sweden</td>
  </tr>
  <tr>
    <td>Centro comercial Moctezuma</td>
    <td>54124545</td>
    <td>Mexico</td>
  </tr>
  <tr>
    <td>Ernst Handel</td>
    <td>54124545</td>
    <td>Austria</td>
  </tr>
  <tr>
    <td>Island Trading</td>
    <td>54124545</td>
    <td>UK</td>
  </tr>
  <tr>
    <td>Königlich Essen</td>
    <td>54124545</td>
    <td>Germany</td>
  </tr>
  <tr>
    <td>Laughing Bacchus Winecellars</td>
    <td>54124545</td>
    <td>Canada</td>
  </tr>
  <tr>
    <td>Magazzini Alimentari Riuniti</td>
    <td>54124545</td>
    <td>Italy</td>
  </tr>
  <tr>
    <td>North/South</td>
    <td>54124545</td>
    <td>UK</td>
  </tr>
  <tr>
    <td>Paris spécialités</td>
    <td>54124545</td>
    <td>France</td>
  </tr>
</table>

</body>
</html>