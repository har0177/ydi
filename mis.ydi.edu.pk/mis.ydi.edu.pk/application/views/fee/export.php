<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?> List
        <span>
            <a href="#" id="export" class="btn btn-sm btn-success pull-right">
                <i class="ace-icon fa fa-database"></i> Export to Excel</a>

        </span>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Manage <?php echo $heading; ?>  List
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>
            <table id="dyntableExport" class="table table-striped table-bordered table-hover">
                <?php
                $class = AdminLTE::fetch("courses");
                foreach ($class as
                        $rr) {
                    ?>
                    <thead>

                        <tr>
                            <th>Course</th>
                            <td><?php echo AdminLTE::student_course($rr->course_id) ?></td>

                        </tr>
                        <tr>
                            <th>S.No</th>
                            <th>Receipt No</th>
                            <th>Course</th>
                            <th>Month / Year</th><th>Registration  No</th><th>Name</th>
                            <th>Adm Date </th>
                            <th>Monthly Fee</th>
                            <th>Dues</th>
                            <th>Date of Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $result = $this->db->query("Select * from fee where course = $rr->course_id and status = 0 order by course ASC");
                        $i = 1;

                        foreach ($result->result() as
                                $r) {
                            ?>
                            <tr> <td> <?php echo $i ?></td><td><?php echo $r->rec_no ?></td>
                                <td><?php echo AdminLTE::student_course($r->course) ?></td>
                                <td><?php
                    if ($r->status_1p == 1) {
                        echo AdminLTE::month($r->month) . " - " . $r->year . " - " . "1st Time Payment";
                    } else {
                        echo AdminLTE::month($r->month) . " - " . $r->year;
                    }
                            ?></td>
                                <td><?php echo $r->reg_no; ?></td>
                                <td><?php echo ucwords(strtolower(AdminLTE::student_data($r->reg_no, "name"))); ?></td>

                                <th><?php echo dateformatesformysql_fata(AdminLTE::student_data($r->reg_no, "do_admission")); ?></th>
                                <td><?php echo $r->monthly ?></td>
                                <td><?php echo $r->dues ?></td>
                                <td><?php echo dateformatesformysql_fata($r->date_of_payment); ?></td>


                                <td><span class='label label-large label-info'>Unpaid</span></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
</div>