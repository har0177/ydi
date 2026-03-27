<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8" />
        <link rel="icon" type="image/jpg" href="<?php echo site_url('images/logo.jpg'); ?>" />
        <meta charset="<?php echo $this->config->item('charset'); ?>">
        <title><?php echo $heading; ?> : Dashboard - Admin Panel</title>
        <link rel="stylesheet" href="<?php echo base_url('dist/css/bootstrap.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('dist/font-awesome/css/font-awesome.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('dist/font-awesome/css/font-awesome.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('dist/css/ace.min.css'); ?>" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="<?php echo base_url('dist/css/style.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('dist/css/select2.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('dist/responsive-tables.css'); ?>" />
        <script src="<?php echo base_url('dist/js/ace-extra.min.js'); ?>"></script>
        <script src="<?php echo base_url() . 'dist/webcam.js' ?>"></script>
        <script src="<?php echo base_url('dist/jquery.min.js'); ?>"></script>
 <style>
            .viewname{
                text-align: center;
                width: 150px;

            }

            .viewname1{
                text-align: center;
                width: 250px;

            }

            .borderless tr th {
                border: none !important;
            }
            .borderless tr td {
                border-top: 1px solid black;
                border-bottom: 1px solid black;
            }

            @media print{

                .table tr th {
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                    font-size: 20px;
                    font-family: "calibri";
                }

                .table tr td {
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                    font-size: 18px;
                    font-family: "calibri";
                }
            }

        </style>

    </head>
    <body class="no-skin">
        <div id="navbar" class="navbar navbar-default">
            <div class="navbar-container" id="navbar-container">
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-header pull-left">
                    <a class="navbar-brand">	<small>	<i class="fa fa-book"></i>YDI</small></a>
                </div>
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li><a href="">   <?php echo $this->session->user_name . " - " . $this->session->user_level; ?></a></li>
                        <li><a href="<?php echo base_url('nawaytakay/profile') ?>"><i class="ace-icon fa fa-user"></i>Profile</a></li>
                        <li><a href="<?php echo base_url('nawaytakay/logout'); ?>"> <i class="ace-icon fa fa-power-off"></i>Logout</a> </li>
                    </ul>
                </div>
            </div><!-- /.navbar-container -->
        </div>
        <div class="main-container" id="main-container">
            <div id="sidebar" class="sidebar responsive">
                <ul class="nav nav-list">
                    <li class="active">
                        <a href="<?php echo base_url('nawaytakay') ?>">
                            <i class="menu-icon fa fa-tachometer"></i>
                            <span class="menu-text"> Dashboard </span>
                        </a> <b class="arrow"></b>
                    </li>
                   
                    <li class="">
                        <a href="#" class="dropdown-toggle">
                            <i class="menu-icon fa fa-users"></i>
                            <span class="menu-text">   Manage Students </span>
                            <b class="arrow fa fa-angle-down"></b></a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                <a href="<?php echo site_url('nawaytakay/all'); ?>"> <i class="menu-icon fa fa-book"></i> All Students </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="<?php echo site_url('nawaytakay/group'); ?>">
                                    <i class="menu-icon fa fa-phone"></i> Send Group SMS </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="<?php echo site_url('nawaytakay/bulk'); ?>">
                                    <i class="menu-icon fa fa-phone"></i> Send Selective SMS </a>
                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                     <li class="">
                        <a href="" class="dropdown-toggle">
                            <i class="menu-icon fa fa-newspaper-o"></i>
                            <span class="menu-text">   Manage Attendance </span> <b class="arrow fa fa-angle-down"></b></a>
                        <b class="arrow"></b>
                        <ul class="submenu">
                            <li class="">
                                <a href="<?php echo site_url('nawaytakay/all_attend'); ?>">
                                    <i class="menu-icon fa fa-dashboard"></i> Dashboard </a>
                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="<?php echo site_url('nawaytakay/search'); ?>">
                                    <i class="menu-icon fa fa-plus-square"></i>  Add Attendance  </a> <b class="arrow"></b></li>
                           
                        </ul>
                    </li>
                    <li class="">
                            <a href="" class="dropdown-toggle">
                                <i class="menu-icon fa fa-money"></i>
                                <span class="menu-text">   Manage Student Fee </span> <b class="arrow fa fa-angle-down"></b></a>
                            <b class="arrow"></b>
                            <ul class="submenu">
                               
                                <li class="">
                                    <a href="<?php echo site_url('nawaytakay/all_fee'); ?>">
                                        <i class="menu-icon fa fa-money"></i> All Fee List </a>
                                    <b class="arrow"></b>
                                </li>
                         <li class="">
                                    <a href="<?php echo site_url('nawaytakay/single'); ?>">
                                        <i class="menu-icon fa fa-plus-square"></i>  Single Fee </a> <b class="arrow"></b></li>


                            </ul>
                        </li>
                       
                            <li class="active">
                                <a href="<?php echo site_url('expensesnaway'); ?>">
                                    <i class="menu-icon fa fa-money"></i> All Expenses </a>
                                <b class="arrow"></b>
                            </li>
                            
                             <li class="active">
                                <a href="<?php echo site_url('nawaytakay/all_words'); ?>">
                                    <i class="menu-icon fa fa-book"></i> Weekly Words </a>
                                <b class="arrow"></b>
                            </li>
                        


                    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                    </div>

            </div>
            <div class="main-content">
                <div class="main-content-inner">
                    <div class="page-content">
                        <div class="page-header hidden-print">
                            <?php
                            flash_alert();
                            echo validation_errors('<div class="alert alert-danger">', '</div>');
                            ?>
                        </div>

                        <?php
                        echo $body;
                        ?>
                        <br>

                    </div>
                </div>
            </div>
            <div class="footer hidden-print">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder">YDI</span>
                            <br>
                            Xpertz Dev &copy; <?php echo date("Y") ?>
                        </span>

                        &nbsp; &nbsp;
                    </div>
                </div>
            </div>

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
        
        <script src="<?php echo base_url('dist/bootstrap.min.js'); ?>"></script>
        
        <script src="<?php echo base_url('dist/js/select2.min.js'); ?>"></script>

        <script src="<?php echo base_url('dist/js/ace-elements.min.js'); ?>"></script>
        <script src="<?php echo base_url('dist/js/ace.min.js'); ?>"></script>

        <script src="<?php echo base_url('dist/jquery.dataTables.min.js'); ?>"></script>

        <script src="<?php echo base_url('dist/js/jquery.table2excel.min.js'); ?>"></script>

        <script type="text/javascript">

            jQuery(function ($) {

                $('[data-rel=tooltip]').tooltip();

                $(".select2").css('width', '300px').select2({allowClear: true})
                        .on('change', function () {
                            $(this).closest('form').validate().element($(this));
                        });

                $(document).one('ajaxloadstart.page', function (e) {
                    //in ajax mode, remove remaining elements before leaving page
                    $('[class*=select2]').remove();
                });
            })
        </script>


        <script type="text/javascript">
            jQuery(document).ready(function () {
                // dynamic table
                jQuery('#dyntable').dataTable({
                    "sPaginationType": "full_numbers",
                    "aaSortingFixed": [[0, 'asc']],
                    "bSort": false,
                    "fnDrawCallback": function (oSettings) {
                        jQuery.uniform.update();
                    }
                });
                $('#export').click(function () {
                    //Some code
                    jQuery("#dyntableExport").table2excel({
                        exclude: ".noExl",
                        name: "Excel Document Name",
                        filename: "Backup",
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true,
                        "sPaginationType": "full_numbers",
                        "aaSortingFixed": [[0, 'asc']],
                        "fnDrawCallback": function (oSettings) {
                            jQuery.uniform.update();
                        }
                    });
                });
                jQuery('#dyntable2').dataTable({
                    "bScrollInfinite": true,
                    "bScrollCollapse": true,
                    "sScrollY": "300px"
                });

            });

        </script>

    </body>

</html>
