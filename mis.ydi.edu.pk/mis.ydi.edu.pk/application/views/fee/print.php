<button onclick="window.print();" class=" hidden-print btn btn-success btn-large">
    <i class="ace-icon fa fa-print bigger-130"></i> Print
</button>
<style>
    @media print{
        .table th,p, .foot{
            font-size: 14px;	
        }
    }
</style>

<table class="table table-responsive table-condensed borderless">

    <tbody>


        <tr style="text-align: center; ">
            <th colspan="3">
                <img  height="80px" alt="YDI" src="<?php echo site_url('images/logo.jpg'); ?>" />

            </th>


        </tr>
    </tbody></table>

<table class="table table-responsive table-condensed borderless">

    <tbody>

        <tr>
            <th style="width: 20%; border: none;" class="lbl">
                <span >Receipt No: </span>
            </th>
            <th style="width: 30%; border-top: none;">
                <span ><?php echo $r->rec_no ?></span>
            </th>
            <th style="width: 20%; border: none;" class="lbl">Course:
            </th>
            <th style="width: 30%; border-top: none;">
                <span><?php echo AdminLTE::student_course($r->course) ?></span>
            </th>
        </tr>

        <tr>
            <th style="width: 20%; border: none;" class="lbl">Student Name:
            </th>
            <th style="width: 30%; border-top: none;">
                <span><?php echo ucwords(strtolower(AdminLTE::student_name($r->reg_no))); ?></span>
            </th>

            <th style="width: 20%; border: none;" class="lbl">
                <span >Reg No: </span>
            </th>
            <th style="width: 30%; border-top: none;">
                <span ><?php echo $r->reg_no; ?></span>
            </th>

        </tr>
        <tr>

            <th style="width: 20%; border: none;" class="lbl">Status:
            </th>
            <th style="width: 30%; border-top: none;">
                <span><?php
                    if ($r->status == '1') {
                        echo "<span class='label label-large label-success'>Paid</span>";
                    } else if ($r->status == '0') {
                        echo "<span class='label label-large label-inverse'>Unpaid</span>";
                    } else if ($r->status == '2') {
                        echo "<span class='label label-large label-info'>Dues Added to New Month</span>";
                    } else {
                        echo "<span class='label label-large label-important'>Partially Paid</span>";
                    }
                    ?></span>
            </th>
            <th style="width: 20%; border: none;" class="lbl">Fee for the Month of:
            </th>
            <th style="width: 30%; border-top: none;">
                <?php echo AdminLTE::month($r->month) . "-" . $r->year; ?>
            </th>
        </tr>

        <tr>

            <th style="width: 20%; border: none;" class="lbl">
            </th>
            <th style="width: 30%; border: none;">

            </th>
            <th style="width: 20%; border: none;" class="lbl">
            </th>
            <th style="width: 30%; border: none;">
            </th>
        </tr>

    </tbody>
</table>
<style type="text/css">
    #align_c{
        text-align: center;
    }
</style>
<table class="table table-responsive table-condensed table-bordered">
    <tr>
        <th><b>Month</b></th>
        <th><b>Jan</b></th>
        <th><b>Feb</b></th>
        <th><b>Mar</b></th>
        <th><b>Apr</b></th>
        <th><b>May</b></th>
        <th><b>Jun</b></th>
        <th><b>Jul</b></th>
        <th><b>Aug</b></th>
        <th><b>Sep</b></th>
        <th><b>Oct</b></th>
        <th><b>Nov</b></th>
        <th><b>Dec</b></th>
    </tr>
    <tr>
        <th><b>Fee</b></th>
        <?php
        for ($i = 1; $i <= 12; $i++) {
            $fee = AdminLTE::tuition_fee_record($r->reg_no, $i, 'monthly');
            echo "<th>$fee</th>";
        }
        ?>


    </tr>
    <tr>
        <th><b>Paid</b></th>
        <?php
        for ($i = 1; $i <= 12; $i++) {
            $fee = AdminLTE::tuition_fee_record($r->reg_no, $i, 'paid');
            echo "<th>$fee</th>";
        }
        ?>


    </tr>
    <tr>
        <th><b>Due</b></th>
        <?php
        for ($i = 1; $i <= 12; $i++) {
            $fee = AdminLTE::tuition_fee_record($r->reg_no, $i, 'dues');
            echo "<th>$fee</th>";
        }
        ?>
    </tr>

</table>
<table class="table table-responsive table-condensed table-bordered">

    <tbody>


        <tr>
            <th  style="width: 50%; border-top: none;" class="lbl">Particlar
            </th>
            <th style="width: 50%; border-top: none;">Amount
            </th>

        </tr>
        <tr>
            <th  style="width: 50%; " class="lbl">Monthly Fee
            </th>
            <th style="width: 50%; "><?php echo $r->monthly ?>
            </th>

        </tr>

        <tr>
            <th  style="width: 50%; " class="lbl">Other Fee
            </th>
            <th style="width: 50%; "><?php echo $r->others ?>
            </th>

        </tr>
        <tr>
            <th  style="width: 50%; " class="lbl">Other Fee Status
            </th>
            <th style="width: 50%; "><?php echo $r->comments ?>
            </th>

        </tr>


        <tr>
            <th  style="width: 50%;" class="lbl">Total Fee
            </th>
            <th style="width: 50%; "><?php echo $r->monthly + $r->others ?>
            </th>

        </tr>

    </tbody>
</table>
<table class="table table-responsive table-condensed table-bordered">

    <tbody>

        <tr>
            <th  style="width: 30%; " class="lbl">
                Errors and Omission accepted. 
            </th>
        </tr>
        <tr>
            <th  style="width: 20%; " class="lbl">Total  Arrears
            </th>
            <th style="width: 50%; "><?php echo $r->dues ?>
            </th>

        </tr>
        <tr>

            <th  style="width: 50%;" class="lbl">Total Amount Payable
            </th>
            <th style="width: 50%; "><?php echo $r->total ?>
            </th>

        </tr>
    </tbody>
</table>

<p style="text-align: center" colspan="4"><i class="fa fa-scissors fa-2x" aria-hidden="true"></i>----------------------------------------------------------------------------------------------------<i class="fa fa-scissors fa-2x" aria-hidden="true"></i></p>

<table class="table table-responsive table-condensed borderless">

    <tbody>


        <tr style="text-align: center; ">
            <th colspan="3">
                <img  height="80px" alt="YDI" src="<?php echo site_url('images/logo.jpg'); ?>" />

            </th>


        </tr>
    </tbody></table>

<table class="table table-responsive table-condensed borderless">


        <tr>
            <th style="width: 20%; border: none;" class="lbl">
                <span >Receipt No: </span>
            </th>
            <th style="width: 30%; border-top: none;">
                <span ><?php echo $r->rec_no ?></span>
            </th>
            <th style="width: 20%; border: none;" class="lbl">Course:
            </th>
            <th style="width: 30%; border-top: none;">
                <span><?php echo AdminLTE::student_course($r->course) ?></span>
            </th>
        </tr>

        <tr>
            <th style="width: 20%; border: none;" class="lbl">Student Name:
            </th>
            <th style="width: 30%; border-top: none;">
                <span><?php echo ucwords(strtolower(AdminLTE::student_name($r->reg_no))); ?></span>
            </th>

              <th style="width: 20%; border: none;" class="lbl">Registeration No:</th>
              <th style="width: 30%; border-top: none;"><?php echo $r->reg_no; ?></th>

        </tr>
        
        <tr>
             <th style="width: 20%; border: none;" class="lbl">Payable Amount:</th>
              <th style="width: 30%; border-top: none;"><?php echo $r->total ?></th>
            <th style="width: 20%; border: none;" class="lbl">Due Amount:</th>
          <th style="width: 30%; border-top: none;"><?php echo $r->dues ?></th>
        </tr>
         <tr>

            <th style="width: 20%; border: none;" class="lbl">Status:
            </th>
            <th style="width: 30%; border-top: none;">
                <span><?php
                    if ($r->status == '1') {
                        echo "<span class='label label-large label-success'>Paid</span>";
                    } else if ($r->status == '0') {
                        echo "<span class='label label-large label-inverse'>Unpaid</span>";
                    } else if ($r->status == '2') {
                        echo "<span class='label label-large label-info'>Dues Added to New Month</span>";
                    } else {
                        echo "<span class='label label-large label-important'>Partially Paid</span>";
                    }
                    ?></span>
            </th>
            <th style="width: 20%; border: none;" class="lbl">Fee for the Month of:
            </th>
            <th style="width: 30%; border-top: none;">
                <?php echo AdminLTE::month($r->month) . "-" . $r->year; ?>
            </th>
        </tr>
</table>
<!-- pay due date account ends -->
