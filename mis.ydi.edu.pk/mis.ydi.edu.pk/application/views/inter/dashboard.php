
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        <?php echo "Dashboard of " . $this->session->user_name . " - " . $this->session->user_level ?>
        <?php
        echo date("d F, Y");
        ?>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Manage <?php echo $heading; ?> Interview Details
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>

            <table id="dyntable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Registration No</th>
                        <th>Course</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Student Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as
                            $r) {
                        $data = AdminLTE::interview_info($r->regno);

                        if (empty($data) && AdminLTE::student_data($r->regno, 'status') == '0') {
                            ?>
                            <tr>

                                <td> <?php echo $i ?></td>
                                <td><?php echo $r->regno ?></td>
                                <td><?php echo AdminLTE::student_course($r->course) ?></td>
                                <td><?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))); ?></td>
                                <td><?php echo ucwords(strtolower(AdminLTE::student_fname($r->regno))); ?></td>
                                </td>


                               

                                <td><?php
                                    if (AdminLTE::student_data($r->regno, 'status') == '1') {
                                        echo "<span class='label label-large label-success'>Confirmed</span>";
                                    } else if (AdminLTE::student_data($r->regno, 'status') == '2') {
                                        echo "<span class='label label-large label-warning'>Struck Off</span> <br>" . AdminLTE::student_data($r->regno, 'comments');
                                    } else {
                                        echo "<span class='label label-large label-inverse'>Pending</span>";
                                    }
                                    ?>	</td>

                                <td>
                                    <div class="hidden-sm action-buttons">
                                        <?php if (AdminLTE::student_data($r->regno, 'status') == '0') { ?>

                                            <?php
                                            $data = AdminLTE::interview_info($r->regno);

                                            if (!empty($data)) {
                                                ?>
                                                <a title="View Interview Form"  class="orange" href="<?php echo site_url('interviewer/view/' . $r->regno) ?>">
                                                    <i class="ace-icon fa fa-eye bigger-130"></i>
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <a title="Take Interview"  class="brown" href="<?php echo site_url('interviewer/interview/' . $r->regno) ?>">
                                                    <i class="ace-icon fa fa-list-alt bigger-130"></i>
                                                </a>

                                            <?php } ?>


                                            <a title="Update Interview Fee" class="green" href="<?php echo site_url('interviewer/update_fee/' . $r->regno) ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>

                                            <a title="Struck Off Student" class="red" href="<?php echo site_url('interviewer/struckoff/' . $r->regno) ?>">
                                                <i class="ace-icon fa fa-warning bigger-130"></i>
                                            </a>

                                        <?php } elseif (AdminLTE::student_data($r->regno, 'status') == '1') { ?>
                                            <a title="View Interview Form"  class="orange" href="<?php echo site_url('interviewer/view/' . $r->regno) ?>">
                                                <i class="ace-icon fa fa-eye bigger-130"></i>
                                            </a>


                                            <a title="Update Interview Fee" class="green" href="<?php echo site_url('interviewer/update_fee/' . $r->regno) ?>">
                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                            </a>

                                            <a title="Struck Off Student" class="red" href="<?php echo site_url('interviewer/struckoff/' . $r->regno) ?>">
                                                <i class="ace-icon fa fa-warning bigger-130"></i>
                                            </a>


                                        <?php } elseif (AdminLTE::student_data($r->regno, 'status') == '2') { ?>
                                            <a title="View Interview Form"  class="orange" href="<?php echo site_url('interviewer/view/' . $r->regno) ?>">
                                                <i class="ace-icon fa fa-eye bigger-130"></i>
                                            </a>

                                        <?php } ?>
                                    </div>

                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }
                    ?>
                </tbody>
            </table>

            <br>
            <div class="row">
                  <div class="widget-box hidden-print">
                    <div class="table-header">
                        Search Date Wise Reports
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">

                            <div id="fuelux-wizard-container">

                                <div class="step-content pos-rel">

                                    <?php echo form_open('', ['class' => 'form-horizontal']); ?>

                                    <div class="form-group">
                                        <label class="control-label col-xs-12 col-sm-2 no-padding-right" for="status">Date: </label>

                                        <div class="col-xs-12 col-sm-6">
                                            <input type="text" name="from" value="<?php echo date('Y-m-d'); ?>" class="form-control datepicker"/>

                                      
                                    </div>
                                         <input type="submit" name="submit" value="Search" class="btn btn-lg btn-success">



                                    <?php echo form_close(); ?>

                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 text-center col-xs-12">
                    <div id="reg" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                </div>

            
            <div class="col-sm-12 text-center col-xs-12">

                <div id="course" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
            </div>
           
                <div class="col-sm-12 text-center col-xs-12">

                    <div id="teacher" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                </div>
                 <div class="col-sm-12 text-center col-xs-12">

                    <div id="student" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                    
                </div>
                <?php
                $cour = $this->db->query("Select course from trainer_data group by course");
                foreach ($cour->result() as
                        $vals) {
                             if(AdminLTE::user_course($vals->course) == 1){
                    ?>
                    <div class="col-sm-6 text-center col-xs-12">

                        <div id="stra<?php echo $vals->course ?>" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                    </div>
                    <?php
                }}
            
            ?>
        </div>
</div>

        <script src = "<?php echo base_url(); ?>dist/highcharts.js"></script>
        <script src="<?php echo base_url(); ?>dist/exporting.js"></script>
       
           
            <?php
            $emp_id = $this->db->query("Select emp_id from user where level = 'Trainer' and status = 1");
            $cc = array();
            $totalc = array();
            $date_year = date('Y');
            foreach ($emp_id->result() as
                    $value) {
              if(!empty($value->emp_id)){
                if (isset($_POST["submit"])) {
                    $dates = $this->input->post('from');
                    $que = $this->db->query("Select count(percentage) as countp, SUM(percentage) as pertage from trainer_data where trainer = $value->emp_id and YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR('$dates')");
                }
                else {
                    $que = $this->db->query("Select count(percentage) as countp, SUM(percentage) as pertage from trainer_data where trainer = $value->emp_id and YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) - 1 ");
                }
               
                if ($que->num_rows() > 0) {

                   $data = $que->row();
                            
                                 $totalperc = $data->pertage;
                                     $totalp = $data->countp;
                        if($totalp > 0)
                    
                     {
                           $cc[] = AdminLTE::employee_name($value->emp_id);
                            $tt = round($totalperc / $totalp);
                    
                        $totalc[] = $tt;
                     }
            }
                    }
                    }
            ?>

            <script>
                $(function () {
                    Highcharts.chart('teacher', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Top 3 Trainers'
                        },
                        subtitle: {
                            text: 'Source: Engr Haroon Yousaf'
                        },

                        xAxis: {
                            categories:
    <?php echo json_encode($cc) ?>
                            ,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Top 3 Trainers'
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
                                name: 'Percentage',
                                data: <?php echo json_encode($totalc, JSON_NUMERIC_CHECK);
    ?>

                            }]


                    });
                });
            </script>
  <?php
          
            $totalc = array();
           $cc = array();
           $date_year = date('Y');
              if (isset($_POST["submit"])) {
                    $dates = $this->input->post('from');
                     $year_from_date = date('Y', strtotime($dates)); // Extract year from $dates
                    $que = $this->db->query("Select regno, percentage from trainer_data where YEAR(date) = $year_from_date and WEEKOFYEAR(date)=WEEKOFYEAR('$dates') order by percentage DESC");
                }
                else {
                    $que = $this->db->query("Select regno, percentage from trainer_data where YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) - 1 order by percentage DESC");
                }
               
               
                foreach ($que->result() as
                        $data) {
 $cc[] = AdminLTE::student_name($data->regno);
                     if (!empty($dates)) {
                        $rank = AdminLTE::rank_date_ydi($data->regno, $dates);
                    }
                    else {
                        $rank = AdminLTE::rank_ydi($data->regno);
                    }
                    if ($rank <= 3) {
                        
                    $totalc[] = $data->percentage;;
                }
                        }
            
          
            ?>

            <script>
                        $(function () {
                        Highcharts.chart('student', {
                        chart: {
                        type: 'column'
                        },
                                title: {
                                text: 'Top 3 Students in YDI'
                                },
                                xAxis: {
                                categories:
    <?php echo json_encode($cc); ?>
                                ,
                                        crosshair: true
                                },
                                yAxis: {
                                min: 0,
                                        title: {
                                        text: 'Top 3 Students in YDI'
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
                                name: 'Percentage',
                                        data: <?php echo json_encode($totalc, JSON_NUMERIC_CHECK);
    ?>

                                }]


                        });
                        });            </script>


            <?php
        $emp_course = $this->db->query("SELECT course_id FROM courses WHERE status = 1");
$c = array();
$total = array();
$reg = array();
$struck = array();
$freez = array();
$pend = array();
	$date_month = date('m');
								$date_year = date('Y');

foreach ($emp_course->result() as $value) {
    $c[] = AdminLTE::student_course($value->course_id);

    $query = $this->db->query("SELECT 
                                    (SELECT COUNT(*) AS total FROM student WHERE course = $value->course_id) AS total,
                                    (SELECT COUNT(*) AS reg FROM student WHERE course = $value->course_id AND status = 1) AS regular,
                                    (SELECT COUNT(*) AS struck FROM student WHERE course = $value->course_id AND status = 2) AS struck,
                                    (SELECT COUNT(*) AS freez FROM student WHERE course = $value->course_id AND status = 3) AS freez,
                                    (SELECT COUNT(*) AS pending FROM student WHERE course = $value->course_id AND status = 0) AS pending");

    foreach ($query->result() as $data) {
        if ($data->total > 0) {
            $total[] = $data->total;
            $reg[] = $data->regular;
            $struck[] = $data->struck;
            $freez[] = $data->freez;
            $pend[] = $data->pending;
        }
    }
}

        ?>
        <script>
            $(function () {
                Highcharts.chart('course', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Students in Courses'
                    },
                    subtitle: {
                        text: 'Source: Engr Haroon Yousaf'
                    },

                    xAxis: {
                        categories:
<?php echo json_encode($c) ?>
                        ,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Students in Courses'
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
                                format: '{y}'
                            }
                        }
                    },
                    series: [{
                            name: 'Total No. of Students',
                            data: <?php echo json_encode($total, JSON_NUMERIC_CHECK);
?>

                        },
                                {
                            name: 'Regular Students',
                            data: <?php echo json_encode($reg, JSON_NUMERIC_CHECK);
?>

                        },
                               
                        {
                            name: 'Struckoff Students ',
                            data: <?php echo json_encode($struck, JSON_NUMERIC_CHECK);
?>

                        }, {
                            name: 'Freeze Students',
                            data: <?php echo json_encode($freez, JSON_NUMERIC_CHECK);
?>

                        },
                        {
                            name: 'Pending Students ',
                            data: <?php echo json_encode($pend, JSON_NUMERIC_CHECK);
?>

                        }]


                });

            });


        </script>

            <script>
                $(function () {

                    Highcharts.chart('reg', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Fee / Expenses Detail'
                        },
                        subtitle: {
                            text: 'Source: Engr Haroon Yousaf'
                        },

                        xAxis: {
                            categories:
<?php echo $datess; ?>,

                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Fee / Expenses Detail'
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
                                    format: 'Rs. {y}'
                                }
                            }
                        },
                        series: [
                            {
                                name: 'Interview Fee',
                                data: <?php echo json_encode($interview, JSON_NUMERIC_CHECK); ?>

                            }, {
                                name: 'Form Fee',
                                data: <?php echo json_encode($other, JSON_NUMERIC_CHECK); ?>

                            }
                            , {
                                name: 'Final Interview / Change Class Fee',
                                data: <?php echo json_encode($final, JSON_NUMERIC_CHECK); ?>

                            }, {
                                name: 'Re-Admission Fee',
                                data: <?php echo json_encode($radm, JSON_NUMERIC_CHECK); ?>

                            }, {
                                name: 'Expenses',
                                data: <?php echo json_encode($daily, JSON_NUMERIC_CHECK); ?>

                            }


                        ]


                    });
                });


            </script>
 <?php
            $courseds = $this->db->query("Select course from trainer_data group by course");
            $date_year = date('Y');
            foreach ($courseds->result() as
                    $valds) {
             if(AdminLTE::user_course($valds->course) == 1){
                if (isset($_POST["submit"])) {
                    $dates = $this->input->post('from');
                    $query = $this->db->query("Select * from trainer_data where course = $valds->course and YEAR(date) = $date_year and WEEKOFYEAR(date)= WEEKOFYEAR('$dates') group by regno order by percentage DESC");
                 
                }
                else {
                    $query = $this->db->query("Select * from trainer_data where course = $valds->course and YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) - 1 group by regno order by percentage DESC ");
                
                }


                $name = array();
                $perc = array();
                $totals = array();
                $totalstra = array();
                foreach ($query->result() as
                        $value) {
                                $trainer_name = AdminLTE::employee_name($value->trainer);
                    if (!empty($dates)) {
                        $rank = AdminLTE::rank_date($value->regno, $valds->course, $dates);
                    } else {
                        $rank = AdminLTE::rank($value->regno, $valds->course);
                    }
                    if ($rank <= 3) {
                        $name[] = AdminLTE::student_name($value->regno);
                        $perc[] = $value->percentage;
                        $attend = explode(",", $value->attend)[0];
                        $coop = explode(",", $value->coop)[0];
                        $pre = explode(",", $value->pre)[0];
                        $part = explode(",", $value->part)[0];
                        $ling = explode(",", $value->ling)[0];
                        $punc = explode(",", $value->punc)[0];
                        $marks = $value->marks;
                        $tmarks = $value->tmarks;


                        $totals[] = (($attend + $coop + $pre + $part + $ling + $punc) / 600) * 60;
                        $totalstra[] = ($marks / $tmarks) * 40;
                    }
                }
                ?>

                <script>
                    $(function () {
                        Highcharts.chart('stra<?php echo $valds->course ?>', {
                            chart: {
                                type: 'column'
                            },
                            
                                    title: {
                                    text: 'Top 3 Students in Course <?php echo AdminLTE::student_course($valds->course). "(". $trainer_name .")" ?>'
                                    },
                            subtitle: {
                                text: 'Source: Engr Haroon Yousaf'
                            },

                            xAxis: {
                                categories:
        <?php echo json_encode($name) ?>
                                ,
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Top 3 Students'
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
                                    name: 'Skills',
                                    data: <?php echo json_encode($totals);
        ?>

                                }, {
                                    name: '<?php echo $value->stra ?>',
                                    data: <?php echo json_encode($totalstra); ?>

                                }, {

                                    name: 'Total Percentage',
                                    data: <?php echo json_encode($perc, JSON_NUMERIC_CHECK) ?>

                                }]


                        });
                    });


                </script>
            <?php } }?>


        </div>
    </div>
</div>