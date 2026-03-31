
<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Add New <?php echo $heading; ?>
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
					<legend>Student Information</legend>

                                     <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="student_image">Student Image:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="col-sm-6 col-xs-6">

                                    <div id="my_camera"></div>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
                
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div id="results" >Your captured image will appear here...</div>
                                    </div>
                                   
                                    </div>
                            </div>
                                        
                                        <div class="hr hr-dotted"></div>
                                        
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Registration No:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name" required="" placeholder="Registration  No" min="0" name="regno" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr-dotted"></div>
                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Full Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required=""  placeholder="Name of Student" name="name" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Father / Guardian Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  placeholder="Father Name of Student" name="fname" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr-dotted"></div>

                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of Birth:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="date"   placeholder="Date of Birh" name="dob" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">CNIC:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  placeholder="CNIC of Student" name="cnic" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                             
                              <div class="hr hr-dotted"></div>

                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Contact:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name"  name="contact" placeholder="Contact Number " class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Permanent Address:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="address" placeholder="Address" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
<div class="hr hr-dotted"></div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Course & Batch: </label>

                                <div class="col-xs-12 col-sm-9">
                                    
  <select required="" name="course" class="select2">

                                        <option value="" >Please Select Course & Batch</option>


                                        <?php echo AdminLTE::courses(); ?>


                                    </select>
                                </div>
                            </div>
                       <div class="hr hr-dotted"></div>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Send SMS: </label>

                                <div class="col-xs-12 col-sm-9">
                                    <input type="radio" name="sms" value='Yes' onclick="checkRadio('Yes')"> Yes &nbsp; &nbsp; &nbsp; <input type="radio" name="sms" onclick="checkRadio('No')" value='No' checked> No
                                    <br>
                                     <input type="radio" name="type" value='IELTS'> IELTS &nbsp; &nbsp; &nbsp;
                                    <input type="radio" name="type" value='EPP' checked> EPP&nbsp; &nbsp; &nbsp;
                                    <input type="radio" name="type" value='Life Skill'> Life Skill  &nbsp;
                                    &nbsp; &nbsp; <input type="radio" name="type" value='PTE'> PTE
                                    <br>
                                    <input type="datetime-local" name="datetime" disabled="true" id="datetime">
                                </div>
                            </div>
                         	</fieldset>				
                            <div class="clearfix"></div>
                            <br>
                        <fieldset>    	
					<legend>Additional Information</legend>
                             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Qualification:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  placeholder="Qualification" name="qualification" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">I am a Student of:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="student" placeholder="Student of" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">School / College / University Timing are From:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="from" placeholder="Time From" class="col-xs-12 col-sm-9" /> 
                                        
                                    </div>
                                   
                                </div>
                                <div class="row clearfix"></div>
                                <br>
                                
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">To:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="to" placeholder="Time To" class="col-xs-12 col-sm-9" /> 
                                        
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

                                    //$options = $tmp;
                                    echo form_dropdown('employee', $employee, set_value('employee'), $datae);
                                    ?>
                                    
                                 
                                    
                                </div>
                               
                            </div>
                            <div class="form-group">
                                 <label class="control-label col-xs-12 col-sm-3 no-padding-right">If Employed Which Profession:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="profession" placeholder="Profession of Student" value="" class="col-xs-12 col-sm-9" /> 
                                        
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
                                    echo form_dropdown('internet', $internet, set_value('internet'), $datan);
                                    ?>
                                    
                                 
                                    
                                </div>
                               
                            </div>
                            <div class="hr hr-dotted"></div>
                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date of Admission:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="date" id="name" name="admission" value="<?php echo date('Y-m-d');?>" placeholder="Date of Admission" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>

                            
                            
                            <div class="space-2"></div>
</fieldset>	
                            
                           <div class="clearfix"></div>
                            <br>
                        <fieldset>    	
					<legend>Fee Information</legend>
                                        <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Receipt No:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name" required=""  name="rec"  class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                                        
                                <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Admission  Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name" required=""  name="fee" value="5500" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Interview Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name" required="" name="interview" value="300" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Monthly Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name" required="" name="monthly" value="1600" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Form Fee:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="number" id="name" required=""  name="other" value="100" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>
                                        <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Other Fee Comments:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="text" id="name"  name="comments" class="col-xs-12 col-sm-9" />
                                    </div>
                                </div>
                            </div>


                          
                            </fieldset>
		
                        
                            <div class="hr hr-dotted"></div>
                            <div class="space-8"></div>

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Add Student" class="btn btn-lg btn-success">
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
     function checkRadio(name) {
    if(name == "Yes"){
        document.getElementById("datetime").disabled = false;

    } else if (name == "No"){
               document.getElementById("datetime").disabled = true;

    }
}
</script>