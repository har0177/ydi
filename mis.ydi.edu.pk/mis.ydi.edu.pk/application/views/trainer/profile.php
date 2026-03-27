<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-user"></i>
        Update <?php echo $heading; ?>
        <a href="<?php echo site_url('trainer'); ?>" class="btn btn-sm btn-success pull-right">  
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
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Full Name:</label>
                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="fullname" value="<?php echo $result->fullname; ?>" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="username">User Name:</label>
                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="username" required="" name="username" value="<?php echo $result->username; ?>" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3" for="email">Email Address:</label>
                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="email" name="email" required="" id="email" value="<?php echo $result->email; ?>" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>
                            <div class="space-2"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password">Password:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="password" required="" name="password" id="password" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>

                            <div class="space-2"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password2">Confirm Password:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="password" required="" name="confirm_password" id="password2" class="col-xs-12 col-sm-6" /> 
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="address">Address:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="address" required="" name="address" value="<?php echo $result->address; ?>" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>

                            <div class="space-2"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right"  for="phone">Phone Number:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-phone"></i>
                                        </span>

                                        <input type="tel" id="phone" required="" value="<?php echo $result->phone; ?>" name="phone" />
                                    </div>
                                </div>
                            </div>


                            <div class="space-2"></div>
                            <div class="hr hr-dotted"></div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Update Profile" class="btn btn-lg btn-success">
                                    </label>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div>


</div><!-- /.col -->