<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-newspaper-o"></i>
        Update <?php echo $heading; ?>
        <a href="<?php echo site_url( 'admin/accounts' ); ?>" class="btn btn-sm btn-success pull-right">
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
																										<?php echo form_open( '', [ 'class' => 'form-horizontal' ] ); ?>
                            <fieldset>
                                <legend>Update Salary Information</legend>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Employee
                                        Name:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" disabled name="salary"
                                                   value="<?php echo AdminLTE::employee_name( $r->emp_id ) ?>"
                                                   class="col-xs-12 col-sm-9"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Month:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" disabled name="salary"
                                                   value="<?php echo $r->month ?>" class="col-xs-12 col-sm-9"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Year:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" disabled name="salary"
                                                   value="<?php echo $r->year ?>" class="col-xs-12 col-sm-9"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Total
                                        Amount:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" disabled name="total" value="<?php echo $r->total ?>"
                                                   class="col-xs-12 col-sm-9"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Paid:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="paid" name="paid" value="<?php echo $r->paid ?>"
                                                   class="col-xs-12 col-sm-9"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="hr hr-dotted"></div>

                                <div class="space-2"></div>

                                <div class="hr hr-dotted"></div>
                                <div class="space-8"></div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Update Salary"
                                                   class="btn btn-lg btn-success">
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