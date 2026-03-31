
<div class="row">
    <div class="col-xs-12">
             <div class="widget-box hidden-print">
            <div class="table-header">
                Search Students by Status
            </div>
            <div class="widget-body">
                <div class="widget-main">

                    <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">

                          <?php echo form_open( '', [ 'class' => 'form-horizontal' ] ); ?>

                            <div class="form-group">

                                <div class="col-xs-12 col-sm-4">

                                  <?php
                                  $data = [
                                    'data-placeholder' => "Select Student Status",
                                    'class'            => "select2",
                                    'id'               => 'status',
                                    'tabindex'         => '-1',
                                    'required'         => ''
                                  ];

                                  echo form_dropdown( 'status', $status, set_value( 'status', 1 ), $data );
                                  ?>
                                </div>

                                <div class="col-xs-12 col-sm-4">

                                    <select required name="course" class="select2">

                                        <option value="all">All Courses</option>


                                      <?php echo AdminLTE::courses(); ?>

                                    </select>

                                </div>

                                <div class="col-xs-12 col-sm-2" style="text-align: right">
                                    <input type="submit" name="submit" value="Search" class="btn btn-sm btn-success">


                                </div>
                            </div>


                          <?php echo form_close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <th>Registration No</th>
                           <th>Course</th>
                        <th>Name</th>
                     
                        <th>Father Name</th>
                            <th>Interviewer</th>
                            
                        <th>
                            Admission Date
                        </th>
                        <th>Interview Date</th>
                    
                        <th>Student Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as $r) {
                        $int_date = AdminLTE::inter_student_info($r->regno);
                        ?>
                        <tr>

                           <td> <?php echo $i ?></td>
                            <td><?php echo $r->regno ?></td>
                            <td><?php echo AdminLTE::student_course($r->course) ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))); ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_fname($r->regno))); ?></td>
                          <td><?php echo ucwords($int_date->inter_name ?? ''); ?></td>
                            <td><?php echo dateformatesformysql_fata(AdminLTE::student_data($r->regno, 'do_admission')); ?></td>
                            <td>
                            <?php
                            $int_date = AdminLTE::inter_student_info($r->regno);
                            if(!empty($int_date)){

                                echo dateformatesformysql_fata($int_date->date);
                            }else{
                              echo '';
                            }
                            ?>
                           
</td>
                            
                            
                             
                                   <td><?php
                    if (AdminLTE::student_data($r->regno, 'status')
                            == '1') {
                        echo "<span class='label label-large label-success'>Confirmed</span>";
                    } else if (AdminLTE::student_data($r->regno, 'status')
                            == '2') {
                        echo "<span class='label label-large label-warning'>Struck Off</span> <br>". AdminLTE::student_data($r->regno, 'comments');
                    } else if (AdminLTE::student_data($r->regno, 'status')
                            == '3') {
                        echo "<span class='label label-large label-grey'>Freeze</span> <br>". AdminLTE::student_data($r->regno, 'comments');
                    } else {
                        echo "<span class='label label-large label-inverse'>Pending</span>";
                    }
                    ?>	</td>
                          
                            <td>
                                <div class="hidden-sm action-buttons ">
                                     <?php if(AdminLTE::student_data($r->regno, 'status') == '0'){ ?>  
                                    
                                    <?php
                                    $data = AdminLTE::interview_info($r->regno);
                                  
                                    if(!empty($data)){
                                        ?>
                                     <a title="View Interview Form"  class="orange" href="<?php echo site_url('interviewer/view/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>
                                  
                                   
                                    <?php
                                    }else{
                                    ?>
                                     <a title="Take Interview"  class="brown" href="<?php echo site_url('interviewer/interview/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-list-alt bigger-130"></i>
                                    </a>
                                    
                                    <?php } ?>
                                   
                                    <a title="Update Interview Fee" class="green" href="<?php echo site_url('interviewer/update_fee/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                     
                                    <a title="Struck Off / Freeze Student" class="red" href="<?php echo site_url('interviewer/struckoff/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-warning bigger-130"></i>
                                    </a>
                                     <a title="Class Change / Final Interview"  class="grey" href="<?php echo site_url('interviewer/interview_final/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-list bigger-130"></i>
                                    </a>
                                    <a title="View Interview Details"  class="red" href="<?php echo site_url('interviewer/view_final/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-eye-slash bigger-130"></i>
                                    </a>
                                     <a title="Send SMS" class="purple" href="<?php echo site_url('interviewer/sms/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-phone-square bigger-130"></i>
                                    </a>
                                    <a title="View Weekly Details"  class="orange" href="<?php echo site_url('interviewer/report/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-eyedropper bigger-130"></i>
                                    </a>
                                    
                                    
                                    <?php }elseif(AdminLTE::student_data($r->regno, 'status') == '1'){  ?>
 <a title="View Interview Form"  class="orange" href="<?php echo site_url('interviewer/view/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>
                                    
                                    

                                    <a title="Update Interview Fee" class="green" href="<?php echo site_url('interviewer/update_fee/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                     
                                    <a title="Struck Off / Freeze Student" class="red" href="<?php echo site_url('interviewer/struckoff/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-warning bigger-130"></i>
                                    </a>
                                    
                                     <a title="Class Change / Final Interview"  class="grey" href="<?php echo site_url('interviewer/interview_final/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-list bigger-130"></i>
                                    </a>
                                  <a title="View Interview Details"  class="red" href="<?php echo site_url('interviewer/view_final/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-eye-slash bigger-130"></i>
                                    </a>
                                     <a title="Send SMS" class="purple" href="<?php echo site_url('interviewer/sms/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-phone-square bigger-130"></i>
                                    </a>
                                    <a title="View Weekly Details"  class="orange" href="<?php echo site_url('interviewer/report/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-eyedropper bigger-130"></i>
                                    </a>
                                     
                                    <?php }elseif(AdminLTE::student_data($r->regno, 'status') == '2' || AdminLTE::student_data($r->regno, 'status') == 3){  ?>
 <a title="View Interview Form"  class="orange" href="<?php echo site_url('interviewer/view/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>
                                    <a title="View Interview Details"  class="red" href="<?php echo site_url('interviewer/view_final/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-eye-slash bigger-130"></i>
                                    </a>
                                    <a title="Struck Off / Freeze Student" class="red" href="<?php echo site_url('interviewer/struckoff/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-warning bigger-130"></i>
                                    </a>
                                     <a title="Send SMS" class="purple" href="<?php echo site_url('interviewer/sms/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-phone-square bigger-130"></i>
                                    </a>
                                     <a title="Re-Admission"  class="orange" href="<?php echo site_url('interviewer/radm/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-adjust bigger-130"></i>
                                    </a>
                                    
                                    <?php } ?>
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
</div>