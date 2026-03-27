
<div class="row">
    <div class="col-xs-12">
        <a href="#" id="export" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-database"></i> Export to Excel</a>

        <div class="table-header">
            Manage Student Logs
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->

        <div>

            <table id="dyntableExport" class="table table-bordered table-hover table-responsive">

                <thead>

                    <tr>
                        <th>S.No</th>
                        <th>
                            Reg No
                        </th>
                        <th>Login</th>
                        <th>Logout</th>
                    </tr>
                </thead>
                <?php
                    $q = $this->db->query("Select * from log_details order by id DESC");
                

                $i = 1;
                foreach ($q->result() as
                        $r) {
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $r->regno ?></td>
                            <td><?php echo $r->login ?></td>
                            <td><?php echo $r->logout ?></td>

                        </tr>
                    </tbody>

                    <?php
                    $i++;
                }
                ?>
            </table>

        </div>
    </div>
</div>