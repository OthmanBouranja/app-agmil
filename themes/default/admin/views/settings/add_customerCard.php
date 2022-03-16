<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <div class="box">
        <div class="box-header">
            <h2 class="blue"><i class="fa-fw fa fa-plus"></i>Ajouter une fiche client</h2>
        </div>

        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-customer-form');
        echo admin_form_open_multipart("system_settings/addCustomerCard", $attrib); ?>
        <div class="box-content">
            <p><?= lang('enter_info'); ?></p>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label class="control-label" for="customer_group"><?php echo $this->lang->line("Type Client"); ?></label>
                        <?php
                        foreach ($customer_groups as $customer_group) {
                            $cgs[$customer_group->id] = $customer_group->name;
                        }
                        echo form_dropdown('customer_group', $cgs, $Settings->customer_group, 'class="form-control select" id="customer_group" style="width:100%;" required="required"');
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group person">
                        <?= lang("Nom du Client ", "name"); ?>
                        <?php echo form_input('name', '', 'class="form-control tip" style="background-color:#e7fce7; id="name" data-bv-notempty="true"'); ?>
                    </div>
                    <div class="form-group">

                        <?= lang("Société", "city"); ?>
                        <?php echo form_input('company', '', 'class="form-control" style="background-color:#e7fce7; id="company"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("Email : Exemple@client.com", "email_address"); ?>
                        <input type="email" name="email" class="form-control"  id="email_address"/>
                    </div>
                    <div class="form-group">
                        <?= lang("phone", "phone"); ?>
                        <input type="tel" name="phone" class="form-control"  id="phone"/>
                    </div>
                    <div class="form-group">
                        <?= lang("N° ICE de la Société", "gst_no"); ?>
                        <?php echo form_input('gst_no', '', 'class="form-control" id="gst_no"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("address", "address"); ?>
                        <?php echo form_input('address', '', 'class="form-control" style="background-color:#fce7f2; id="address" required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("Ville", "city"); ?>
                        <?php echo form_input('city', '', 'class="form-control" style="background-color:#fce7f2; id="city" required="required"'); ?>
                    </div>
                    

                </div>
            </div>


        </div>
        <div class="modal-footer">
            <?php echo form_submit('addCustomerCard', "Ajouter fiche client", 'class="btn btn-primary"'); ?>
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

