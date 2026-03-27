
<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Update <?php echo $heading; ?>
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
                                <legend>Update Employee Information</legend>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Name</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="name" value="<?php echo $r->name ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">CNIC No:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="cnic" value="<?php echo $r->cnic ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Qualification</label><div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="qualification" value="<?php echo $r->qualification ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>


                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Contact No:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="contact" value="<?php echo $r->contact ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Address:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="address" value="<?php echo $r->address ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of Joining:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="date" id="name" required="" name="join" value="<?php echo $r->join_date ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Basic Salary:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name"  name="salary" value="<?php echo $r->salary ?>" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="news_image">Employee Image:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <?php if ($r->img == "") {
                                            ?>
                                            <img  width="100" height="100px" alt="<?php echo $r->name ?>" src="<?php echo site_url('images/profile.png'); ?>" />
                                        <?php } else {
                                            ?>
                                            <img  width="100" height="100px" alt="<?php echo $r->name ?>" src="<?php echo site_url('images/' . $r->img); ?>" />
                                        <?php } ?>   <div class="space-2"></div>
                                        <div class="clearfix">

                                            <input type="file" name="image" accept="image/*" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Course & Batch: </label>
                                    <div class="col-xs-12 col-sm-9">

                                        <select name="course[]" class="select2" multiple="">

                                            <option value="" >Please Select Course & Batch</option>

                                            <?php 
                                            $course = explode(",", $r->course);
                                  
                                            $query = $this->db->get('courses');
        foreach ($query->result() as $rr) {
            $c = in_array($rr->course_id, $course) == $rr->course_id ? "selected=''" : "";
           
          echo  "<option value='$rr->course_id' $c> $rr->course_name " . AdminLTE::batch_name($rr->batch) . " </option>";
        
        }
      
  ?>


                                        </select>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>

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
                                        echo form_dropdown('category', $category, set_value('category', $r->category), $data2);
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
                                        echo form_dropdown('status', $status, set_value('status', $r->status), $data);
                                        ?>
                                    </div>
                                </div>
                                <div class="space-2"></div>

                                <div class="hr hr-dotted"></div>
                                <div class="space-8"></div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Update Employee" class="btn btn-lg btn-success">
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