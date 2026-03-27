<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-user"></i>
        Manage Fee 
        <span> <a href="<?php echo site_url('nawaytakay/create_fee'); ?>" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-plus-square"></i> Add Fee</a>
            
        </span>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Manage <?php echo $heading; ?> 
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>
            <table id="dyntable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                         <th>Month / Year</th><th>Registration  No</th><th>Name</th>
                        
                        <th>Monthly Fee</th>
                          <th>Dues</th>
                           <th>Paid</th>
                           <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

               <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as $r) {
                        ?>
                   <tr> <td> <?php echo $i ?></td>
                  
                            <td><?php
                                echo AdminLTE::month($r->month) . " - " . $r->year;
                           ?></td>
                            <td><?php echo $r->reg_no; ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_data($r->reg_no, "name"))); ?></td>
                            
                            
                            <td><?php echo $r->monthly ?></td>
                            <td><?php echo $r->dues ?></td>
                            <td><?php echo $r->paid ?></td>
                            <td><?php echo $r->date ?></td>
                            </td>


                            <?php
                    if ($r->status == '1') {
                        echo "<td><span class='label label-large label-success'>Paid</span></td>";
                        ?>
                             <td>
                                
                            </td>
                            <?php
                    } else if ($r->status == '0') {
                        echo "<td><span class='label label-large label-info'>Unpaid</span></td>";
                        ?>
                            <td>
                                <div class="hidden-sm action-buttons">
                                
                                    <a title="Paid Fee"  class="green" href="<?php echo site_url('nawaytakay/paid_fee/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-paypal bigger-130"></i>
                                    </a>

 <a title="Delete Fee"  class="red" href="<?php echo site_url('nawaytakay/delete/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-trash bigger-130"></i>
                                    </a>
                                </div>
                               

                            </td>
                            <?php
                    } else if ($r->status == '2') {
                        echo "<td><span class='label label-large label-danger'>Dues Added to New Month</span></td>";
                       ?>
                             <td>
                                
                            </td>
                            <?php
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
<?php echo $datess; ?>,

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