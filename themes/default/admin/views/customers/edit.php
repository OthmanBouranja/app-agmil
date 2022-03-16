<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i>Modifier client</h2>
    </div>
    <div class="box-content">
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo admin_form_open_multipart("customers/edit/" . $customer->id, $attrib); ?>

        <p><?= lang('enter_info'); ?></p>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">

                    <label class="control-label" for="customer_card">Nom du client</label>
                    <?php
                    echo form_input('customer_card', (isset($_POST['customer_card']) ? $_POST['customer_card'] : $customer->name), 'id="customer_card" data-placeholder="' . $this->lang->line('select') . ' ' . $this->lang->line('customer') . '" required="required" class="form-control input-tip" style="width:100%;"');
                    ?>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="price_group"><?php echo $this->lang->line("price_group"); ?></label>
                    <?php
                    $pgs[''] = lang('select').' '.lang('price_group');
                    foreach ($price_groups as $price_group) {
                        $pgs[$price_group->id] = $price_group->name;
                    }
                    echo form_dropdown('price_group', $pgs, $customer->price_group_id, 'class="form-control select" id="price_group" style="width:100%;"');
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group company">
                    <?= lang("N° Immatricule Véhicule", "company"); ?>
                    <?php echo form_input('company', $customer->company, 'class="form-control tip" style="background-color:#e7fce7; id="company" data-bv-notempty="true"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("N° VIN", "vat_no"); ?>
                    <?php echo form_input('vat_no', $customer->vat_no, 'class="form-control" style="background-color:#e7fce7; id="vat_no"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("N° ICE de la Société", "gst_no"); ?>
                    <?php echo form_input('gst_no', $customer->gst_no, 'class="form-control" disabled id="gst_no"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("Email : Exemple@client.com", "email_address"); ?>
                    <input disabled type="email" name="email" class="form-control" required="required"  id="email_address"
                           value="<?= $customer->email ?>"/>
                </div>
                <!--<div class="form-group company">
                    <?= lang("contact_person", "contact_person"); ?>
                    <?php echo form_input('contact_person', $customer->contact_person, 'class="form-control" id="contact_person" data-bv-notempty="true"'); ?>
                </div>-->

                <div class="form-group">
                    <?= lang("phone", "phone"); ?>
                    <input disabled type="tel" name="phone" class="form-control" required="required" id="phone"
                           value="<?= $customer->phone ?>"/>
                </div>
                <div class="form-group">
                    <?= lang("address", "address"); ?>
                    <?php echo form_input('address', $customer->address, 'class="form-control" disabled style="background-color:#fce7f2; id="address" required="required"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("Ville", "city"); ?>
                    <?php echo form_input('city', $customer->city, 'class="form-control" disabled style="background-color:#fce7f2; id="city" required="required"'); ?>
                </div>

            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <?= lang("Marque Véhicule", "postal_code"); ?>
                    <?php echo form_input('postal_code', $customer->postal_code, 'class="form-control" style="background-color:#f8ebde;" id="postal_code"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("Modèle Véhicule", "country"); ?>
                    <?php echo form_input('country', $customer->country, 'class="form-control" style="background-color:#f8ebde;" id="country"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("Date de mise en circulation", "cf1"); ?>
                    <?php echo form_input('cf1', $customer->cf1, 'class="form-control" style="background-color:#f8ebde; id="cf1"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("Couleur Véhicule :", "cf2"); ?>
                    <?php echo form_input('cf2', $customer->cf2, 'class="form-control" id="cf2"'); ?>

                </div>
                <div class="form-group">
                    <?= lang("Type Carburant", "cf3"); ?>
                    <?php echo form_input('cf3', $customer->cf3, 'class="form-control" id="cf3"'); ?>
                </div>

            </div>
        </div>
        <div class="form-group">
            <?= lang('award_points', 'award_points'); ?>
            <?= form_input('award_points', set_value('award_points', $customer->award_points), 'class="form-control tip" id="award_points"  required="required"'); ?>
        </div>

        <?php echo form_submit('edit_customer', lang('edit_customer'), 'class="btn btn-primary"'); ?>

        <?php echo form_close(); ?>
    </div>
</div>





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
            $customer_card.val(customer_card).select2({
                minimumInputLength: 1,
                data: [],
                initSelection: function(element, callback) {

                    var formatData = {
                        "id":customer_card,
                        "text":"<?= $customer->name; ?>",
                        "company":"<?= $customer->company_name; ?>",
                        "phone":"<?= $customer->phone; ?>",
                        "email":"<?= $customer->email; ?>",
                        "gst_no":"<?= $customer->gst_no; ?>",
                        "city":"<?= $customer->city; ?>",
                        "address":"<?= $customer->address; ?>",
                    }
                    callback(formatData);
                },
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
                    console.log('element',element);
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

        } else {
            nsCustomer();
        }



        var $carBrand = $('#postal_code');
        init_model = true;
        $carBrand.change(function(e) {
            localStorage.setItem('carBrand', $(this).val());
        });
        if ((carBrand = localStorage.getItem('carBrand'))) {

            $carBrand.val(carBrand).select2({
                minimumInputLength: 1,
                data: [],
                initSelection: function(element, callback) {
                    callback({"id":"<?= $customer->carBrand?>","name":"<?= $customer->postal_code?>" });
                },
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





    var $carModel = $('#country');
    $carModel.change(function(e) {
        localStorage.setItem('carModel', $(this).val());
    });

    function getModelsByBrand(brand){
        $.ajax({
            type: "get",
            url: "<?= admin_url('customers/getModelsByBrand') ?>/" + brand.id,
            dataType: "json",
            success: function (scdata) {
                if (scdata != null) {
                    scdata.push({id: '', text: 'Selectionner un modèle'});
                    $carModel.select2("destroy").empty().attr("placeholder", "Selectionner un modèle").select2({
                        placeholder: "Selectionner un modèle",
                        minimumResultsForSearch: 7,
                        data: scdata,
                        initSelection: function(element, callback) {
                            if(init_model){
                                callback({"id":"<?= $customer->carModel?>","text":"<?= $customer->country?>" });
                            }
                        },
                    });
                } else {
                    $carModel.select2("destroy").empty().attr("placeholder", "Aucun modèle").select2({
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

    // hellper function for customer if no localStorage value
    function nsCustomer() {
        $('#customer_card').select2({
            minimumInputLength: 1,
            ajax: {
                url: site.base_url + 'customers/suggestions',
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
        });
    }

</script>
