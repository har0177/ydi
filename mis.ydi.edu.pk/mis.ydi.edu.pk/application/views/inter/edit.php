<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Update Interview Fee of <?php echo AdminLTE::student_name($r->regno) ?>
        <a href="<?php echo site_url('interviewer'); ?>" class="btn btn-sm btn-success pull-right">  
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
					<legend>Update Fee Information</legend>
                          

                                <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Interview Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  name="interview" value="<?php echo $r->interview ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

 <div class="hr hr-dotted"></div>


                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Update Fee" class="btn btn-lg btn-success">
                                    </label>
                                </div>
                            </div>
                             </fieldset>
                            </form>
                        </div> </div>
                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div>


</div><!-- /.col -->