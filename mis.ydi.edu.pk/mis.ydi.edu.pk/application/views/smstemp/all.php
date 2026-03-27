<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading ?>

    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-12 col-md-6 col-sm-12 col-lg-6">
            <?php echo form_open('admin/school/add_sms', ['class' => 'form-horizontal']); ?>
            <div class='form-group'>
                <label for='message'>Message:</label>
                <textarea rows='5' style="text-align: left" name='message' required="" id='message' maxlength="612" class='form-control' placeholder='Enter Message'></textarea>
                <div id="errorDiv"></div>
            </div>

            <div class="hr hr-dotted"></div>


            <div class="form-group">
                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                    <label>
                        <input type="submit" name="submit" value="Add SMS" class="btn btn-lg btn-success">
                    </label>
                </div>
            </div>

            </form>
        </div>
        <div class="col-xs-12 col-md-6 col-sm-12 col-lg-6">

            <div class="table-header">
                Manage <?php echo $heading ?>
            </div>
            <!-- div.table-responsive -->
            <!-- div.dataTables_borderWrap -->

            <table id="dyntable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>SMS</th>

                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as
                            $r) {
                        ?>
                        <tr> <td> <?php echo $i ?></td><td><?php echo $r->sms ?></td>
                            <td>
                                <div class="hidden-sm action-buttons">
                                    <a class="green" title="Update SMS" href="<?php echo site_url('admin/school/edit_sms/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
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