<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Update <?php echo $heading ?>
        <a href="<?php echo site_url('admin/school/all_section'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-body">
                <div class="widget-main">
                    <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">
                            <?php echo form_open('', ['class' => 'form-horizontal']); ?>
  <fieldset >    	
					<legend>Update Course</legend>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Course Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="course" value="<?php echo $r->course_name ?>" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
    <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Batch: </label>

                                <div class="col-xs-12 col-sm-9">
                                    
                                    <select required name="batch" class="select2">

                                        <option value="" >Please Select Batch </option>


                                        <?php echo AdminLTE::batch($r->batch); ?>


                                    </select>
                                </div>
                            </div>
   <div class="space-2"></div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Status</label>

                                <div class="col-xs-12 col-sm-9">
                                    <?php
                                    $data = array(
                                        'data-placeholder' => "Select Course Status",
                                        'class' => "select2",
                                        'id' => 'status',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );

                                    //$options = $tmp;
                                    echo form_dropdown('status', $status, set_value('status', $r->status), $data);
                                    ?>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Update Course" class="btn btn-lg btn-success">
                                    </label>
                                </div>
                            </div>
  </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div>


</div><!-- /.col -->