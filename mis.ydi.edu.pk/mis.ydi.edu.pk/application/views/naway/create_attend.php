  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> 
            <i class="ace-icon fa fa-newspaper-o"></i>
            Make New attendance Sheet for Date: <?php echo dateformatesformysql_fata($this->input->post('date', TRUE)); ?>
            <a href="<?php echo site_url('nawaytakay/search'); ?>" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
        </h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <?php echo form_open('nawaytakay/create_attend', ['class' => 'form-horizontal']); ?>
                <input type="hidden" name="date" value="<?php echo $this->input->post('date', TRUE); ?>">
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
                                <td><?php echo AdminLTE::student_name($r->regno); ?></td>
                                <td><?php echo $r->regno; ?></td>

                        <input class="form-control" type="hidden" name="id[]" value="<?php echo $r->regno; ?>"/>
                        <td><input type="radio" value="1" checked="" name="attend[<?php echo $r->regno ?>][]" > Present  
                            &nbsp;&nbsp; <input type="radio" value="2" name="attend[<?php echo $r->regno ?>][]">Absent
                            &nbsp;&nbsp; <input type="radio" value="3" name="attend[<?php echo $r->regno ?>][]">Leave
                            &nbsp;&nbsp; <input type="radio" value="4" name="attend[<?php echo $r->regno ?>][]">N/A
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
                            <input type="submit" name="submit" value="Save Result" class="btn btn-lg btn-success">
                        </label>
                    </div>
                </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->



    </section><!-- /.content -->

</div><!-- /.content-wrapper -->
