
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        View <?php echo $heading ?> Profile
        <a href="<?php echo site_url('nawaytakay'); ?>" class="btn btn-sm btn-success pull-right">
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

                            <?php if (AdminLTE::student_image($r->regno) == "") {
                                ?>
                            <img  class="img-responsive" width="180" height="150" alt="<?php echo AdminLTE::student_name($r->regno) ?>" src="<?php echo site_url('images/profile.png'); ?>" />
                            <?php } else { ?>
                                <img  class="img-responsive" width="180" height="150" alt="<?php echo AdminLTE::student_name($r->regno) ?>" src="<?php echo site_url('images/' . AdminLTE::student_image($r->regno)); ?>" />
                            <?php } ?>
                        </span>

                        <div class="space-4"></div>

                        <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                            <div class="inline position-relative">
                                <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                    <i class="ace-icon fa fa-circle light-green"></i>
                                    &nbsp;
                                    <span class="white"><?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))); ?></span>
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
                                <span class="editable" id="username"><?php echo $r->regno ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Admission Date </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="signup"><?php echo dateformatesformysql_fata($r->date); ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Courses </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="about"><?php
                                    echo strtoupper(AdminLTE::student_course(AdminLTE::student_data($r->regno, "course"))) . "<br>"
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
                                    <span class="editable" id="username"><?php echo ucwords(strtolower(AdminLTE::student_fname($r->regno))); ?></span>
                                </div>
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
 
        <div class="col-sm-12 text-center col-xs-12">
            <div id="fee" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
        </div>
  


        <script src = "<?php echo base_url(); ?>dist/highcharts.js"></script>
        <script src="<?php echo base_url(); ?>dist/exporting.js"></script>
        <?php
        $qc = $this->db->query("SELECT SUM(paid) as paid, SUM(dues) as unpaid, month as date from naway_fee where reg_no = '$r->regno' group by month");
        $paid = json_encode(array_columnn($qc->result(), 'paid'), JSON_NUMERIC_CHECK);
        $unpaid = json_encode(array_columnn($qc->result(), 'unpaid'), JSON_NUMERIC_CHECK);

        $datee = array();
        foreach ($qc->result() as
                $fdata) {
        
            $datee[] = date("F", mktime(0, 0, 0, $fdata->date, 10));
        }
        ?>
        <script>
            $(function () {

                Highcharts.chart('fee', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Fee Chart of Student <?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))) ?>'
                    },

                    xAxis: {
                        categories:
    <?php echo json_encode($datee); ?>,

                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Fee Chart of Student <?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))) ?>'
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
    

