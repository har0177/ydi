<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-user"></i>
        Update <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/user'); ?>" class="btn btn-sm btn-success pull-right">  
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
                                <legend>User Information</legend>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Full Name:</label>
                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="fullname" value="<?php echo $result->fullname; ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="username">User Name:</label>
                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" required="" id="username" name="username" value="<?php echo $result->username; ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3" for="email">Email Address:</label>
                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="email" required="" name="email" id="email" value="<?php echo $result->email; ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>
                                <div class="space-2"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password">Password:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="password" required="" name="password" id="password" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="space-2"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password2">Confirm Password:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="password" required="" name="confirm_password" id="password2" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="address">Address:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" required="" id="address" name="address" value="<?php echo $result->address; ?>" class="col-xs-12 col-sm-9" />
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

                                            <input type="tel" required="" id="phone" value="<?php echo $result->phone; ?>" name="phone" />
                                        </div>
                                    </div>
                                </div>

                                <div class="space-2"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Status</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <?php
                                        $data = array(
                                            'data-placeholder' => "Select User Status",
                                            'class' => "select2",
                                            'id' => 'status',
                                            'tabindex' => '-1',
                                            'required' => ''
                                        );

                                        //$options = $tmp;
                                        echo form_dropdown('status', $status, set_value('status', $result->status), $data);
                                        ?>
                                    </div>
                                </div>

                                <div class="space-2"></div>
                                <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Level</label>

                                <div class="col-xs-12 col-sm-9">
                                    <?php
                                    $datal = array(
                                        'data-placeholder' => "Select User Level",
                                        'class' => "select2",
                                        'id' => 'level',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );

                                    //$options = $tmp;
                                    echo form_dropdown('level', $level, set_value('level', $result->level), $datal);
                                    ?>
                                </div>
                            </div>
                                <div class="hr hr-dotted"></div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Update User" class="btn btn-lg btn-success">
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div>


</div><!-- /.col -->