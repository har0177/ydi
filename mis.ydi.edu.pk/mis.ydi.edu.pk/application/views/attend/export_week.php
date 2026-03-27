

<div class="page-header hidden-print">
    <h1> 
        <i class="ace-icon fa fa-sun-o"></i>
        Weekly <?php echo $heading; ?> 
        <span>     <a href="<?php echo site_url('admin/attendance/search_week'); ?>" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
            <a href="#" id="export" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-database"></i> Export to Excel</a>
            <a href="<?php echo site_url('admin/attendance/search'); ?>" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-list"></i> Add Attendance</a>



        </span>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Weekly <?php echo $heading; ?>  
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>  
            <table id="dyntableExport" class="table table-bordered table-condensed">
                
                    <thead>

                        <tr>
                            <th>Course</th>
                            <td><?php echo AdminLTE::student_course($course) ?></td>
                             
                              

                        </tr>
                        <tr>
                      
                            <th>From</th>
                            <td><?php echo  dateformatesformysql_fata($from); ?></td>
                            <th>To</th>
                            <td><?php echo  dateformatesformysql_fata($to); ?></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <th>Total Students</th>
                               <th> P </th><th> A </th><th> L </th>
                        </tr>
                    </thead>
                   
 <?php 
                    foreach ($result as $r) {
     
                    ?>
                    <?php
                  
                        $hazir = 0;
                        $bemar = 0;
                        $ghairHazir = 0;
                        $rokhsat = 0;
                        $mezaan = '';
                        ?>
                        <tbody>


                            <tr>
                                <td><?php echo date('l, F jS, Y', strtotime($r->date)) ; ?></td>
                                <td><?php echo $r->std; ?></td>
<?php
                                 //$this->db->select('status');
                                $this->db->select('DISTINCT(std_id), status');
       $array = array('course_id' => $course, 'DayNAME(date)' => $r->name, 'date' => $r->date);
                                    $this->db->where($array);
                                    $query = $this->db->get('attend');
                                    if ($query->num_rows() > 0) {
                                        $ttend = $query->result();
                                        foreach ($ttend as $status) {

                                          

                                            if ($status->status == 1) {
                                                $hazir += 1;
                                            } else if ($status->status == 2) {
                                               
                                                $ghairHazir += 1;
                                            } else if ($status->status == 3) {
                                               
                                                $rokhsat += 1;
                                            } 
                                        }
                                      
                                    } else {
                                        ?>
                                        <td> </td> 
                                         <td> </td> 
                                         <td> </td> 
                                         
                                        <?php
                                    }
                                
                                echo "<td> $hazir </td><td> $ghairHazir </td><td> $rokhsat </td>";
                                ?>
                            </tr>

                        </tbody>
                       <?php
                    
                }
                ?> 
            </table> 
            
 <div  class="col-sm-12 text-center">

                <div id="attend" style="min-width: 300px; height: 400px; margin: 0 auto"></div>

            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>dist/highcharts.js"></script>
<script src="<?php echo base_url(); ?>dist/exporting.js"></script>
<?php 
 $hazir = array();
                      
                        $ghairHazir = array();
                        $rokhsat = array();
                        $mezaan = '';
                        $date = array();
                        $std = array();
                        $h = 0;
                        $gh = 0;
                        $rk = 0;
foreach($result as $r){
                    
                     $this->db->select('DISTINCT(std_id), status');
       $array = array('course_id' => $course, 'DayNAME(date)' => $r->name, 'date' => $r->date);
                                    $this->db->where($array);
                                    $query = $this->db->get('attend');
                                    if ($query->num_rows() > 0) {
                                        $ttend = $query->result();
                                        foreach ($ttend as $status) {
 if ($status->status == 1) {
                                                $h += 1;
                                            } else if ($status->status == 2) {
                                               
                                                $gh += 1;
                                            } else if ($status->status == 3) {
                                               
                                                $rk += 1;
                                            } 
                                        }
                                      
                                    } 
                                    $hazir[] = $h;
                                    $ghairHazir[] = $gh;
                                    $rokhsat[] = $rk;
                                    $date[] = date('l, M jS, Y', strtotime($r->date));
                                    $std[] = $r->std; 
                                    $h = 0;
                        $gh = 0;
                        $rk = 0;
                                         
                }
                   
?>
    <script>
        $(function () {
            Highcharts.chart('attend', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Student Attendance Report'
                },
                subtitle: {
                    text: '<?php echo AdminLTE::student_course($course); ?>'
                },
                
                xAxis: {
                    categories: 
                        <?php echo json_encode($date); ?>
                                
                    ,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Student Attendance Report'
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
                series: [ {
                        name: 'Total Students',
                        data: 
    <?php echo json_encode($std, JSON_NUMERIC_CHECK) ?>
                                
                    }, {
                        name: 'Present',
                        data: <?php echo json_encode($hazir) ?>    
                    }, {
                        name: 'Absent',
                        data: <?php echo json_encode($ghairHazir) ?>
                                
                    }, {
                        name: 'Leave',
                        data: <?php echo json_encode($rokhsat) ?>
                                
                    }]
                        
                        
            });
        });
        
        
    </script>
    


 
