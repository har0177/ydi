<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Update Fee Information
        <a href="<?php echo site_url('admin/students'); ?>" class="btn btn-sm btn-success pull-right">  
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
                            <?php echo form_open_multipart('', ['class' => 'form-horizontal']); ?>

                           
                        <fieldset>    	
					<legend>Fee Information</legend>
                                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Recipt No:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"   name="rec" value="<?php echo $r->rec_no ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                                <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Registration  Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  name="fee" value="<?php echo $r->fee ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Interview Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  name="interview" value="<?php echo $r->interview ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Monthly Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  name="monthly" value="<?php echo $r->monthly ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Other Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  name="other" value="<?php echo $r->other ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                                        <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Other Fee Comments:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="comments" value="<?php echo $r->comments ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>


                          
                            </fieldset>
		
                        
                            <div class="hr hr-dotted"></div>
                            <div class="space-8"></div>

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Update Fee Details" class="btn btn-lg btn-success">
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


</div><!-- /.col -->