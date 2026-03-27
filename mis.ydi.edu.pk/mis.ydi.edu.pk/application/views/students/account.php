<button onclick="window.print();" class=" hidden-print btn btn-success btn-large">
    <i class="ace-icon fa fa-print bigger-130"></i> Print
</button>

<div class="row">

    <div class="col-xs-12">

        <div id="user-profile-1" class="user-profile row">
            <div class="col-xs-12 col-sm-3 center">
                <div>
                        <span class="profile-picture">

                            <?php if( $r->img == "" ) {
                              ?>
                                <img class="img-responsive" width="180" height="150" alt="<?php echo $r->name ?>"
                                     src="<?php echo site_url( 'images/profile.png' ); ?>"/>
                            <?php } else { ?>
                                <img class="img-responsive" width="180" height="150" alt="<?php echo $r->name ?>"
                                     src="<?php echo site_url( 'images/' . $r->img ); ?>"/>
                            <?php } ?>
                        </span>

                    <div class="space-4"></div>

                    <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                        <div class="inline position-relative">
                            <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                <i class="ace-icon fa fa-circle light-green"></i>
                                &nbsp;
                                <span class="white"><?php echo ucwords( strtolower( $r->name ) ); ?></span>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="space-6"></div>

                <div class="hr hr16 dotted"></div>
            </div>

            <div class="col-xs-12 col-sm-9">

                <div class="profile-user-info profile-user-info-striped">

                    <div class="profile-info-row">
                        <div class="profile-info-name viewname"> Registration Number</div>

                        <div class="profile-info-value viewname1">
                            <span class="editable" id="username"><?php echo $r->reg_no ?></span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name viewname"> Admission Date</div>

                        <div class="profile-info-value viewname1">
                            <span class="editable"
                                  id="signup"><?php echo dateformatesformysql_fata( $r->do_admission ); ?></span>
                        </div>
                    </div>

                    <div class="profile-info-row">
                        <div class="profile-info-name viewname"> Courses</div>

                        <div class="profile-info-value viewname1">
                                <span class="editable" id="about"><?php
                                  echo strtoupper( AdminLTE::student_course( $r->course ) ) . "<br>";
                                  ?></span>
                        </div>
                    </div>

                </div>

                <div class="space-10"></div>

                <div class="col-xs-12 col-sm-12">

                    <div class="profile-user-info profile-user-info-striped">

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Father / Guardian Name</div>

                            <div class="profile-info-value viewname1">
                                <span class="editable"
                                      id="username"><?php echo ucwords( strtolower( $r->f_name ) ); ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> CNIC</div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->cnic ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Contact Number</div>
                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->contact ?></span>
                            </div>
                        </div>


                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Date of Birth</div>

                            <div class="profile-info-value viewname1">
                                    <span class="editable" id="age"><?php
                                      if( !empty( $r->dob ) ) {
                                        $originalDate = $r->dob;
                                        $date = explode( "-", $r->dob );
                                        echo "<span style='float: left'>In Figure :</span>" . date( "d-m-Y",
                                            strtotime( $originalDate ) ) . "<br> ";
                                        echo "<span style='float: left'>In Words :</span>  " . AdminLTE::day( $date[ 2 ] ) . " ";
                                        echo AdminLTE::month( $date[ 1 ] ) . ", ";
                                        echo AdminLTE::year( $date[ 0 ] );
                                      } ?></span>
                            </div>
                        </div>


                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Permanent Address</div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="login"><?php echo $r->address ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> I am a Student of</div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="login"><?php echo $r->std_of ?></span>
                            </div>
                        </div>


                    </div>

                    <div class="space-20"></div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Receipt No</th>
                        <th>Registration No</th>
                        <th>Course</th>
                        <th>Name</th>

                        <th>Registration  Fee</th>
                        <th>Monthly  Fee</th>
                        <th>Interview  Fee</th>
                        <th>Other  Fee</th>
                        <th>Student Status</th>
                        <th>Date</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    foreach ($admission as $r) {
                      ?>
                        <tr>
                            <td><?php echo AdminLTE::month(explode('-', $r->date)[1]); ?></td>
                            <td><?php echo $r->regno ?></td>
                            <td><?php echo AdminLTE::student_course($r->course); ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_data($r->regno, "name"))); ?></td>


                          <?php  if ($r->fee_status == '1') {
                            echo "<td> $r->fee  &nbsp; <span class='label label-large label-success'>Paid</span></td>";
                          }else{
                            echo "<td> $r->fee &nbsp; <span class='label label-large label-inverse'>UnPaid</span></td>";

                          } ?>

                            <td><?php echo $r->monthly ?></td>
                            <td><?php echo $r->interview ?></td>
                            <td><?php echo $r->other ?></td>
                            <td><?php
                              if ($r->std_status
                                  == '1') {
                                echo "<span class='label label-large label-success'>Confirmed</span>";
                              } else if ($r->std_status
                                         == '2') {
                                echo "<span class='label label-large label-warning'>Struck Off</span> <br> $r->comments";
                              } else if ($r->std_status
                                         == '3'){
                                echo "<span class='label label-large label-freeze'>Freeze</span>";
                              }else {
                                echo "<span class='label label-large label-inverse'>Pending</span>";
                              }
                              ?>	</td>
                            <td><?php echo $r->date ?></td>
                        </tr>

                      <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div><div class="col-xs-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Rec No</th>
                        <th>Month / Year</th><th>Registration  No</th><th>Name</th>
                        <th>Monthly Fee</th>
                        <th>Dues</th>
                        <th>Date of Payment</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $i = 1;
                    foreach ($fee as $r) {
                      ?>
                        <tr> <td> <?php echo $i ?></td>
                            <td><?php  echo $r->rec_no ?></td>
                            <td><?php if($r->status_1p == 1){
                                echo AdminLTE::month($r->month) . " - " . $r->year  . " - " . "1st Time Payment";
                              }else{
                                echo AdminLTE::month($r->month) . " - " . $r->year;
                              }  ?></td>
                            <td><?php echo $r->reg_no; ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_data($r->reg_no, "name"))); ?></td>


                            <td><?php echo $r->monthly ?></td>
                            <td><?php echo $r->dues ?></td>
                            <td><?php echo dateformatesformysql_fata($r->date_of_payment); ?></td>

                          <?php
                          if ($r->status == '1') {
                            echo "<td><span class='label label-large label-success'>Paid</span></td>";

                          } else if ($r->status == '0') {
                            echo "<td><span class='label label-large label-info'>Unpaid</span></td>";

                          } else if ($r->status == '2') {
                            echo "<td><span class='label label-large label-danger'>Dues Added to New Month</span></td>";

                          }
                          else {
                            echo "<td><span class='label label-large label-default'>Partially Paid</span></td>";
                          }
                          ?>
                        </tr>
                      <?php
                      $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="col-xs-12">
                <h4 class="header smaller lighter blue">
                    <i class="ace-icon fa fa-calendar"></i>
                    Attendance History
                </h4>
                <table id="attendance-table" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                        <th>Course</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!empty($attendance)) {
                        $i = 1;
                        foreach ($attendance as $att) {
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td data-order="<?php echo $att->date; ?>"><?php echo dateformatesformysql_fata($att->date); ?></td>
                            <td><?php echo $att->course_name . ' ' . AdminLTE::batch_name($att->batch); ?></td>
                            <td>
                                <?php
                                if ($att->status == 1) {
                                    echo "<span class='label label-success'>P</span>";
                                } else if ($att->status == 2) {
                                    echo "<span class='label label-warning'>A</span>";
                                } else if ($att->status == 3) {
                                    echo "<span class='label label-info'>L</span>";
                                } else {
                                    echo "<span class='label label-default'>N/A</span>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                          $i++;
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="4" class="text-center">No attendance records found</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <script>
            $(document).ready(function() {
                $('#attendance-table').DataTable({
                    "pageLength": 10,
                    "order": [[1, "desc"]],
                    "language": {
                        "emptyTable": "No attendance records found"
                    }
                });
            });
            </script>
        </div>


    </div>
</div>