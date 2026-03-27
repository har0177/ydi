<style>

    textarea, input[type=text], input[type=password], input[type=datetime], input[type=datetime-local], input[type=date], input[type=checkbox], input[type=month], input[type=time], input[type=week], input[type=number], input[type=email], input[type=url], input[type=search], input[type=tel], input[type=color] {
        border-radius: 0!important;
        color: #000;
        background-color: #FFF;
        border: 2px solid lightslategray;
        padding: 6px 4px 6px;
        font-size: 16px;
        text-align: center;
        font-family: inherit;
        -webkit-box-shadow: none!important;
        box-shadow: none!important;
        -webkit-transition-duration: 0.3s;
        transition-duration: 0.3s;
        height: 50px;
    } 
    .tab .nav-tabs {
        border-bottom:0 none;
    }
    .tab .nav-tabs li a{
        position: relative;
        padding: 15px;
        color: #804000;
        font-size: 17px;
       
    }
    .tab .nav-tabs li a:hover{
        background:transparent;
        border:1px solid transparent;
    }
    .tab .nav-tabs li a:before{
        content: "";
        width:100%;
        height:100%;
        position:absolute;
        bottom: 8px;
        left:-2px;
        background: #FFB871;

        border: 1px solid #d3d3d3;
        border-bottom: 0px none;
        border-bottom-left-radius:5px;
        border-bottom-right-radius:5px;
        border-top-right-radius:25px;
        border-top-left-radius:25px;
        transform-origin: left center 0;
        transform: perspective(6px) rotateX(3deg);
        z-index:-30;
    }
    .tab .nav-tabs li{
        margin-right: 15px;
    }
    .tab .nav-tabs li.active a:before{
        background: #804000;
    }
    .tab .nav-tabs li.active a,
    .tab .nav-tabs li.active a:focus,
    .tab .nav-tabs li.active a:hover{
        border:1px solid transparent;
        background:transparent;
        color: #fff;
        font-weight:300;
        
    }
    .tab-content .tab-pane{
        background: #fdfdfd;
        line-height: 24px;
        border: 1px solid #e74c3c;
        border-top:5px solid #e74c3c;
        border-bottom:5px solid #e74c3c;
        padding:30px 25px;

    }
    th{
        font-weight: bold;
    }
    .tab-content .tab-pane h4{
        margin-top: 0;
        font-weight:700;
        font-size: 20px;
    }
    @media only screen and (max-width: 767px) {
        .tab .nav-tabs li a{
            padding: 15px 10px;
            font-size: 14px;
        }
        .tab .nav-tabs li a:before{
            bottom: 6px;
        }
    }
    @media only screen and (max-width: 499px) {
        .tab .nav-tabs li{
            width:100%;
            margin-bottom: 5px;
            margin-top: 5px;
        }
        .tab .nav-tabs li a:before{
            bottom: 0;
            transform: none;
            border-bottom: 1px solid #408080;
        }
    }


    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1065; /* Sit on top */
        padding-top: 180px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        border: 1px solid #888;
        width: 80%;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        -webkit-animation-name: animatetop;
        -webkit-animation-duration: 0.4s;
        animation-name: animatetop;
        animation-duration: 0.4s
    }
    /* Add Animation */
    @-webkit-keyframes animatetop {
        from {top:600px; opacity:0} 
        to {top:0; opacity:1}
    }

    @keyframes animatetop {
        from {top:600px; opacity:0}
        to {top:0; opacity:1}
    }

    /* The Close Button */
    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        padding: 20px 16px;
        background-color: #5cb85c;
        color: white;
    }

    .modal-body {padding: 2px 16px;}

    .modal-footer {
        padding: 2px 16px;
        background-color: #5cb85c;
        color: white;
    }
</style>
<div class="modal fade" id="bgmodel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="btn btn-danger close active" data-dismiss="modal" aria-label="close">&times;</a>

                <h4 class="modal-title">Upload Background Image</h4>
            </div>
            <div class="modal-body">

                <?php echo form_open_multipart('student/profile', ['class' => 'form-horizontal']); ?>



                <div class="form-group">

                    <div class="col-xs-12 col-sm-9">
                        <div class="clearfix">
                            <input type="file" name="file" accept="image/*"  class="col-xs-12 col-sm-9" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                        <label>
                            <input type="submit" name="submit" value="Change Image" class="btn btn-lg btn-success">
                        </label>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="imagemodel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="btn btn-danger close active" data-dismiss="modal" aria-label="close">&times;</a>

                <h4 class="modal-title">Upload Profile Image</h4>
            </div>
            <div class="modal-body">

                <?php echo form_open_multipart('student/image', ['class' => 'form-horizontal']); ?>



                <div class="form-group">

                    <div class="col-xs-12 col-sm-9">
                        <div class="clearfix">
                            <input type="file" name="file" accept="image/*"  class="col-xs-12 col-sm-9" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                        <label>
                            <input type="submit" name="submit" value="Change Image" class="btn btn-lg btn-success">
                        </label>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="passwordmodel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" class="btn btn-danger close active" data-dismiss="modal" aria-label="close">&times;</a>

                <h4 class="modal-title">Change Password</h4>
            </div>
            <div class="modal-body">
                <?php echo form_open('student/profile_update/' . $this->session->user_logged, ['class' => 'form-horizontal']); ?>



                <div class="form-group">

                    <div class="col-xs-12 col-sm-9">
                        <label>New Password:</label>
                        <div class="clearfix">
                            <input type="password" required="" name="password" id="password"  class="col-xs-12 col-sm-9" />
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <div class="col-xs-12 col-sm-9">
                        <label>Confirm Password:</label>
                        <div class="clearfix">
                            <input type="password" required="" name="confirm_password" id="password2"  class="col-xs-12 col-sm-9" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                        <label>
                            <input type="submit" name="submit" value="Update Profile" class="btn btn-lg btn-success">
                        </label>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <?php flash_alert(); ?>
    <section class="cover-sec">
        <?php
        if (!empty(AdminLTE::student_image($this->session->user_logged, 'bg'))) {
            ?>
            <img src="<?php echo site_url('images/' . AdminLTE::student_image($this->session->user_logged, 'bg')); ?>" height="400px" alt="<?php echo $this->session->user_name ?>" >
            <?php
        }
        else {
            ?>
            <img src="http://likequote.com/wp-content/uploads/2018/07/facebook-cover-photo-motivational-quotes17.png" height="400px" alt="<?php echo $this->session->user_name ?>" >
            <?php
        }
        ?>

        <a class="post-jb active" href='#bgmodel' data-toggle='modal' ><i class="fa fa-camera"></i></a>

    </section>

    <div class="col-sm-3">

        <div class="user_profile">
            <a class="profilecam" href='#imagemodel' data-toggle='modal' ><i class="fa fa-camera"></i></a>
            <div class="user-pro-img">
                <?php
                if (empty(AdminLTE::student_image($this->session->user_logged, 'profile'))) {
                    ?>
                    <img src="https://mis.ydi.edu.pk/images/<?php echo AdminLTE::student_image($this->session->user_logged, 'img'); ?>" class="" alt="<?php echo $this->session->user_name ?>">
                    <?php
                }
                else {
                    ?>
                    <img src="<?php echo site_url('images/' . AdminLTE::student_image($this->session->user_logged, 'profile')); ?>"  class="img-responsive" alt="<?php echo $this->session->user_name ?>">
                    <?php
                }
                ?>

                
            </div><!--user-pro-img end-->
            <div class="user_pro_status">
                <h1 class="btn btn-info btn-lg"><?php echo $this->session->user_name ?></h1><br><br>



            </div><!--user_pro_status end-->


        </div><!--user_profile end-->



    </div>

    <div class="col-sm-9">
        <br>

        <div class="tab" role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li  class="active"><a href="#javatab" aria-controls="javatab" aria-selected="true" role="tab" data-toggle="tab">Personal Info</a></li>
                <li ><a href="#jquerytab" aria-controls="jquerytab" aria-selected="false" role="tab" data-toggle="tab">Interview Report</a></li>
                <li ><a href="#ctab" aria-controls="ctab" aria-selected="false" role="tab" data-toggle="tab">Weekly Reports</a></li>
                <li ><a href="#mysqltab" aria-controls="mysqltab" aria-selected="false" role="tab" data-toggle="tab">Fee Details</a></li>
                <li ><a href="#datatab" aria-controls="datatab" aria-selected="false" role="tab" data-toggle="tab">Practice Data</a></li>
            </ul>
            <!-- Tab panes content goes here-->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade-in active" id="javatab">
                    <div class="container-fluid">
                        <div class="profile-user-info profile-user-info-striped">

                            <div class="profile-info-row">
                                <div class="profile-info-name viewname"> Registration Number </div>

                                <div class="profile-info-value viewname1">
                                    <span class="editable" id="username"><?php echo $this->session->user_logged ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name viewname"> Admission Date </div>

                                <div class="profile-info-value viewname1">
                                    <span class="editable" id="signup"><?php echo dateformatesformysql_fata(AdminLTE::student_data($this->session->user_logged, "do_admission")); ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name viewname"> Courses </div>

                                <div class="profile-info-value viewname1">
                                    <span class="editable" id="about"><?php
                                        echo strtoupper(AdminLTE::student_course(AdminLTE::student_data($this->session->user_logged, "course"))) . "<br>"
                                        ;
                                        ?></span>
                                </div>
                            </div>

                        </div>

                        <div class="space-10"></div>

                        <div class="col-xs-12 col-sm-12">

                            <div class="profile-user-info profile-user-info-striped">

                                <div class="profile-info-row">
                                    <div class="profile-info-name viewname"> Father / Guardian Name </div>

                                    <div class="profile-info-value viewname1">
                                        <span class="editable" id="username"><?php echo ucwords(strtolower(AdminLTE::student_data($this->session->user_logged, "f_name"))); ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name viewname">  CNIC </div>

                                    <div class="profile-info-value viewname1">
                                        <span class="editable" id="username"><?php echo AdminLTE::student_data($this->session->user_logged, "cnic") ?></span>
                                    </div>
                                </div>




                                <div class="profile-info-row">
                                    <div class="profile-info-name viewname"> Date of Birth </div>

                                    <div class="profile-info-value viewname1">
                                        <span class="editable" id="age"><?php
                                            $originalDate = AdminLTE::student_data($this->session->user_logged, "dob");
                                            $date = explode("-", $originalDate);
                                            echo "<span style='float: left'>In Figure :</span>" . date("d-m-Y", strtotime($originalDate)) . "<br> ";
                                            echo "<span style='float: left'>In Words :</span>  " . AdminLTE::day($date[2]) . " ";
                                            echo AdminLTE::month($date[1]) . ", ";
                                            echo AdminLTE::year($date[0]);
                                            ?></span>
                                    </div>
                                </div>



                                <div class="profile-info-row">
                                    <div class="profile-info-name viewname"> Permanent Address </div>

                                    <div class="profile-info-value viewname1">
                                        <span class="editable" id="login"><?php echo AdminLTE::student_data($this->session->user_logged, "address") ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name viewname"> I am a Student of </div>

                                    <div class="profile-info-value viewname1">
                                        <span class="editable" id="login"><?php echo AdminLTE::student_data($this->session->user_logged, "std_of") ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name viewname"> Qualification </div>

                                    <div class="profile-info-value viewname1">
                                        <span class="editable" id="login"><?php echo AdminLTE::student_data($this->session->user_logged, "qualification") ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name viewname"> Employment</div>

                                    <div class="profile-info-value viewname1">
                                        <span class="editable" id="login"><?php echo AdminLTE::student_data($this->session->user_logged, "employment") ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name viewname"> ID Card Status</div>
                                    <?php
                                    $status = "";
                                    if (AdminLTE::student_data($this->session->user_logged, "card_status") == 1) {
                                        $status = "<div class='btn btn-success'>Issued</div>";
                                    }
                                    else {
                                        $status = "<div class='btn btn-danger'>Not Issued</div>";
                                    }
                                    ?>
                                    <div class="profile-info-value viewname1">
                                        <span class="editable" id="login"><?php echo $status ?></span>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="jquerytab">
                    <div class="container-fluid">
                        <?php
                        if (!empty(AdminLTE::interview_info($this->session->user_logged))) {
                            ?>
                            <table  class="table table-striped table-bordered table-responsive">
                                <tr>
                                    <th colspan="4" style="background: #4f80a0; text-align: center">   TRAINEE'S PROFILE</th>

                                </tr>
                                <tr><th >Name</th>
                                    <td style=""><?php echo ucwords(strtolower($this->session->user_name)); ?></td>
                                    <th >Father Name</th>


                                    <td style=""><?php echo ucwords(strtolower(AdminLTE::student_fname($this->session->user_logged))); ?></td>
                                </tr>
                                <tr>
                                    <th>Registration No</th>
                                    <td><?php echo strtoupper($this->session->user_logged); ?></td>
                                    <th>Interview Date</th>
                                    <td><?php echo strtoupper(dateformatesformysql_fata(AdminLTE::inter_data($this->session->user_logged, "date"))); ?></td>
                                </tr>
                                <tr>
                                    <th>EDIR Number</th>
                                    <td><?php echo strtoupper(AdminLTE::inter_data($this->session->user_logged, "edir")); ?></td>
                                    <th>Courses & Batch</th>
                                    <td><?php echo strtoupper(AdminLTE::student_course(AdminLTE::student_data($this->session->user_logged, 'course'))); ?>
                                    </td>

                                </tr>



                                <tr>
                                    <th colspan="4" style="background: #4f80a0; text-align: center">   TRAINEE’S LINGUAL</th>
                                </tr>
                                <tr><th >Comprehension</th>
                                    <td colspan="3" style="text-align: left" style=""><?php echo explode("-", AdminLTE::inter_data($this->session->user_logged, "comp"))[1]; ?></td>
                                </tr>

                                <tr><th>Grammar Accuracy</th>
                                    <td colspan="3" style="text-align: left"><?php echo explode("-", AdminLTE::inter_data($this->session->user_logged, "grac"))[1]; ?></td>
                                </tr>
                                <tr><th>Comprehensibility & Pronunciation</th>
                                    <td colspan="3" style="text-align: left"><?php echo explode("-", AdminLTE::inter_data($this->session->user_logged, "compro"))[1]; ?></td>
                                </tr>

                                <tr><th>Fluency</th>
                                    <td colspan="3" style="text-align: left"><?php echo explode("-", AdminLTE::inter_data($this->session->user_logged, "flu"))[1]; ?></td>
                                </tr>

                                <tr><th>Maturity Of Language</th>
                                    <td colspan="3" style="text-align: left"><?php echo explode("-", AdminLTE::inter_data($this->session->user_logged, "mtol"))[1]; ?></td>
                                </tr>
                                <tr><th>Vocabulary</th>
                                    <td colspan="3" style="text-align: left"><?php echo explode("-", AdminLTE::inter_data($this->session->user_logged, "voca"))[1]; ?></td>
                                </tr>



                                <tr>
                                    <th colspan="4">    BEHAVIORAL INFORMATION</th>
                                </tr>
                                <tr><th>Greetings/ Farewell</th>
                                    <td colspan="3" style="text-align: left" style=""><?php echo explode("-", AdminLTE::inter_data($this->session->user_logged, "greet"))[1]; ?></td>
                                </tr>

                                <tr><th>Body Language</th>
                                    <td colspan="3" style="text-align: left"><?php echo explode("-", AdminLTE::inter_data($this->session->user_logged, "blang"))[1]; ?></td>
                                </tr>
                                <tr><th>Confidence Level</th>
                                    <td colspan="3" style="text-align: left"><?php echo explode("-", AdminLTE::inter_data($this->session->user_logged, "clevel"))[1]; ?></td>
                                </tr>


                            </table>
                            <div class="col-sm-12 text-center col-xs-12">
                                <div id="one" ></div>
                            </div>


                            <strong>Comments / Recommendations: </strong> <span> <?php echo AdminLTE::inter_data($this->session->user_logged, "comments") ?></span>

                            <DIV style="page-break-after:always"></DIV>


                            <br>
                            <h2 style="text-align: center; font-weight: bolder">    
                                YOUTH DEVELOPMENT INSTITUTE <br>
                                English Proficiency Program

                            </h2>

                            <table class="table table-responsive" style="font-size: 16px">
                                <tr>
                                    <th>Subject</th>
                                    <td style="" colspan="3" style="text-align: left">EPP Admission Confirmation </td>
                                </tr>
                                <tr>
                                    <th style="font-weight: normal; font-size: 16px; text-align: justify" colspan="4">
                                        <br><strong>   Dear &nbsp; <?php echo strtoupper($this->session->user_name); ?> </strong> <br>
                                <p style="background: white; border: none; text-align: justify; font-family: times; font-size: 18px">           &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                    We are pleased to inform you that you have been registered in EPP-YDI under the registration number <b><?php echo $this->session->user_logged ?></b>. <br>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Your EPP session will commence from <b><?php echo dateformatesformysql_fata(AdminLTE::inter_data($this->session->user_logged, "cstart")) ?></b>. Please make sure to attend your classes on regular basis.If you remain absent for three days either continuously or in a month without any prior application, your registration will be cancelled.  
                                </p>

                                </th>
                                </tr>
                                <tr>
                                    <th  colspan="3" style="background: #4f80a0; text-align: center">Training Session Schedule</th>
                                </tr>
                                <tr>
                                    <th>Day</th>
                                    <th>Duration</th>
                                    <th>Activity</th>
                                </tr>
                                <tr>
                                    <th >Monday</th>
                                    <td style="">1.5 Hours</td>
                                    <td style="">Training Session - Lecture, Activities.</td>
                                </tr>
                                <tr>
                                    <th>Tuesday</th>
                                    <td>1.5 Hours</td>
                                    <td>Training Session - Lecture, Activities.</td>
                                </tr>
                                <tr>
                                    <th>Wednesday</th>
                                    <td>1.5 Hours</td>
                                    <td>Training Session - Lecture, Activities.</td>
                                </tr>
                                <tr>
                                    <th>Thursday</th>
                                    <td>1.5 Hours</td>
                                    <td>Training Session - Lecture, Activities.</td>
                                </tr>
                                <tr>
                                    <th>Friday</th>
                                    <td>1.5 Hours</td>
                                    <td>Evaluation Day</td>
                                </tr>
                                <tr>
                                    <th>Saturday</th>
                                    <td>Open Day</td>
                                    <td>Prior notifications are given to student if an activity is arranged <br> OR  <br> Student can have the opportunity to take assistance from his/her trainer</td>
                                </tr>

                                <tr>

                                    <th colspan="3" style="background: #4f80a0; text-align: center">  Certification Criteria </th>
                                </tr>
                                <tr >

                                    <td style="" colspan="2">90% Attendance </td>
                                    <td colspan="2" style="">70% Marks in Progress Report & Final Interview</td>
                                </tr>

                            </table>

                            <?php
                        }
                        else {
                            echo "No Data Found!";
                        }
                        ?>

                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="ctab">
                    <div class="container-fluid">
                        <?php
                        $config = array();
                        $config["base_url"] = site_url() . "student/portal";
                        $config["total_rows"] = AdminLTE::record_count_week($this->session->user_logged);
                        $config["per_page"] = 1;
                        $config["uri_segment"] = 3;
                        $config['full_tag_open'] = '<ul class="pagination">';
                        $config['full_tag_close'] = '</ul>';
                        $config['first_link'] = false;
                        $config['last_link'] = false;
                        $config['first_tag_open'] = '<li>';
                        $config['first_tag_close'] = '</li>';
                        $config['prev_link'] = '<i class="fas fa-arrow-left"></i>';
                        $config['prev_tag_open'] = '<li class="prev">';
                        $config['prev_tag_close'] = '</li>';
                        $config['next_link'] = '<i class="fas fa-arrow-right"></i>';
                        $config['next_tag_open'] = '<li>';
                        $config['next_tag_close'] = '</li>';
                        $config['last_tag_open'] = '<li>';
                        $config['last_tag_close'] = '</li>';
                        $config['cur_tag_open'] = '<li class="active"><a href="#">';
                        $config['cur_tag_close'] = '</a></li>';
                        $config['num_tag_open'] = '<li>';
                        $config['num_tag_close'] = '</li>';

                        $this->pagination->initialize($config);

                        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                        $report = AdminLTE::fetch_data_weekly($config["per_page"], $page, $this->session->user_logged);
                        $links = $this->pagination->create_links();
                        if (!empty($report)) {
                            foreach ($report as
                                    $weekdata) {
                                ?>



                                <table id="" class="table table-striped table-bordered table-responsive">
                                    <tr>
                                        <th colspan="4" style="background: #4f80a0; text-align: center">   TRAINEE'S PROFILE</th>
                                    </tr>
                                    <tr><th>Name</th>
                                        <td><?php echo ucwords(strtolower($this->session->user_name)); ?></td>
                                        <th>Registration No</th>
                                        <td><?php echo strtoupper($this->session->user_logged); ?></td>
                                    </tr>
                                    <tr>
                                        <th>EDIR Number</th>
                                        <td><?php
                                            echo AdminLTE::table_data_onefield("interview", "edir", array(
                                                "regno" => $this->session->user_logged))
                                            ?></td>
                                        <th>Courses & Batch</th>
                                        <td><?php echo AdminLTE::student_course($weekdata->course);
                                            ?></td>

                                    </tr>
                                    <tr>
                                        <th>Trainer</th>
                                        <td><?php
                                            echo AdminLTE::employee_name($weekdata->trainer);
                                            ?>

                                        </td>
                                        <th>Date</th>
                                        <td><?php echo dateformatesformysql_fata($weekdata->date) ?></td>
                                    <tr>
                                        <th colspan="4" style="background: #4f80a0; text-align: center">   TRAINEE'S INFORMATION</th>
                                    </tr>
                                    </tr>

                                    <tr><th >Attendance</th>
                                        <td colspan="3" style=" text-align: justify"><?php echo explode(",", $weekdata->attend)[1]; ?></td>
                                    </tr>

                                    <tr><th>Punctuality</th>
                                        <td colspan="3" style=" text-align: justify"><?php echo explode(",", $weekdata->punc)[1]; ?></td>
                                    </tr>
                                    <tr><th>Participation</th>
                                        <td colspan="3" style=" text-align: justify"><?php echo explode(",", $weekdata->part)[1]; ?></td>
                                    </tr>

                                    <tr><th>Cooperation</th>
                                        <td colspan="3" style=" text-align: justify"><?php echo explode(",", $weekdata->coop)[1]; ?></td>
                                    </tr>

                                    <tr><th>Presentation Skills</th>
                                        <td colspan="3" style=" text-align: justify"><?php echo explode(",", $weekdata->pre)[1]; ?></td>
                                    </tr>
                                    <tr><th>Lingual Skills</th>
                                        <td colspan="3" style=" text-align: justify"><?php echo explode(",", $weekdata->ling)[1]; ?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="background: #4f80a0; text-align: center">   <?php echo strtoupper($weekdata->stra) ?></th>
                                    </tr>
                                    <tr>
                                        <th> Obtained Marks</th>
                                        <td>
                                            <?php echo $weekdata->marks ?>
                                        </td>
                                        <th>Total Marks</th>
                                        <td><?php echo $weekdata->tmarks ?></td>
                                    </tr>
                                </table>



                                <strong>Comments / Recommendations: </strong> <span> <?php echo $weekdata->comments ?></span>


                                <br>
                                <div class="col-sm-12 text-center col-xs-12">
                                    <div id="a_p_t_<?php echo $weekdata->date ?>"></div>
                                </div>
                                <div class="col-sm-12 text-center col-xs-12">
                                    <div id="stra_<?php echo $weekdata->date ?>"></div>
                                </div>



                                <br>
                                <?php echo $links; ?>
                                <br><br><br>


                                <?php
                                $id = $this->session->user_logged;
                                $query = $this->db->query("Select * from trainer_data where regno = $id and date = '$weekdata->date'");
                                foreach ($query->result() as
                                        $value) {
                                    ?>
                                    <script>
                                        $(function () {
                                            Highcharts.chart('a_p_t_<?php echo $weekdata->date ?>', {
                                                chart: {
                                                    type: 'column'
                                                },
                                                title: {
                                                    text: 'Student Weekly Report'
                                                },
                                                xAxis: {
                                                    categories: [
                                                        'Student Weekly Report'

                                                    ],
                                                    crosshair: true
                                                },
                                                yAxis: {
                                                    min: 0,
                                                    title: {
                                                        text: '<?php echo AdminLTE::student_name($id) ?>'
                                                    }
                                                },
                                                tooltip: {
                                                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                            '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                                    footerFormat: '</table>',
                                                    shared: true,
                                                    useHTML: true
                                                },
                                                plotOptions: {
                                                    column: {
                                                        pointPadding: 0.1,
                                                        borderWidth: 0
                                                    },
                                                    series: {
                                                        dataLabels: {
                                                            enabled: true,
                                                            format: '{y} %'
                                                        }
                                                    }
                                                },
                                                series: [{
                                                        name: 'Total',
                                                        data: [
                                                            100
                                                        ]

                                                    }, {
                                                        name: 'Attendance',
                                                        data: [
            <?php echo explode(",", $value->attend)[0] ?>
                                                        ]

                                                    }, {
                                                        name: 'Punctuality',
                                                        data: [
            <?php echo explode(",", $value->punc)[0] ?>
                                                        ]

                                                    }, {
                                                        name: 'Participation',
                                                        data: [
            <?php echo explode(",", $value->part)[0] ?>
                                                        ]

                                                    }, {
                                                        name: 'Cooperation',
                                                        data: [
            <?php echo explode(",", $value->coop)[0] ?>
                                                        ]

                                                    }, {
                                                        name: 'Presentation Skills',
                                                        data: [
            <?php echo explode(",", $value->pre)[0] ?>
                                                        ]

                                                    }, {
                                                        name: 'Lingual Skills',
                                                        data: [
            <?php echo explode(",", $value->ling)[0] ?>
                                                        ]

                                                    }]


                                            });
                                        });


                                    </script>

                                    <script>
                                        $(function () {
                                            Highcharts.chart('stra_<?php echo $weekdata->date ?>', {
                                                chart: {
                                                    type: 'column'
                                                },
                                                title: {
                                                    text: 'Student Overall Performance'
                                                },
                                                xAxis: {
                                                    categories: [
                                                        'Student Overall Performance',
                                                    ],
                                                    crosshair: true
                                                },
                                                yAxis: {
                                                    min: 0,
                                                    title: {
                                                        text: '<?php echo AdminLTE::student_name($id) ?>'
                                                    }
                                                },
                                                tooltip: {
                                                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                            '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                                                    footerFormat: '</table>',
                                                    shared: true,
                                                    useHTML: true
                                                },
                                                plotOptions: {
                                                    column: {
                                                        pointPadding: 0.1,
                                                        borderWidth: 0
                                                    },
                                                    series: {
                                                        dataLabels: {
                                                            enabled: true,
                                                            format: '{y} %'
                                                        }
                                                    }
                                                },
                                                series: [{
                                                        name: 'Total',
                                                        data: [
                                                            100
                                                        ]

                                                    }, {
                                                        name: 'Skills',
                                                        data: [
            <?php
            $attend = explode(",", $value->attend)[0];
            $coop = explode(",", $value->coop)[0];
            $pre = explode(",", $value->pre)[0];
            $part = explode(",", $value->part)[0];
            $ling = explode(",", $value->ling)[0];
            $punc = explode(",", $value->punc)[0];

            $total1 = (($attend + $coop + $pre + $part + $ling + $punc) / 600) * 60;
            echo $total1;
            ?>
                                                        ]

                                                    }, {
                                                        name: '<?php echo $value->stra ?>',
                                                        data: [
            <?php
            $total2 = ($value->marks / $value->tmarks) * 40;
            echo $total2;
            ?>
                                                        ]

                                                    },
                                                    {
                                                        name: 'Total Percentage',
                                                        data: [
            <?php echo $total1 + $total2; ?>
                                                        ]

                                                    }]


                                            });
                                        });


                                    </script>
                                    <?php
                                }
                            }
                        }
                        else {
                            echo "No Data Found!";
                        }
                        ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane tada" id="mysqltab">
                    <div class="container-fluid">
                        <div class="col-sm-12 text-center col-xs-12">
                            <div id="fee" ></div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane tada" id="datatab">
                     <div class="container-fluid">
                   
                        <?php
                        $course = AdminLTE::table_data_onefield("student", "course", array(
                                    "reg_no" => $this->session->user_logged));
                        $config = array();
                        $config["base_url"] = site_url() . "student/portal";
                        $config["total_rows"] = AdminLTE::record_count_int($course);
                        $config["per_page"] = 6;
                        $config["uri_segment"] = 3;
                        $config['full_tag_open'] = '<ul class="pagination">';
                        $config['full_tag_close'] = '</ul>';
                        $config['first_link'] = false;
                        $config['last_link'] = false;
                        $config['first_tag_open'] = '<li>';
                        $config['first_tag_close'] = '</li>';
                        $config['prev_link'] = 'Previous';
                        $config['prev_tag_open'] = '<li class="prev">';
                        $config['prev_tag_close'] = '</li>';
                        $config['next_link'] = 'Next';
                        $config['next_tag_open'] = '<li>';
                        $config['next_tag_close'] = '</li>';
                        $config['last_tag_open'] = '<li>';
                        $config['last_tag_close'] = '</li>';
                        $config['cur_tag_open'] = '<li class="active"><a href="#">';
                        $config['cur_tag_close'] = '</a></li>';
                        $config['num_tag_open'] = '<li>';
                        $config['num_tag_close'] = '</li>';

                        $this->pagination->initialize($config);

                        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                        $news = AdminLTE::fetch_data($config["per_page"], $page, $course);
                        $links = $this->pagination->create_links();
                        if (!empty($news)) {

                            foreach ($news as
                                    $n) {
                                ?>
                    
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="col-sm-4">
                         
                                            <?php
                                            $image = pathinfo($n->data, PATHINFO_EXTENSION);
                                            $ext = strtolower($image);
                                           
                                            if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif") {
                                                ?>
                                    <img target="_blank" src="https://mis.ydi.edu.pk/materials/<?php echo $n->data ?>" alt="<?php echo $n->topic ?>" class="img-responsive center-block" > 
                                   
                                                    
                                                <?php
                                                if(!empty($n->link)){
                                                    ?>
                                    <p style="text-align: center; line-height: 50px">
                                        <a href="<?php echo $n->link ?>" class="btn btn-sm btn-danger" target="_blank">Play Video</a></p>
                                                <?php
                                                }
                                            }
                                            else {
                                                ?>
                                                  <a href="https://mis.ydi.edu.pk/materials/<?php echo $n->data ?>" class="btn btn-sm btn-info center-block">Download Documents</a> 
                                                <?php
                                                if(!empty($n->link)){
                                                    ?>
                                                 <p style="text-align: center; line-height: 50px">
                                                <a href="<?php echo $n->link ?>" class="btn btn-sm btn-danger" target="_blank">Play Video</a>
                                                 </p>
                                                <?php
                                                }
                                            }
                                            
                                            
                                            ?>
                                </div>
                        <div class="col-sm-8" style="text-align: justify;  border: 4px solid white; font-family: 'Times New Roman'">
                                   
                            <h3 style="text-transform: uppercase"><?php echo $n->topic ?></h3>
                            <br>
                                            <p><?php echo $n->comments ?></p>
                                            <p style="text-align: center">***********************************</p>
                                        </div>
                           
                                </div>
                             </div>
                                <?php
                            }
                            ?>

                            <br>
                            <?php echo $links; ?>

               
                            <?php
                        }
                        else {
                            echo "No Data Found!";
                        }
                        ?>
                        </div>
                   
                    </div>
                </div>
            </div>
        </div>



    </div>


    <?php
    $regno = $this->session->user_logged;
    $year = date("Y");
    $qc = $this->db->query("SELECT SUM(paid) as paid, SUM(dues) as unpaid, MONTHNAME(date_of_payment) as date from fee where reg_no = $regno and year = $year group by MONTH(date_of_payment)");
    $paid = json_encode(array_columnn($qc->result(), 'paid'), JSON_NUMERIC_CHECK);
    $unpaid = json_encode(array_columnn($qc->result(), 'unpaid'), JSON_NUMERIC_CHECK);

    $datee = json_encode(array_columnn($qc->result(), 'date'), JSON_NUMERIC_CHECK);
    ?>
    <script>
        $(function () {

            Highcharts.chart('fee', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Traning Fee Chart of Student <?php echo ucwords(strtolower($this->session->user_name)) ?>'
                },
                xAxis: {
                    categories:
<?php echo $datee; ?>,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Traning Fee Chart of Student <?php echo ucwords(strtolower($this->session->user_name)) ?>'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0;"><b>{point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    },
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: 'Rs. {y}'
                        }
                    }
                },
                series: [
                    {
                        name: 'Total Paid Fee',
                        data: <?php echo $paid ?>

                    },
                    {
                        name: 'Total UnPaid Fee',
                        data: <?php echo $unpaid ?>

                    },
                ]


            });
        });


    </script>

    <?php
    $this->db->select('*');
    $this->db->from('student');
    $this->db->join('interview', 'interview.regno = student.reg_no');
    $this->db->where(array(
        'reg_no' => $this->session->user_logged,
        'interview.status' => 1));
    $query = $this->db->get();

    $compre = 0;
    $grac = 0;
    $comp = 0;
    $flu = 0;
    $mlang = 0;
    $voca = 0;
    $greet = 0;
    $blang = 0;
    $clevel = 0;
    $name = "";
    foreach ($query->result() as
            $value) {
        $name = AdminLTE::student_name($value->regno);
        $comp = explode("-", $value->comp)[0];
        $grac = explode("-", $value->grac)[0];
        $flu = explode("-", $value->flu)[0];
        $compre = explode("-", $value->compro)[0];
        $voca = explode("-", $value->voca)[0];
        $mlang = explode("-", $value->mtol)[0];
        $greet = explode("-", $value->greet)[0];
        $blang = explode("-", $value->blang)[0];
        $clevel = explode("-", $value->clevel)[0];
    }
    ?>
    <script>
        $(function () {
            Highcharts.chart('one', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'TRAINEE’S LINGUAL &  BEHAVIORAL INFORMATION'
                },
                subtitle: {
                    text: 'Source: Engr Haroon Yousaf'
                },
                xAxis: {
                    categories: [
                        '<?php echo $name ?>'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'TRAINEE’S LINGUAL &  BEHAVIORAL INFORMATION'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.1,
                        borderWidth: 0
                    },
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{y} %'
                        }
                    }
                },
                series: [
                    {
                        name: 'Total',
                        data: [
                            100
                        ]

                    },
                    {
                        name: 'Comprehension',
                        data: [
<?php echo $comp ?>
                        ]

                    },
                    {
                        name: 'Grammar Accuracy',
                        data: [
<?php echo $grac ?>
                        ]

                    },
                    {
                        name: 'Comprehensibility & Pronunciation',
                        data: [
<?php echo $compre ?>
                        ]

                    },
                    {
                        name: 'Fluency',
                        data: [
<?php echo $flu ?>
                        ]

                    },
                    {
                        name: 'Maturity Of Language',
                        data: [
<?php echo $mlang ?>
                        ]

                    },
                    {
                        name: 'Vocabulary',
                        data: [
<?php echo $voca ?>
                        ]

                    },
                    {
                        name: 'Greetings/ Farewell',
                        data: [
<?php echo $greet ?>
                        ]

                    },
                    {
                        name: 'Body Language',
                        data: [
<?php echo $blang ?>
                        ]

                    },
                    {
                        name: 'Confidence Level',
                        data: [
<?php echo $clevel ?>
                        ]

                    }

                ]


            });
        });


        $(document).ready(function () {
          $('a[data-toggle="tab"]').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});

$('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
    var id = $(e.target).attr("href");
    localStorage.setItem('selectedTab', id)
});

var selectedTab = localStorage.getItem('selectedTab');
if (selectedTab != null) {
    $('a[data-toggle="tab"][href="' + selectedTab + '"]').tab('show');
}
        });


    </script>
