  

 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
       <h3> 
        <i class="ace-icon fa fa-newspaper-o"></i>
         <?php echo $heading; ?> Sheet for Date: <?php echo dateformatesformysql_fata($date); ?>
        <a href="<?php echo site_url('nawaytakay/all_attend'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
             <a href="<?php echo site_url('nawaytakay/update_attend/'.$date); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-edit"></i> Update Attendance</a>
    </h3>
        </section>

        <section class="content">
		<div class="box">
		<div class="box-body">
                  
       		    <table id="" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S. NO</th>
                       <th>Name</th>
                       <th>Reg No</th>
                       <th>Attendance</th>
                       
                    </tr>
                </thead>

                <tbody>
                  
                    <?php
                    $i = 1;
                    foreach ($result as $r) {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))); ?></td>
                            <td><?php echo $r->regno; ?></td>
                            
                            <td><?php 
                    
                            $value = AdminLTE::table_data_onefield('naway_attend', 'status', array('std_id' => $r->regno, 'date' => $date));
                         if($value == 1){
                                              echo "<span class='badge badge-success'>P</span>";
                                          }else if($value == 2){
                                              echo "<span class='badge badge-warning'>A</span>";
                                          }else if($value == 3){
                                              echo "<span class='badge badge-yellow'>L</span>";
                                          }else if($value == 4){
                                              echo "<span class='badge badge-red'>N/A</span>";
                                          }else{
                                              echo "<span class='badge badge-red'>N/A</span>";
                                          }
                            
                    
                                          ?></td>
                       
                        </tr>
                        <?php
                    $i++;
                        
                                          }
                    
                    ?>
                </tbody>
            </table> 
                    
</div><!-- /.box-body -->
              </div><!-- /.box -->
			
						
		  
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->
