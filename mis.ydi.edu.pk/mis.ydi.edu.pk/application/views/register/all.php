<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?> 
        
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
                        <th>Receipt No</th>
						<th>Registration No</th>
                         <th>Course</th>
                         <th>Name</th>
                        
                        <th>Registration  Fee</th>
						<th>Monthly  Fee</th>
						<th>Interview  Fee</th>
						<th>Other  Fee</th>
                        <th>Student Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

               <tbody>
                    <?php
                    foreach ($result as $r) {
                        ?>
                        <tr>
                            <td><?php echo $r->rec_no ?></td>
							<td><?php echo $r->regno ?></td>
                            <td><?php echo AdminLTE::student_course($r->course); ?></td>
                            <td><?php echo ucwords(strtolower(AdminLTE::student_data($r->regno, "name"))); ?></td>
                            
                            
                          <?php  if ($r->fee_status == '1') {
                        echo "<td> $r->fee  &nbsp; <span class='label label-large label-success'>Paid</span></td>";
                            }else{
                                echo "<td> $r->fee &nbsp; <span class='label label-large label-inverse'>UnPaid</span></td>";
                          
                            } ?>
                          
                        <td><?php echo $r->monthly ?></td>
						<td><?php echo $r->interview ?></td>
						<td><?php echo $r->other ?></td>
                              <td><?php
                  if ($r->std_status
                            == '1') {
                        echo "<span class='label label-large label-success'>Confirmed</span>";
                    } else if ($r->std_status
                            == '2') {
                        echo "<span class='label label-large label-warning'>Struck Off</span> <br> $r->comments";
                    } else if ($r->std_status
                            == '3'){
                        echo "<span class='label label-large label-freeze'>Freeze</span>";
                    }else {
                        echo "<span class='label label-large label-inverse'>Pending</span>";
                    }
                    ?>	</td>
                             <td>
                                 <a title="Update Fee Detail"  class="warning" href="<?php echo site_url('admin/register/update/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                 <a title="Paid Registration  Fee"  class="green" href="<?php echo site_url('admin/register/paid_fee/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-paypal bigger-130"></i>
                                    </a>
                                
                                 <a title="Status Change"  class="purple" href="<?php echo site_url('admin/register/status_change/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-chain-broken bigger-130"></i>
                                    </a>
                             </td>
                        </tr>

                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>