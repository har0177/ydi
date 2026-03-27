
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        Dashboard of  Attendance
        <a href="<?php echo site_url('nawaytakay/days'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-newspaper-o"></i> Days Attendance </a>
           
            <a href="<?php echo site_url('nawaytakay/search'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-list"></i> Add Attendance</a>
   
           

    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">


        <div class="widget-box">
            <div class="table-header">
                Search Attendance 
            </div>
            <div class="widget-body">
                <div class="widget-main">

                    <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">	

                            <?php echo form_open('nawaytakay/search_attendance', ['class' => 'form-horizontal']); ?>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Date: </label>

                                <div class="col-xs-12 col-sm-3">
                                    <input type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control"/>
								</div>
                            </div>

                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Search" class="btn btn-lg btn-success">
                                    </label>
                                </div>
                            </div>



                            <?php echo form_close(); ?>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>

       </div>     <!-- PAGE CONTENT ENDS -->

    
