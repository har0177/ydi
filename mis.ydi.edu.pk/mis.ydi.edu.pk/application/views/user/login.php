
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
           <link rel="icon" type="image/jpg" href="<?php echo site_url('images/logo.jpg'); ?>" />
        <title>YDI - Login Page</title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>dist/css/bootstrap.min.css" />
       <link rel="stylesheet" href="<?php echo base_url() ?>dist/font-awesome/css/font-awesome.css" />

        <!-- text fonts -->
        <link rel="stylesheet" href="<?php echo base_url() ?>dist/css/fonts.googleapis.com.css" />
   <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo base_url() ?>dist/css/ace.min.css" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="<?php echo base_url() ?>css/ace-part2.min.css" />
        <![endif]-->
        <link rel="stylesheet" href="<?php echo base_url() ?>dist/css/ace-rtl.min.css" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="<?php echo base_url() ?>css/ace-ie.min.css" />
        <![endif]-->

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
        <style>
      fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
	}	
	
		legend
		{
			font-size:14px;
			font-weight:bold;
			margin-bottom: 0px; 
			width: 50%; 
			border: 1px solid #ddd;
			border-radius: 4px; 
			padding: 5px 5px 5px 10px; 
			background-color: #ffffff;
		}
                .form-horizontal .control-label {
    text-align: center;
    margin-bottom: 0;
    padding-top: 7px;
}

        </style>
    </head>

    <body class="login-layout">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h1>
                                    <i class="ace-icon fa fa-book green"></i>
                                    <span class="red">YDI</span>
                                    <span class="white" id="id-text2">MIS System</span>
                                </h1>
                                
                            </div>

                            <div class="space-6"></div>
                   <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                           <h4 class="text-center blue lighter bigger">
                                                <img  height="80px" alt="logo" src="<?php echo site_url('images/logo.jpg'); ?>" />

                                            </h4>

                                            <div class="space-6"></div>

                                            <fieldset >
                                                <legend>Login to YDI</legend>
                                                <?php
                                                flash_alert();
                                                echo validation_errors('<div class="alert alert-danger">', '</div>')
                                                ?>
                                                <?php echo form_open('admin/user/login', ['class' => 'form-horizontal']); ?>

                                                    <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input class="form-control" required="" placeholder="Username" id="username" name="username" type="text" />  <i class="ace-icon fa fa-envelope"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input class="form-control " required="" placeholder="Password"  id="password" name="password" type="password" />  <i class="ace-icon fa fa-lock"></i>
                                                    </span>
                                                </label>
                                                <label class="block clearfix">
                                                    <span  class="col-sm-6 col-xs-6" style="">
                                                   
                                                        <input class=" " required="" name="level" type="radio" value="Manager"/> Manager    
                                                    </span>
                                                     <span  class="col-sm-6 col-xs-6" style="">
                                                   
                        <input class=" " required="" name="level" type="radio" value="Admin"/> Administrator
                                                        
                                                    </span>
                                                     <span  class="col-sm-6 col-xs-6" style="">
                                                   
                                                         <input class=" " required="" name="level" type="radio" value="Interviewer"/> Interviewer
                                                     </span>
                                                    <span  class="col-sm-6 col-xs-6" style="">
                                                   
                                                              <input class=" " required="" name="level" type="radio" value="Trainer"/> Trainer                                   </span>
                                                    <span  class="col-sm-6 col-xs-6" style="">
                                                   
                                                         <input class=" " required="" name="level" type="radio" value="Publications"/> Publications
                                                    </span>
                                                     <span  class="col-sm-6 col-xs-6" style="">
                                                   
                                                         <input class=" " required="" name="level" type="radio" value="NawayTakay"/> Naway Takay
                                                    </span>
                                                    <span  class="col-sm-6 col-xs-6" style="">
                                                   
                                                         <input class=" " required="" name="level" type="radio" value="Internee"/> Internee
                                                    </span>
                                                </label>
                                                <div class="space"></div>

                                                
                                                <div class="clearfix">
                                                        <button type="submit" class="width-35 pull-right btn btn-sm btn-success">
                                                            <i class="ace-icon fa fa-key"></i>
                                                            <span class="bigger-110">Login</span>
                                                        </button>
                                                    </div>

                                            </fieldset>


                                            <?php echo form_close(); ?>
                                           
                                        </div><!-- /.widget-main -->

                                        <div class="toolbar clearfix">
                                            <div>
                                                <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                    <i class="ace-icon fa fa-arrow-left"></i>
                                                    I Forgot My Password
                                                </a>
                                            </div>

                                        </div>
                                    </div><!-- /.widget-body -->
                                </div><!-- /.login-box -->

                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="text-center blue lighter bigger">
                                                <img  height="80px" alt="logo" src="<?php echo site_url('images/logo.jpg'); ?>" />

                                            </h4>

                                            <div class="space-6"></div>
                                            <p>
                                                Enter Your Email Address to Receive Instructions!
                                            </p>

                                           <?php echo form_open('admin/user/forget', ['class' => 'form-horizontal']); ?>
                                            
                                                <fieldset>
                                                    <legend>Retrieve Password</legend>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" name="email" class="form-control" placeholder="Email" />
                                                            <i class="ace-icon fa fa-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="ace-icon fa fa-lightbulb-o"></i>
                                                            <span class="bigger-110">Send Me!</span>
                                                        </button>
                                                    </div>
                                                </fieldset>
                                           

                                            <?php echo form_close(); ?>
                                           
                                        </div><!-- /.widget-main -->

                                        <div class="toolbar center">
                                            <a href="#" data-target="#login-box" class="back-to-login-link">
                                                Back to Login
                                                <i class="ace-icon fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div><!-- /.widget-body -->
                                </div><!-- /.forgot-box -->

                              
                            </div><!-- /.position-relative -->

                          <div class="footer-content" style="text-align: center">
                            <span class="bigger-120" style="color: #fff">
                                <span class="blue bolder">YDI</span>
                                <br>
                                Xpertz Dev &copy; 2019 
                            </span>

                            &nbsp; &nbsp;
                        </div>
                        </div>
                    </div><!-- /.col -->
                    
                </div><!-- /.row -->
                
                
            </div><!-- /.main-content -->
            
        </div><!-- /.main-container -->

        <!-- basic scripts -->
        <script src="<?php  echo base_url() ?>dist/jquery.min.js"></script>


		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});
			
		</script>

    </body>
</html>
