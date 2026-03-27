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
                                <legend>Update Batch</legend>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Batch Name:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="batch" value="<?php echo $r->batch_name ?>" class="col-xs-12 col-sm-6" />
                                        </div>
                                    </div>
                                </div>


                                <div class="hr hr-dotted"></div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Update Batch" class="btn btn-lg btn-success">
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