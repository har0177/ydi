<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-certificate"></i>
        Issuance of Certificate 
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
                            <?php echo form_open('', ['class' => 'form-horizontal']); ?>

                            <div class="form-group">
                              
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Remarks</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required=""  name="remarks" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of Withdraw:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="date" id="name" required="" name="withdraw"  class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr-dotted"></div>
                            <div class="space-8"></div>

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Certifcate" class="btn btn-lg btn-success">
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