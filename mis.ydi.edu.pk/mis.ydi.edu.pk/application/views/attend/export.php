

     <div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?> 
        <span>     <a href="<?php echo site_url('admin/attendance'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
            <a href="#" id="export" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-database"></i> Export to Excel</a>
   
           <a href="<?php echo site_url('admin/attendance/search'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-list"></i> Add Attendance</a>
   
           


        </span>
    </h1>
</div><!-- /.page-header -->
<div class="widget-box hidden-print">
    <div class="table-header">
        Search Course Wise Data
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <div id="fuelux-wizard-container">

                <div class="step-content pos-rel">

                    <?php echo form_open('', ['class' => 'form-horizontal']); ?>


                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Courses & Batch: </label>

                        <div class="col-xs-12 col-sm-9">


                            <select required name="course" class="select2">

                                <option value="" >Please Select Course & Batch </option>

                                <?php echo AdminLTE::courses(); ?>


                            </select>
                            &nbsp;  &nbsp; &nbsp; &nbsp;        <input type="submit" name="submit" value="Search" class="btn btn-lg btn-success">


                        </div>

                    </div>





                    <?php echo form_close(); ?>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
        <div class="table-header">
            Manage <?php echo $heading; ?> of Year <?php echo  date('Y'); ?>
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
     

       		    <table id="dyntableExport" class="table table-responsive table-condensed table-responsive">
                         <?php
                     

            if (isset($_POST['submit'])) {
                $course = $this->input->post('course');
                ?>
                      
                <thead>
                    
                 
                    <tr>
                    
                            <th colspan="2">Course</th>
                        <td><?php echo AdminLTE::student_course($course); ?></td>
                    
                        <th >Jan</th><th></th><th></th>
                        <th >Feb</th><th></th><th></th>
                         <th >Mar</th><th></th><th></th>
                          <th >Apr</th><th></th><th></th>
                           <th >May</th><th></th><th></th>
                            <th >Jun</th> <th></th><th></th>
                            <th >Jul</th><th></th><th></th>
                             <th >Aug</th><th></th><th></th>
                              <th >Sept</th><th></th><th></th>
                               <th >Oct</th><th></th><th></th>
                                <th >Nov</th><th></th><th></th>
                                 <th >Dec</th><th></th><th></th>
                    </tr>
                    <tr>
                        <th>S.NO</th>
                        <th>Name</th>
                       <th>Reg No</th>
                       
                                <?php
                                for($i = 01; $i <= 12; $i++) {
         echo "<th> P </th><th> A </th> <th> L </th> ";  
        }
                                ?>
                            </tr>
                            
                    
                </thead>
  <?php
  
  $result = AdminLTE::fetchall('student', '', '', 'course ='.$course.' and status =1', '');
  $i=1;                 
  foreach ($result as $r) {
                        $id = $r['reg_no'];
                        						   $mezaan = '';
                        ?>
                <tbody>
                  
                   
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo ucwords(strtolower($r['name'] ?? '')); ?></td>
                            <td><?php echo $r['reg_no']; ?></td>
                            
                          <?php
                          for ($l = 01; $l <= 12; $l++) {
                              
                              for ($k = 1; $k <= 3; $k++) {    
                                $this->db->select('Count(status) as total');
                                $array = array('course_id' => $r['course'], 'std_id' => $id, 'status' => $k, 'Month(date)'=> $l, 'Year(date)'=> date('Y'));
        $this->db->where($array);
        $query = $this->db->get('attend');
                              
                     if ($query->num_rows() > 0) {
            $ttend = $query->result();
                     
                  	   foreach ($ttend as $status) {
                               echo "<td>"; 
                                echo $status->total;
					   
                                echo"</td>";
                     } } else {
                         echo "<td>0</td>";
                                                   
                                                            ?>
                                                    <td> </td> 
                                                            <?php
                          } }}                           
                                                    
                        ?>
                        </tr>
                           
                </tbody>
                 
                   <?php 
                    $i++;
                    }}
                    ?>
                
            </table> 
             
     
</div>
    </div>
