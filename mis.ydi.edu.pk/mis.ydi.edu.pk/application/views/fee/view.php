
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        View <?php echo $heading ?> Profile
        <a href="<?php echo site_url('admin/fee'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">


        <div>
            <div id="user-profile-1" class="user-profile row">
                <div class="col-xs-12 col-sm-3 center">
                    <div>
                        <?php $image = AdminLTE::student_image($r->reg_no); ?>
                        <span class="profile-picture">
                            <img class="img-responsive" width="180" height="150" alt="<?php echo AdminLTE::student_name($r->reg_no); ?>" src="<?php echo site_url('images/' . $image); ?>" />
                        </span>

                        <div class="space-4"></div>

                        <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                            <div class="inline position-relative">
                                <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                    <i class="ace-icon fa fa-circle light-green"></i>
                                    &nbsp;
                                    <span class="white"><?php echo ucwords(strtolower(AdminLTE::student_name($r->reg_no))); ?></span>
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="space-6"></div>

                    <div class="hr hr16 dotted"></div>
                </div>

                <div class="col-xs-12 col-sm-9">

                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Class </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo AdminLTE::student_class($r->class) . " " . $r->session ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Month </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->month ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Session </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->session ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Total Fee </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->total ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Date of Submission </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="signup"><?php echo $r->date_of_payment ?></span>
                            </div>
                        </div>


                    </div>

                    <div class="space-10"></div>


                </div>
                <div class="col-xs-12 col-sm-9">

                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Transport Fee </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->transport ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Tuition Fee </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->tuition ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Hostel Fee </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->hostel ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Promotion Fee </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="signup"><?php echo $r->promotion ?></span>
                            </div>
                        </div>


                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Exam Fee </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="signup"><?php echo $r->exam ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Other Dues</div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="signup"><?php echo $r->dues ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="space-10"></div>


                </div>
            </div>

        </div>


        <!-- PAGE CONTENT ENDS -->


        <div class="space-6"></div>

    </div>


    <div class="vspace-12-sm"></div>
</div><!-- /.row -->


