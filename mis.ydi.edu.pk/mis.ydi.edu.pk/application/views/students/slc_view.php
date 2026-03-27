<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-certificate"></i>
         Certificate Detail
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Certificate Detail
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Registration No</th>
                        <th>Remarks</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($result as $r) {
                        ?>
                        <tr>

                            <td><?php echo AdminLTE::student_name($r->regno) ?></td>
                            <td><?php echo $r->regno ?></td>
                            <td><?php echo $r->remarks ?></td>
                            <td><?php echo date("d-m-Y", strtotime($r->date)); ?></td>
                            <td>
                                <div class="hidden-sm action-buttons">
                                    <a class="green" href="<?php echo site_url('admin/students/print_slc/' . $r->regno) ?>">
                                        <i class="ace-icon fa fa-print bigger-130"></i>
                                    </a>
                                </div>

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