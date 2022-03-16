<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <div class="box">
        <div class="box-header">
            <h2 class="blue"><i class="fa-fw fa fa-plus"></i>Modifier fiche client</h2>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-customer-form');
        echo admin_form_open_multipart("system_settings/edit_customercard/".$customercard->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label class="control-label" for="customer_group"><?php echo $this->lang->line("Type Client"); ?></label>
                        <?php
                        foreach ($customer_groups as $customer_group) {
                            $cgs[$customer_group->id] = $customer_group->name;
                        }
                        echo form_dropdown('customer_group', $cgs, $customercard->customer_group_id, 'class="form-control select" id="customer_group" style="width:100%;" required="required"');
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group person">
                        <?= lang("Nom du Client ", "name"); ?>
                        <?php echo form_input('name', set_value('code', $customercard->name), 'class="form-control tip" style="background-color:#e7fce7; id="name" data-bv-notempty="true"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("Société", "city"); ?>
                        <?php echo form_input('company', set_value('code', $customercard->company), 'class="form-control" style="background-color:#e7fce7; id="company"'); ?>
                    </div>

                    <div class="form-group">
                        <?= lang("Email : Exemple@client.com", "email_address"); ?>
                        <?php echo form_input('email', set_value('code', $customercard->email), 'class="form-control" style="background-color:#e7fce7; id="email_address"'); ?>
                    </div>

                    <div class="form-group">
                        <?= lang("phone", "phone"); ?>
                        <?php echo form_input('phone', set_value('code', $customercard->phone), 'class="form-control" style="background-color:#e7fce7; id="phone"'); ?>
                    </div>


                    <div class="form-group">
                        <?= lang("N° ICE de la Société", "gst_no"); ?>
                        <?php echo form_input('gst_no', set_value('code', $customercard->gst_no), 'class="form-control" id="gst_no"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("address", "address"); ?>
                        <?php echo form_input('address', set_value('code', $customercard->address), 'class="form-control" style="background-color:#fce7f2; id="address" required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("Ville", "city"); ?>
                        <?php echo form_input('city', set_value('code', $customercard->city), 'class="form-control" style="background-color:#fce7f2; id="city" required="required"'); ?>
                    </div>
                    

                </div>
            </div>


        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_customercard', "Modifier fiche client", 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
        $('#add-customer-form').bootstrapValidator({
            feedbackIcons: {
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh'
            }, excluded: [':disabled']
        });
        $('select.select').select2({minimumResultsForSearch: 7});
        fields = $('.modal-content').find('.form-control');
        $.each(fields, function () {
            var id = $(this).attr('id');
            var iname = $(this).attr('name');
            var iid = '#' + id;
            if (!!$(this).attr('data-bv-notempty') || !!$(this).attr('required')) {
                $("label[for='" + id + "']").append(' *');
                $(document).on('change', iid, function () {
                    $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', iname);
                });
            }
        });
    });
</script>

