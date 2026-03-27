<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $title; ?>
        <a href="<?php echo site_url('trainer/upload'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-plus-square"></i> Upload Practice Materials</a>
        

    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Manage <?php echo $title; ?>
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>
            <table id="dyntable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Course</th>
                        <th>Topic</th>
                        <th>Data</th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as $r) {
                        ?>
                        <tr>
                            <td> <?php echo $i ?></td>
                           
                            <td><?php echo AdminLTE::student_course($r->course) ?></td>
                            <td><?php echo $r->topic ?></td>
                            <?php if(empty($r->data)){
                                echo "<td> </td>";
                            }else{ ?>
                            <td><a href="<?php echo base_url().'materials/'.$r->data ?>" class="btn btn-sm btn-info">Download</a></td>
                            <?php }  
                            
                            if(empty($r->link)){
                                echo "<td> </td>";
                            }else{ ?>
                            <td><a href="<?php echo $r->link ?>" class="btn btn-sm btn-danger">Play Video</a></td>
<?php } ?>

                            <td>
                                <div class="hidden-sm action-buttons">
                                   
                                    <a title="Update Material Form" class="light-grey" href="<?php echo site_url('trainer/edit_data/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>

                                    <a title="Delete Material Form" class="red" onclick="return confirm('Are You Sure Want to Delete it?')" href="<?php echo site_url('trainer/delete_data/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
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