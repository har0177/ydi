<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/accounts/create'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-plus-square"></i> Add New</a>
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
                        <th>Name</th>
                        <th>Month / Year</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Dues</th>
                        <th>Date of Received / Added</th>
                        <th>Status</th>
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
                            <td>
                                  <?php echo ucwords(strtolower(AdminLTE::employee_name($r->emp_id))); ?></td>
                            <td><?php echo AdminLTE::month($r->month) . "-" . $r->year ?></td>
                            <td><?php echo $r->total ?></td>

                            <td><?php echo $r->paid ?></td>
                            <td><?php echo $r->dues ?></td>
                            <td><?php echo $r->received_date . " / " . $r->date ?></td>
                            </td>



                            <td><?php
                                if ($r->status == '1') {
                                    echo "<span class='label label-large label-success'>Paid</span>";
                                }
                                else if ($r->status == '0') {
                                    echo "<span class='label label-large label-inverse'>Unpaid</span>";
                                }
                                else if ($r->status == '3') {
                                    echo "<span class='label label-large label-warning'>Partially Paid / Advance</span>";
                                }
                                else {
                                    echo "<span class='label label-large label-danger'>Dues Added to New Month</span>";
                                }
                                ?>	</td>
                            <td>
                                <?php
                                if ($r->status == '1') {
                                    ?>
                                    <a title="Update Employee Salary" class="light-grey" href="<?php echo site_url('admin/accounts/edit/' . $r->id) ?>">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i></a>
		                                <?php
                                }
                                else if ($r->status == '0' || $r->status = '3') {
                                    ?>
                                    <div class="hidden-sm action-buttons">
                                        <a title="Paid Employee Salary" class="green" href="<?php echo site_url('admin/accounts/paid/' . $r->id) ?>">
                                            <i class="ace-icon fa fa-paypal bigger-130"></i>
                                        </a>

                                        <a title="Partial / Advance Employee Salary" class="light-red" href="<?php echo site_url('admin/accounts/partial/' . $r->id) ?>">
                                            <i class="ace-icon fa fa-money bigger-130"></i>
                                        </a>

                                        <a title="Update Employee Salary" class="light-grey" href="<?php echo site_url('admin/accounts/edit/' . $r->id) ?>">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>
                                    </div>
                                <?php
                                }
                                else {
                                    echo "<span class='label label-large label-danger'>Dues Added to New Month</span>";
                                }
                                ?>

        <!--                                    <a title="Delete Employee Salary" class="red" onclick="return confirm('Are You Sure Want to Delete it?');" href="<?php echo site_url('admin/accounts/delete/' . $r->id) ?>">
                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                            </a>-->


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