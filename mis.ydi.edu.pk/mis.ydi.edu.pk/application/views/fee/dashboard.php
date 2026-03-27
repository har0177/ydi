<style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 10px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;

        border: 1px solid #888;
        width: 130%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }
</style>
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        Dashboard of  <?php echo $heading; ?>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <div class="modal fade" id="paid" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button title="Close" type="button" class="close dark-opaque" data-dismiss="modal">
                            <i class="ace-icon fa fa-close bigger-130"></i>
                        </button>

                        <h4 class="modal-title">List of Overall
                            <span class='label label-large label-success'>Paid</span> Fee</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-header">

                            <span>
                                <a href="#" id="export" class="btn btn-sm btn-success pull-right">
                                    <i class="ace-icon fa fa-database"></i> Export to Excel</a>

                            </span>
                        </div>

                        <table id="dyntableExport" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Month</th><th>Course</th><th>Name</th>
                                    <th>Reg No</th>
                                    <th>Fee</th>
                                    <th>Dues</th>
                                    <th>Date of Payment</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $query = $this->db->query("Select * from fee where status = 1 order by course ASC");

                                if ($query->num_rows() > 0) {
                                    $rep = $query->result();
                                } else {
                                    set_flash_alert("No data Found!", 'danger');
                                }
                                if ($rep > 0) {
                                    $i = 1;
                                    foreach ($rep as
                                            $r) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo AdminLTE::month($r->month) ?></td>
                                            <td><?php echo AdminLTE::student_course($r->course); ?></td>
                                            <td><?php echo AdminLTE::student_data($r->reg_no, "name"); ?></td>

                                            <td><?php echo $r->reg_no ?></td>
                                            <td><?php echo $r->monthly ?></td>
                                            <td><?php echo $r->dues ?></td>
                                            <td><?php echo dateformatesformysql_fata($r->date_of_payment); ?></td>
                                            </td>


                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="unpaid" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button title="Close" type="button" class="close dark-opaque" data-dismiss="modal">
                            <i class="ace-icon fa fa-close bigger-130"></i>
                        </button>

                        <h4 class="modal-title">List of Overall
                            <span class='label label-large label-inverse'>UnPaid</span> Fee</h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-header">

                            <span>
                                <a href="#" id="export" class="btn btn-sm btn-success pull-right">
                                    <i class="ace-icon fa fa-database"></i> Export to Excel</a>

                            </span>
                        </div>

                        <table id="dyntableExport" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Month</th><th>Course</th><th>Name</th>
                                    <th>Reg No</th>
                                    <th>Fee</th>
                                    <th>Dues</th>
                                    <th>Date of Payment</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $query = $this->db->query("Select * from fee where status = 0 order by course ASC");

                                if ($query->num_rows() > 0) {
                                    $rep = $query->result();
                                } else {
                                    set_flash_alert("No data Found!", 'danger');
                                }
                                if ($rep > 0) {
                                    $i = 1;
                                    foreach ($rep as
                                            $r) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo AdminLTE::month($r->month) ?></td>
                                            <td><?php echo AdminLTE::student_course($r->course); ?></td>
                                            <td><?php echo AdminLTE::student_data($r->reg_no, "name"); ?></td>

                                            <td><?php echo $r->reg_no ?></td>
                                            <td><?php echo $r->monthly ?></td>
                                            <td><?php echo $r->dues ?></td>
                                            <td><?php echo dateformatesformysql_fata($r->date_of_payment); ?></td>

                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>

                        </table>

                    </div>


                </div>
            </div>
        </div>

        <div class="row">
            <div class="space-6"></div>
            <div class="col-sm-12 infobox-container">
                <a class="infobox infobox-green" href='#paid' data-toggle='modal' data-id='paid'>
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-user"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php
                            foreach ($paid as
                                    $value) {


                                echo $value->total . " Students";
                            }
                            ?></span>
                        <div class="infobox-content">Paid Fee </div>
                    </div>
                </a>

                <a class="infobox infobox-blue" href='#unpaid' data-toggle='modal' data-id='unpaid'>
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-user"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php
                            foreach ($unpaid as
                                    $value) {


                                echo $value->total . " Students";
                            }
                            ?></span>
                        <div class="infobox-content">UnPaid Fee</div>
                    </div>
                </a>

                <a class="infobox infobox-purple" href="#">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-money"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php
                            foreach ($amount as
                                    $value) {


                                echo " RS." . $value->total;
                            }
                            ?></span>
                        <div class="infobox-content">Total Amount</div>
                    </div>
                </a>




                <a class="infobox infobox-orange" href="#">
                    <div class="infobox-icon">
                        <i class="ace-icon fa fa-money"></i>
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-data-number"><?php
                            foreach ($par_paid as
                                    $value) {


                                echo " RS." . $value->total;
                            }
                            ?></span>
                        <div class="infobox-content">Partially Paid</div>
                    </div>
                </a>

                <div class="space-6"></div>

            </div>


            <div class="vspace-12-sm"></div>
        </div><!-- /.row -->
        <div class="widget-box">
            <div class="table-header">
                Search Fee
            </div>
            <div class="widget-body">
                <div class="widget-main">

                    <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">

                            <?php echo form_open('', ['class' => 'form-horizontal']); ?>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label class="control-label col-xs-3" for="status">Month</label>

                                    <?php
                                    $data2 = array(
                                        'data-placeholder' => "Select Month",
                                        'class' => "select2",
                                        'id' => 'month',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );

//$options = $tmp;
                                    echo form_dropdown('month', $month, set_value('month', date('m')), $data2);
                                    ?>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <label class="control-label col-xs-3" for="status">Year</label>



                                    <select required name="year" class="select2">

                                        <option value="" >Please Select Year </option>


                                        <?php echo AdminLTE::years(); ?>


                                    </select>


                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6">
                                    <label class="control-label col-xs-3" for="status">Status</label>
                                    <?php
                                    $data7 = array(
                                        'data-placeholder' => "Select Status",
                                        'class' => "select2",
                                        'id' => 'status',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );

//$options = $tmp;
                                    echo form_dropdown('status', $status, set_value('status',1), $data7);
                                    ?>
                                </div>
                       

                            <div class="col-xs-12 col-sm-6">
                                <label class="control-label col-xs-3" for="status">Course & Batch</label>

                                <select required name="course" class="select2">

                                    <option value="all">All Courses</option>
						
						
						                            <?php echo AdminLTE::courses(); ?>

                                </select>

                                </div>
                            </div>


                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <div class="col-xs-12" style="text-align: right">
                                    <label>
                                        <input type="submit" name="submit" value="Search" class="btn btn-lg btn-success">
                                    </label>
                                </div>
                            </div>



                            <?php echo form_close(); ?>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>
        </div>


        <?php
        if (isset($_POST['submit'])) {
            ?>
            <div class="table-header">
                List of  <?php
                $status = $this->input->post('status');
                if ($status == 0) {
                    echo "<span class='label label-large label-info'>Unpaid</span>";
                } elseif ($status == 1) {
                    echo "<span class='label label-large label-success'>Paid</span>";
                } elseif ($status == 2) {
                    echo "<span class='label label-large label-danger'>Dues Added to New Month</span>";
                } elseif ($status == 3) {
                    echo "<span class='label label-large label-default'>Partially Paid</span>";
                }
                ?> Fee
                <span>
                    <a href="#" id="export" class="btn btn-sm btn-success pull-right">
                        <i class="ace-icon fa fa-database"></i> Export to Excel</a>

                </span>
            </div>

            <table id="dyntableExport" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Month</th><th>Course</th><th>Name</th>
                        <th>Reg No</th>
                        <th>Fee</th>
                        <th>Dues</th>
                        <th>Date of Payment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($report > 0) {
                        $i = 1;
                        foreach ($report as
                                $r) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo AdminLTE::month($r->month) ?></td>
                                <td><?php echo AdminLTE::student_course($r->course); ?></td>
                                <td><?php echo AdminLTE::student_data($r->reg_no, "name"); ?></td>

                                <td><?php echo $r->reg_no ?></td>
                                <td><?php echo $r->monthly ?></td>
                                <td><?php echo $r->dues ?></td>
                                <td><?php echo dateformatesformysql_fata($r->date_of_payment); ?></td>
                                </td>


                                <?php
                                if ($r->status == '1') {
                                    echo "<td><span class='label label-large label-success'>Paid</span></td>";
                                    ?>
                                    <td>
                                        <div class="hidden-sm action-buttons">
                                            <a title="Print Fee" class="light-blue2" href="<?php echo site_url('admin/fee/printform/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-print bigger-130"></i>
                                            </a>

                                            <a title="Delete Fee"  class="red" onclick="return confirm('Are You Sure Want to Delete it?');" href="<?php echo site_url('admin/fee/delete/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                            </a>
                                        </div>

                                    </td>
                                    <?php
                                } else if ($r->status == '0') {
                                    echo "<td><span class='label label-large label-info'>Unpaid</span></td>";
                                    ?>
                                    <td>
                                        <div class="hidden-sm action-buttons">
                                            <a title="Print Fee" class="light-blue2" href="<?php echo site_url('admin/fee/printform/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-print bigger-130"></i>
                                            </a>
                                            <a title="Paid Fee"  class="green" href="<?php echo site_url('admin/fee/paid/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-paypal bigger-130"></i>
                                            </a>

                                            <a title="Partial Paid Fee"  class="light-red" href="<?php echo site_url('admin/fee/fee_partial/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-money bigger-130"></i>
                                            </a>


                                            <a title="Update Fee"  class="grey" href="<?php echo site_url('admin/fee/edit/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>

                                            <a title="Delete Fee"  class="red" onclick="return confirm('Are You Sure Want to Delete it?');" href="<?php echo site_url('admin/fee/delete/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                            </a>
                                        </div>

                                    </td>
                                    <?php
                                } else if ($r->status == '2') {
                                    echo "<td><span class='label label-large label-danger'>Dues Added to New Month</span></td>";
                                    ?>
                                    <td>
                                        <div class="hidden-sm action-buttons">
                                            <a title="Print Fee" class="light-blue2" href="<?php echo site_url('admin/fee/printform/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-print bigger-130"></i>
                                            </a>

                                            <a title="Delete Fee"  class="red" onclick="return confirm('Are You Sure Want to Delete it?');" href="<?php echo site_url('admin/fee/delete/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                            </a>
                                        </div>

                                    </td>
                                    <?php
                                } else if ($r->status == '4') {
                                    echo "<td><span class='label label-large label-purple'>Concession</span></td>";
                                    ?>
                                    <td>
                                        <div class="hidden-sm action-buttons">
                                            <a title="Print Fee" class="light-blue2" href="<?php echo site_url('admin/fee/printform/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-print bigger-130"></i>
                                            </a>

                                            <a title="Delete Fee"  class="red" onclick="return confirm('Are You Sure Want to Delete it?');" href="<?php echo site_url('admin/fee/delete/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                            </a>
                                        </div>

                                    </td>
                                    <?php
                                } else {
                                    echo "<td><span class='label label-large label-default'>Partially Paid</span></td>";
                                    ?>
                                    <td>
                                        <div class="hidden-sm action-buttons">
                                            <a title="Print Fee" class="light-blue2" href="<?php echo site_url('admin/fee/printform/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-print bigger-130"></i>
                                            </a>

                                            <a title="Delete Fee"  class="red" onclick="return confirm('Are You Sure Want to Delete it?');" href="<?php echo site_url('admin/fee/delete/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                            </a>
                                        </div>

                                    </td>
                                    <?php
                                }
                                ?>

                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        <?php } ?>

    </div>
</div>


