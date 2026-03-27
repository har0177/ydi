
<div class="page-header">
    <h5 style="text-align: center; font-family: 'Baskerville Old Face'">    
        YOUTH DEVELOPMENT INSTITUTE <br>
       NawayTakay Program

    </h5>
</div><!-- /.page-header -->
<style>
    input[type=text], input[type=number]{
        border: 1px solid lightslategray;
        height: 33px;
    }
</style>
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
                <td><input type="hidden" name="course" value="<?php echo $course = AdminLTE::table_data_onefield("student", "course", array("reg_no" => $r->regno)) ?>">
                    <?php echo AdminLTE::student_course($course); ?></td>

            </tr>
            <tr>
                <th>Trainer</th>
                <td><?php  echo "Nida Umar"
                
                ?>
                    <input type="hidden" name="trainer" value="Nida Umar">
                    
                </td>
                <th>Date</th>
                <td> <input type="date" id="name"  name="date" value="<?php echo date("Y-m-d"); ?>" class="col-xs-12" /></td>
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
                                    echo form_dropdown('strategy', $strategy, set_value('strategy'), $datal);
                                    ?>
                                </div>
                            </div>
        
        <table id="" class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>
                    Criteria
                </th>     
                <th>
                    Obtained Marks
                </th> 
                <th>
                    Total Marks
                </th> 
                <th>
                   Comments
                </th> 
                
            </tr>
                 
            </thead>
            <tbody>
                <tr>
                <th style="width: 15%">
                  Learned Vocabulary
                </th>     
                <th style="width: 15%">
                    <input type="number" placeholder="Obt Marks"  name="lc[]" class="form-control"> 
                </th> 
                <th style="width: 10%">
                    <input type="number" placeholder="Total Marks" value="10" name="lc[]" class="form-control">
                </th> 
                <th style="width: 60%">
                                       <input type="text" name="lc[]" placeholder="Comments" class="form-control">
                </th> 
                
            </tr>
             <tr>
                <th>
                  Confidence
                </th>     
                <th>
                    <input type="number" placeholder="Obt Marks" name="conf[]" class="form-control"> 
                </th> 
                <th>
                                     <input type="number" placeholder="Total Marks" value="10" name="conf[]" class="form-control">
                </th> 
                <th>
                                       <input type="text" name="conf[]" placeholder="Comments" class="form-control">
                </th> 
                
            </tr>
            <tr>
                <th>
                 Sentence Structure
                </th>     
                <th>
                    <input type="number" placeholder="Obt Marks" name="ss[]" class="form-control"> 
                </th> 
                <th>
                                     <input type="number" placeholder="Total Marks" value="10" name="ss[]" class="form-control">
                </th> 
                <th>
                                       <input type="text" name="ss[]" placeholder="Comments" class="form-control">
                </th> 
                
            </tr>
            <tr>
                <th>
                 Word Pronunciations
                </th>     
                <th>
                    <input type="number" placeholder="Obt Marks" name="wp[]" class="form-control"> 
                </th> 
                <th>
                                     <input type="number" placeholder="Total Marks" value="10" name="wp[]" class="form-control">
                </th> 
                <th>
                                       <input type="text" name="wp[]" placeholder="Comments" class="form-control">
                </th> 
                
            </tr>
             <tr>
                <th>
                 Spellings
                </th>     
                <th>
                    <input type="number" placeholder="Obt Marks" name="sp[]" class="form-control"> 
                </th> 
                <th>
                                     <input type="number" placeholder="Total Marks" value="10" name="sp[]" class="form-control">
                </th> 
                <th>
                                       <input type="text" name="sp[]" placeholder="Comments" class="form-control">
                </th> 
                
            </tr>
            </tbody>
           
        </table>
        

                            <div class="hr hr-dotted"></div>
                            <div class="space-8"></div>

                             <div class="form-group">
            <div class="col-xs-12 col-sm-4 pull-right">
                <label>
                    <input type="submit" name="submit" value="Submit Details" class="btn btn-lg btn-success">
                </label>
            </div>
        </div>

        </form>
    </div>
</div>
