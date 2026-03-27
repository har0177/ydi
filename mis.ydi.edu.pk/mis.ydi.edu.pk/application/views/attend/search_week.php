<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Search <?php echo $heading ?> Sheet
        <a href="<?php echo site_url('admin/attendance'); ?>" class="btn btn-sm btn-success pull-right">  
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
                            <?php echo form_open('admin/attendance/search_attendance_weekly', ['class' => 'form-horizontal']); ?>
                           
                   
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
								<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">From Date: </label>

								<div class="col-xs-12 col-sm-3">
                                                                    <input type="text" name="from" value="<?php echo date('Y-m-d');?>" class="form-control datepicker"/>
								</div>
							</div>
                            <div class="hr hr-dotted"></div>
                                <div class="form-group">
								<label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">To Date: </label>

								<div class="col-xs-12 col-sm-3">
                                                                    <input type="text" name="to" value="<?php echo date('Y-m-d');?>" class="form-control datepicker"/>
								</div>
							</div>
                            

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Search Attendance" class="btn btn-lg btn-success">
                                    </label>
                                </div>
                            </div>
                            </form>
                        </div>
                     </div>
                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div>


</div><!-