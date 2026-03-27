<div class="page-header hidden-print">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Weekly Words
        <a href="<?php echo site_url('nawaytakay/all'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
        <a href="<?php echo site_url('nawaytakay/add_words'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Add New Words</a>
    </h1>
</div><!-- /.page-header -->
<style>
    input[type=text]{
        border: 1px solid lightslategray;
        height: 33px;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-body hidden-print">
            <div class="widget-main">

                <div id="fuelux-wizard-container">

                    <div class="step-content pos-rel">

                        <?php echo form_open('', ['class' => 'form-horizontal']); ?>


                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Month</label>



                            <div class="col-xs-12 col-sm-6">
                                <?php
                                $data2 = array(
                                    'data-placeholder' => "Select Month",
                                    'class' => "select2",
                                    'id' => 'month',
                                    'tabindex' => '-1',
                                    'required' => ''
                                );

                                //$options = $tmp;
                                echo form_dropdown('month', $month, set_value('month', date('m')), $data2);
                                ?>
                            </div>

                            <input type="submit" name="submit" value="Search" class="btn btn-sm btn-success">
                        </div>




                        <?php echo form_close(); ?>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
        </div>

        <?php
        if (isset($_POST['submit'])) {
            $month = $this->input->post('month', TRUE);
            $search = $this->db->query("Select * from week_words where month = $month");
            if ($search->num_rows() > 0) {
                $weeks = array();
               
                foreach ($search->result() as
                        $value) {
                    $weeks[] = "<th> Week " . $value->week . "</th>";
                    
                }
                ?>

                <div class="table-header">
                    Monthly Words of <?php echo AdminLTE::month($month) ?>
                </div>
                <!-- div.table-responsive -->
                <!-- div.dataTables_borderWrap -->
                <div>

                    <table id="" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
        <?php
        foreach ($weeks as
                $val) {
            echo $val;
        }
        ?>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                            <?php
                          foreach ($search->result() as
                        $w) {
                       for($i = 1; $i <= 5; $i++){
               
                
                        
                        if($w->week == $i){
                            ?>
                 
                 
                
                     <td style="text-align: left">
                    <?php
                              for($j = 0; $j <= 9; $j++){
                                if(!empty(explode(":", $w->words)[$j])){
                                    echo $j+1 . " : " . explode(":", $w->words)[$j] . " / ". explode(":", $w->meanings)[$j] . "<br>";
                                }
                              
                            }
                            ?>
                          </td>
               
                         <?php
                        }
                        
                        ?>
                   
                    
  <?php } } 
                
                ?>
                            </tr>
                        </tbody>
                    </table>

                </div>
        <?php
    }
    else {
        set_flash_alert("No Record Found!", "danger");
        redirect('nawaytakay/all_words');
    }
}
else {
    ?>


            <div class="table-header">
                Manage Weekly Words Detail
            </div>
            <!-- div.table-responsive -->
            <!-- div.dataTables_borderWrap -->
            <div>

                <table id="dyntable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Month</th>
                            <th>Week</th>
                            <th>Words / Meaning</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
    <?php
    $i = 1;
    foreach ($result as
            $r) {
        ?>
                            <tr>

                                <td> <?php echo $i ?></td>
                                <td><?php echo AdminLTE::month($r->month) ?></td>
                                <td><?php echo $r->week ?></td>
                                <td style="text-align: left"><?php
                    for ($j = 0;
                            $j <= 9;
                            $j++) {
                        if (!empty(explode(":", $r->words)[$j])) {
                            echo $j + 1 . " : " . explode(":", $r->words)[$j] . " / " . explode(":", $r->meanings)[$j] . "<br>";
                        }
                    }
        ?></td>
                                </td>
                                <td><?php echo dateformatesformysql_fata($r->date) ?></td>
                                <td>
                                    <a title="Update Weekly Words" class="green" href="<?php echo site_url('nawaytakay/edit_words/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-pencil-square-o bigger-130"></i>
                                    </a>

                                </td>
                            </tr>
        <?php
        $i++;
    }
    ?>
                    </tbody>
                </table>

            </div>

<?php } ?>

    </div>

</div>