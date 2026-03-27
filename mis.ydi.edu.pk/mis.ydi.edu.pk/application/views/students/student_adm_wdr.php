<div class="page-header text-center text-capitalize">
    <h1> 
        <img  height="30px" alt="YDI" src="<?php echo site_url('images/logo.jpg'); ?>" />
               
        
          <a onclick="window.print();" class="btn btn-sm btn-success pull-right hidden-print">
    <i class="ace-icon fa fa-print bigger-130"></i> Print </a>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="table-header hidden-print">
          Students Admission & Withdrawal Information
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                       
                        <th>Registration No</th>
                        <th>Admission Date</th>
                        <th>Name</th>
                         <th>Date of Birth</th>
                        <th>Father Name</th>
                        
                        <th>Residence</th>
                        <th>Course</th>
                        <th>Arrears Dues</th>
                        <th>Withdrawal Date</th>
                        <th>Remarks</th>
                        </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as $r) {
                      
                      
                        ?>
                        <tr>

                      
                            <td><?php echo $r->reg_no ?></td>
                            <td><?php echo date("d-m-Y", strtotime($r->do_admission)); ?></td>
                            <td><?php echo $r->name ?></td>
                            <td><?php echo date("d-m-Y", strtotime($r->dob)); ?></td>
                            <td><?php echo $r->f_name ?></td>
                            <td><?php echo $r->address ?></td>
                            <td> <?php 
                                     echo AdminLTE::student_course($r->course); ?></td>
                            <?php  
							$result2 = $this->students->find_student_fee($r->reg_no);
							if(empty($result2)){
                                  ?>
                            <td> </td>
                            <?php
                                }
                                ?>
                            <?php 
							
							foreach ($result2 as $rrr) {
                               ?>
                            <td><?php echo $rrr->dues ?></td>
                          
                            <?php } ?>
                            
                           <?php    
						   $result1 = $this->students->find_slc($r->reg_no);
						   if(empty($result1)){
                                  ?>
                            <td> </td>
                            <td> </td>
							
                            <?php
                                }
                                ?>
                            <?php  foreach ($result1 as $rr) {
                               ?>
                             
                            <td><?php echo date("d-m-Y", strtotime($rr->date)); ?></td>
                            <td><?php echo $rr->remarks ?></td>
                            <?php } ?>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
