<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Add New <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/employee'); ?>" class="btn btn-sm btn-success pull-right">  
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
                                <legend>Employee Information</legend>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Name</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="name" placeholder="Name of Employee" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">CNIC No:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="cnic" placeholder="CNIC of Employee" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Qualification</label> <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="qualification" placeholder="Qualification" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div> </div>



                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Contact No:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="contact" placeholder="Contact Number" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>


                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Address:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="address" placeholder="Address of Employee" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of Joining:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="date" id="name" required="" value="<?php echo date('Y-m-d'); ?>" name="join" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Basic Salary:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name"  name="salary" placeholder="Basic Salary Per Month of Employee" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Username:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name"  name="username" placeholder="username for registeration / login" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Password:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name"  name="password" placeholder="password for registeration / login" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="news_image">Employee Image:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="file" name="image" accept="image/*" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Course & Batch: </label>

                                    <div class="col-xs-12 col-sm-9">

                                        <select name="course[]" class="select2" multiple="">

                                            <option value="" >Please Select Course & Batch</option>

                                            <?php echo AdminLTE::courses(); ?>


                                        </select>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Category</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <?php
                                        $data2 = array(
                                            'data-placeholder' => "Select Category",
                                            'class' => "select2",
                                            'id' => 'category',
                                            'tabindex' => '-1',
                                            'required' => ''
                                        );

                                        //$options = $tmp;
                                        echo form_dropdown('category', $category, set_value('category'), $data2);
                                        ?>
                                    </div>
                                </div>
                                <div class="space-2"></div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Status</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <?php
                                        $data = array(
                                            'data-placeholder' => "Select Employee Status",
                                            'class' => "select2",
                                            'id' => 'status',
                                            'tabindex' => '-1',
                                            'required' => ''
                                        );

                                        //$options = $tmp;
                                        echo form_dropdown('status', $status, set_value('status'), $data);
                                        ?>
                                    </div>
                                </div>
                                <div class="space-2"></div>

                                <div class="hr hr-dotted"></div>
                                <div class="space-8"></div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Add Employee" class="btn btn-lg btn-success">
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