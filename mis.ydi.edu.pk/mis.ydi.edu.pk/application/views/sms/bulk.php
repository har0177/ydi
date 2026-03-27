<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-phone-square"></i>
        Send Bulk  SMS to Selected Students
        <a href="<?php echo site_url('admin/dashboard'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->

<div class="row">

    <div class='col-md-10 col-sm-9 col-xs-12'>
        <div class="pull-right">
            <?php
            AdminLTE::sms_balance();
            ?>
        </div>
        <div class='col-xs-12'>
            <?php echo form_open('', ['class' => 'form-horizontal']); ?>

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Senders: </label>

                <div class="col-xs-12 col-sm-9">

                    <select name="sender[]" class="select2" multiple="">

                        <option value="" >Please Select Numbers</option>

                        <?php
                        $this->db->where('status', '1');
                        $query = $this->db->get('student');
                        foreach ($query->result() as
                                $r) {
                            if (empty($r->contact)) {
                                continue;
                            }
                            echo "<option value='$r->contact'> $r->name -" . AdminLTE::student_course($r->course) . "- $r->contact  </option>";
                        }
                        ?>

                    </select>
                </div>
            </div>

            <div class="form-group" id="temp">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">SMS Templates: </label>

                <div class="col-xs-12 col-sm-9">

                    <?php
                    $this->db->where(array('from_user' => $this->session->user_id));
                    $que = $this->db->get('sms_temp');
                    foreach ($que->result() as
                            $r) {
                        ?>

                        <div class="radio">
                            <label><input type="radio" class="sms" onclick="getElements()"  name ="temp" value="<?php echo $r->sms ?>"><?php echo $r->sms ?></label>
                        </div>
                        <?php
                    }
                    ?>



                </div>
            </div>

            <div class='form-group' id="msg">
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