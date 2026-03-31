

<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?>
        <span>     <a href="<?php echo site_url('admin/attendance'); ?>" class="btn btn-sm btn-success pull-right">
                <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
            <a href="#" id="export" class="btn btn-sm btn-success pull-right">
                <i class="ace-icon fa fa-database"></i> Export to Excel</a>
            <a href="<?php echo site_url('admin/attendance/search'); ?>" class="btn btn-sm btn-success pull-right">
                <i class="ace-icon fa fa-list"></i> Add Attendance</a>



        </span>
    </h1>
</div><!-- /.page-header -->
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
        <div class="table-header">
            Manage <?php echo $heading; ?> of the Month <?php echo date('F') . " - " . date('Y'); ?>
        </div>
        <div>

            <table id="dyntableExport" class="table table-bordered table-condensed table-responsive">
            <?php
            if (isset($_POST['submit'])) {
                $course = $this->input->post('course');
                ?>
                <thead>

                    <tr>
                        <th>Course</th>
                        <td><?php echo AdminLTE::student_course($course) ?></td>

                    </tr>
                    <tr>
                        <th>S.NO </th>
                        <th>Name</th>
                        <th>Roll No</th>

                        <?php
                        for ($th = 01;
                                $th <= 31;
                                $th++) {
                            ?>
                            <th> <?php
                                if ($th < 10) {
                                    echo('0' . $th);
                                } else {
                                    echo($th);
                                }
                                ?> </th>
                        <?php }//end for loop   ?>
                        <th> P </th><th> A </th><th> L </th>
                    </tr>
                </thead>
                <?php
                $result = AdminLTE::fetchall('student', '', '', 'course =' . $course .' and status = 1', '');
                $i = 1;
                foreach ($result as
                        $r) {
                    $id = $r['reg_no'];
                    $hazir = 0;
                    $bemar = 0;
                    $ghairHazir = 0;
                    $rokhsat = 0;
                    $mezaan = '';
              
                    ?>
                    <tbody>


                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo ucwords(strtolower($r['name'] ?? '')); ?></td>
                            <td><?php echo $r['reg_no']; ?></td>

                            <?php
                            for ($k = 01;
                                    $k <= 31;
                                    $k++) {


                               // $this->db->select('status');
                            $this->db->select('DISTINCT(std_id), status');
                                $array = array('course_id' => $course, 'std_id' => $id, 'Day(date)' => $k, 'Month(date)' => date('m'), 'Year(date)' => date('Y'));
                                $this->db->where($array);
                                $query = $this->db->get('attend');
                                if ($query->num_rows() > 0) {
                                    $ttend = $query->result();
                                    foreach ($ttend as
                                            $status) {

                                        echo "<td>";

                                        if ($status->status == 1) {
                                            echo $att = ('<span class="badge badge-success" style="font-size:8px; font-weight: bold">P</span>');
                                            ?>

                                            <?php
                                            $hazir += 1;
                                        } else if ($status->status == 2) {
                                            echo $att = ('<span class="badge badge-warning" style="font-size:8px; font-weight: bold">A</span>');
                                            ?>

                                            <?php
                                            $ghairHazir += 1;
                                        } else if ($status->status == 3) {
                                            echo $att = ('<span class="badge badge-yellow" style="font-size:8px; font-weight: bold">L</span>');
                                            ?>

                                            <?php
                                            $rokhsat += 1;
                                        } 
                                    }
                                    echo"</td>";
                                } else {
                                    ?>
                                    <td> </td>
                                    <?php
                                }
                            }
                            echo "<td> $hazir </td><td> $ghairHazir </td> <td> $rokhsat </td>";
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
