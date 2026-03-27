<div class="page-header hidden-print">
    <h1> 
        <i class="ace-icon fa fa-paper-plane"></i>
       ID Card of Students
        <a href="<?php echo site_url('cardmaker'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->
<div class="row margin-top">
    <div class="col-xs-12">

     
             		     		
                              <style>
                     

div {
    
   
    height: auto;
}
div img {
   
    width: 100%;
}
.image {
    
    position: absolute;
    margin-top: -30.5%;
    left: 17%;
    height: 170px;
    width: 170px;
  }
  

 
.name {
    
    position: absolute;
    margin-top: -39.5%;
    left: 15%;
    font-size: 22px;
    font-weight: bold;
}

.session {
    
    position: absolute;
    margin-top: -37%;
    left: 15%;
    font-size: 22px;
    font-weight: bold;
}

.adm {
    
    position: absolute;
    margin-top: -70.4%;
    left: 18%;
    font-size: 26px;
    font-weight: bold;
    color: white;
}

 @media print{
	
     .image {
    
    position: absolute;
    margin-top: -31%;
    left: 17%;
    height: 110px;
    width: 110px;
  }
  
 
 
.name {
    
    position: absolute;
    margin-top: -39%;
    text-align: center;
    font-size: 12px;
    font-weight: bold;
}

.session {
    
    position: absolute;
    margin-top: -35.2%;
     text-align: center;
    font-size: 12px;
    font-weight: bold;
}


.adm {
    
    position: absolute;
    margin-top: -70%;
    left: 16%;
    font-size: 18px;
    font-weight: bold;
     color: white;
}


  
  } 
  
  
  
  
</style>

    

 <?php
                    foreach ($result as $r) {
                        ?>
<div>
    <img src="<?php echo base_url('images/idcard.png'); ?>" class="idcard" />
       <?php if($r->img == ""){
                  ?>
                   <img  class="image img-rounded"  alt="<?php echo $r->name ?>" src="<?php echo site_url('images/profile.png'); ?>" />
                <?php
                }else{ ?>
                <img  class="image img-rounded" alt="<?php echo $r->name ?>" src="<?php echo site_url('images/' . $r->img); ?>" />
                <?php } ?>
                
                <p class="name"><?php echo ucwords($r->name)  ?></p>
                <p class="session">Session : <?php echo dateformates($r->do_admission)  ?></p>

                <p class="adm" style="color: white"><?php echo strtoupper(AdminLTE::student_course($r->course)) ?></p>

    
</div> 
<br>


                    <?php } ?>					
    </div>

</div><!-- /.col -->