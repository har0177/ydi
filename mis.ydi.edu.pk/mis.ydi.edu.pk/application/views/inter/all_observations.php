<div class="page-header hidden-print">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?>
        <a href="<?php echo site_url('interviewer/createObservation'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-plus-square"></i> Add Observation</a>
  

    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
          
        <div class="table-header">
            Manage <?php echo $heading; ?> 
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>
           
            <table id="dyntable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                
                        <th>Name</th>
                     
                        <th>Batch Name</th>
                            <th>Date</th>
                            
                     
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as $r) {                        ?>
                        <tr>

                           <td> <?php echo $i ?></td>
                            <td><?php echo $r->name ?></td>
                                <td><?php echo $r->batch ?></td>
                                           <td><?php echo $r->date ?></td>
                        
</td>
                            
                            
                          
                            <td>
                                <div class="hidden-sm action-buttons ">
                                    <a title="View Observation Form"  class="orange" href="<?php echo site_url('interviewer/viewObservation/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>
                                 
                                </div>

                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>