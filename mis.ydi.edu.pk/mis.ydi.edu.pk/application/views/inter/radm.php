<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
       Re-Admission of  <?php echo AdminLTE::student_name($r->regno) ?>
        <a href="<?php echo site_url('interviewer/all'); ?>" class="btn btn-sm btn-success pull-right">  
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
					<legend>Re-Admission</legend>
                          
                                <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Status: </label>

                               <div class="col-xs-12 col-sm-9">
                                    <?php
                                    $datae = array(
                                        'data-placeholder' => "Select Status",
                                        'class' => "select2",
                                        'id' => 'status',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );

                                    //$options = $tmp;
                                    echo form_dropdown('status', $status, set_value('status', $r->std_status), $datae);
                                    ?>
                                    
                                 
                                    
                                </div>
                            </div>
                                        
                                <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Re-Admission Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  name="fee" value="500" class="col-xs-12 col-sm-9" />
                                        
                                    </div>
                                </div>
                            </div>
                                     

 <div class="hr hr-dotted"></div>


                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Submit" class="btn btn-lg btn-success">
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