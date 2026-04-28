<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8" />
        <link rel="icon" type="image/jpg" href="<?php echo site_url('images/logo.png'); ?>" />
        <meta charset="<?php echo $this->config->item('charset'); ?>">
        <title><?php echo $heading; ?> : YDI</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/animate.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/flatpickr.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" >

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/lib/slick/slick.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/lib/slick/slick-theme.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/portal-polish.css">

        <!-- YDI design system: Tailwind + fonts (matches ydi.edu.pk) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: '#f5f3ff', 100: '#ede9fe', 200: '#ddd6fe', 300: '#c4b5fd',
                                400: '#a78bfa', 500: '#7c3aed', 600: '#6d28d9', 700: '#5b21b6',
                                800: '#4c1d95', 900: '#3b0764'
                            },
                            secondary: {
                                50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd',
                                400: '#60a5fa', 500: '#3b82f6', 600: '#1e40af', 700: '#1e3a8a',
                                800: '#1e3a8a', 900: '#172554'
                            }
                        },
                        fontFamily: {
                            'sans': ['Inter', 'system-ui', 'sans-serif'],
                            'display': ['Poppins', 'system-ui', 'sans-serif']
                        }
                    }
                }
            }
        </script>

        <script src = "<?php echo base_url(); ?>dist/highcharts.js"></script>
        <script src="<?php echo base_url(); ?>dist/exporting.js"></script>
        <script>
            if (window.Highcharts) {
                Highcharts.setOptions({
                    colors: ['#7c3aed', '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#ec4899', '#8b5cf6'],
                    chart: {
                        backgroundColor: 'transparent',
                        style: { fontFamily: 'Inter, system-ui, sans-serif' },
                        spacing: [16, 8, 12, 8]
                    },
                    title: {
                        style: { color: '#0f172a', fontSize: '14px', fontWeight: '600', fontFamily: 'Poppins, sans-serif' },
                        align: 'left', x: 8, y: 4
                    },
                    subtitle: { style: { color: '#64748b', fontSize: '11px' } },
                    xAxis: {
                        gridLineColor: '#f1f5f9',
                        lineColor: '#e2e8f0',
                        tickColor: '#e2e8f0',
                        labels: { style: { color: '#64748b', fontSize: '11px', fontWeight: '500' } },
                        title: { style: { color: '#94a3b8', fontSize: '10px', textTransform: 'uppercase', letterSpacing: '0.06em' } }
                    },
                    yAxis: {
                        gridLineColor: '#f1f5f9',
                        lineColor: 'transparent',
                        tickColor: 'transparent',
                        labels: { style: { color: '#94a3b8', fontSize: '11px' } },
                        title: { style: { color: '#94a3b8', fontSize: '10px' } }
                    },
                    legend: {
                        itemStyle: { color: '#475569', fontSize: '11px', fontWeight: '500' },
                        itemHoverStyle: { color: '#0f172a' },
                        itemMarginTop: 4, itemMarginBottom: 4,
                        symbolRadius: 4
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        borderColor: 'transparent',
                        borderRadius: 8,
                        style: { color: '#fff', fontSize: '12px' },
                        useHTML: false,
                        padding: 10
                    },
                    plotOptions: {
                        column: { borderRadius: 6, borderWidth: 0, pointPadding: 0.1, groupPadding: 0.12 },
                        bar:    { borderRadius: 6, borderWidth: 0 },
                        line:   { lineWidth: 2.5, marker: { radius: 4, lineWidth: 2, lineColor: '#fff' } },
                        area:   { lineWidth: 2.5 },
                        pie:    { borderWidth: 0, dataLabels: { style: { color: '#0f172a', fontWeight: '500', textOutline: 'none' } } },
                        series: { animation: { duration: 900 } }
                    },
                    credits: { enabled: false },
                    exporting: { enabled: false }
                });
            }
        </script>
        <script defer src="<?php echo base_url(); ?>assets/js/portal-gamification.js"></script>
        <style>
            .responsive-table {
                width: 100%;
                overflow-y: scroll;
            }
            .img-responsive {
                display: block;
                max-width: 100%;
                width: 100%;
                height: auto;
            }
            strong, h3, h4{
                font-weight: bold;
            }
            .profile-info-row {
                display: table-row;
            }.profile-user-info-striped {
                border: 1px solid #DCEBF7;
            }
            .profile-user-info {
                display: table;
                width: 98%;
                width: calc(100% - 24px);
                margin: 0 auto;
            }.profile-info-row:first-child .profile-info-name {
                border-top: none;
            }
            .profile-user-info-striped .profile-info-name {
                color: #336199;
                background-color: #EDF3F4;
                border-top: 1px solid #F7FBFF;
            }
            .viewname {
                text-align: center;
                font-weight: bolder;

            }
            .profile-info-name {
                text-align: center;
                font-weight: 00;
                color: #667E99;
                background-color: transparent;
                border-top: 1px dotted #D5E4F1;
                display: table-cell;

                vertical-align: middle;
            }.profile-info-row:first-child .profile-info-value {
                border-top: none;
            }
            .profile-user-info-striped .profile-info-value {
                border-top: 1px dotted #DCEBF7;
                padding-left: 12px;
            }
            .viewname1 {
                text-align: center;

            }
            .profile-info-value {
                display: table-cell;
                padding: 6px 4px 6px 6px;
                border-top: 1px dotted #D5E4F1;
            }.space-10 {
                max-height: 1px;
                min-height: 1px;
                overflow: hidden;
                margin: 12px 0;
                margin: 10px 0 9px;
            }

            #buttona {
                position: fixed;
                right: 0;
                top: 75%;
                z-index: 1000;
            }

            .alert-minimalist {
                background-color: lightblue;
                border-color: rgba(149, 149, 149, 0.3);
                border-radius: 3px;
                color: rgb(149, 149, 149);
                padding: 10px;
            }
            .alert-minimalist > [data-notify="icon"] {
                height: 50px;
                width: 50px;
                margin-right: 12px;
            }
            .alert-minimalist > [data-notify="title"] {
                color: rgb(51, 51, 51);
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }

            .alert-minimalist > [data-notify="message"] {
                font-size: 80%;
                color: #111415;
            }
        </style>
    </head>

    <div class="wrapper">



        <header>
            <div class="container">
                <div class="header-data">
                    <div class="logo">
                        <a href="<?php echo base_url() ?>" title=""><img src="<?php echo site_url('images/logo.png') ?>" alt="YDI" height="50px" ></a>

                    </div><!--logo end-->

                    <div class="user-account">
                        <a href="https://www.ydi.edu.pk/quiz.php" id="buttona" target="_blank" title="Quizes">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span>Quizes</span>
                        </a>

                        <a href="#passwordmodel" data-toggle="modal" class="ydi-icon-btn" title="Password setting">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z"/></svg>
                        </a>

                        <div class="user-info">
                            <?php
                            if (empty(AdminLTE::student_image($this->session->user_logged, 'profile'))) {
                                ?>
                                <img  src="https://mis.ydi.edu.pk/images/<?php echo AdminLTE::student_image($this->session->user_logged, 'img'); ?>" height="40px" width="40px" alt="<?php echo $this->session->user_name ?>" onerror="this.outerHTML='<div class=&quot;ydi-avatar-fallback ydi-avatar-sm&quot;>'+(this.alt?this.alt.charAt(0).toUpperCase():'?')+'</div>'">
                                <?php
                            }
                            else {
                                ?>
                                <img  src="<?php echo site_url('images/' . AdminLTE::student_image($this->session->user_logged, 'profile')); ?>" height="40px" width="40px" alt="<?php echo $this->session->user_name ?>">
                            <?php } ?>
                            <a href="#" title="<?php echo $this->session->user_name ?>"><?php echo $this->session->user_name ?></a>
                            <i class="fa fa-arrow-circle-down"></i>
                        </div>

                        <a href="<?php echo base_url('user/logout'); ?>" class="ydi-icon-btn" title="Logout">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </a>

                        <div class="user-account-settingss" style="display:none">
                            <ul class="us-links"></ul>
                            <h3 class="tc"><a href="<?php echo base_url('user/logout'); ?>"></a></h3>
                        </div>
                    </div>
                </div><!--header-data end-->
            </div>
        </header><!--header end-->	





        <main>
            <div class="main-section">
                <div class="container">
                    <div class="main-section-data">


                        <?php
                        echo $body;
                        ?>

                    </div>
                </div>
            </div>
        </main>


        <div class="chatbox-list">
            <div class="chatbox">
                <div class="chat-mg" style="position: fixed;
                     right: 0;
                     top: 88%;

                     ">
                    <a href="#" title="" onclick="openForm()"><img src="<?php echo site_url() ?>assets/images/output-onlinepngtools.png" alt=""></a>

                </div>
                <div class="conversation-box" id="myForm">
                    <div class="con-title">
                        <h3><i class="fa fa-comments"></i> YDI Chat Room</h3>
                        <a href="#" title="" onclick="closeForm()"><i class="fa fa-minus-circle"></i></a>
                    </div>
                    <div class="panel-body">
                        <ul class="chat" id="received">

                        </ul>
                    </div>
                    <div class="panel-footer"  id="msg_block">
                        <form method="post" action="<?php echo base_url() ?>student/process" class="form">
                            <div class="input-group">
                                <input id="message" type="text" name="message" class="form-control input-sm" placeholder="Start Conversation here..." />

                                <span class="input-group-btn">
                                    <button class="btn btn-warning btn-sm" id="submit">Send</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
        <footer>
            <div class="footy-sec mn no-margin">
                <div class="container">

                    <p>Copyright <?php echo date('Y'); ?> by Xpertz Dev</p>

                </div>
            </div>
        </footer><!--footer end-->


    </div><!--theme-layout end-->



    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/popper.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/flatpickr.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/lib/slick/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/script.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/notify.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/notify.min.js"></script>

    <script>

                            $(document).ready(function () {
                                $("#successMessage").delay(5000).slideUp(300);
                                $("#notify").delay(5000).slideUp(300);
                            });
                            function openForm() {
                                document.getElementById("myForm").style.display = "block";
                            }

                           

                            function closeForm() {
                                document.getElementById("myForm").style.display = "none";
                            }
                            
                            $(document).mouseup(function(e) 
{
    var container = $("#myForm");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide();
    }
});
                   
 
    </script>

    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <script>

                            var setCookie = function (key, value) {
                                var expires = new Date();
                                expires.setTime(expires.getTime() + (5 * 60 * 1000));
                                document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
                            }

                            var getCookie = function (key) {
                                var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
                                return keyValue ? keyValue[2] : null;
                            }



                            if (getCookie('user_guid') == null || typeof (getCookie('user_guid')) == 'undefined') {
                                var user_guid = <?php echo $this->session->user_logged ?>;
                                setCookie('user_guid', user_guid);
                            }

                            $(".form").submit(function (e) {
                                e.preventDefault();

                                $.ajax({
                                    url: $(this).attr("action"),
                                    type: "post",
                                    data: new FormData($(this)[0]),
                                    contentType: false,
                                    processData: false,
                                    success: function (data) {

                                    }

                                });
                                $("#message").attr("disabled", "disabled");


                            });

                            // Enable pusher logging - don't include this in production
                            Pusher.logToConsole = true;

                            var pusher = new Pusher('87e9ce2e3ab856b2b087', {
                                cluster: 'ap1',
                                forceTLS: true
                            });



                            var channel = pusher.subscribe('YDI');
                            channel.bind('my-event', function (data) {
                                var html = "";
                                var is_me = data.guid == getCookie('user_guid');

                                if (is_me) {
                                    html = '<li class="right clearfix">';
                                    html += '	<span class="chat-img pull-right">';
                                    html += '		<img src="' + data.pic + '" alt="' + data.nickname + '" class="img-circle" style="height: 50px; width: 50px" />';
                                    html += '	</span>';
                                    html += '	<div class="chat-body clearfix">';
                                    html += '		<div class="header">';
                                    html += '			<small class="text-muted"><span class="glyphicon glyphicon-time"></span>' + data.timestamp + '</small>';
                                    html += '			<strong class="pull-right primary-font">' + data.nickname + '</strong>';
                                    html += '		</div>';
                                    html += '		<p>' + data.message + '</p>';
                                    html += '	</div>';
                                    html += '</li>';

                                } else {

                                    var html = '<li class="left clearfix">';
                                    html += '	<span class="chat-img pull-left">';
                                    html += '		<img src="' + data.pic + '" alt="' + data.nickname + '" class="img-circle" style="height: 50px; width: 50px" />';
                                    html += '	</span>';
                                    html += '	<div class="chat-body clearfix">';
                                    html += '		<div class="header">';
                                    html += '			<strong class="primary-font">' + data.nickname + '</strong>';
                                    html += '			<small class="pull-right text-muted"><span class="glyphicon glyphicon-time"></span>' + data.timestamp + '</small>';

                                    html += '		</div>';
                                    html += '		<p>' + data.message + '</p>';
                                    html += '	</div>';
                                    html += '</li>';

                                    $.notify({
                                        icon: data.pic,
                                        title: data.nickname,
                                        message: data.message

                                    }, {
                                        type: 'minimalist',
                                        delay: 5000,
                                        showProgressbar: true,
                                        icon_type: 'image',
                                        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                                                '<img data-notify="icon" class="img-circle pull-left">' +
                                                '<span data-notify="title">{1}</span>' +
                                                '<span data-notify="message">{2}</span>' +
                                                '</div>'
                                    });

                                }
                                $("#received").append(html);

                                $('#message').val("");
                                $("#message").removeAttr('disabled');
                                // Scroll to the bottom of the container when a new message becomes available
                                $(".panel-body").scrollTop($(".panel-body")[0].scrollHeight);
                            });



    </script>
</body>
</html>