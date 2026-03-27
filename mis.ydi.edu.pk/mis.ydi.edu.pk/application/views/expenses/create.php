<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-newspaper-o"></i>
        Add New <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/expenses'); ?>" class="btn btn-sm btn-success pull-right">
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
                            <fieldset >
                                <legend>Expanses Information</legend>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Receipt No:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="rec"  class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Expense Types: </label>

                                    <div class="col-xs-12 col-sm-9">

                                        <select name="exp_name" class="select2">

                                            <option value="" >Please Select Expense Type</option>

                                            <?php echo AdminLTE::expense_names(); ?>


                                        </select>
                                        <a href="<?php echo site_url('admin/expenses/add_expname'); ?>" class="btn btn-sm btn-success pull-right">
                                            <i class="ace-icon fa fa-plus-square"></i> Add Expense Type</a>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Amount:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="number" id="name" required="" name="amount" value="0" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>


                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Comments:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <textarea rows='5' style="text-align: left" id="name" required="" name="comments" placeholder="Comments" maxlength="612" class='form-control'></textarea>

                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Date: </label>

                                    <div class="col-xs-12 col-sm-3">
                                        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control"/>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>
                                <div class="space-8"></div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Add Expanses" class="btn btn-lg btn-success">
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