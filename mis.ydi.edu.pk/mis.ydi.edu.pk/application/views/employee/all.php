<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/employee/create'); ?>" class="btn btn-sm btn-success pull-right">
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
                        <th>CNIC</th>
                        <th>Qualification</th>
                        <th>Category</th>
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
                            <td><?php echo $r->name ?></td>
                            <td><?php echo $r->cnic ?></td>
                            <td><?php echo $r->qualification ?></td>
                            <td><?php echo $r->category ?></td>


                            <td><?php
                                if ($r->status == '1') {
                                    echo "<span class='label label-large label-success'>Active</span>";
                                } else {
                                    echo "<span class='label label-large label-inverse'>Deactive</span>";
                                }
                                ?>	</td>
                            <td>
                                <div class="hidden-sm action-buttons">
                                    <a title="View Employee Form" class="green" href="<?php echo site_url('admin/employee/view/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>

                                    <a title="Update Employee Form" class="light-grey" href="<?php echo site_url('admin/employee/edit/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    <a title="Send SMS" class="purple" href="<?php echo site_url('admin/employee/sms/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-phone-square bigger-130"></i>
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