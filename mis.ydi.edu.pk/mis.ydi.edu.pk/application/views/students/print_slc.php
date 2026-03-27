<button onclick="window.print();" class=" hidden-print btn btn-success btn-large">
    <i class="ace-icon fa fa-print bigger-130"></i> Print
</button>
<table class="table table-responsive table-condensed borderless">

    <tbody>
         <tr style="text-align: center; ">
            <th colspan="3"><img  height="70"  alt="<?php echo $r->name ?>" src="<?php echo site_url('images/logo.jpg'); ?>" /></th>
            <th>
                <?php if($r->img == ""){
                  ?>
                   <img  width="140"  alt="<?php echo $r->name ?>" src="<?php echo site_url('images/profile.png'); ?>" />
                <?php
                }else{ ?>
                <img  width="140"  alt="<?php echo $r->name ?>" src="<?php echo site_url('images/' . $r->img); ?>" />
                <?php } ?>
            </th>
        </tr>
        <tr>
            <th colspan="4" width="703"><h4 style="font-family: 'Baskerville Old Face'; font-size: 24px; text-align: center;  font-weight: bold"> LEAVING CERTIFICATE</h4></th>
</tr>

<tr>
    <th  >Full Name</th>
    <td style="border-top: none;" ><?php echo strtoupper($r->name) ?></td>

</tr>
<tr>
    <th >Father / Guardian Name</th>
    <td ><?php echo strtoupper($r->f_name) ?></td>

</tr>
<tr>
    <th >Date of Birth</th>
    <td style="width: 500px;"><?php
        $originalDate
                = $r->dob;
        $date
                = explode("-", $r->dob);
        echo "<span style='float: left'>In Figure :</span>" . date("d-m-Y", strtotime($originalDate)) . "<br> ";
        echo "<span style='float: left'>In Words :</span>  " . AdminLTE::day($date[2]) . " ";
        echo AdminLTE::month($date[1]) . ", ";
        echo AdminLTE::year($date[0]);
        ?></td>

</tr>

<tr>
    <th >Permanent Address</th>
    <td ><?php echo $r->address ?></td>

</tr>
<tr>
    <th >Admission Information:</th>
    <td style="width: 400px;"><?php
        $info = AdminLTE::admission_info($r->reg_no);
        foreach ($info as $e) {
            $originalDate = $e->date;
            echo "<span style='float: left;'>Date :</span>" . date("d-m-Y", strtotime($originalDate)) . "<br> ";
            echo "<span style='float: left;'>Course :</span> ". AdminLTE::student_course($r->course);   
        }
        ?></td>

</tr>
<tr>
    <th >Remarks:</th>
    <td style="width: 500px;"><?php
        $info = AdminLTE::withdraw_info($r->reg_no);
        foreach ($info as $e) {
            echo $e->remarks ;
        }
        ?></td>

</tr>
   
</tbody>
</table>
