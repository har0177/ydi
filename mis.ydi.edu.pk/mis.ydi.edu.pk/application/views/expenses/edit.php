<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-newspaper-o"></i>
        Update <?php echo $heading; ?>
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
                                            <input type="text" id="name" required="" name="rec" value="<?php echo $r->rec_no; ?>"   class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Expense Names: </label>

                                    <div class="col-xs-12 col-sm-9">

                                        <select name="exp_name" class="select2">

                                            <option value="" >Please Select Expense Name</option>

                                            <?php echo AdminLTE::expense_names($r->exp_id); ?>


                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Amount:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="number" id="name" required="" name="amount" value="<?php echo $r->amount ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Date: </label>

                                    <div class="col-xs-12 col-sm-3">
                                        <input type="date" name="date" value="<?php echo $r->date; ?>" class="form-control "/>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>


                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Comments:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <textarea rows='5' style="text-align: left" id="name" required="" name="comments" placeholder="Comments" maxlength="612" class='form-control'><?php echo $r->comments; ?></textarea>

                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>
                                <div class="space-8"></div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Update Expanses" class="btn btn-lg btn-success">
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