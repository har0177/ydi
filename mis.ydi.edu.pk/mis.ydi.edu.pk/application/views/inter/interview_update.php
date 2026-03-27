
                  <div class="page-header">
                      <h5 style="text-align: center; font-family: 'Baskerville Old Face'">    
                          YOUTH DEVELOPMENT INSTITUTE <br>
  English Proficiency Program

                       </h5>
                  </div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
             <?php echo form_open('', ['class' => 'form-horizontal']); ?>
        <div class="table-header">
          TRAINEE'S PROFILE
        </div>
     
       
            <table id="" class="table table-striped table-bordered table-hover">
          
                    <tr><th>Name</th>
                       <td><?php echo ucwords(strtolower( AdminLTE::student_name($r->regno))); ?></td>
                        <th>Father Name</th>
                   
                      
                      <td><?php echo ucwords(strtolower(AdminLTE::student_fname($r->regno))); ?></td>
                    </tr>
                    <tr>
                         <th>Registration No</th>
                              <td><?php echo strtoupper( $r->regno); ?></td>
                                        <th>Classes Starts From: </th>
                <th><input type="text" name="idate"  class="form-control datepicker" value="<?php echo $r->date  ?>"></th>
          
                    </tr>
                    <tr>
                        <th>EDIR Number</th>
                        <td><input type="text" name="edir" value="<?php echo $r->edir ?>" class="form-control" placeholder="EDIR Number"></td>
                          <th>Classes Starts From: </th>
                <th><input type="text" name="cstart"  class="form-control datepicker" value="<?php echo $r->cstart  ?>"></th>
            </tr>
            <tr> <th>Courses & Batch</th>
                        <td> 
                                        <select required name="course" class="select2">

                                            <option value="" >Please Select Course & Batch </option>


                                            <?php echo AdminLTE::courses(AdminLTE::student_data($r->regno, 'course')); ?>


                                        </select>


                               
                                </td>
                                  <th>Interviewer Name: </th>
                <th><input type="text" name="inter_name"  class="form-control" placeholder="Enter Your Name Here"></th>
                
                       
                         </tr>
                  
                       
                    </tr>
        

            </table>
        <div class="table-header">
           TRAINEE’S LINGUAL 
        </div>
     
       
            <table id="" class="table table-striped table-bordered table-hover">
          
                   <tr>
                <th>
                    Lingual Skills
                </th>
                <th>Level 1</th> <th>Level 2</th> <th>Level 3</th> <th>Level 4</th>
            </tr>
            <tr><th>Comprehension</th>
                
                <th><input type="radio" style="height: 15px;" name="comp[]" <?php if(explode("-",$r->comp)[0] == 80){
                    echo "checked";
                } ?> class="form-control" value="80-Trainee was able to understand all the verbal cues and responded to them appropriately.">Trainee was able to understand all the verbal cues and responded to them appropriately.</th>
                <th><input type="radio" style="height: 15px;" name="comp[]" <?php if(explode("-",$r->comp)[0] == 60){
                    echo "checked";
                } ?>  class="form-control" value="60-Trainee was able to understand some of the verbal cues and responded to them appropriately but in a bit longer time.">Trainee was able to understand some of the verbal cues and responded to them appropriately but in a bit longer time.</th>

                <th><input type="radio" style="height: 15px;" name="comp[]" <?php if(explode("-",$r->comp)[0] == 40){
                    echo "checked";
                } ?>  class="form-control" value="40-Trainee was able to understand very few verbal cues and hardly responded well.">Trainee was able to understand very few verbal cues and hardly responded well.</th>
                <th><input type="radio" style="height: 15px;" name="comp[]" <?php if(explode("-",$r->comp)[0] == 20){
                    echo "checked";
                } ?>  class="form-control" value="20-Trainee was unable to understand even the simple verbal cues and couldn’t give appropriate responses.">Trainee was unable to understand even the simple verbal cues and couldn’t give appropriate responses.</th>

            </tr>

            <tr><th>Grammar Accuracy</th>
                <th><input type="radio" style="height: 15px;" name="grac[]" <?php if(explode("-",$r->grac)[0] == 80){
                    echo "checked";
                } ?>  class="form-control" value="80-Trainee was able to use sentence structure, vocabulary and grammar correctly with no significant errors.">Trainee was able to use sentence structure, vocabulary and grammar correctly with no significant errors.</th>
                <th><input type="radio" style="height: 15px;" name="grac[]" <?php if(explode("-",$r->grac)[0] == 60){
                    echo "checked";
                } ?>  class="form-control" value="60-Trainee was able to use sentence structure, vocabulary and grammar with minimal errors.">Trainee was able to use sentence structure, vocabulary and grammar with minimal errors.</th>
                <th><input type="radio" style="height: 15px;" name="grac[]" <?php if(explode("-",$r->grac)[0] == 40){
                    echo "checked";
                } ?>  class="form-control" value="40-Trainee was able to use sentence structure, vocabulary and grammar with maximum errors.">Trainee was able to use sentence structure, vocabulary and grammar with maximum errors.</th>
                <th><input type="radio" style="height: 15px;" name="grac[]" <?php if(explode("-",$r->grac)[0] == 20){
                    echo "checked";
                } ?> class="form-control" value="20-Trainee was unable to use sentence structure, vocabulary and grammar correctly and appropriately. ">Trainee was unable to use sentence structure, vocabulary and grammar correctly and appropriately. </th>

            </tr>
            <tr><th>Comprehensibility & Pronunciation</th>
                <th><input type="radio" style="height: 15px;" name="compro[]" <?php if(explode("-",$r->compro)[0] == 80){
                    echo "checked";
                } ?> class="form-control" value="80-Trainee was able to communicate all the ideas and be understood clearly and easily using correct pronunciation.">Trainee was able to communicate all the ideas and be understood clearly and easily using correct pronunciation.</th>
                <th><input type="radio" style="height: 15px;" name="compro[]" <?php if(explode("-",$r->compro)[0] == 60){
                    echo "checked";
                } ?> class="form-control" value="60-Trainee was able to communicate some of the ideas and be understood easily using correct pronunciation with minimal errors.">Trainee was able to communicate some of the ideas and be understood easily using correct pronunciation with minimal errors.</th>
                <th><input type="radio" style="height: 15px;" name="compro[]" <?php if(explode("-",$r->compro)[0] == 40){
                    echo "checked";
                } ?> class="form-control" value="40-Trainee was able to communicate few ideas and was hard to be understood using mispronunciation.">Trainee was able to communicate few ideas and was hard to be understood using mispronunciation.</th>
                <th><input type="radio" style="height: 15px;" name="compro[]" <?php if(explode("-",$r->compro)[0] == 20){
                    echo "checked";
                } ?> class="form-control" value="20-Trainee was not able to communicate ideas and be understood clearly.">Trainee was not able to communicate ideas and be understood clearly.</th>

            </tr>

            <tr><th>Fluency</th>
                <th><input type="radio" style="height: 15px;" name="flu[]" <?php if(explode("-",$r->flu)[0] == 80){
                    echo "checked";
                } ?> class="form-control" value="80-Trainee was able to communicate smoothly, clearly and fluently.">Trainee was able to communicate smoothly, clearly and fluently.</th>
                <th><input type="radio" style="height: 15px;" name="flu[]" <?php if(explode("-",$r->flu)[0] == 60){
                    echo "checked";
                } ?>  class="form-control" value="60-Trainee was able to communicate smoothly, clearly with only natural hesitations.">Trainee was able to communicate smoothly, clearly with only natural hesitations.</th>
                <th><input type="radio" style="height: 15px;" name="flu[]" <?php if(explode("-",$r->flu)[0] == 40){
                    echo "checked";
                } ?>  class="form-control" value="40-Trainee was able to communicate ideas with lots of pauses and breaks.">Trainee was able to communicate ideas with lots of pauses and breaks.</th>
                <th><input type="radio" style="height: 15px;" name="flu[]"<?php if(explode("-",$r->flu)[0] == 20){
                    echo "checked";
                } ?>  class="form-control" value="20-Trainee was unable to communicate ideas smoothly and clearly.">Trainee was unable to communicate ideas smoothly and clearly.</th>
            </tr>

            <tr><th>Maturity Of Language</th>
                <th><input type="radio" style="height: 15px;"  name="mtol[]" <?php if(explode("-",$r->mtol)[0] == 80){
                    echo "checked";
                } ?>   class="form-control" value="80-Trainee was able to include details in conversation beyond the minimal requirements.">Trainee was able to include details in conversation beyond the minimal requirements.</th>
                <th><input type="radio" style="height: 15px;"  name="mtol[]" <?php if(explode("-",$r->mtol)[0] == 60){
                    echo "checked";
                } ?>   class="form-control" value="60-Trainee was able to include minimal details to support his/her ideas.">Trainee was able to include minimal details to support his/her ideas.</th>
                <th><input type="radio" style="height: 15px;"  name="mtol[]" <?php if(explode("-",$r->mtol)[0] == 40){
                    echo "checked";
                } ?>   class="form-control" value="40-Trainee was able to give his/her responses in very specific way without going to details.">Trainee was able to give his/her responses in very specific way without going to details.</th>
                <th><input type="radio" style="height: 15px;"  name="mtol[]" <?php if(explode("-",$r->mtol)[0] == 20){
                    echo "checked";
                } ?>   class="form-control" value="20-Trainee was unable to communicate either in detailed or in a specific way.">Trainee was unable to communicate either in detailed or in a specific way.</th>

            </tr>
            <tr><th>Vocabulary</th>
                <th><input type="radio" style="height: 15px;"  name="voca[]" <?php if(explode("-",$r->voca)[0] == 80){
                    echo "checked";
                } ?>   class="form-control" value="80-Trainee had the ability to use wide range of vocabulary with appropriate sentences.">Trainee had the ability to use wide range of vocabulary with appropriate sentences.</th>
                <th><input type="radio" style="height: 15px;"  name="voca[]" <?php if(explode("-",$r->voca)[0] == 60){
                    echo "checked";
                } ?>   class="form-control" value="60-Trainee had the ability to use limited range of vocabulary with appropriate sentences.">Trainee had the ability to use limited range of vocabulary with appropriate sentences.</th>
                <th><input type="radio" style="height: 15px;"  name="voca[]" <?php if(explode("-",$r->voca)[0] == 40){
                    echo "checked";
                } ?>   class="form-control" value="40-Trainee had the ability to use limited range of vocabulary but in inappropriate sentences.">Trainee had the ability to use limited range of vocabulary but in inappropriate sentences.</th>
                <th><input type="radio" style="height: 15px;"  name="voca[]" <?php if(explode("-",$r->voca)[0] == 20){
                    echo "checked";
                } ?>   class="form-control" value="20-Trainee was unable to use wide range of vocabulary with appropriate sentences.">Trainee was unable to use wide range of vocabulary with appropriate sentences.</th>
            </tr>


        </table>

        <div class="table-header">
            BEHAVIORAL INFORMATION
        </div>


        <table id="" class="table table-striped table-bordered table-hover">

            <tr><th>Greetings/ Farewell</th>
                <th><input type="radio" style="height: 15px;" name="greet[]" <?php if(explode("-",$r->greet)[0] == 80){
                    echo "checked";
                } ?>   class="form-control" value="80-Trainee greeted and departed in a formal way without any hesitation." >Trainee greeted and departed in a formal way without any hesitation.</th>
                <th><input type="radio" style="height: 15px;" name="greet[]" <?php if(explode("-",$r->greet)[0] == 60){
                    echo "checked";
                } ?>  class="form-control" value="60-Trainee greeted and departed in a formal way with only natural hesitation." >Trainee greeted and departed in a formal way with only natural hesitation.</th>
                <th><input type="radio" style="height: 15px;" name="greet[]" <?php if(explode("-",$r->greet)[0] == 40){
                    echo "checked";
                } ?>  class="form-control" value="40-Trainee greeted and departed in an informal way and was very hesitant and shy." >Trainee greeted and departed in an informal way and was very hesitant and shy.</th>
                <th><input type="radio" style="height: 15px;" name="greet[]" <?php if(explode("-",$r->greet)[0] == 20){
                    echo "checked";
                } ?>  class="form-control" value="20-Trainee didn’t greet and depart in a formal way." >Trainee didn’t greet and depart in a formal way.</th>

            </tr>

            <tr><th>Body Language</th>
                <th><input type="radio" style="height: 15px;" name="blang[]" <?php if(explode("-",$r->blang)[0] == 80){
                    echo "checked";
                } ?>  class="form-control" value="80-Trainee used his/her body language most of the time to convey his/her ideas more proficiently.">Trainee used his/her body language most of the time to convey his/her ideas more proficiently.</th>
                <th><input type="radio" style="height: 15px;" name="blang[]" <?php if(explode("-",$r->blang)[0] == 60){
                    echo "checked";
                } ?> class="form-control" value="60-Trainee used his/her body some of the time to convey his/her ideas proficiently.">Trainee used his/her body some of the time to convey his/her ideas proficiently.</th>
                <th><input type="radio" style="height: 15px;" name="blang[]" <?php if(explode("-",$r->blang)[0] == 40){
                    echo "checked";
                } ?> class="form-control" value="40-Trainee hardly used his/her body to convey their ideas proficiently.">Trainee hardly used his/her body to convey their ideas proficiently.</th>
                <th><input type="radio" style="height: 15px;" name="blang[]" <?php if(explode("-",$r->blang)[0] == 20){
                    echo "checked";
                } ?> class="form-control" value="20-Trainee didn’t use gestures to convey his/her ideas proficiently.">Trainee didn’t use gestures to convey his/her ideas proficiently.</th>

            </tr>
            <tr><th>Confidence Level</th>
                <th><input type="radio" style="height: 15px;" name="clevel[]" <?php if(explode("-",$r->clevel)[0] == 80){
                    echo "checked";
                } ?> class="form-control" value="80-Trainee was very confident and expressed his/her ideas without hesitation.">Trainee was very confident and expressed his/her ideas without hesitation.</th>
                <th><input type="radio" style="height: 15px;" name="clevel[]"  <?php if(explode("-",$r->clevel)[0] == 60){
                    echo "checked";
                } ?> class="form-control" value="60-Trainee’s confidence level was good and had only natural hesitation.">Trainee’s confidence level was good and had only natural hesitation.</th>
                <th><input type="radio" style="height: 15px;" name="clevel[]"  <?php if(explode("-",$r->clevel)[0] == 40){
                    echo "checked";
                } ?> class="form-control" value="40-Trainee’s confidence level was low and was hesitant to share ideas and face the interviewere.">Trainee’s confidence level was low and was hesitant to share ideas and face the interviewere.</th>
                <th><input type="radio" style="height: 15px;" name="clevel[]"  <?php if(explode("-",$r->clevel)[0] == 20){
                    echo "checked";
                } ?> class="form-control" value="20-Trainee was very hesitant and couldn’t express himself / herself well in front of interviewere.">Trainee was very hesitant and couldn’t express himself / herself well in front of interviewere.</th>

            </tr>
             <tr>
                 <th>Recommendations / Comments:</th>
                 <th colspan="4"><input type="text" name="comments" class="form-control" value="<?php echo $r->comments ?>"></th>
                
            </tr>
            </table>
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
