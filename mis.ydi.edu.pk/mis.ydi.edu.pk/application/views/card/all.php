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
                    <tr><th>S.No</th>
                        <th>Course</th>
                        <th>Registration No</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Student Status</th>
                         <th>Card Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as $r) {
                        ?>
                        <tr>
 <td> <?php echo $i ?></td>
                            <td><?php echo AdminLTE::student_course($r->course) ?></td>
                            <td><?php echo $r->reg_no ?></td>
                            <td><?php echo ucwords(strtolower($r->name ?? '')); ?></td>
                            <td><?php echo ucwords(strtolower($r->f_name ?? '')); ?></td>
                           
                            
                           

                            <td><?php
                    if ($r->status
                            == '1') {
                        echo "<span class='label label-large label-success'>Confirmed</span>";
                    } else if ($r->status
                            == '2') {
                        echo "<span class='label label-large label-warning'>Struck Off</span> <br> $r->comments";
                    } else {
                        echo "<span class='label label-large label-inverse'>Pending</span>";
                    }
                    ?>	</td>
                            <td><?php
                    if ($r->card_status
                            == '1') {
                        echo "<span class='label label-large label-success'>Issued</span>";
                    } else {
                        echo "<span class='label label-large label-inverse'>Not Issued</span>";
                    }
                    ?>	</td>
                            <td>
                                <div class="hidden-sm action-buttons">
                                   
                                    <a title="Student Card" class="green" href="<?php echo site_url('cardmaker/card/' . $r->reg_no) ?>">
                                        <i class="ace-icon fa fa-picture-o bigger-130"></i>
                                    </a>
                                     <a title="Issue Card" class="grey" href="<?php echo site_url('cardmaker/issue/' . $r->reg_no) ?>">
                                        <i class="ace-icon fa fa-paypal bigger-130"></i>
                                    </a>


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