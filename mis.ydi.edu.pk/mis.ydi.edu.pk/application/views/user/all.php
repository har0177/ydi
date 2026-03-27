<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?> 
        <a href="<?php echo site_url('admin/user/add'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-plus-square"></i> Add New</a>
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
                        <th>Full Name</th>
                        <th class="hidden-480">Username</th>
                        <th class="hidden-480">Email Address</th>
                        <th class="hidden-480">Address</th>
                        <th class="hidden-480">Phone</th>
                        <th>Status</th>
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
                            <td>
                                <?php echo $r->fullname ?>
                            </td>
                            <td class="hidden-480"><?php echo $r->username ?></td>
                            <td class="hidden-480"><?php echo $r->email ?></td>
                            <td class="hidden-480"><?php echo $r->address ?></td>
                            <td class="hidden-480"><?php echo $r->phone ?></td>
                            <td><?php
                                if ($r->status == '1') {
                                    echo "<span class='label label-large label-success'>Active</span>";
                                } else {
                                    echo "<span class='label label-large label-inverse'>Deactive</span>";
                                }
                                ?>	</td>
                            <td>
                                <div class="hidden-sm action-buttons">
                                    <a class="green" href="<?php echo site_url('admin/user/edit/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>

                                                                                                                                    <!--<a class="red" href="<?php echo site_url('admin/user/delete/' . $r->id) ?>">
                                                                                                                                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                                                                                                    </a> -->
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