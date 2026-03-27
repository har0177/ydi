<script src="<?php echo base_url(); ?>dist/highcharts.js"></script>
<script src="<?php echo base_url(); ?>dist/exporting.js"></script>
<button onclick="window.print();" class=" hidden-print btn btn-success btn-large">
    <i class="ace-icon fa fa-print bigger-130"></i> Print
</button>
<div class="widget-box hidden-print">
    <div class="table-header">
        Search Report
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <div id="fuelux-wizard-container">

                <div class="step-content pos-rel">

                    <?php echo form_open('', ['class' => 'form-horizontal']); ?>


                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Date</label>

                        <div class="col-xs-12 col-sm-3">


                            <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control datepicker">
                        </div>
                        <input type="submit" name="submit" value="Search" class="btn btn-lg btn-success">
                    </div>







                    <?php echo form_close(); ?>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {

    if (!empty($report)) {

        foreach ($report as
                $rr) {
            ?>

            <div class="page-header">

                <img src="<?php echo base_url() . 'images/logo.jpg' ?>" width="100px">  <h2 style="text-align: center;">
                    YOUTH DEVELOPMENT INSTITUTE <br>
                    English Proficiency Program

                </h2>

            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">

                    <table id="" class="table table-striped table-bordered table-responsive">
                        <tr>
                            <th colspan="4">   TRAINEE'S PROFILE</th>
                        </tr>
                        <tr><th>Name</th>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_name($rr->regno))); ?></td>
                            <th>Registration No</th>
                            <td><?php echo strtoupper($rr->regno); ?></td>
                        </tr>
                        <tr>
                            <th>EDIR Number</th>
                            <td><?php echo AdminLTE::table_data_onefield("interview", "edir", array("regno" => $rr->regno)) ?></td>
                            <th>Courses & Batch</th>
                            <td><?php echo (AdminLTE::student_course(AdminLTE::table_data_onefield("student", "course", array("reg_no" => $rr->regno)))); ?></td>

                        </tr>
                        <tr>
                            <th>Trainer</th>
                            <td><?php
                                echo AdminLTE::employee_name($rr->trainer);
                                ?>

                            </td>
                            <th>Date</th>
                            <td><?php echo dateformatesformysql_fata($rr->date) ?></td>
                        <tr>
                            <th colspan="4">   TRAINEE'S INFORMATION</th>
                        </tr>
                        </tr>

                        <tr><th >Attendance</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $rr->attend)[1]; ?></td>
                        </tr>

                        <tr><th>Punctuality</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $rr->punc)[1]; ?></td>
                        </tr>
                        <tr><th>Participation</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $rr->part)[1]; ?></td>
                        </tr>

                        <tr><th>Cooperation</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $rr->coop)[1]; ?></td>
                        </tr>

                        <tr><th>Presentation Skills</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $rr->pre)[1]; ?></td>
                        </tr>
                        <tr><th>Lingual Skills</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $rr->ling)[1]; ?></td>
                        </tr>
                        <tr>
                            <th colspan="4">   <?php echo strtoupper($rr->stra) ?></th>
                        </tr>
                        <tr>
                            <th> Obtained Marks</th>
                            <td>
                                <?php echo $rr->marks ?>
                            </td>
                            <th>Total Marks</th>
                            <td><?php echo $rr->tmarks ?></td>
                        </tr>
                    </table>



                    <b>Comments / Recommendations: </b> <span> <?php echo $rr->comments ?></span>


                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div id="a_p_t<?php echo $rr->regno ?>" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div id="stra<?php echo $rr->regno ?>" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                        </div>

                    </div>



                </div>
            </div>
            <?php
            $array = array("date" => $rr->date, "regno" => $rr->regno);
            $this->db->where($array);
            $query = $this->db->get('trainer_data');


            foreach ($query->result() as
                    $val) {
                ?>
                <script>
                    $(function () {
                        Highcharts.chart('a_p_t<?php echo $rr->regno ?>', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Student Weekly Report'
                            },
                          

                            xAxis: {
                                categories: [
                                    'Student Weekly Report'

                                ],
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: '<?php echo AdminLTE::student_name($val->regno) ?>'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                        '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.1,
                                    borderWidth: 0
                                },
                                series: {
                                    dataLabels: {
                                        enabled: true,
                                        format: '{y} %'
                                    }
                                }
                            },
                            series: [{
                                    name: 'Total',
                                    data: [
                                        100
                                    ]

                                }, {
                                    name: 'Attendance',
                                    data: [
                <?php echo explode(",", $val->attend)[0] ?>
                                    ]

                                }, {
                                    name: 'Punctuality',
                                    data: [
                <?php echo explode(",", $val->punc)[0] ?>
                                    ]

                                }, {
                                    name: 'Participation',
                                    data: [
                <?php echo explode(",", $val->part)[0] ?>
                                    ]

                                }, {
                                    name: 'Cooperation',
                                    data: [
                <?php echo explode(",", $val->coop)[0] ?>
                                    ]

                                }, {
                                    name: 'Presentation Skills',
                                    data: [
                <?php echo explode(",", $val->pre)[0] ?>
                                    ]

                                }, {
                                    name: 'Lingual Skills',
                                    data: [
                <?php echo explode(",", $val->ling)[0] ?>
                                    ]

                                }]


                        });
                    });


                </script>

                <script>
                    $(function () {
                        Highcharts.chart('stra<?php echo $rr->regno ?>', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Student Overall Performance'
                            },
                           
                            xAxis: {
                                categories: [
                                    'Student Overall Performance',
                                ],
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: '<?php echo AdminLTE::student_name($val->regno) ?>'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                        '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.1,
                                    borderWidth: 0
                                },
                                series: {
                                    dataLabels: {
                                        enabled: true,
                                        format: '{y} %'
                                    }
                                }
                            },
                            series: [{
                                    name: 'Total',
                                    data: [
                                        100
                                    ]

                                }, {
                                    name: 'Skills',
                                    data: [
                <?php
                $attend = explode(",", $val->attend)[0];
                $coop = explode(",", $val->coop)[0];
                $pre = explode(",", $val->pre)[0];
                $part = explode(",", $val->part)[0];
                $ling = explode(",", $val->ling)[0];
                $punc = explode(",", $val->punc)[0];

                $total1 = (($attend + $coop + $pre + $part + $ling + $punc) / 600) * 60;
                echo $total1;
                ?>
                                    ]

                                }, {
                                    name: '<?php echo $val->stra ?>',
                                    data: [
                <?php
                $total2 = ($val->marks / $val->tmarks) * 40;
                echo $total2
                ?>
                                    ]

                                },
                                {
                                    name: 'Total Percentage',
                                    data: [
                <?php echo $total1 + $total2; ?>
                                    ]

                                }]


                        });
                    });


                </script>
            <?php } ?>
            <DIV style="page-break-after:always"></DIV>


            <?php
        }
    }
} else {
    $emp = AdminLTE::user_data($this->session->user_id);
    $result = $this->db->query("Select * from trainer_data where trainer = $emp and WEEKOFYEAR(date) = WEEKOFYEAR(CURDATE()) group by regno");
	if($result->num_rows() == 0){
	$result = $this->db->query("Select * from trainer_data where trainer = $emp and WEEKOFYEAR(date) = WEEKOFYEAR(CURDATE()) - 1 group by regno");
		
	}
    if (!empty($result)) {
        foreach ($result->result() as
                $r) {
            ?>

            <div class="page-header">

                <img src="<?php echo base_url() . 'images/logo.jpg' ?>" width="100px">  <h2 style="text-align: center;">
                    YOUTH DEVELOPMENT INSTITUTE <br>
                    English Proficiency Program

                </h2>

            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">

                    <table id="" class="table table-striped table-bordered table-responsive">
                        <tr>
                            <th colspan="4">   TRAINEE'S PROFILE</th>
                        </tr>
                        <tr><th>Name</th>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))); ?></td>
                            <th>Registration No</th>
                            <td><?php echo strtoupper($r->regno); ?></td>
                        </tr>
                        <tr>
                            <th>EDIR Number</th>
                            <td><?php echo AdminLTE::table_data_onefield("interview", "edir", array("regno" => $r->regno)) ?></td>
                            <th>Courses & Batch</th>
                            <td><?php echo (AdminLTE::student_course(AdminLTE::table_data_onefield("student", "course", array("reg_no" => $r->regno)))); ?></td>

                        </tr>
                        <tr>
                            <th>Trainer</th>
                            <td><?php
                                echo AdminLTE::employee_name($r->trainer);
                                ?>

                            </td>
                            <th>Date</th>
                            <td><?php echo dateformatesformysql_fata($r->date) ?></td>
                        <tr>
                            <th colspan="4">   TRAINEE'S INFORMATION</th>
                        </tr>
                        </tr>

                        <tr><th >Attendance</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $r->attend)[1]; ?></td>
                        </tr>

                        <tr><th>Punctuality</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $r->punc)[1]; ?></td>
                        </tr>
                        <tr><th>Participation</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $r->part)[1]; ?></td>
                        </tr>

                        <tr><th>Cooperation</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $r->coop)[1]; ?></td>
                        </tr>

                        <tr><th>Presentation Skills</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $r->pre)[1]; ?></td>
                        </tr>
                        <tr><th>Lingual Skills</th>
                            <td colspan="3" style=" text-align: justify"><?php echo explode(",", $r->ling)[1]; ?></td>
                        </tr>
                        <tr>
                            <th colspan="4">   <?php echo strtoupper($r->stra) ?></th>
                        </tr>
                        <tr>
                            <th> Obtained Marks</th>
                            <td>
                                <?php echo $r->marks ?>
                            </td>
                            <th>Total Marks</th>
                            <td><?php echo $r->tmarks ?></td>
                        </tr>
                    </table>



                    <b>Comments / Recommendations: </b> <span> <?php echo $r->comments ?></span>


                    <div class="row">
                        <div class="col-lg-6 col-xs-6">
                            <div id="a_p_t<?php echo $r->regno ?>" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <div id="stra<?php echo $r->regno ?>" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                        </div>

                    </div>



                </div>
            </div>

            <?php
            $query = $this->db->query("Select * from trainer_data where regno = $r->regno order by id DESC LIMIT 1");
            foreach ($query->result() as
                    $value) {
                ?>
                <script>
                    $(function () {
                        Highcharts.chart('a_p_t<?php echo $r->regno ?>', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Student Weekly Report'
                            },
                          

                            xAxis: {
                                categories: [
                                    'Student Weekly Report'

                                ],
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: '<?php echo AdminLTE::student_name($value->regno) ?>'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                        '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.1,
                                    borderWidth: 0
                                },
                                series: {
                                    dataLabels: {
                                        enabled: true,
                                        format: '{y} %'
                                    }
                                }
                            },
                            series: [{
                                    name: 'Total',
                                    data: [
                                        100
                                    ]

                                }, {
                                    name: 'Attendance',
                                    data: [
                <?php echo explode(",", $value->attend)[0] ?>
                                    ]

                                }, {
                                    name: 'Punctuality',
                                    data: [
                <?php echo explode(",", $value->punc)[0] ?>
                                    ]

                                }, {
                                    name: 'Participation',
                                    data: [
                <?php echo explode(",", $value->part)[0] ?>
                                    ]

                                }, {
                                    name: 'Cooperation',
                                    data: [
                <?php echo explode(",", $value->coop)[0] ?>
                                    ]

                                }, {
                                    name: 'Presentation Skills',
                                    data: [
                <?php echo explode(",", $value->pre)[0] ?>
                                    ]

                                }, {
                                    name: 'Lingual Skills',
                                    data: [
                <?php echo explode(",", $value->ling)[0] ?>
                                    ]

                                }]


                        });
                    });


                </script>

                <script>
                    $(function () {
                        Highcharts.chart('stra<?php echo $r->regno ?>', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Student Overall Performance'
                            },
                          
                            xAxis: {
                                categories: [
                                    'Student Overall Performance',
                                ],
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: '<?php echo AdminLTE::student_name($value->regno) ?>'
                                }
                            },
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                        '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.1,
                                    borderWidth: 0
                                },
                                series: {
                                    dataLabels: {
                                        enabled: true,
                                        format: '{y} %'
                                    }
                                }
                            },
                            series: [{
                                    name: 'Total',
                                    data: [
                                        100
                                    ]

                                }, {
                                    name: 'Skills',
                                    data: [
                <?php
                $attend = explode(",", $value->attend)[0];
                $coop = explode(",", $value->coop)[0];
                $pre = explode(",", $value->pre)[0];
                $part = explode(",", $value->part)[0];
                $ling = explode(",", $value->ling)[0];
                $punc = explode(",", $value->punc)[0];

                $total1 = (($attend + $coop + $pre + $part + $ling + $punc) / 600) * 60;
                echo $total1;
                ?>
                                    ]

                                }, {
                                    name: '<?php echo $value->stra ?>',
                                    data: [
                <?php
                $total2 = ($value->marks / $value->tmarks) * 40;
                echo $total2;
                ?>
                                    ]

                                },
                                {
                                    name: 'Total Percentage',
                                    data: [
                <?php echo $total1 + $total2; ?>
                                    ]

                                }]


                        });
                    });


                </script>
                <?php
            }
            ?>
            <DIV style="page-break-after:always"></DIV>


            <?php
        }
    }
}
?>
