<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-phone-square"></i>
        Send Group SMS to YDI Students
        <a href="<?php echo site_url('admin/dashboard'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class=' col-xs-12'>
        <div class="pull-right">
            <?php
            AdminLTE::sms_balance();
            ?>
        </div>
        <div class='col-md-12'>
            <?php echo form_open('', ['class' => 'form-horizontal']); ?>
            <div class="form-group" id="temp">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">SMS Templates: </label>

                <div class="col-xs-12 col-sm-9">

                    <?php
                    $this->db->where(array('from_user' => $this->session->user_id));
                    $query = $this->db->get('sms_temp');
                    foreach ($query->result() as
                            $r) {
                        ?>

                        <div class="radio">
                            <label><input type="radio" class="sms" onclick="getElements()"  name ="temp" value="<?php echo htmlspecialchars($r->sms, ENT_QUOTES, 'UTF-8') ?>"><?php echo htmlspecialchars($r->sms, ENT_QUOTES, 'UTF-8') ?></label>
                        </div>
                        <?php
                    }
                    ?>



                </div>
            </div>
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
</div>
<script>
    function getElements()
    {
        document.getElementById("message").value = document.querySelector('input[name=temp]:checked').value;
    }
</script>