<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Add New <?php echo $heading; ?>
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
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Student Registration Number:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="reg_no" value="0" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Month</label>

                                <div class="col-xs-12 col-sm-9">
                                    <?php
                                    $data2 = array(
                                        'data-placeholder' => "Select Month",
                                        'class' => "select2",
                                        'id' => 'month',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );

                                    //$options = $tmp;
                                    echo form_dropdown('month', $month, set_value('month'), $data2);
                                    ?>
                                </div>
                            </div>

                            <div class="hr hr-dotted"></div>


                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Session</label>

                                <div class="col-xs-12 col-sm-9">
                                    <?php
                                    $data1 = array(
                                        'data-placeholder' => "Select Session",
                                        'class' => "select2",
                                        'id' => 'session',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );

                                    //$options = $tmp;
                                    echo form_dropdown('session', $session, set_value('session'), $data1);
                                    ?>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Transport Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="transport" value="0" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Hostel Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="hostel" value="0" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Exam Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="exam" value="0" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Promotion Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="promotion" value="0" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Tuition Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="tuition" value="0" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Other Dues:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="other" value="0" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of Submission:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="submission" class="col-xs-12 col-sm-6 datepicker" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>



                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Add Fee" class="btn btn-lg btn-success">
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