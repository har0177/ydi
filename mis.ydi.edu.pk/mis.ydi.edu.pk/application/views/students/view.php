
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        View <?php echo $heading ?> Profile
        <a href="<?php echo site_url('admin/students'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">


        <div>
            <div id="user-profile-1" class="user-profile row">
                <div class="col-xs-12 col-sm-3 center">
                    <div>
                        <span class="profile-picture">

                            <?php if ($r->img == "") {
                                ?>
                                <img  class="img-responsive" width="180" height="150" alt="<?php echo $r->name ?>" src="<?php echo site_url('images/profile.png'); ?>" />
                            <?php } else { ?>
                                <img  class="img-responsive" width="180" height="150" alt="<?php echo $r->name ?>" src="<?php echo site_url('images/' . $r->img); ?>" />
                            <?php } ?>
                        </span>

                        <div class="space-4"></div>

                        <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                            <div class="inline position-relative">
                                <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                    <i class="ace-icon fa fa-circle light-green"></i>
                                    &nbsp;
                                    <span class="white"><?php echo ucwords(strtolower($r->name)); ?></span>
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
                            <div class="profile-info-name viewname"> Registration Number </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->reg_no ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Admission Date </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="signup"><?php echo dateformatesformysql_fata($r->do_admission); ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Courses </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="about"><?php
                                    echo strtoupper(AdminLTE::student_course($r->course)) . "<br>"
                                    ;
                                    ?></span>
                            </div>
                        </div>

                    </div>

                    <div class="space-10"></div>

                    <div class="col-xs-12 col-sm-12">

                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name viewname"> Father / Guardian Name </div>

                                <div class="profile-info-value viewname1">
                                    <span class="editable" id="username"><?php echo ucwords(strtolower($r->f_name)); ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name viewname">  CNIC </div>

                                <div class="profile-info-value viewname1">
                                    <span class="editable" id="username"><?php echo $r->cnic ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name viewname"> Contact Number </div>
                                <div class="profile-info-value viewname1">
                                    <span class="editable" id="username"><?php echo $r->contact ?></span>
                                </div>
                            </div>


                            <div class="profile-info-row">
                                <div class="profile-info-name viewname"> Date of Birth </div>

                                <div class="profile-info-value viewname1">
                                    <span class="editable" id="age"><?php
                                    if(!empty($r->dob)){
                                        $originalDate = $r->dob;
                                        $date = explode("-", $r->dob);
                                        echo "<span style='float: left'>In Figure :</span>" . date("d-m-Y", strtotime($originalDate)) . "<br> ";
                                        echo "<span style='float: left'>In Words :</span>  " . AdminLTE::day($date[2]) . " ";
                                        echo AdminLTE::month($date[1]) . ", ";
                                        echo AdminLTE::year($date[0]);
                                     } ?></span>
                                </div>
                            </div>



                            <div class="profile-info-row">
                                <div class="profile-info-name viewname"> Permanent Address </div>

                                <div class="profile-info-value viewname1">
                                    <span class="editable" id="login"><?php echo $r->address ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name viewname"> I am a Student of </div>

                                <div class="profile-info-value viewname1">
                                    <span class="editable" id="login"><?php echo $r->std_of ?></span>
                                </div>
                            </div>


                        </div>

                        <div class="space-20"></div>

                    </div>
                </div>
            </div>
        </div>


        <!-- PAGE CONTENT ENDS -->


        <div class="space-6"></div>

    </div>
    <?php
    if (auth_manager()) {
        ?>
        <div class="col-sm-12 text-center col-xs-12">
            <div id="fee" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <div id="a_p_t" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <div id="stra" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
        </div>




        <script src = "<?php echo base_url(); ?>dist/highcharts.js"></script>
        <script src="<?php echo base_url(); ?>dist/exporting.js"></script>
        <?php
        $qc = $this->db->query("SELECT SUM(paid) as paid, SUM(dues) as unpaid, MONTHNAME(date_of_payment) as date from fee where reg_no = '$r->reg_no' group by MONTH(date_of_payment)");
        $paid = json_encode(array_columnn($qc->result(), 'paid'), JSON_NUMERIC_CHECK);
        $unpaid = json_encode(array_columnn($qc->result(), 'unpaid'), JSON_NUMERIC_CHECK);

        $datee = json_encode(array_columnn($qc->result(), 'date'), JSON_NUMERIC_CHECK);
        ?>
        <script>
            $(function () {

                Highcharts.chart('fee', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Admission / Traning Fee Chart of Student <?php echo ucwords(strtolower($r->name)) ?>'
                    },

                    xAxis: {
                        categories:
    <?php echo $datee; ?>,

                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Admission / Traning Fee Chart of Student <?php echo ucwords(strtolower($r->name)) ?>'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0;"><b>{point.y:.1f} </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
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
                            name: 'Total Paid Fee',
                            data: <?php echo $paid ?>

                        },
                        {
                            name: 'Total UnPaid Fee',
                            data: <?php echo $unpaid ?>

                        },
                    ]


                });
            });


        </script>
        <?php
        $array = array("regno" => $r->reg_no);
        $this->db->where($array);
        $this->db->order_by("date", "DESC");
        $this->db->limit(1);
        $query = $this->db->get('trainer_data');


        foreach ($query->result() as
                $val) {
            ?>
            <script>
                $(function () {
                    Highcharts.chart('a_p_t', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Student Weekly Report'
                        },
                        subtitle: {
                            text: 'Source: Engr Haroon Yousaf'
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
                    Highcharts.chart('stra', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Student Overall Performance'
                        },
                        subtitle: {
                            text: 'Source: Engr Haroon Yousaf'
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

    <?php } ?>
    <div class="vspace-12-sm"></div>
</div><!-- /.row -->


