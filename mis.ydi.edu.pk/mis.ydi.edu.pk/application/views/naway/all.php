
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        Students List of Naway Takay
         <span> <a href="<?php echo base_url("nawaytakay/all_reports"); ?>" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-print"></i> All Reports</a>
            
        </span>
    </h1>
</div><!-- /.page-header -->

<div class="row">
        <?php echo form_open('', ['class' => 'form-horizontal']); ?>

            <div class="form-group col-lg-6 col-md-6 col-xs-6 col-sm-6">
                <label class="control-label col-xs-3 col-sm-3 no-padding-right" for="status">Search Student</label>

                <div class="col-xs-9 col-sm-9">
                    <input type="number" style="height: 30px" class="form-control" name="regno" id="" placeholder="Enter Registeration No">
                </div>
            </div>

            <div class="form-group col-lg-3 col-md-3 col-xs-3 col-sm-3">
                <label>
                    <input type="submit" id="submit" name="submit" value="Search" class="btn btn-sm btn-success">
                     
                </label>
                <label>
                     <a href="<?php echo site_url('nawaytakay/all'); ?>" class="btn btn-sm btn-success">  
            View All</a>
                </label>
               

            </div>
            

            <?php echo form_close(); ?>
            
            
            <?php
            if(isset($_POST['submit'])){
                  $regno = $this->input->post('regno', TRUE);

$search = $this->db->query("Select * from naway where regno = $regno")->row();
if(!empty($search)){
                ?>
                  <div class="col-xs-12">
        
        <div class="table-header">
            Manage <?php echo $heading; ?> Details
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        
        
        <div>

            <table id="" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                      
                        <th>Registration No</th>
                        <th>Course</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Admission Date</th>
                        <th>Fee</th>
                        <th>Student Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                  
                        <tr>
                            <td><?php echo $search->regno ?></td>
                            <td><?php echo AdminLTE::student_course(AdminLTE::student_data($search->regno, "course")) ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_name($search->regno))); ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_fname($search->regno))); ?></td>
                            </td>
                            <td><?php echo dateformatesformysql_fata($search->date) ?></td>
                               <td><?php echo $search->fee ?></td>

                            <td><?php
                                if (AdminLTE::naway_data($search->regno, 'status') == '1') {
                                    echo "<span class='label label-large label-success'>Confirmed</span>";
                                }
                                else if (AdminLTE::naway_data($search->regno, 'status') == '2') {
                                    echo "<span class='label label-large label-warning'>Struck Off</span> <br>" . AdminLTE::naway_data($search->regno, 'comments');
                                }else if (AdminLTE::naway_data($search->regno, 'status') == '3') {
                                    echo "<span class='label label-large label-yellow'>Freeze</span> <br>" . AdminLTE::naway_data($search->regno, 'comments');
                                }
                                else {
                                    echo "<span class='label label-large label-inverse'>Pending</span>";
                                }
                                ?>	</td>

                            <td>
                                
                                <div class="hidden-sm action-buttons">
								 <a title="Update Student Form" class="green" href="<?php echo site_url('nawaytakay/update_student/' . $search->regno) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    
                                    <a title="View Student Form" class="green" href="<?php echo site_url('nawaytakay/view_student/' . $search->regno) ?>">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>
                                    
  <a title="Send SMS" class="purple" href="<?php echo site_url('nawaytakay/sms/' . $search->regno) ?>">
                                        <i class="ace-icon fa fa-phone-square bigger-130"></i>
                                    </a>
 <a title="Struck Off Student" class="red" href="<?php echo site_url('nawaytakay/struckoff/' . $search->regno) ?>">
                                                <i class="ace-icon fa fa-warning bigger-130"></i>
                                            </a>
                                    
									                                    <?php
                                    $data = AdminLTE::monthly_report_info($search->regno);

                                    if (empty($data)) {
                                        ?>
                                       <a title="Add Monthly Report" class="pink" href="<?php echo site_url('nawaytakay/monthly_report/' . $search->regno) ?>">
                                                <i class="ace-icon fa fa-pie-chart bigger-130"></i>
                                            </a>
                                        <a title="Monthly Report View" class="green" href="<?php echo site_url('nawaytakay/monthly_view/' . $search->regno) ?>">
                                            <i class="ace-icon fa fa-eye bigger-130"></i>
                                        </a>
                                    <?php } else {
                                        ?>
                                        <a title="Monthly Report View" class="green" href="<?php echo site_url('nawaytakay/monthly_view/' . $search->regno) ?>">
                                            <i class="ace-icon fa fa-eye bigger-130"></i>
                                        </a>
                                    <?php }
                                    ?>
                                     
                                   
                                  


                                </div>

                            </td>
                        </tr>
                       
                </tbody>
            </table>

        </div>
    </div>
                
                <?php
}else{
    set_flash_alert("No Record Found!", "danger");
    redirect("nawaytakay/all");
}
            }else{
                
            
            ?>
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
                        <th>Admission Date</th>
                        <th>Fee</th>
                        <th>Student Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as
                            $r) {
                       ?>
                        <tr>

                            <td> <?php echo $i ?></td>
                            <td><?php echo $r->regno ?></td>
                            <td><?php echo AdminLTE::student_course(AdminLTE::student_data($r->regno, "course")) ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))); ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_fname($r->regno))); ?></td>
                            </td>
                            <td><?php echo dateformatesformysql_fata($r->date) ?></td>
                               <td><?php echo $r->fee ?></td>

                            <td><?php
                                if (AdminLTE::naway_data($r->regno, 'status') == '1') {
                                    echo "<span class='label label-large label-success'>Confirmed</span>";
                                }
                                else if (AdminLTE::naway_data($r->regno, 'status') == '2') {
                                    echo "<span class='label label-large label-warning'>Struck Off</span> <br>" . AdminLTE::naway_data($r->regno, 'comments');
                                }else if (AdminLTE::naway_data($r->regno, 'status') == '3') {
                                    echo "<span class='label label-large label-yellow'>Freeze</span> <br>" . AdminLTE::naway_data($r->regno, 'comments');
                                }
                                else {
                                    echo "<span class='label label-large label-inverse'>Pending</span>";
                                }
                                ?>	</td>

                            <td>
                                
                                <div class="hidden-sm action-buttons">
								 <a title="Update Student Form" class="green" href="<?php echo site_url('nawaytakay/update_student/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    
                                    <a title="View Student Form" class="green" href="<?php echo site_url('nawaytakay/view_student/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>
                                    
  <a title="Send SMS" class="purple" href="<?php echo site_url('nawaytakay/sms/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-phone-square bigger-130"></i>
                                    </a>
 <a title="Struck Off Student" class="red" href="<?php echo site_url('nawaytakay/struckoff/' . $r->regno) ?>">
                                                <i class="ace-icon fa fa-warning bigger-130"></i>
                                            </a>
                                    
									                                    <?php
                                    $data = AdminLTE::monthly_report_info($r->regno);

                                    if (empty($data)) {
                                        ?>
                                       <a title="Add Monthly Report" class="pink" href="<?php echo site_url('nawaytakay/monthly_report/' . $r->regno) ?>">
                                                <i class="ace-icon fa fa-pie-chart bigger-130"></i>
                                            </a>
                                        <a title="Monthly Report View" class="green" href="<?php echo site_url('nawaytakay/monthly_view/' . $r->regno) ?>">
                                            <i class="ace-icon fa fa-eye bigger-130"></i>
                                        </a>
                                    <?php } else {
                                        ?>
                                        <a title="Monthly Report View" class="green" href="<?php echo site_url('nawaytakay/monthly_view/' . $r->regno) ?>">
                                            <i class="ace-icon fa fa-eye bigger-130"></i>
                                        </a>
                                    <?php }
                                    ?>
                                     
                                   
                                  


                                </div>

                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    
                    ?>
                </tbody>
            </table>

        </div>
    </div>
    
    <?php } ?>
</div>