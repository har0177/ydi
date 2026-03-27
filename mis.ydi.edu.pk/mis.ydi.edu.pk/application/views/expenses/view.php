
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
        View <?php echo $heading ?> Profile
        <a href="<?php echo site_url('admin/expenses'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">


        <div>
            <div id="user-profile-1" class="user-profile row">


                <div class="col-xs-12 col-sm-12">

                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Receipt No </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->rec_no ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Expense Type </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo AdminLTE::exp_name($r->exp_id) ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Amount </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->amount ?></span>
                            </div>
                        </div>


                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Comments </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo $r->comments ?></span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name viewname"> Date </div>

                            <div class="profile-info-value viewname1">
                                <span class="editable" id="username"><?php echo dateformatesformysql_fata($r->date) ?></span>
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


