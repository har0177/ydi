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
            <img src="<?php echo site_url('assets/img/cover-default.jpg'); ?>" height="400px" alt="<?php echo $this->session->user_name ?>" onerror="this.style.display='none'">
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
                    <img src="https://mis.ydi.edu.pk/images/<?php echo AdminLTE::student_image($this->session->user_logged, 'img'); ?>" class="" alt="<?php echo $this->session->user_name ?>" onerror="this.outerHTML='<div class=&quot;ydi-avatar-fallback&quot;>'+(this.alt?this.alt.charAt(0).toUpperCase():'?')+'</div>'">
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
                        <?php
                        $stats = AdminLTE::game_stats($this->session->user_logged);
                        $statsJson = htmlspecialchars(json_encode($stats), ENT_QUOTES, 'UTF-8');
                        $admissionRaw = AdminLTE::student_data($this->session->user_logged, "do_admission");
                        $admissionDisplay = $admissionRaw && $admissionRaw !== '0000-00-00'
                            ? date('M j, Y', strtotime($admissionRaw)) : '';

                        $regNo        = $this->session->user_logged;
                        $fatherName   = ucwords(strtolower(AdminLTE::student_data($regNo, "f_name") ?: ''));
                        $cnic         = AdminLTE::student_data($regNo, "cnic");
                        $address      = AdminLTE::student_data($regNo, "address");
                        $stdOf        = AdminLTE::student_data($regNo, "std_of");
                        $qualification= AdminLTE::student_data($regNo, "qualification");
                        $employment   = AdminLTE::student_data($regNo, "employment");
                        $cardStatus   = AdminLTE::student_data($regNo, "card_status");
                        $courseRaw    = AdminLTE::student_data($regNo, "course");
                        $courseName   = $courseRaw ? strtoupper(AdminLTE::student_course($courseRaw)) : '';
                        $admissionFmt = $admissionRaw && $admissionRaw !== '0000-00-00'
                            ? date('d M, Y', strtotime($admissionRaw)) : '';

                        $dobRaw = AdminLTE::student_data($regNo, "dob");
                        $dobParts = explode("-", (string) $dobRaw);
                        $dobFmt = '';
                        $dobWords = '';
                        if (count($dobParts) === 3 && strtotime($dobRaw)) {
                            $dobFmt = date('d M, Y', strtotime($dobRaw));
                            ob_start(); AdminLTE::day($dobParts[2]);   $dW_d = ob_get_clean();
                            ob_start(); AdminLTE::month($dobParts[1]); $dW_m = ob_get_clean();
                            ob_start(); AdminLTE::year($dobParts[0]);  $dW_y = ob_get_clean();
                            $dobWords = trim($dW_d . ' ' . $dW_m . ', ' . $dW_y);
                        }

                        $ph = function ($v) {
                            $v = trim((string) $v);
                            return $v === '' || $v === '0' || strtolower($v) === 'na' ? '<span class="ydi-empty">—</span>' : htmlspecialchars($v, ENT_QUOTES);
                        };
                        ?>

                        <!-- ========== HERO BAND ========== -->
                        <section class="relative overflow-hidden rounded-3xl mb-8 bg-slate-900 text-white">
                            <!-- gradient mesh backdrop -->
                            <div class="absolute inset-0 bg-gradient-to-br from-primary-700 via-primary-600 to-secondary-700"></div>
                            <div class="absolute -top-24 -right-24 w-[28rem] h-[28rem] rounded-full bg-secondary-400/30 blur-3xl"></div>
                            <div class="absolute -bottom-32 -left-24 w-[28rem] h-[28rem] rounded-full bg-fuchsia-500/20 blur-3xl"></div>
                            <div class="absolute inset-0 opacity-[0.08]" style="background-image: radial-gradient(circle at 1px 1px, #fff 1px, transparent 0); background-size: 22px 22px;"></div>

                            <div class="relative p-6 lg:p-8">
                                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                                    <div class="min-w-0">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-white/70 mb-3">Student Dashboard</p>
                                        <h1 class="font-display font-bold leading-[1.05] tracking-tight text-4xl lg:text-5xl">
                                            Hello, <span class="bg-gradient-to-r from-amber-200 via-white to-amber-100 bg-clip-text text-transparent"><?php echo htmlspecialchars($this->session->user_name); ?></span>.
                                        </h1>
                                        <p class="mt-3 text-sm lg:text-base text-white/80 max-w-xl">
                                            <?php if ($admissionFmt): ?>
                                                Member since <?php echo $admissionFmt; ?> · <span class="tabular-nums"><?php echo (int)$stats['days_enrolled']; ?></span> days at YDI · <?php echo $courseName ? htmlspecialchars($courseName) : 'Course pending'; ?>
                                            <?php else: ?>
                                                Welcome to your YDI student portal.
                                            <?php endif; ?>
                                        </p>
                                    </div>

                                    <!-- inline live stats -->
                                    <div class="flex flex-wrap gap-2.5 lg:flex-nowrap">
                                        <div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur px-4 py-3 min-w-[120px]">
                                            <p class="text-[10px] font-semibold uppercase tracking-widest text-white/60">Attendance</p>
                                            <p class="font-display font-bold text-2xl tabular-nums leading-none mt-1.5"><?php echo (int)$stats['attendance_pct']; ?><span class="text-sm text-white/60 ml-0.5">%</span></p>
                                        </div>
                                        <div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur px-4 py-3 min-w-[120px]">
                                            <p class="text-[10px] font-semibold uppercase tracking-widest text-white/60">XP</p>
                                            <p class="font-display font-bold text-2xl tabular-nums leading-none mt-1.5"><?php echo (int)$stats['xp']; ?></p>
                                        </div>
                                        <div class="rounded-2xl bg-white/10 border border-white/15 backdrop-blur px-4 py-3 min-w-[120px] flex items-center gap-2">
                                            <svg class="w-5 h-5 text-amber-300" fill="currentColor" viewBox="0 0 24 24"><path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.59 2.65.59 4.04 0 2.65-2.15 4.8-4.8 4.8z"/></svg>
                                            <div>
                                                <p class="text-[10px] font-semibold uppercase tracking-widest text-white/60">Streak</p>
                                                <p class="font-display font-bold text-xl tabular-nums leading-none mt-1"><?php echo (int)$stats['streak']; ?> <span class="text-sm font-medium text-white/60">d</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- ========== PERSONAL INFORMATION ========== -->
                        <section class="mb-10">
                            <div class="flex items-end justify-between gap-4 mb-5">
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-600 mb-1">01 — Profile</p>
                                    <h3 class="font-display text-2xl font-bold text-slate-900 tracking-tight">Personal Information</h3>
                                    <p class="text-sm text-slate-500 mt-1">Your registered details at YDI. Contact admin if anything is incorrect.</p>
                                </div>
                                <?php if ($cardStatus == 1): ?>
                                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        ID Card Issued
                                    </span>
                                <?php else: ?>
                                    <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        ID Card Not Issued
                                    </span>
                                <?php endif; ?>
                            </div>

                            <?php
                            $infoIcon = function($svgPath) {
                                return '<svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">' . $svgPath . '</svg>';
                            };
                            $iCard = '<path d="M3 8l9-5 9 5M3 8v10a2 2 0 002 2h14a2 2 0 002-2V8M3 8l9 5 9-5M9 14h6"/>';
                            $iCal  = '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>';
                            $iBook = '<path d="M4 19.5A2.5 2.5 0 016.5 17H20V3H6.5A2.5 2.5 0 004 5.5v14zM4 19.5V21h15"/>';
                            $iUser = '<path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>';
                            $iId   = '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M9 9h6M9 13h6M9 17h3"/>';
                            $iCake = '<path d="M20 21v-8a2 2 0 00-2-2H6a2 2 0 00-2 2v8M4 21h16M2 17h20M5 11V8a2 2 0 012-2h10a2 2 0 012 2v3M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>';
                            $iPin  = '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 1118 0z"/><circle cx="12" cy="10" r="3"/>';
                            $iSch  = '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5a6 3 0 0012 0v-5"/>';
                            $iCap  = '<path d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>';
                            $iWork = '<path d="M21 13.255A23.93 23.93 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>';

                            $cell = function($icon, $label, $value, $sub = '', $wide = false) {
                                $cls = 'group bg-white border border-slate-200 rounded-2xl p-5 hover:border-primary-300 hover:shadow-[0_8px_24px_rgba(124,58,237,0.08)] transition';
                                if ($wide) $cls .= ' lg:col-span-2';
                                echo '<div class="' . $cls . '">';
                                echo '  <div class="flex items-center gap-2 mb-2">';
                                echo '    <div class="w-7 h-7 rounded-lg bg-primary-50 group-hover:bg-primary-100 flex items-center justify-center transition">';
                                echo $icon;
                                echo '    </div>';
                                echo '    <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500">' . $label . '</p>';
                                echo '  </div>';
                                echo '  <p class="font-display text-base font-semibold text-slate-900 leading-snug break-words">' . $value . '</p>';
                                if ($sub) echo '  <p class="text-xs text-slate-500 mt-1">' . $sub . '</p>';
                                echo '</div>';
                            };
                            ?>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                <?php $cell($infoIcon($iCard), 'Registration', htmlspecialchars($regNo)); ?>
                                <?php $cell($infoIcon($iCal),  'Admission Date', $admissionFmt ?: '<span class="text-slate-400 font-normal">—</span>'); ?>
                                <?php $cell($infoIcon($iBook), 'Course', $courseName ? htmlspecialchars($courseName) : '<span class="text-slate-400 font-normal">—</span>', '', true); ?>

                                <?php $cell($infoIcon($iUser), 'Father / Guardian', $ph($fatherName)); ?>
                                <?php $cell($infoIcon($iId),   'CNIC', $ph($cnic)); ?>
                                <?php $cell($infoIcon($iCake), 'Date of Birth', $dobFmt ?: '<span class="text-slate-400 font-normal">—</span>', $dobWords ? htmlspecialchars($dobWords) : '', true); ?>

                                <?php $cell($infoIcon($iPin),  'Permanent Address', $ph($address), '', true); ?>
                                <?php $cell($infoIcon($iSch),  'Studying At', $ph($stdOf)); ?>
                                <?php $cell($infoIcon($iCap),  'Qualification', $ph($qualification)); ?>

                                <?php $cell($infoIcon($iWork), 'Employment', $ph($employment), '', true); ?>
                            </div>
                        </section>

                        <!-- ========== PERFORMANCE ========== -->
                        <section class="mb-10">
                            <div class="flex items-end justify-between gap-4 mb-5">
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-600 mb-1">02 — Progress</p>
                                    <h3 class="font-display text-2xl font-bold text-slate-900 tracking-tight">Performance Snapshot</h3>
                                    <p class="text-sm text-slate-500 mt-1">Live numbers from your attendance, weekly evaluations, and fee record.</p>
                                </div>
                            </div>

                            <div id="ydi-game"
                                 class="grid grid-cols-1 lg:grid-cols-12 gap-4"
                                 data-reg="<?php echo htmlspecialchars($regNo, ENT_QUOTES); ?>"
                                 data-name="<?php echo htmlspecialchars($this->session->user_name, ENT_QUOTES); ?>"
                                 data-admission-display="<?php echo htmlspecialchars($admissionDisplay, ENT_QUOTES); ?>"
                                 data-stats="<?php echo $statsJson; ?>">
                                <svg width="0" height="0" style="position:absolute" aria-hidden="true">
                                    <defs>
                                        <linearGradient id="ydiGrad" x1="0" y1="0" x2="1" y2="1">
                                            <stop offset="0%" stop-color="#7c3aed"/>
                                            <stop offset="100%" stop-color="#3b82f6"/>
                                        </linearGradient>
                                    </defs>
                                </svg>

                                <!-- Big attendance ring -->
                                <div class="lg:col-span-5 relative overflow-hidden rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
                                    <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full bg-primary-100/40 blur-2xl pointer-events-none"></div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-primary-600 mb-1 flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                                        Attendance
                                    </p>
                                    <h4 class="font-display text-lg font-semibold text-slate-900 mb-5">Class Attendance Rate</h4>
                                    <div class="flex items-center gap-6">
                                        <div class="relative w-36 h-36 flex-none">
                                            <svg viewBox="0 0 80 80" class="w-full h-full -rotate-90">
                                                <circle cx="40" cy="40" r="34" fill="none" stroke="#f1f5f9" stroke-width="6"/>
                                                <circle cx="40" cy="40" r="34" fill="none" stroke="url(#ydiGrad)" stroke-width="6" stroke-linecap="round" data-game-ring/>
                                            </svg>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="text-center">
                                                    <span class="font-display font-bold text-3xl text-slate-900 tabular-nums" data-game-pct>0</span>
                                                    <span class="block text-[10px] font-semibold uppercase tracking-widest text-slate-500 -mt-1">percent</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0 space-y-3">
                                            <div>
                                                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Present</p>
                                                <p class="font-display text-2xl font-bold text-emerald-600 tabular-nums"><?php echo (int)$stats['present']; ?></p>
                                            </div>
                                            <div>
                                                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Absent</p>
                                                <p class="font-display text-2xl font-bold text-rose-500 tabular-nums"><?php echo (int)$stats['absent']; ?></p>
                                            </div>
                                            <div>
                                                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Days</p>
                                                <p class="font-display text-2xl font-bold text-slate-900 tabular-nums"><?php echo (int)($stats['present'] + $stats['absent']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Level + XP card -->
                                <div class="lg:col-span-7 relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-primary-900 to-secondary-900 text-white p-6 shadow-lg">
                                    <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-secondary-400/20 blur-3xl pointer-events-none"></div>
                                    <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full bg-primary-400/15 blur-3xl pointer-events-none"></div>
                                    <div class="relative">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/60 mb-1 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-300"></span>
                                            Level &amp; XP
                                        </p>
                                        <h4 class="font-display text-lg font-semibold mb-6">Your Journey</h4>

                                        <div class="flex items-center gap-5 mb-6">
                                            <div class="w-20 h-20 rounded-2xl bg-white/10 border border-white/20 backdrop-blur flex items-center justify-center text-4xl flex-none shadow-2xl" data-game-level-emoji>🌱</div>
                                            <div class="min-w-0">
                                                <p class="text-xs uppercase tracking-widest text-white/60 font-semibold">Current Level</p>
                                                <p class="font-display text-3xl font-bold tracking-tight" data-game-level-name>Newcomer</p>
                                                <p class="text-sm text-white/70 mt-1" data-game-tenure></p>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between items-end mb-2">
                                                <span class="text-xs uppercase tracking-widest text-white/60 font-semibold">Experience</span>
                                                <span class="font-display text-sm font-semibold text-white tabular-nums" data-game-xp-text></span>
                                            </div>
                                            <div class="h-2.5 rounded-full bg-white/10 overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-amber-300 via-amber-200 to-white rounded-full transition-[width] duration-1000 shadow-[0_0_18px_rgba(252,211,77,0.45)]" style="width: 0" data-game-xp-fill></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- KPI strip -->
                                <div class="lg:col-span-12 bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 divide-x divide-slate-200">
                                        <div class="p-5">
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500 mb-1.5">Latest Score</p>
                                            <p class="font-display text-3xl font-bold text-slate-900 tabular-nums"><span data-game-latest>0</span><span class="text-base font-medium text-slate-400 ml-0.5">%</span></p>
                                        </div>
                                        <div class="p-5">
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500 mb-1.5">Average</p>
                                            <p class="font-display text-3xl font-bold text-slate-900 tabular-nums"><span data-game-avg>0</span><span class="text-base font-medium text-slate-400 ml-0.5">%</span></p>
                                        </div>
                                        <div class="p-5">
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500 mb-1.5">Best Score</p>
                                            <p class="font-display text-3xl font-bold text-slate-900 tabular-nums"><span data-game-best>0</span><span class="text-base font-medium text-slate-400 ml-0.5">%</span></p>
                                        </div>
                                        <div class="p-5">
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500 mb-1.5">Reports</p>
                                            <p class="font-display text-3xl font-bold text-slate-900 tabular-nums" data-game-reports>0</p>
                                        </div>
                                        <div class="p-5">
                                            <p class="text-[10px] font-semibold uppercase tracking-[0.14em] text-slate-500 mb-1.5">Class Rank</p>
                                            <p class="font-display text-3xl font-bold text-slate-900 tabular-nums" data-game-rank>—</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fee status card -->
                                <div class="lg:col-span-12 relative overflow-hidden rounded-3xl border border-slate-200 bg-gradient-to-r from-white via-amber-50/40 to-white p-6 shadow-sm flex items-center justify-between flex-wrap gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center flex-none">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500 mb-0.5">Outstanding Fee Dues</p>
                                            <p class="font-display text-3xl font-bold text-slate-900 tabular-nums">PKR <span data-game-dues>0</span></p>
                                        </div>
                                    </div>
                                    <a href="#" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold transition shadow-sm">
                                        Contact Accounts
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </section>

                        <!-- ========== ACHIEVEMENTS ========== -->
                        <section class="mb-10">
                            <div class="flex items-end justify-between gap-4 mb-5">
                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-600 mb-1">03 — Milestones</p>
                                    <h3 class="font-display text-2xl font-bold text-slate-900 tracking-tight">Achievements</h3>
                                    <p class="text-sm text-slate-500 mt-1">Unlock badges as you progress through your YDI program.</p>
                                </div>
                            </div>

                            <div class="bg-white border border-slate-200 rounded-3xl p-5 lg:p-6 shadow-sm">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3" data-game-badges></div>
                            </div>
                        </section>
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
                                $idEsc = $this->db->escape($id);
                                $dateEsc = $this->db->escape($weekdata->date);
                                $query = $this->db->query("Select * from trainer_data where regno = $idEsc and date = $dateEsc");
                                $rows = ($query && method_exists($query, 'result')) ? $query->result() : [];
                                foreach ($rows as $value) {
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
    $regno = $this->db->escape($this->session->user_logged);
    $year = (int) date("Y");
    $qc = $this->db->query("SELECT SUM(paid) as paid, SUM(dues) as unpaid, MONTHNAME(date_of_payment) as date FROM fee WHERE reg_no = $regno AND year = $year GROUP BY MONTH(date_of_payment), MONTHNAME(date_of_payment) ORDER BY MONTH(date_of_payment)");
    $rows = ($qc && method_exists($qc, 'result')) ? $qc->result() : [];
    $paid   = json_encode(array_columnn($rows, 'paid'), JSON_NUMERIC_CHECK);
    $unpaid = json_encode(array_columnn($rows, 'unpaid'), JSON_NUMERIC_CHECK);
    $datee  = json_encode(array_columnn($rows, 'date'), JSON_NUMERIC_CHECK);
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
        'student.reg_no' => $this->session->user_logged,
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
    $rowsLB = ($query && method_exists($query, 'result')) ? $query->result() : [];
    $part = function ($v) {
        $arr = explode('-', (string) $v);
        return isset($arr[0]) && is_numeric($arr[0]) ? (int) $arr[0] : 0;
    };
    foreach ($rowsLB as $value) {
        $name = AdminLTE::student_name($value->regno);
        $comp   = $part($value->comp ?? '');
        $grac   = $part($value->grac ?? '');
        $flu    = $part($value->flu ?? '');
        $compre = $part($value->compro ?? '');
        $voca   = $part($value->voca ?? '');
        $mlang  = $part($value->mtol ?? '');
        $greet  = $part($value->greet ?? '');
        $blang  = $part($value->blang ?? '');
        $clevel = $part($value->clevel ?? '');
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
