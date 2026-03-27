  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> 
            <i class="ace-icon fa fa-newspaper-o"></i>
            Make New <?php echo $heading; ?> Sheet of Course <?php echo AdminLTE::student_course($this->input->post('course', TRUE)) ?> for Date: <?php echo dateformatesformysql_fata($this->input->post('date', TRUE)); ?>
            <a href="<?php echo site_url('admin/attendance'); ?>" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
        </h1>
    </section>


<script>
$(function()
{
  $('#theform').submit(function(){
    $("input[type='submit']", this)
      .val("Please Wait...")
      .attr('disabled', 'disabled');
    return true;
  });
});
</script>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <?php echo form_open('admin/attendance/create', ['class' => 'form-horizontal', 'id' => 'theform']); ?>
                <input type="hidden" name="date" value="<?php echo $this->input->post('date', TRUE) ?>">
                <input type="hidden" name="course" value="<?php echo $this->input->post('course', TRUE) ?>">

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
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $r->name; ?></td>
                                <td><?php echo $r->reg_no; ?></td>

                        <input class="form-control" type="hidden" name="id[]" value="<?php echo $r->reg_no; ?>"/>
                        <td><input type="radio" value="1" checked="" name="attend[<?php echo $r->reg_no ?>][]" > Present  
                            &nbsp;&nbsp; <input type="radio" value="2" name="attend[<?php echo $r->reg_no ?>][]">Absent
                            &nbsp;&nbsp; <input type="radio" value="3" name="attend[<?php echo $r->reg_no ?>][]">Leave
                            &nbsp;&nbsp; <input type="radio" value="4" name="attend[<?php echo $r->reg_no ?>][]">N/A
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
                            <input type="submit" name="submit" id="btnsubmit" value="Save Result" class="btn btn-lg btn-success">
                        </label>
                    </div>
                </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->



    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
