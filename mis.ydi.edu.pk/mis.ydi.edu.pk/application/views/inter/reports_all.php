<div class="widget-box hidden-print">
    <div class="table-header">
        Search Course Wise Data
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <div id="fuelux-wizard-container">

                <div class="step-content pos-rel">

                    <?php echo form_open('', ['class' => 'form-horizontal']); ?>


                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Courses & Batch: </label>

                        <div class="col-xs-12 col-sm-9">


                            <select required name="course" class="select2">

                                <option value="" >Please Select Course & Batch </option>

                                <?php echo AdminLTE::courses(); ?>


                            </select>
                            &nbsp;  &nbsp; &nbsp; &nbsp;        <input type="submit" name="submit" value="Search" class="btn btn-lg btn-success">
                            <input type="button" name="button" value="View All" onclick="showHide()" class="btn btn-lg btn-success">


                        </div>

                    </div>





                    <?php echo form_close(); ?>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <a href="#" id="export" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-database"></i> Export to Excel</a>

        <div class="table-header">
            Manage Students
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <?php
        if (isset($_POST['submit'])) {
            $course = $this->input->post('course');
            $qq = $this->db->query("Select * from student where course = $course order by reg_no ASC");
            ?>
            <table id = "dyntableExport" class = "table table-bordered table-hover table-responsive">

                <thead>

                    <tr>
                        <th>Course</th>
                        <td><?php echo AdminLTE::student_course($course) ?></td>

                    </tr>
                    <tr>
                        <th>S.No</th>
                        <th>
                            Admission Date
                        </th>
                        <th>Name</th>
                        <th>Reg No</th>
                        <th>Batch No</th>
                        <th>Interview Date</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <?php
                $i = 1;
                foreach ($qq->result() as
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
                            <td><?php
                                $int_date = AdminLTE::table_data_onefield("interview", "date", array('regno' => $r->reg_no));
                                if(!empty($int_date)){
                                     echo dateformatesformysql_fata($int_date); 
                                }else{
                                     echo '';
                                }
                               ?></td>
                              <?php
                                if ($r->status == 1) {
                                        echo $status;
                                }else if ($r->status == 2) {
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
                                }  else {
                                    echo "<td><span class='badge badge-info'>Pending</span></td>";
                                }
                                ?>


                        </tr>
                    </tbody>

                    <?php
                    $i++;
                }
                ?>
            </table>

            <?php
        }
        ?>
        <div id = "all">

            <table id = "dyntableExport" class = "table table-bordered table-hover table-responsive">
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
                            <th>
                                Admission Date
                            </th>
                            <th>Name</th>
                            <th>Reg No</th>
                            <th>Batch No</th>
                            <th>Interview Date</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <?php
                    $q = $this->db->query("Select * from student where course = $rr->course_id  order by course ASC");
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
                                <td><?php
                                $int_date = AdminLTE::table_data_onefield("interview", "date", array('regno' => $r->reg_no));
                                if(!empty($int_date)){
                                     echo dateformatesformysql_fata($int_date); 
                                }else{
                                     echo '' ;
                                }
                               ?></td>
                                  <?php
                                if ($r->status == 1) {
                                        echo $status;
                                }else if ($r->status == 2) {
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
                                }  else {
                                    echo "<td><span class='badge badge-info'>Pending</span></td>";
                                }
                                ?>


                            </tr>
                        </tbody>

                        <?php
                        $i++;
                    }
                }
                ?>
            </table>

        </div>
    </div>
</div>
<script>
    document.getElementById('all').style.display = 'none';
    function showHide() {

        var e = document.getElementById('all');

        if (e.style.display != 'none') {
            e.style.display = 'none';
        } else {
            e.style.display = '';
        }

    }
</script>