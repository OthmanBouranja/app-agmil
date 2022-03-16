<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">

    $(document).ready(function () {
        if (!localStorage.getItem('customer_card')) {
            localStorage.setItem('customer_card', "0");
        }
        if (!localStorage.getItem('carBrand')) {
            localStorage.setItem('carBrand', "0");
        }
    });
</script>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i>Ajouter client</h2>
    </div>
    <div class="box-content">
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-customer-form');
        echo admin_form_open_multipart("customers/add", $attrib); ?>

        <p><?= lang('enter_info'); ?></p>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">

                    <label class="control-label" for="customer_card">Nom du client</label>
                    <?php
                    echo form_input('customer_card', (isset($_POST['customer_card']) ? $_POST['customer_card'] : ''), 'id="customer_card" data-placeholder="Selectionner un client" required="required" class="form-control input-tip" style="width:100%;"');
                    ?>

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="price_group"><?php echo $this->lang->line("Client"); ?></label>
                    <?php
                    $pgs[''] = lang('select').' '.lang('Groupe Client');
                    foreach ($price_groups as $price_group) {
                        $pgs[$price_group->id] = $price_group->name;
                    }
                    echo form_dropdown('price_group', $pgs, $Settings->price_group, 'class="form-control select" id="price_group" style="width:100%;"');
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group company">
                    <?= lang("N° Immatricule Véhicule", "company"); ?>
                    <?php echo form_input('company', '', 'class="form-control tip" style="background-color:#e7fce7; id="company" data-bv-notempty="true"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("N° VIN", "vat_no"); ?>
                    <?php echo form_input('vat_no', '', 'class="form-control" style="background-color:#e7fce7; id="vat_no"'); ?>
                </div>

                <div class="form-group">
                    <?= lang("Email : Exemple@client.com", "email_address"); ?>
                    <input disabled type="email" name="email" class="form-control"  id="email_address"/>
                </div>
                <!--<div class="form-group company">
                    <?= lang("contact_person", "contact_person"); ?>
                    <?php echo form_input('contact_person', '', 'class="form-control" id="contact_person" data-bv-notempty="true"'); ?>
                </div>-->

                <div class="form-group">
                    <?= lang("phone", "phone"); ?>
                    <input disabled type="tel" name="phone" class="form-control"  id="phone"/>
                </div>
                <div class="form-group">
                    Type
                    <?php echo form_input('customer_group_name', '', 'class="form-control" disabled id="customer_group_name" '); ?>
                </div>
                <div class="form-group">
                    N° ICE de la Société
                    <?php echo form_input('gst_no', '', 'class="form-control" disabled id="gst_no" '); ?>
                </div>
                <div class="form-group">
                    <?= lang("address", "address"); ?>
                    <?php echo form_input('address', '', 'class="form-control" disabled id="address" '); ?>
                </div>
                <div class="form-group">
                    <?= lang("Ville", "city"); ?>
                    <?php echo form_input('city', '', 'class="form-control" disabled id="city" '); ?>
                </div>


            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <?= lang("Marque Véhicule", "postal_code"); ?>
                    <?php echo form_input('postal_code', '', 'class="form-control" style="background-color:#f8ebde;" data-placeholder="Selectionner une marque" id="postal_code" data-bv-notempty="true"'); ?>
                </div>
                <div class="form-group all">
                    <?= lang('Modèle', 'country') ?>
                    <div class="controls" id="subcat_data"> <?php
                        echo form_input('country', '', 'class="form-control" id="country"  placeholder="Selectionner un modèle"');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= lang("Date de mise en circulation", "cf1"); ?>
                    <?php echo form_input('cf1', '', 'class="form-control" style="background-color:#f8ebde; id="cf1"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("Couleur Véhicule :", "cf2"); ?>
                    <?php echo form_input('cf2', '', 'class="form-control" id="cf2"'); ?>

                </div>
                <div class="form-group">
                    <?= lang("Type Carburant", "cf3"); ?>
                    <?php echo form_input('cf3', '', 'class="form-control" id="cf3"'); ?>
                </div>

            </div>
        </div>

        <div class="hidden">
            <input type="hidden" id="customer_group_id" name="customer_group_id">
            <input type="hidden" id="name" name="name">
        </div>

        <?php echo form_submit('add_customer', lang('add_customer'), 'class="btn btn-primary"'); ?>


        <?php echo form_close(); ?>

    </div>
</div>
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

<script>
    $(document).ready(function() {


        // clear localStorage and reload
        $('#reset').click(function(e) {
            bootbox.confirm(lang.r_u_sure, function(result) {
                if (result) {
                    if (localStorage.getItem('customer_card')) {
                        localStorage.removeItem('customer_card');
                    }
                    $('#modal-loading').show();
                    location.reload();
                }
            });
        });




        var $customer_card = $('#customer_card');
        $customer_card.change(function(e) {
            localStorage.setItem('customer_card', $(this).val());
        });
        if ((customer_card = localStorage.getItem('customer_card'))) {
            console.log('customer_card',customer_card);
            $customer_card.select2({
                minimumInputLength: 1,
                data: [],
                ajax: {
                    url: site.base_url + 'customers/customerCardsuggestions',
                    dataType: 'json',
                    dvietMillis: 15,
                    data: function(term, page) {
                        return {
                            term: term,
                            limit: 10,
                        };
                    },
                    results: function(data, page) {
                        if (data.results != null) {

                            return { results: data.results };
                        } else {
                            return { results: [{ id: '', text: 'No Match Found' }] };
                        }
                    },
                },
                formatSelection: function(element){
                    $("#address").val(element.address);
                    $("#city").val(element.city);
                    $("#email_address").val(element.email);
                    $("#phone").val(element.phone);
                    $("#gst_no").val(element.gst_no);
                    $("#gst_no").attr('value',element.gst_no);
                    $("#customer_group_name").val(element.customer_group_name);
                    $("#customer_group_id").val(element.customer_group_id);
                    $("#name").val(element.name);
                    return element.text + ' (' + element.id + ')';
                },
            });

        }



        var $carBrand = $('#postal_code');
        $carBrand.change(function(e) {
            localStorage.setItem('carBrand', $(this).val());
        });
        if ((carBrand = localStorage.getItem('carBrand'))) {

            $carBrand.select2({
                minimumInputLength: 1,
                data: [],
                ajax: {
                    url: site.base_url + 'customers/carBrandsuggestions',
                    dataType: 'json',
                    dvietMillis: 15,
                    data: function(term, page) {
                        return {
                            term: term,
                            limit: 10,
                        };
                    },
                    results: function(data, page) {

                        if (data.results != null) {
                            return { results: data.results };
                        } else {
                            return { results: [{ id: '', text: 'No Match Found' }] };
                        }
                    },
                },
                formatSelection: function(element){
                    getModelsByBrand(element);
                    return element.name;
                },
            });

        }

    });


    function getModelsByBrand(brand){
        $.ajax({
            type: "get",
            url: "<?= admin_url('customers/getModelsByBrand') ?>/" + brand.id,
            dataType: "json",
            success: function (scdata) {
                if (scdata != null) {
                    scdata.push({id: '', text: 'Selectionner un modèle'});
                    $("#country").select2("destroy").empty().attr("placeholder", "Selectionner un modèle").select2({
                        placeholder: "Selectionner un modèle",
                        minimumResultsForSearch: 7,
                        data: scdata
                    });
                } else {
                    $("#country").select2("destroy").empty().attr("placeholder", "Aucun modèle").select2({
                        placeholder: "Aucun modèle",
                        minimumResultsForSearch: 7,
                        data: [{id: '', text: 'Aucun modèle'}]
                    });
                }
            },
            error: function () {
                bootbox.alert('<?= lang('ajax_error') ?>');
                $('#modal-loading').hide();
            }
        });
    }
    /* -----------------------
     * Misc Actions
     ----------------------- */


</script>

