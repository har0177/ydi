
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        View <?php echo $heading ?> Profile
        <a href="<?php echo site_url('admin/accounts'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">


        <div>
            <div id="user-profile-1" class="user-profile row">
                <div class="col-xs-12 col-sm-3 center">
                    <div>
                        <?php $image = AdminLTE::employee_image($r->emp_id); ?>
                        <span class="profile-picture">
                             <?php if($image == ""){
                  ?>
                        <img class="img-responsive" width="180" height="150" alt="<?php echo ucwords(strtolower(AdminLTE::employee_name($r->emp_id))); ?>" src="<?php echo site_url('images/profile.png'); ?>" />
                      
                <?php
                }else{ ?>
                     <img class="img-responsive" width="180" height="150" alt="<?php echo ucwords(strtolower(AdminLTE::employee_name($r->emp_id))); ?>" src="<?php echo site_url('images/' . $image); ?>" />
                      
                <?php } ?>
                        </span>

                        <div class="space-4"></div>

                        <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                            <div class="inline position-relative">
                                <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                    <i class="ace-icon fa fa-circle light-green"></i>
                                    &nbsp;
                                    <span class="white"><?php echo ucwords(strtolower(AdminLTE::employee_name($r->emp_id))); ?></span>
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
                            <div class="profile-info-name viewname"> Month </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->month ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Year </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->year ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Amount </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->amount ?></span>
                            </div>
                        </div>

                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Received Date </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="signup"><?php echo $r->received_date ?></span>
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


