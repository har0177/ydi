
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        Dashboard of  <?php echo $heading; ?>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">

         <div class="widget-box">
            <div class="table-header">
                                Search Attendance 
                            </div>
            <div class="widget-body">
                <div class="widget-main">
                    
                    <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">	
                            
                                    <?php echo form_open('', ['class' => 'form-horizontal']); ?>
                           
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Course & Batch: </label>

                                <div class="col-xs-12 col-sm-9">


                                    <select required name="course" class="select2">

                                        <option value="" >Please Select Course & Batch </option>


                                        <?php echo AdminLTE::courses(); ?>


                                    </select>


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
                ?>
            <div class="table-header">
                Attendance
            </div>
            <div>		
                <table id="" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Total Students</th>
                            <th>Present Students</th>
                            </tr>
                    </thead>

                    <tbody>
    <?php
    if ($report > 0) {
        foreach ($report as $r) {
            ?>
                                <tr><td><?php echo $r->std ?></td>
                                    <td><?php if($r->status == 1){
                                        echo $r->status;
                                    }else{
                                        echo 0;
                                    } ?></td>
                                    

                                </tr>
                        <?php
                    } }
                ?>
                    </tbody>
                </table>	
<?php } ?>
        </div>     <!-- PAGE CONTENT ENDS -->

    </div>
</div>
