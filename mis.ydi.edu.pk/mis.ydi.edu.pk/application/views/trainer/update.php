
<div class="page-header">
    <h5 style="text-align: center; font-family: 'Baskerville Old Face'">    
        YOUTH DEVELOPMENT INSTITUTE <br>
        English Proficiency Program

    </h5>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
       <div class="table-header">
            TRAINEE'S PROFILE
        </div>

  <?php echo form_open('', ['class' => 'form-horizontal']); ?>

        <table id="" class="table table-striped table-bordered table-hover">

            <tr><th>Name</th>
                <td><?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))); ?></td>
                <th>Registration No</th>
                <td><?php echo strtoupper($r->regno); ?></td>
               </tr>
            <tr>
                <th>EDIR Number</th>
                <td><?php echo AdminLTE::table_data_onefield("interview", "edir", array("regno" => $r->regno)) ?></td>
                <th>Courses & Batch</th>
                 <td><?php echo (AdminLTE::student_course(AdminLTE::table_data_onefield("student", "course", array("reg_no" => $r->regno)))); ?></td>
            </tr>
            <tr>
                <th>Trainer</th>
                <td><?php 
                echo AdminLTE::employee_name($r->trainer);
                
                ?>
                    
                </td>
                <th>Date</th>
                <td><input type="hidden" name="date" value="<?php echo $r->date ?>"><?php echo dateformatesformysql_fata($r->date) ?></td>
            </tr>


            </tr>


        <table id="" class="table table-striped table-bordered table-hover">
            
            <tr><th>Attendance</th>
                <th><input type="radio" style="height: 15px;" name="attend[]" <?php if(explode(",",$r->attend)[0] == 80){
                    echo "checked";
                } ?> class="form-control" value="80, Trainee was regular throughout the week (Frequently Regular)">Trainee was regular throughout the week (Frequently Regular)</th>
             <th><input type="radio" style="height: 15px;" name="attend[]" <?php if(explode(",",$r->attend)[0] == 60){
                    echo "checked";
                } ?>   class="form-control" value="60, Trainee was absent for one/ more than one day  but properly informed the E.D. (Occasionally regular)">Trainee was absent for one/ more than one day  but properly informed the E.D. (Occasionally regular)</th>
                <th><input type="radio" style="height: 15px;" name="attend[]" <?php if(explode(",",$r->attend)[0] == 40){
                    echo "checked";
                } ?>   class="form-control" value="40, Trainee was absent for one/more than one day but didn’t inform the E.D (Occasionally Irregular)">Trainee was absent for one/more than one day but didn’t inform the E.D (Occasionally Irregular)</th>
                <th><input type="radio" style="height: 15px;" name="attend[]" <?php if(explode(",",$r->attend)[0] == 20){
                    echo "checked";
                } ?>  class="form-control" value="20, Trainee was not regular throughout the week. (Frequently Irregular)">Trainee was not regular throughout the week. (Frequently Irregular)</th>
                   
             
            </tr>

            <tr><th>Punctuality</th>
                <th><input type="radio" style="height: 15px;" name="punc[]" <?php if(explode(",",$r->punc)[0] == 80){
                    echo "checked";
                } ?>    class="form-control" value="80, Trainee was punctual and came to the class on exact time. (Frequently Punctual)">Trainee was punctual and came to the class on exact time. (Frequently Punctual)</th>
             <th><input type="radio" style="height: 15px;" name="punc[]" <?php if(explode(",",$r->punc)[0] == 60){
                    echo "checked";
                } ?>    class="form-control" value="60, Trainee came late to the class occasionally with reasonable excuse. (Occasionally Punctual)">Trainee came late to the class occasionally with reasonable excuse. (Occasionally Punctual)</th>
                <th><input type="radio" style="height: 15px;" name="punc[]"  <?php if(explode(",",$r->punc)[0] == 40){
                    echo "checked";
                } ?>   class="form-control" value="40, Trainee came late to the class occasionally with no reasonable excuses. (Occasionally Late)">Trainee came late to the class occasionally with no reasonable excuses. (Occasionally Late)</th>
                <th><input type="radio" style="height: 15px;" name="punc[]" <?php if(explode(",",$r->punc)[0] == 20){
                    echo "checked";
                } ?>    class="form-control" value="20, Trainee is not punctual and never comes to the class on exact time. (Frequently Late)">Trainee is not punctual and never comes to the class on exact time. (Frequently Late)</th>
                   
             
            </tr>
         
            <tr><th>Participation</th>
                <th><input type="radio" style="height: 15px;" name="part[]" <?php if(explode(",",$r->part)[0] == 80){
                    echo "checked";
                } ?>     class="form-control" value="80, Trainee well participated in-group activity by providing authentic and reasonable points. (Excellent)">Trainee well participated in-group activity by providing authentic and reasonable points. (Excellent)</th>
             <th><input type="radio" style="height: 15px;" name="part[]" <?php if(explode(",",$r->part)[0] == 60){
                    echo "checked";
                } ?>    class="form-control" value="60, Trainee participated in-group activity sometimes by providing relevant points.(Very good)">Trainee participated in-group activity sometimes by providing relevant points.(Very good)</th>
                <th><input type="radio" style="height: 15px;" name="part[]" <?php if(explode(",",$r->part)[0] == 40){
                    echo "checked";
                } ?>    class="form-control" value="40, Trainee actively participated in group activity by providing inapplicable points. (Good)">Trainee actively participated in group activity by providing inapplicable points. (Good)</th>
                <th><input type="radio" style="height: 15px;" name="part[]" <?php if(explode(",",$r->part)[0] == 20){
                    echo "checked";
                } ?>    class="form-control" value="20, Trainee hardly participated in the group activity and remained silent throughout activity. (Fair)">Trainee hardly participated in the group activity and remained silent throughout activity. (Fair)</th>
                   
             
            </tr>
            <tr><th>Cooperation</th>
                <th><input type="radio" style="height: 15px;" name="coop[]"  <?php if(explode(",",$r->coop)[0] == 80){
                    echo "checked";
                } ?>    class="form-control" value="80, Trainee was very cooperative to the team members as he/she actively listened to them, and appreciated and responded well to others’ opinion. (Excellent)">Trainee was very cooperative to the team members as he/she actively listened to them, and appreciated and responded well to others’ opinion. (Excellent)</th>
             <th><input type="radio" style="height: 15px;" name="coop[]" <?php if(explode(",",$r->coop)[0] == 60){
                    echo "checked";
                } ?>     class="form-control" value="60, Trainee was cooperative to the team members as he/she actively listened to them and appreciated their points but did not respond to them.  (Very good)">Trainee was cooperative to the team members as he/she actively listened to them and appreciated their points but did not respond to them.  (Very good)</th>
                <th><input type="radio" style="height: 15px;" name="coop[]" <?php if(explode(",",$r->coop)[0] == 40){
                    echo "checked";
                } ?>     class="form-control" value="40, Trainee occasionally cooperated with his/her team members and responded only when he/she was asked to. (Good)">Trainee occasionally cooperated with his/her team members and responded only when he/she was asked to. (Good)</th>
                <th><input type="radio" style="height: 15px;" name="coop[]" <?php if(explode(",",$r->coop)[0] == 20){
                    echo "checked";
                } ?>     class="form-control" value="20, Trainee hardly paid attention to the team members and rarely participated in their discussion. (Fair)">Trainee hardly paid attention to the team members and rarely participated in their discussion. (Fair)</th>
                   
             
            </tr>
              <tr><th>Presentation Skills</th>
                <th><input type="radio" style="height: 15px;" name="pre[]"  <?php if(explode(",",$r->pre)[0] == 80){
                    echo "checked";
                } ?>     class="form-control" value="80, Trainee presented himself in an exciting way with excellent and beneficial content and made use of his body language frequently. (Excellent)">Trainee presented himself in an exciting way with excellent and beneficial content and made use of his body language frequently. (Excellent)</th>
             <th><input type="radio" style="height: 15px;" name="pre[]"  <?php if(explode(",",$r->pre)[0] == 60){
                    echo "checked";
                } ?>    class="form-control" value="60, Trainee presented himself well with gestures but the contents were inapt and non-beneficial. (Very Good)">Trainee presented himself well with gestures but the contents were inapt and non-beneficial. (Very Good)</th>
                <th><input type="radio" style="height: 15px;" name="pre[]"  <?php if(explode(",",$r->pre)[0] == 40){
                    echo "checked";
                } ?>    class="form-control" value="40, Trainee’s presentation was a bit boring as he hardly made use of gestures and didn’t keep the class attentive. (Fair)">Trainee’s presentation was a bit boring as he hardly made use of gestures and didn’t keep the class attentive. (Fair)</th>
                <th><input type="radio" style="height: 15px;" name="pre[]"  <?php if(explode(",",$r->pre)[0] == 20){
                    echo "checked";
                } ?>    class="form-control" value="20, Trainee’s presentation lacked the use of body language and appropriate contents. (Poor)">Trainee’s presentation lacked the use of body language and appropriate contents. (Poor)</th>
                   
             
            </tr>
              <tr><th>Lingual Skills</th>
                <th><input type="radio" style="height: 15px;" name="ling[]"  <?php if(explode(",",$r->ling)[0] == 80){
                    echo "checked";
                } ?>     class="form-control" value="80, Trainee apprehended everything that was taught in the week with accuracy and was able to reproduce that by using correct grammatical structure and appropriate pronunciation. (Excellent)">Trainee apprehended everything that was taught in the week with accuracy and was able to reproduce that by using correct grammatical structure and appropriate pronunciation. (Excellent)</th>
             <th><input type="radio" style="height: 15px;" name="ling[]" <?php if(explode(",",$r->ling)[0] == 60){
                    echo "checked";
                } ?>     class="form-control" value="60, Trainee apprehended some of the contents that were taught in the week and was able to reproduce them by using simple sentences with minor grammatical errors and occasionally mispronunciation. (Very Good)">Trainee apprehended some of the contents that were taught in the week and was able to reproduce them by using simple sentences with minor grammatical errors and occasionally mispronunciation. (Very Good)</th>
                <th><input type="radio" style="height: 15px;" name="ling[]" <?php if(explode(",",$r->ling)[0] == 40){
                    echo "checked";
                } ?>    class="form-control" value="40, Trainee apprehended very few contents that taught in the week and was able was to reproduce very few of them with major grammatical mistakes and mispronunciation. (Fair)">Trainee apprehended very few contents that taught in the week and was able was to reproduce very few of them with major grammatical mistakes and mispronunciation. (Fair)</th>
                <th><input type="radio" style="height: 15px;" name="ling[]" <?php if(explode(",",$r->ling)[0] == 20){
                    echo "checked";
                } ?>    class="form-control" value="20, Trainee hardly apprehended any content taught in the class and was unable to reproduce them either with accurate grammar or pronunciation. (Poor)">Trainee hardly apprehended any content taught in the class and was unable to reproduce them either with accurate grammar or pronunciation. (Poor)</th>
                   
             
            </tr>
        </table>
            <h3>Strategy used for Evaluation </h3>
            <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-3 no-padding-right bolder" for="status">Strategy:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <?php
                                    $datal = array(
                                        'data-placeholder' => "Select Strategy",
                                        'class' => "select2",
                                        'id' => 'strategy',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );

                                    //$options = $tmp;
                                    echo form_dropdown('strategy', $strategy, set_value('strategy', $r->stra), $datal);
                                    ?>
                                </div>
                            </div>
             <div class="hr hr-dotted"></div>
            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Total Marks:</label>
                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name" required="" name="tmarks" value="<?php echo $r->tmarks ?>"  class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
             <div class="hr hr-dotted"></div>
             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Obtained Marks:</label>
                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name" required="" name="marks" value="<?php echo $r->marks ?>" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
             <div class="hr hr-dotted"></div>
             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Comments:</label>
                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required="" name="comments" value="<?php echo $r->comments ?>"  placeholder="comments" class="col-xs-12 col-sm-6" />
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-dotted"></div>
                            <div class="space-8"></div>

                             <div class="form-group">
            <div class="col-xs-12 col-sm-4 pull-right">
                <label>
                    <input type="submit" name="submit" value="Update Details" class="btn btn-lg btn-success">
                </label>
            </div>
        </div>

        </form>
    </div>
</div>
