<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Update <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/students'); ?>" class="btn btn-sm btn-success pull-right">  
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
					<legend>Update Student Information</legend>
        <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="student_image">Student Image:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="col-sm-6 col-xs-6">

                                    <div id="my_camera"></div>
                <input type="button" value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
                
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div id="results" >                   <?php if ($r->img
                                            == "") {
                                        ?>
                                        <img  class="img-responsive" width="180" height="150" alt="<?php echo $r->name ?>" src="<?php echo site_url('images/profile.png'); ?>" />
                                        <?php } else {
                                        ?>
                                        <img  class="img-responsive" width="180" height="150" alt="<?php echo $r->name ?>" src="<?php echo site_url('images/' . $r->img); ?>" />
<?php } ?></div>
                                    </div>
                                   
                                    </div>
                            </div>
                                        <div class="hr hr-dotted"></div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Full Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                        <input type="hidden"  name="regno" value="<?php echo $r->reg_no ?>" />
                        <input type="text" id="name" required="" name="name" value="<?php echo $r->name ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Father / Guardian Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="fname" value="<?php echo $r->f_name ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr-dotted"></div>

                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of Birth:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="date" id="name"  name="dob" value="<?php echo $r->dob ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">CNIC:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  name="cnic" value="<?php echo $r->cnic ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                             
                              <div class="hr hr-dotted"></div>

                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Contact:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  name="contact" value="<?php echo $r->contact ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                            
                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Permanent Address:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="address" value="<?php echo $r->address ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
<div class="hr hr-dotted"></div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Course & Batch: </label>

                                <div class="col-xs-12 col-sm-9">
                                     <select required="" name="course" class="select2">

                                        <option value="" >Please Select Course & Batch</option>


                                        <?php echo AdminLTE::courses($r->course); ?>


                                    </select>

                                </div>
                            </div>
                            </fieldset>				
                            <div class="clearfix"></div>
                            <br>
                        <fieldset>    	
					<legend>Update Additional Information</legend>
                             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Qualification:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="qualification" value="<?php echo $r->qualification ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
 
                             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">I am a Student of:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="student" value="<?php echo $r->std_of ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
 

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">School / College / University Timing are From:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="from"  value="<?php echo $r->from ?>" class="col-xs-12 col-sm-9" /> 
                                        
                                    </div>
                                   
                                </div>
                                <div class="row clearfix"></div>
                                <br>
                                
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">To:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="to"  value="<?php echo $r->to ?>" class="col-xs-12 col-sm-9" /> 
                                        
                                    </div>
                                   
                                </div>
                            </div>

                            
                             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Employment Status</label>

                                <div class="col-xs-12 col-sm-9">
                                    <?php
                                    $datae = array(
                                        'data-placeholder' => "Select Employment",
                                        'class' => "select2",
                                        'id' => 'employee',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );
                                        if($r->employment == "Not Employee"){
                                           echo form_dropdown('employee', $employee, set_value('employee', $r->employment), $datae);
                                     
                                        }else{
                                             echo form_dropdown('employee', $employee, set_value('employee', "Employee"), $datae);
                                   
                                        }
                                    //$options = $tmp;
                                    ?>
                                    
                                 
                                    
                                </div>
                               
                            </div>
                            <div class="form-group">
                                 <label class="control-label col-xs-12 col-sm-3 no-padding-right">If Employed Which Profession:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="profession" value="<?php echo $r->employment ?>" class="col-xs-12 col-sm-9" /> 
                                        
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Do you have Internet access:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <?php
                                    $datan = array(
                                        'data-placeholder' => "Select Internet Status",
                                        'class' => "select2",
                                        'id' => 'internet',
                                        'tabindex' => '-1',
                                        'required' => ''
                                    );

                                    //$options = $tmp;
                                    echo form_dropdown('internet', $internet, set_value('internet', $r->internet), $datan);
                                    ?>
                                    
                                 
                                    
                                </div>
                               
                            </div>
                            <div class="hr hr-dotted"></div>
                           
                          
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of Admission:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="date" id="name"  name="admission" value="<?php echo $r->do_admission ?>" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                          
                          
                            <div class="space-2"></div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Status</label>

                                <div class="col-xs-12 col-sm-9">
                                    <?php
                                    $data = array(
                                        'data-placeholder' => "Select Student Status",
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
</fieldset>
                          
                            <div class="hr hr-dotted"></div>
                            <div class="space-8"></div>

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Update Student" class="btn btn-lg btn-success">
                                    </label>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div>


</div><!-- /.col -->

<!-- Camera capture - inline, no external dependency -->
<script>
(function() {
    var cameraDiv = document.getElementById('my_camera');
    var videoStream = null;
    var videoElem = null;
    var CAM_WIDTH = 180;
    var CAM_HEIGHT = 180;

    function showError(msg) {
        cameraDiv.innerHTML = '<div style="padding:10px;color:red;font-size:12px;">'
            + '<b>Camera Error:</b> ' + msg + '</div>';
    }

    function startCamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showError('Camera not supported. Use HTTPS and a modern browser.');
            return;
        }

        cameraDiv.innerHTML = '<div style="padding:20px;text-align:center;color:#666;">Starting camera...</div>';

        navigator.mediaDevices.getUserMedia({ audio: false, video: { facingMode: "user" } })
        .then(function(stream) {
            videoStream = stream;
            cameraDiv.innerHTML = '';

            videoElem = document.createElement('video');
            videoElem.setAttribute('autoplay', '');
            videoElem.setAttribute('playsinline', '');
            videoElem.setAttribute('muted', '');
            videoElem.muted = true;
            videoElem.style.width = CAM_WIDTH + 'px';
            videoElem.style.height = CAM_HEIGHT + 'px';
            videoElem.style.objectFit = 'cover';
            videoElem.srcObject = stream;
            cameraDiv.appendChild(videoElem);

            videoElem.play().catch(function() {
                videoElem.muted = true;
                videoElem.play();
            });
        })
        .catch(function(err) {
            showError(err.name + ': ' + err.message);
        });
    }

    // show tap-to-start button (user gesture needed for camera permission on mobile)
    cameraDiv.innerHTML = '<div style="width:' + CAM_WIDTH + 'px;height:' + CAM_HEIGHT + 'px;'
        + 'display:flex;align-items:center;justify-content:center;cursor:pointer;'
        + 'background:#f5f5f5;border:2px dashed #aaa;border-radius:8px;text-align:center;">'
        + '<div><div style="font-size:28px;">&#128247;</div><b style="font-size:13px;">Tap to start camera</b></div></div>';

    cameraDiv.querySelector('div').addEventListener('click', function() {
        startCamera();
    });

    // take_snapshot - captures frame from video to base64
    window.take_snapshot = function() {
        if (!videoElem) {
            showError('Camera is not started yet. Tap to start camera first.');
            return;
        }
        var canvas = document.createElement('canvas');
        canvas.width = CAM_WIDTH;
        canvas.height = CAM_HEIGHT;
        var ctx = canvas.getContext('2d');
        ctx.drawImage(videoElem, 0, 0, CAM_WIDTH, CAM_HEIGHT);

        var data_uri = canvas.toDataURL('image/jpeg', 1.0);
        var cleanedString = data_uri.substring(data_uri.indexOf(",") + 1);

        $(".image-tag").val(cleanedString);
        document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
    };
})();
</script>