
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        <?php echo "Dashboard of " . $this->session->user_name . " - " . $this->session->user_level ?>
        <?php
        echo date("d F, Y");
        ?>
        <a href="<?php echo site_url('trainer/printall'); ?>" class="btn btn-sm btn-success pull-right hidden-print">
            <i class="ace-icon fa fa-file-pdf-o"></i> Save Reports to PDF</a>


    </h1>

</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">


        <div class="row">
            <div class="col-sm-6 text-center col-xs-12">

                <div id="course" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
            </div>
            <?php
            $user = AdminLTE::user_data($this->session->user_id);
            $emp_course = explode(",", AdminLTE::employee_data($user, "course"));
            foreach ($emp_course as
                    $value) {
                ?>
                <div class="col-sm-6 text-center col-xs-12">

                    <div id="stra<?php echo $value ?>" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                </div>
            <?php } ?>


        </div>


        <script src="<?php echo base_url(); ?>dist/highcharts.js"></script>
        <script src="<?php echo base_url(); ?>dist/exporting.js"></script>
        <?php
         $user = AdminLTE::user_data($this->session->user_id);
         $date_year = date('Y');
         $emp_course = explode(",", AdminLTE::employee_data($user, "course"));
    
         foreach ($emp_course as
                 $value) {

            $query = $this->db->query("Select * from trainer_data where course = $value and YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) group by regno order by percentage DESC");
            if($query->num_rows() == 0){
                $query = $this->db->query("Select * from trainer_data where course = $value and YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) - 1 group by regno order by percentage DESC");
            }
            $name = array();
            $perc = array();
            $totals = array();
            $totalstra = array();
            foreach ($query->result() as
                    $value) {
                $rank = AdminLTE::rank($value->regno, $value->course);
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
                    Highcharts.chart('stra<?php echo $value->course ?>', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Top 3 Students in Course <?php echo AdminLTE::student_course($value->course) ?>'
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
        <?php } ?>


        <?php
        $user = AdminLTE::user_data($this->session->user_id);
        $emp_course = explode(",", AdminLTE::employee_data($user, "course"));
        $c = array();
        $total = array();
        foreach ($emp_course as
                $value) {
            $c[] = AdminLTE::student_course($value);

            $query = $this->db->query("Select count(*) as total from student where course = $value and status = 1");
            foreach ($query->result() as
                    $data) {
                $total[] = $data->total;
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

                        }]


                });
            });


        </script>


    </div>
</div>