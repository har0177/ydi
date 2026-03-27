  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> 
            <i class="ace-icon fa fa-newspaper-o"></i>
            Make New <?php echo $heading; ?> Sheet of Course <?php echo AdminLTE::student_course($course) ?> for Date: <?php echo dateformatesformysql_fata($date); ?>
            <a href="<?php echo site_url('trainer'); ?>" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
        </h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <?php echo form_open('trainer/update_attend/'.$course.'/'.$date, ['class' => 'form-horizontal']); ?>
                
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr><th>S.No</th>
                            <th>Name</th>
                            <th>Reg No</th>
                            <th>Attendance</th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $i = 1;
                        foreach ($result as $r) {
                            $status = $r->status;
                            
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo AdminLTE::student_name($r->std_id); ?></td>
                                <td><?php echo $r->std_id; ?></td>

                        <input class="form-control" type="hidden" name="id[]"  value="<?php echo $r->std_id; ?>"/>
                        <td><input type="radio" value="1" <?php echo ($status== 1) ?  "checked" : "" ;  ?> name="attend[<?php echo $r->std_id ?>][]" > Present  
                            &nbsp;&nbsp; <input type="radio" <?php echo ($status== 2) ?  "checked" : "" ;  ?> value="2" name="attend[<?php echo $r->std_id ?>][]">Absent
                            &nbsp;&nbsp; <input type="radio" value="3" <?php echo ($status== 3) ?  "checked" : "" ;  ?> name="attend[<?php echo $r->std_id ?>][]">Leave
                            &nbsp;&nbsp; <input type="radio" value="4" <?php echo ($status== 4) ?  "checked" : "" ;  ?> name="attend[<?php echo $r->std_id ?>][]">N/A
                        </td>   

                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                    </tbody>
                </table> 
                <div class="form-group">
                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                        <label>
                            <input type="submit" name="submit" value="Update Attendance" class="btn btn-lg btn-success">
                        </label>
                    </div>
                </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->



    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
