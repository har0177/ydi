<div class="page-header hidden-print">
    <h1> 
        <i class="ace-icon fa fa-certificate"></i>
        ID Card of Student
        <?php
        if ($this->session->has_userdata('user_logged') && !$this->session->user_level == "CardMaker") {
            ?>
            <a href="<?php echo site_url('admin/students'); ?>" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
            <?php
        }
        ?>

    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">



        <style>


            div {


                height: auto;
            }
            div img {

                width: 100%;
            }


            .name {

                position: absolute;
                bottom: 25%;
                left: 23%;
                font-size: 18px;
                font-weight: bold;
                color: #54678D !important;

                writing-mode: tb-rl;
                transform: rotate(-180deg);
            }

            .session {

                position: absolute;
                color: #969799 !important;
                bottom: 25%;
                left: 25.5%;
                font-size: 14px;
                font-weight: bold;

                writing-mode: tb-rl;
                transform: rotate(-180deg);
            }

            .adm {

                position: absolute;
                color: white !important;

                bottom: 27%;
                left: 1%;
                font-size: 26px;
                font-weight: bold;

                writing-mode: tb-rl;
                transform: rotate(-180deg);
            }
            .reg {

                position: absolute;
                color: #52658C !important;
                bottom: 27%;
                left: 26%;
                font-size: 70px;
                font-weight: bold;

                writing-mode: tb-rl;
                transform: rotate(-180deg);
            }

            @media print{


                .name {

                    position: absolute;
                    text-align: center;
                    font-size: 11px;
                    font-weight: bold;
                    color: #54678D !important;
                    left: 22.5%;
                    bottom: 23%;

                    writing-mode: tb-rl;
                    transform: rotate(-180deg);
                }

                .session {

                    position: absolute;
                    color: #969799 !important;
                    text-align: center;
                    font-size: 9px;
                    font-weight: bold;
                    -webkit-print-color-adjust: exact; 
                    left: 25.5%;
                    bottom: 23%;

                    writing-mode: tb-rl;
                    transform: rotate(-180deg);
                }


                .reg {
                    color: #52658C !important;
                    position: absolute;
                    font-size: 40px;
                    font-weight: bold;
                   

                    bottom: 25%;
                    left: 26%;

                    writing-mode: tb-rl;
                    transform: rotate(-180deg);
                }

                .adm {

                    position: absolute;

                    font-size: 18px;
                    font-weight: bold;
                    color: #ffffff !important;
                    -webkit-print-color-adjust: exact; 
                    left: 1.3%;
                    bottom: 25%;

                    writing-mode: tb-rl;
                    transform: rotate(-180deg);
                }



            } 




        </style>
        <div>

            <img src="<?php echo base_url('images/idcard.jpg'); ?>" class="idcard" />


            <p class="name"><?php echo ucwords($r->name ?? '') ?></p>
            <p class="session" >Session : <?php echo dateformates($r->do_admission) ?></p>

            <p class="adm"><?php echo strtoupper(AdminLTE::student_course($r->course)) ?></p>
            <p class="reg"><?php echo $r->reg_no ?></p>


        </div> 




    </div><!-- /.col -->
</div>