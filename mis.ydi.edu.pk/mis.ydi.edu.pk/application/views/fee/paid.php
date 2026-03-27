<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
         Paid <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/fee'); ?>" class="btn btn-sm btn-success pull-right">  
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

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Receipt No:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" name="rec" required="" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>

                            
                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of Submission:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="date" id="name" required="" name="submission" value="<?php echo $r->date_of_payment ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>
                         
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Paid Fee" class="btn btn-lg btn-success">
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