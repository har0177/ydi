<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-phone-square"></i>
       Send SMS to Unpaid Students

        <a href="<?php echo site_url('admin/fee'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->

<div class='col-xs-12'>
    <div class="pull-right">
        <?php
        AdminLTE::sms_balance();
        ?>
    </div>
    <div class='col-md-12'>
        <?php echo form_open('', ['class' => 'form-horizontal']); ?>

        <div class='form-group'>
            <label for='message'>Message:</label>
            <textarea rows='5' style="text-align: left" name='message' id='message' maxlength="612" class='form-control' placeholder='Enter Message'></textarea>
            <div id="errorDiv"></div>
        </div>

        <div class='form-group text-right'>
            <input type="submit" name="submit" class='btn btn-success' value='Send SMS'>
        </div>
        </form>
    </div>

</div>

