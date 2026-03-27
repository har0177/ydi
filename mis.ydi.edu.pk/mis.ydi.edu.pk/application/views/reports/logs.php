
<div class="row">
    <div class="col-xs-12">
        <a href="#" id="export" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-database"></i> Export to Excel</a>

        <div class="table-header">
            Manage Message Logs Last 7 Days
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->

        <div>

            <table id="dyntableExport" class="table table-bordered table-hover table-responsive">

                <thead>

                    <tr>
                        <th>S.No</th>
                           
                        <th>
                            Contact No
                        </th>
                       
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <?php
                if ($this->session->user_level == "Manager") {
                    $q = $this->db->query("Select * from logs where date >= (CURDATE() - INTERVAL 7 DAY )order by date DESC");
                } else {
                    $q = $this->db->query("Select * from logs where from_user = " . $this->session->user_id . "  and date >= (CURDATE() - INTERVAL 7 DAY )order by date DESC");
                }

                $i = 1;
                foreach ($q->result() as
                        $r) {
                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $i ?></td>
                          
                            
                            <td><?php echo $r->contact ?></td>
                        
                            <td><?php echo $r->msg ?></td>
                            <td><?php echo dateformatesformysql_fata($r->date) ?></td>

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