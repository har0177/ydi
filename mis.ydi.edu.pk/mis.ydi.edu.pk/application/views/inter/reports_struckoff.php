<div class="widget-box hidden-print">
    <div class="table-header">
        Search Report
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <div id="fuelux-wizard-container">

                <div class="step-content pos-rel">

                    <?php echo form_open('', ['class' => 'form-horizontal']); ?>

                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Month</label>

                        <div class="col-xs-12 col-sm-9">
                            <?php
                            $month = AdminLTE::months();
                            $data2 = array(
                                'data-placeholder' => "Select Month",
                                'class' => "select2",
                                'id' => 'month',
                                'tabindex' => '-1',
                                'required' => ''
                            );

                            //$options = $tmp;
                            echo form_dropdown('month', $month, set_value('month'), $data2);
                            ?>
                        </div>
                    </div>

                   


                    <div class="hr hr-dotted"></div>

                    <div class="form-group">
                        <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                            <label>
                                <input type="submit" name="submit" value="Search" class="btn btn-lg btn-success">
                            </label>
                        </div>
                    </div>



                    <?php echo form_close(); ?>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
</div>
<?php
if (isset($_POST['submit'])) {
    $month = $this->input->post('month', TRUE);
    ?>
    <div class="row">
        <div class="col-xs-12">
            <a href="#" id="export" class="btn btn-sm btn-success pull-right">
                <i class="ace-icon fa fa-database"></i> Export to Excel</a>

            <div class="table-header">
                Manage Drop Out of Month <?php echo AdminLTE::month($month) ?>
            </div>
            <!-- div.table-responsive -->
            <!-- div.dataTables_borderWrap -->

            <div>

                <table id="dyntableExport" class="table table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>
                                Admission Date
                            </th>
                            <th>Name</th>
                            <th>Reg No</th>
                            <th>Batch No</th>
                            <th>Interview Date</th>
							 <th>StruckOff Date</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <?php
                    $q = $this->db->query("Select do_admission, dates, status, name, reg_no, course, comments from student where status IN (2,3) and  MONTH(dates) =" . $month . " and YEAR(dates) =" . date('Y') . "");
                    if ($q->num_rows() > 0) {
                        $i = 1;
                        foreach ($q->result() as
                                $r) {
                            $absent = AdminLTE::count_lastweek("status", 2, $r->reg_no);
                            $status = "";
                            if ($absent >= 3) {
                                $status = "<td><span class='badge badge-inverse'>Irregular</span></td>";
                            } else {
                                $status = "<td><span class='badge badge-success'>Regular</span></td>";
                            }
                            ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo dateformatesformysql_fata($r->do_admission) ?></td>
                                    <td><?php echo strtoupper($r->name) ?></td>
                                    <td><?php echo $r->reg_no ?></td>
                                    <td><?php echo strtoupper(AdminLTE::student_course($r->course)); ?></td>
                                    <td><?php echo dateformatesformysql_fata(AdminLTE::table_data_onefield("interview", "date", array('regno' => $r->reg_no))) ?></td>
									<td><?php echo dateformatesformysql_fata($r->dates) ?></td>
                                       <?php
                               
                                       if ($r->status == 2) {
                                        echo "<td><span class='badge badge-danger'>"; 
                                        if(empty($r->comments)){
                                            echo "StruckOff";
                                        }else{
                                          echo $r->comments;  
                                        } 
                                        echo"</span></td>";
                                }else if ($r->status == 3) {
                                        echo "<td><span class='badge badge-yellow'>"; 
                                        if(empty($r->comments)){
                                            echo "Freeze";
                                        }else{
                                          echo $r->comments;  
                                        } 
                                        echo"</span></td>";
                                } 
                                ?>

                                </tr>
                            </tbody>

                            <?php
                            $i++;
                        }
                    } else {
                        set_flash_alert("No Data Found", "danger");
                    }
                    ?>
                </table>

            </div>
        </div>
    </div>
    <?php
} ?>