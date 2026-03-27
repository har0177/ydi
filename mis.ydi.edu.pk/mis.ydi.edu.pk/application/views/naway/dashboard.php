
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
            Manage <?php echo $heading; ?> Details
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
                       $data = AdminLTE::naway_info($r->regno);
if(empty($data)){
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
                                }
                                else if (AdminLTE::student_data($r->regno, 'status') == '2') {
                                    echo "<span class='label label-large label-warning'>Struck Off</span> <br>" . AdminLTE::student_data($r->regno, 'comments');
                                }
                                else {
                                    echo "<span class='label label-large label-inverse'>Pending</span>";
                                }
                                ?>	</td>

                            <td>
                                <div class="hidden-sm action-buttons">


                                    <a title="Add Student" class="green" href="<?php echo site_url('nawaytakay/add/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-plus-circle bigger-130"></i>
                                    </a>


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

        </div>
         <div class="col-sm-12 text-center col-xs-12">
                    <div id="reg" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                </div>
    </div>
</div>
<script src = "<?php echo base_url(); ?>dist/highcharts.js"></script>
        <script src="<?php echo base_url(); ?>dist/exporting.js"></script>
       
           
<script>
                $(function () {

                    Highcharts.chart('reg', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Fee / Expenses / Revenue Detail'
                        },
                        subtitle: {
                            text: 'Source: Engr Haroon Yousaf'
                        },

                        xAxis: {
                            categories:
<?php echo json_encode($datess); ?>,

                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Fee / Expenses / Revenue Detail'
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
                                name: 'Admission Fee',
                                data: <?php echo json_encode($adm, JSON_NUMERIC_CHECK); ?>

                            },  {
                                name: 'Monthly Fee',
                                data: <?php echo json_encode($radm, JSON_NUMERIC_CHECK); ?>

                            }, {
                                name: 'Expenses',
                                data: <?php echo json_encode($daily, JSON_NUMERIC_CHECK); ?>

                            }, {
                                name: 'Revenue',
                                data: <?php echo json_encode($revenue, JSON_NUMERIC_CHECK); ?>

                            }


                        ]


                    });
                });


            </script>