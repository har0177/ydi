<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-newspaper-o"></i>
        Update <?php echo $heading; ?>
        <a href="<?php echo site_url( 'admin/fee' ); ?>" class="btn btn-sm btn-success pull-right">
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
                                <legend>Update Fee Information</legend>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Courses
                                        & Batch: </label>

                                    <div class="col-xs-12 col-sm-9">


                                        <select required name="course" class="select2">

                                            <option value="">Please Select Course & Batch</option>
                                          
                                          
                                          <?php echo AdminLTE::courses( $r->course ); ?>


                                        </select>


                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right"
                                           for="status">Month</label>

                                    <div class="col-xs-12 col-sm-9">
                                      <?php
                                      $data2 = [
                                        'data-placeholder' => "Select Month",
                                        'class'            => "select2",
                                        'id'               => 'month',
                                        'tabindex'         => '-1',
                                        'required'         => ''
                                      ];
                                      
                                      //$options = $tmp;
                                      echo form_dropdown( 'month', $month, set_value( 'month', $r->month ), $data2 );
                                      ?>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right"
                                           for="status">Year</label>

                                    <div class="col-xs-12 col-sm-9">
                                      <?php
                                      $data3 = [
                                        'data-placeholder' => "Select Year",
                                        'class'            => "select2",
                                        'id'               => 'year',
                                        'tabindex'         => '-1',
                                        'required'         => ''
                                      ];
                                      //$options = $tmp;
                                      echo form_dropdown( 'year', $year, set_value( 'year' ), $data3 );
                                      ?>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>


                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Monthly
                                        Fee:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="monthly"
                                                   value="<?php echo $r->monthly ?>" class="col-xs-12 col-sm-9"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Other Fee:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="other"
                                                   value="<?php echo $r->others ?>" class="col-xs-12 col-sm-9"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>


                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Other Fee
                                        Comments:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" name="comments"
                                                   value="<?php echo $r->comments ?>" class="col-xs-12 col-sm-9"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of
                                        Submission:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="date" id="name" required="" name="submission"
                                                   value="<?php echo $r->date_of_payment ?>"
                                                   class="col-xs-12 col-sm-9"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>


                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Update Fee"
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