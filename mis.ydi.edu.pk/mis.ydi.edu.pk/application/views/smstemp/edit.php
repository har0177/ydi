<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-newspaper-o"></i>
        Update <?php echo $heading ?>
        <a href="<?php echo site_url('admin/school/all_sms'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-12 col-md-6 col-sm-12 col-lg-6">
            <?php echo form_open('', ['class' => 'form-horizontal']); ?>
            <div class='form-group'>
                <label for='message'>Message:</label>
                <textarea rows='5' style="text-align: left" name='message' id='message' maxlength="612" class='form-control' placeholder='Enter Message'><?php echo $r->sms ?></textarea>
                <div id="errorDiv"></div>
            </div>


            <div class="hr hr-dotted"></div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                    <label>
                        <input type="submit" name="submit" value="Update SMS" class="btn btn-lg btn-success">
                    </label>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>