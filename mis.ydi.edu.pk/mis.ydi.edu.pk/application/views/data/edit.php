<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-newspaper-o"></i>
       Upload <?php echo $title; ?>
        <a href="<?php echo site_url('trainer/data'); ?>" class="btn btn-sm btn-success pull-right">
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
                            <?php echo form_open_multipart('trainer/update_data/'.$r->id, ['class' => 'form-horizontal']); ?>
                            <fieldset >
                                <legend>Data Information</legend>
                               
                                <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Course & Batch: </label>

                                <div class="col-xs-12 col-sm-9">
                                    
  <select required="" name="course" class="select2">

                                        <option value="" >Please Select Course & Batch</option>


                                        <?php 
                                        $emp = AdminLTE::user_data($this->session->user_id);
                            $emp_course = explode(",", AdminLTE::employee_data($emp, "course"));
                               
                            foreach ($emp_course as
                                    $value) {
                             $selected = "";
                                $course = AdminLTE::student_course($value);
                                if($r->course == $value){
                                    $selected = "selected";
                                }
                                ?>
                                        <option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $course ?></option>
                                  <?php      
                                    } ?>


                                    </select>
                                </div>
                            </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Topic:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="text" id="name" required="" name="topic" value="<?php echo $r->topic ?>" placeholder="Topic Name" class="col-xs-12 col-sm-9" />
                                        </div>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>


                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Comments:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <textarea rows='5' style="text-align: left" id="name"  required="" name="comments" placeholder="Comments" maxlength="612" class='form-control'><?php echo $r->comments ?></textarea>

                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>
<div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Image / PDF File:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <?php echo $r->data ?>
                                        <input type="file" name="image" class="col-xs-12 col-sm-6" />

                                    </div>
                                </div>
                                <h3 style='text-align: center'></h3> <div class="form-group"> <label class="control-label col-xs-12 col-sm-3 no-padding-right">Video Link:</label> <div class="col-xs-12 col-sm-9"> <div class="clearfix"> <input type="text" id="name" name="link" value="<?php echo $r->link ?>" class="col-xs-12 col-sm-9" /> </div> </div> </div>
                                <div class="hr hr-dotted"></div>
                                <div class="space-8"></div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Update Uploaded Data" class="btn btn-lg btn-success">
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