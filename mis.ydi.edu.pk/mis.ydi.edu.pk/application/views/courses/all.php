<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading ?>

    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-12 col-md-6 col-sm-12 col-lg-6">
            <?php echo form_open('admin/school/add_course', ['class' => 'form-horizontal']); ?>
            <fieldset >    	
                <legend>Add New Course</legend>

                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Course Name:</label>

                    <div class="col-xs-12 col-sm-9">
                        <div class="clearfix">
                            <input type="text" id="name" placeholder="Course Name" required="" name="course" class="col-xs-12 col-sm-9" />
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Batch: </label>

                    <div class="col-xs-12 col-sm-9">

                        <select required name="batch[]" class="select2" multiple="">

                            <option value="" >Please Select Batch </option>


                            <?php echo AdminLTE::batch(); ?>


                        </select>
                    </div>
                </div>
                <div class="hr hr-dotted"></div>

                <div class="form-group">
                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                        <label>
                            <input type="submit" name="submit" value="Add Course" class="btn btn-lg btn-success">
                        </label>
                    </div>
                </div>
            </fieldset>
            </form>
        </div>
        <div class="col-xs-12 col-md-6 col-sm-12 col-lg-6">

            <div class="table-header">
                Manage <?php echo $heading ?>
            </div>
            <!-- div.table-responsive -->
            <!-- div.dataTables_borderWrap -->

            <table id="dyntable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr><th>S.No</th>
                        <th>Batch No.</th>
                        <th>Course Name</th>
<th>Status</th>

                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as $r) {
                        ?>
                        <tr> <td> <?php echo $i ?></td><td><?php echo AdminLTE::batch_name($r->batch) ?></td>
                            <td><?php echo $r->course_name ?></td>
                             <td><?php
                    if ($r->status
                            == '1') {
                        echo "<span class='label label-large label-success'>Active</span>";
                    } else {
                        echo "<span class='label label-large label-inverse'>De active</span>";
                    }
                    ?>	</td>
                            <td>
                                <div class="hidden-sm action-buttons">
                                    <a class="green" title="Update Course" href="<?php echo site_url('admin/school/edit_course/' . $r->course_id) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>

<!--                                    <a class="red" title="Delete Course" href="<?php echo site_url('admin/school/delete_course/' . $r->course_id) ?>" onclick="return confirm('Are You Sure Want to Delete it?');">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a> -->
                                </div>

                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>	

                </tbody>
            </table>
        </div>
    </div>

</div>