<script type="text/javascript">


    <?php if ($Owner || $Admin) {
    ?>
    if (!localStorage.getItem('codate')) {
        $("#codate").datetimepicker({
            format: site.dateFormats.js_ldate,
            fontAwesome: true,
            language: 'sma',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0
        }).datetimepicker('update', new Date());
    }
    $(document).on('change', '#codate', function (e) {
        localStorage.setItem('codate', $(this).val());
    });
    if (codate = localStorage.getItem('codate')) {
        $('#codate').val(codate);
    }
    <?php
    } ?>

</script>

<style>
    .attribut{
        display: flex;
        justify-content: space-around;
        font-weight: bold;
    }
    .checkboxInput{
        display: flex;
        justify-content: space-around;
        margin-bottom: 3px;
    }
    .TextPneu{
        margin-top:25px;
    }
    .TextCarburant{
        text-align: center;
    }
    .TextEtat{
        margin-top: 70px;
    }
    .TextAcces{
        margin-top: 92px;
    }
    .TextCheck{
        margin-bottom: 43%;
        white-space: nowrap;
    }
    .TextCarburant {
        font-weight: bold;
        font-size: 17px;
    }
    .TextONR {
        text-align: center;
        font-weight: bold;
        font-size: 13px;
    }
    .TextIntérieur {
        text-align: center;
        font-weight: bold;
        font-size: 14px;
    }
    .TextCheckEtat{
        margin-bottom: 23%;
        white-space: nowrap;
    }
    .checkCarburant{
        display: flex;
        justify-content: center;
        justify-content: space-evenly;
    }
    .TextCheckAbime{
        margin-bottom: 16px;
        white-space: nowrap;
    }
    .InputChe{
        margin-bottom: 7px;
        margin-top: 2px;
    }
    .TextTitleCarbur{
        display: flex;
        justify-content: center;
        justify-content: space-evenly;
    }
    .TextCheckAcces{
        white-space: nowrap;
        margin-bottom: 13px;
    }
    .TextEtatAcces{
        margin-left: -6px;
        margin-top: 28px;
    }
    h3{
        margin-top: 0px;
    }
    .TextONR{
        white-space: nowrap;
    }
    .TextPneuJante{
        margin-top: 6%;
    }
    .boxAnti{
        margin-top: 6%;
    }
    .ImagCarDiv{
        text-align: center;
        margin-top: 13px;
    }
    .padinText{
        padding: 2px;
    }
    .attributOkAbim{
        margin-left: 20px;
    }
    .ImagCar{
        width: 50%;
    }
    .hrTablet{
        display: none;
    }
    @media only screen and (max-width: 768px){
        .hrTablet{
            display: block;
            border-top: 3px solid #eee;
        }
        .CartGrise{
            margin-top: 6%;
        }
        .TextCheck{
            margin-bottom: 3%;
        }
        .TextPneu{
            margin-left: 9%;
            margin-top: 35px;
        }
        .inputCheckbox{
            margin-top: -24%;
            margin-left: 20%;
            margin-right: 20%;
        }
        .TextPneuJante{
            margin-top: 6%;
            margin-left: 9%;
        }
        .attributOkAbim{
            margin-left: 9px;
        }
        .TextTitleCarbur{
            margin-left: -20px;
        }
        .checkboxJante{
            margin-top: -24%;
            margin-left: 20%;
            margin-right: 20%;
        }
        .TextCheckEtat{
            margin-bottom: 3%;
            margin-left: 9%;
        }
        .TextEtat{
            margin-top: 95px;
        }
        .checkboxIntérieur{
            margin-top: -49%;
            margin-left: 20%;
            margin-right: 20%;
        }
        .TextONR{
            text-align: center;
            font-weight: bold;
            font-size: 17px;
        }
        .TextIntérieur{
            text-align: center;
            font-weight: bold;
            font-size: 17px;
        }
        .TextEtatAcces{
            margin-left: 150px;
            margin-top: 40px;
        }
        .divAttribut{
            margin-top: -44%;
            margin-left: 20%;
        }
        .checkboxEtatBottom{
            margin-bottom: 2%;
        }
        .divDroitG{
            margin-top: -32%;
            margin-left: 20%;
            margin-right: 20%;
        }
        .TextPhare{
            margin-left: 50px;
            margin-top: 45px;
        }
        .textAbimés{
            margin-top: -98%;
            margin-left: 6%;
        }
        .checkboxAbimés2{
            float: right;
            margin-top: -98%;
            margin-right: 10%;
        }
        .textAbimés2{
            float: right;
            margin-top: -98%;
            margin-right: -35%;
        }
        .TextCarburant{
            font-weight: bold;
            font-size: 17px;
        }
        .ImpremierRespons{
            float: right;
            margin-top: -46px;
        }
    }
</style>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i>Ficher de controle réception véhicule atelier</h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
                echo admin_form_open_multipart('controle/add_controle', $attrib)
                ?>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-md-2">
                            <div class="form-group">
                                <?= lang('date', 'codate'); ?>
                                <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ''), 'class="form-control input-tip datetime" id="codate" required="required"'); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Immatriculation</label>
                                <?php echo form_input('immatriculation', (isset($_POST['immatriculation']) ? $_POST['immatriculation'] : ''), 'class="form-control input-tip" id="dvref"'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Marque</label>
                                <?php echo form_input('marque', (isset($_POST['marque']) ? $_POST['marque'] : ''), 'class="form-control input-tip" id="dvref"'); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Kilometrage</label>
                                <?php echo form_input('kilometrage', (isset($_POST['kilometrage']) ? $_POST['kilometrage'] : ''), 'class="form-control input-tip" id="dvref"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 ">
                        <div class="col-md-5">
                            <div class="form-group">
                                <?php echo form_textarea('dealtis_car', (isset($_POST['dealtis_car']) ? $_POST['dealtis_car'] : ''), 'class="form-control" id="note"'); ?>
                            </div>

                            <div class="col-lg-12">
                                <div class="col-md-2 TextPneu">
                                    <h5 class="TextCheck" >Pneu AVD</h5>
                                    <h5 class="TextCheck">Pneu AVG</h5>
                                    <h5 class="TextCheck">Pneu ARD</h5>
                                    <h5 class="TextCheck">Pneu ARG</h5>
                                </div>
                                <div class="col-md-5 inputCheckbox">
                                    <div class="attribut">
                                        <p class="padinText">Mauvais</p> <p class="padinText">Moyen</p> <p class="padinText">Bon</p> <p class="padinText">Neige</p>
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="pneu_avd" id="pneu_avd" value="mauvais" <?= isset($_POST['pneu_avd']) ?  : '' ?>/>
                                        <input type="radio" class="checkbox" name="pneu_avd" id="pneu_avd" value="moyen"  <?= isset($_POST['pneu_avd']) ?  : '' ?>>
                                        <input type="radio" class="checkbox" name="pneu_avd" id="pneu_avd" value="bon" <?= isset($_POST['pneu_avd']) ?  : '' ?> >
                                        <input type="radio" class="checkbox" name="pneu_avd" id="pneu_avd"  value="neige" <?= isset($_POST['pneu_avd']) ?  : '' ?> >

                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="pneu_avg" id="pneu_avg" value="mauvais" <?= isset($_POST['pneu_avg']) ? : '' ?>  >
                                        <input type="radio" class="checkbox" name="pneu_avg" id="pneu_avg" value="moyen"  <?= isset($_POST['pneu_avg']) ? : '' ?>>
                                        <input type="radio" class="checkbox" name="pneu_avg" id="pneu_avg" value="bon" <?= isset($_POST['pneu_avg']) ?  : '' ?> >
                                        <input type="radio" class="checkbox" name="pneu_avg" id="pneu_avg"  value="neige" <?= isset($_POST['pneu_avg']) ?  : '' ?> >

                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="pneu_ard" id="pneu_ard" value="mauvais" <?= isset($_POST['pneu_ard']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="pneu_ard" id="pneu_ard" value="moyen"  <?= isset($_POST['pneu_ard']) ? : '' ?>>
                                        <input type="radio" class="checkbox" name="pneu_ard" id="pneu_ard" value="bon" <?= isset($_POST['pneu_ard']) ?  : '' ?> >
                                        <input type="radio" class="checkbox" name="pneu_ard" id="pneu_ard"  value="neige" <?= isset($_POST['pneu_ard']) ?  : '' ?> >
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="pneu_arg" id="pneu_arg" value="mauvais" <?= isset($_POST['pneu_arg']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="pneu_arg" id="pneu_arg" value="moyen"  <?= isset($_POST['pneu_arg']) ? : '' ?>>
                                        <input type="radio" class="checkbox" name="pneu_arg" id="pneu_arg" value="bon" <?= isset($_POST['pneu_arg']) ? : '' ?> >
                                        <input type="radio" class="checkbox" name="pneu_arg" id="pneu_arg"  value="neige" <?= isset($_POST['pneu_arg']) ?  : '' ?> >
                                    </div>
                                </div>
                                <hr class="hrTablet">
                                <div class="col-md-2 TextPneuJante">
                                    <h5 class="TextCheck" >Jante AVD</h5>
                                    <h5 class="TextCheck">Jante AVG</h5>
                                    <h5 class="TextCheck">Jante ARD</h5>
                                    <h5 class="TextCheck">Jante ARG</h5>
                                </div>
                                <div class="col-md-3 checkboxJante">
                                    <div class="attribut attributOkAbim">
                                        <p class="padinText">Ok</p> <p class="padinText">Abimée</p>
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="jante_avd" id="jante_avd" value="ok" <?= isset($_POST['jante_avd']) ?  : '' ?> >
                                        <input type="radio" class="checkbox" name="jante_avd" id="jante_avd"  value="abimee" <?= isset($_POST['jante_avd']) ?  : '' ?> >

                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="jante_avg" id="jante_avg" value="ok" <?= isset($_POST['jante_avg']) ?  : '' ?> >
                                        <input type="radio" class="checkbox" name="jante_avg" id="jante_avg"  value="abimee" <?= isset($_POST['jante_avg']) ?  : '' ?> >
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="jante_ard" id="jante_ard" value="ok" <?= isset($_POST['jante_ard']) ?  : '' ?> >
                                        <input type="radio" class="checkbox" name="jante_ard" id="jante_ard"  value="abimee" <?= isset($_POST['jante_ard']) ?  : '' ?> >
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="jante_arg" id="jante_arg" value="ok" <?= isset($_POST['jante_arg']) ? : '' ?> >
                                        <input type="radio" class="checkbox" name="jante_arg" id="jante_arg"  value="abimee" <?= isset($_POST['jante_arg']) ? : '' ?> >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hrTablet">
                        <div class="col-md-7">
                            <div class="col-lg-12">
                                <div class="col-md-2 TextEtat">
                                    <h5 class="TextCheckEtat" >Siége AVG</h5>
                                    <h5 class="TextCheckEtat">Siége AVD</h5>
                                    <h5 class="TextCheckEtat">Siége ARG</h5>
                                    <h5 class="TextCheckEtat">Siége ARD</h5>
                                    <h5 class="TextCheckEtat">Banquettes</h5>
                                    <h5 class="TextCheckEtat">Moquettes</h5>
                                    <h5 class="TextCheckEtat">Ciel de Toit</h5>
                                </div>
                                <div class="col-md-5 checkboxIntérieur">
                                    <h3 class="TextIntérieur">Etat Intérieur</h3>
                                    <p class="TextONR">Ok(propre) N(nettoyer) R(réparer)</p>
                                    <div class="attribut">
                                        <p>Ok</p> <p>N</p> <p>R</p>
                                    </div>
                                    <div class="checkboxInput checkboxEtatBottom">
                                        <input type="radio" class="checkbox" name="siege_avg" id="siege_avg" value="propre" <?= isset($_POST['jante_arg']) ? : '' ?>  >
                                        <input type="radio" class="checkbox" name="siege_avg" id="siege_avg" value="nettoyer" <?= isset($_POST['jante_arg']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="siege_avg" id="siege_avg" value="reparer" <?= isset($_POST['jante_arg']) ?  : '' ?>  >
                                    </div>
                                    <div class="checkboxInput checkboxEtatBottom">
                                        <input type="radio" class="checkbox" name="siege_avd" id="siege_avd" value="propre" <?= isset($_POST['siege_avd']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="siege_avd" id="siege_avd" value="nettoyer" <?= isset($_POST['siege_avd']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="siege_avd" id="siege_avd" value="reparer" <?= isset($_POST['siege_avd']) ?  : '' ?>  >
                                    </div>
                                    <div class="checkboxInput checkboxEtatBottom">
                                        <input type="radio" class="checkbox" name="siege_arg" id="siege_arg" value="propre" <?= isset($_POST['siege_arg']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="siege_arg" id="siege_arg" value="nettoyer" <?= isset($_POST['siege_arg']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="siege_arg" id="siege_arg" value="reparer" <?= isset($_POST['siege_arg']) ?  : '' ?>  >
                                    </div>
                                    <div class="checkboxInput checkboxEtatBottom">
                                        <input type="radio" class="checkbox" name="siege_ard" id="siege_ard" value="propre" <?= isset($_POST['siege_ard']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="siege_ard" id="siege_ard" value="nettoyer" <?= isset($_POST['siege_ard']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="siege_ard" id="siege_ard" value="reparer" <?= isset($_POST['siege_ard']) ?  : '' ?>  >
                                    </div>
                                    <div class="checkboxInput checkboxEtatBottom">
                                        <input type="radio" class="checkbox" name="banquettes" id="banquettes" value="propre" <?= isset($_POST['banquettes']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="banquettes" id="banquettes" value="nettoyer" <?= isset($_POST['banquettes']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="banquettes" id="banquettes" value="reparer" <?= isset($_POST['banquettes']) ?  : '' ?>  >
                                    </div>
                                    <div class="checkboxInput checkboxEtatBottom">
                                        <input type="radio" class="checkbox" name="moquettes" id="moquettes" value="propre" <?= isset($_POST['moquettes']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="moquettes" id="moquettes" value="nettoyer" <?= isset($_POST['moquettes']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="moquettes" id="moquettes" value="reparer" <?= isset($_POST['moquettes']) ?  : '' ?>  >
                                    </div>
                                    <div class="checkboxInput checkboxEtatBottom">
                                        <input type="radio" class="checkbox" name="ciel_de_toit" id="ciel_de_toit" value="propre" <?= isset($_POST['ciel_de_toit']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="ciel_de_toit" id="ciel_de_toit" value="nettoyer" <?= isset($_POST['ciel_de_toit']) ?  : '' ?>  >
                                        <input type="radio" class="checkbox" name="ciel_de_toit" id="ciel_de_toit" value="reparer" <?= isset($_POST['ciel_de_toit']) ?  : '' ?>  >
                                    </div>
                                </div>
                                <hr class="hrTablet" >
                                <div class="col-md-5">
                                    <h3 class="TextIntérieur">Papiers/accessoires de bord</h3>
                                    <div class="col-lg-12">
                                        <div class="col-md-6">
                                            <div class="TextEtatAcces">
                                                <h5 class="TextCheckAcces" >Cart Grise</h5>
                                                <h5 class="TextCheckAcces">Assurance</h5>
                                                <h5 class="TextCheckAcces">Carnet entretien</h5>
                                                <h5 class="TextCheckAcces">Livre de bord</h5>
                                                <h5 class="TextCheckAcces">Constat</h5>
                                                <h5 class="TextCheckAcces">Kit de secours</h5>
                                                <h5 class="TextCheckAcces">Double de clefs</h5>
                                                <h5 class="TextCheckAcces">Roue de secours</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6 divAttribut">
                                            <div class="attribut">
                                                <p>Ok</p>
                                            </div>
                                            <div class="checkboxInput">
                                                <input type="checkbox" class="checkbox" name="carte_grise" id="carte_grise" value="ok" <?= isset($_POST['carte_grise']) ? : '' ?> >
                                            </div>
                                            <div class="checkboxInput">
                                                <input type="checkbox" class="checkbox" name="assurance" id="assurance" value="ok" <?= isset($_POST['assurance']) ? : '' ?> >
                                            </div>
                                            <div class="checkboxInput">
                                                <input type="checkbox" class="checkbox" name="carnet_entretien" id="carnet_entretien" value="ok" <?= isset($_POST['carnet_entretien']) ?  : '' ?> >
                                            </div>
                                            <div class="checkboxInput">
                                                <input type="checkbox" class="checkbox" name="livre_bord" id="livre_bord" value="ok" <?= isset($_POST['livre_bord']) ?  : '' ?> >
                                            </div>
                                            <div class="checkboxInput">
                                                <input type="checkbox" class="checkbox" name="constat" id="constat" value="ok" <?= isset($_POST['constat']) ?  : '' ?> >
                                            </div>
                                            <div class="checkboxInput">
                                                <input type="checkbox" class="checkbox" name="kit_secours" id="kit_secours" value="ok" <?= isset($_POST['kit_secours']) ?  : '' ?> >
                                            </div>
                                            <div class="checkboxInput">
                                                <input type="checkbox" class="checkbox" name="double_clefs" id="double_clefs" value="ok" <?= isset($_POST['double_clefs']) ?  : '' ?> >
                                            </div>
                                            <div class="checkboxInput">
                                                <input type="checkbox" class="checkbox" name="roue_secours" id="roue_secours" value="ok" <?= isset($_POST['roue_secours']) ? : '' ?> >
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr class="hrTablet" >

                    <div class="col-lg-12">
                        <div class="col-md-5">
                            <h5 class="TextCarburant" >Niveau de Carburant</h5>
                            <div class="TextTitleCarbur">
                                <h5 class="" >Réserve</h5>
                                <h5 class="">1/4</h5>
                                <h5 class="">1/2</h5>
                                <h5 class="">3/4</h5>
                                <h5 class="">Plein</h5>
                            </div>
                            <div class="checkCarburant">
                                <input type="radio" class="checkbox" name="niv_carburant" id="niv_carburant" value="reserve" <?= isset($_POST['niv_carburant']) ? : '' ?> >
                                <input type="radio" class="checkbox" name="niv_carburant" id="niv_carburant" value="1/4" <?= isset($_POST['niv_carburant']) ?  : '' ?> >
                                <input type="radio" class="checkbox" name="niv_carburant" id="niv_carburant" value="1/2" <?= isset($_POST['niv_carburant']) ?  : '' ?> >
                                <input type="radio" class="checkbox" name="niv_carburant" id="niv_carburant" value="3/4" <?= isset($_POST['niv_carburant']) ?  : '' ?> >
                                <input type="radio" class="checkbox" name="niv_carburant" id="niv_carburant" value="plein" <?= isset($_POST['niv_carburant']) ?  : '' ?> >
                            </div>
                            <div class="ImagCarDiv">
                                <img alt="" src="<?php echo base_url() . 'assets/uploads/vwpaintcode.jpg'  ?> " class="ImagCar">
                            </div>
                            <hr class="hrTablet" >
                            <div class="col-lg-12">
                                <div class="col-md-4 boxAnti">
                                    <div class="TextPhare">
                                        <h5 class="TextCheckAcces" >Phare avant</h5>
                                        <h5 class="TextCheckAcces">Anti Brouillard</h5>
                                        <h5 class="TextCheckAcces">Clignotant Rétro</h5>
                                        <h5 class="TextCheckAcces">Option Arriére</h5>
                                        <h5 class="TextCheckAcces">Vitre Avant</h5>
                                        <h5 class="TextCheckAcces">Vitre Arriére</h5>
                                    </div>
                                </div>
                                <div class="col-md-6 divDroitG ">
                                    <div class="attribut">
                                        <p>Droit</p> <p>Gauche</p>
                                    </div>

                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="phare_avant" id="phare_avant" value="droit" <?= isset($_POST['phare_avant']) ?  : '' ?> >
                                        <input type="radio" class="checkbox" name="phare_avant" id="phare_avant" value="gauche" <?= isset($_POST['phare_avant']) ?  : '' ?> >
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="anti_brouillard" id="anti_brouillard" value="droit" <?= isset($_POST['anti_brouillard']) ?  : '' ?> >
                                        <input type="radio" class="checkbox" name="anti_brouillard" id="anti_brouillard" value="gauche" <?= isset($_POST['anti_brouillard']) ?  : '' ?> >
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="clignotant_retro" id="clignotant_retro" value="droit" <?= isset($_POST['clignotant_retro']) ? : '' ?> >
                                        <input type="radio" class="checkbox" name="clignotant_retro" id="clignotant_retro" value="gauche" <?= isset($_POST['clignotant_retro']) ?  : '' ?> >
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="optique_arriere" id="optique_arriere" value="droit" <?= isset($_POST['optique_arriere']) ?  : '' ?> >
                                        <input type="radio" class="checkbox" name="optique_arriere" id="optique_arriere" value="gauche" <?= isset($_POST['optique_arriere']) ? : '' ?> >
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="vitre_avant" id="vitre_avant" value="droit" <?= isset($_POST['vitre_avant']) ? : '' ?> >
                                        <input type="radio" class="checkbox" name="vitre_avant" id="vitre_avant" value="gauche" <?= isset($_POST['vitre_avant']) ?  : '' ?> >
                                    </div>
                                    <div class="checkboxInput">
                                        <input type="radio" class="checkbox" name="vitre_arriere" id="vitre_arriere" value="droit" <?= isset($_POST['vitre_arriere']) ?  : '' ?>>
                                        <input type="radio" class="checkbox" name="vitre_arriere" id="vitre_arriere" value="gauche" <?= isset($_POST['vitre_arriere']) ?  : '' ?>>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <hr class="hrTablet">
                        <div class="col-md-7">
                            <h5 class="TextCarburant" >Cochez les Eléments abimés</h5>
                            <div class="col-lg-12">
                                <div class="col-md-6">
                                    <div class="col-lg-12">
                                        <div class="col-md-2 checkboxAbimés">
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="pv_av" id="pv_av" value="pv_av" <?= isset($_POST['pv_av']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="capot" id="capot" value="capot" <?= isset($_POST['capot']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="aile_avg" id="aile_avg" value="aile_avg" <?= isset($_POST['aile_avg']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="porte_avg" id="porte_avg" value="porte_avg" <?= isset($_POST['porte_avg']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="porte_arg" id="porte_arg" value="porte_arg" <?= isset($_POST['porte_arg']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="aile_arg" id="aile_arg" value="aile_arg" <?= isset($_POST['aile_arg']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="bas_caisse_g" id="bas_caisse_g" value="bas_caisse_g" <?= isset($_POST['bas_caisse_g']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="jante_avg2" id="jante_avg2" value="jante_avg2" <?= isset($_POST['jante_avg2']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="jante_arg2" id="jante_arg2" value="jante_arg2" <?= isset($_POST['jante_arg2']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="retroviseur_g" id="retroviseur_g" value="retroviseur_g" <?= isset($_POST['retroviseur_g']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="enjoliveur_pc_av" id="enjoliveur_pc_av" value="enjoliveur_pc_av" <?= isset($_POST['enjoliveur_pc_av']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="baguette_porte_avg" id="baguette_porte_avg" value="baguette_porte_avg" <?= isset($_POST['baguette_porte_avg']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="baguette_porte_arg" id="baguette_porte_arg" value="baguette_porte_arg" <?= isset($_POST['baguette_porte_arg']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="enjoliveur_aile_avg" id="enjoliveur_aile_avg" value="enjoliveur_aile_avg" <?= isset($_POST['enjoliveur_aile_avg']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="enjoliveur_aile_arg" id="enjoliveur_aile_arg" value="enjoliveur_aile_arg" <?= isset($_POST['enjoliveur_aile_arg']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="pare_brise" id="pare_brise" value="pare_brise" <?= isset($_POST['pare_brise']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="lunette_arriere" id="lunette_arriere" value="lunette_arriere" <?= isset($_POST['lunette_arriere']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="balais_essuie_glace_av" id="balais_essuie_glace_av" value="balais_essuie_glace_av" <?= isset($_POST['balais_essuie_glace_av']) ?  : '' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-8 textAbimés">
                                            <div class="">
                                                <h5 class="TextCheckAbime" >PV AV</h5>
                                                <h5 class="TextCheckAbime">CAPOT</h5>
                                                <h5 class="TextCheckAbime">AILE AVG</h5>
                                                <h5 class="TextCheckAbime">PORT AVG</h5>
                                                <h5 class="TextCheckAbime">PORT ARG</h5>
                                                <h5 class="TextCheckAbime">AILE ARG</h5>
                                                <h5 class="TextCheckAbime">BAS de CAISSE G</h5>
                                                <h5 class="TextCheckAbime">JANTE AVG</h5>
                                                <h5 class="TextCheckAbime">JANTE ARG</h5>
                                                <h5 class="TextCheckAbime">RETROVISEUR G</h5>
                                                <h5 class="TextCheckAbime">ENJOLIVEUR PC AV</h5>
                                                <h5 class="TextCheckAbime">BAGUETTE Port AVG</h5>
                                                <h5 class="TextCheckAbime">BAGUETTE Port ARG</h5>
                                                <h5 class="TextCheckAbime">ENJOLIVER Aile AVG</h5>
                                                <h5 class="TextCheckAbime">ENJOLIVER Aile ARG</h5>
                                                <h5 class="TextCheckAbime">PARE BRISE</h5>
                                                <h5 class="TextCheckAbime">LUNETTE Arriére</h5>
                                                <h5 class="TextCheckAbime">Balais Essuie Glace AV</h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-lg-12">
                                        <div class="col-md-2 checkboxAbimés2">
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="pc_ar" id="pc_ar" value="pc_ar" <?= isset($_POST['pc_ar']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="coffre" id="coffre" value="coffre" <?= isset($_POST['coffre']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="aile_avd" id="aile_avd" value="aile_avd" <?= isset($_POST['aile_avd']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="porte_avd" id="porte_avd" value="porte_avd" <?= isset($_POST['porte_avd']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="porte_ard" id="porte_ard" value="porte_ard" <?= isset($_POST['porte_ard']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="aile_ard" id="aile_ard" value="aile_ard" <?= isset($_POST['aile_ard']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="bas_de_caisse_jante" id="bas_de_caisse_jante" value="bas_de_caisse_jante" <?= isset($_POST['bas_de_caisse_jante']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="avd" id="avd" value="avd" <?= isset($_POST['avd']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="jante_ard2" id="avd" value="jante_ard2" <?= isset($_POST['jante_ard2']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="retriviseur_d" id="retriviseur_d" value="retriviseur_d" <?= isset($_POST['retriviseur_d']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="calandre" id="calandre" value="calandre" <?= isset($_POST['calandre']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="baguette_porte_avd" id="baguette_porte_avd" value="baguette_porte_avd" <?= isset($_POST['baguette_porte_avd']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="baguette_porte_ard" id="baguette_porte_ard" value="baguette_porte_ard" <?= isset($_POST['baguette_porte_ard']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="baguette_aile_avd" id="baguette_aile_avd" value="baguette_aile_avd" <?= isset($_POST['baguette_aile_avd']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="baguette_aile_ard" id="baguette_aile_ard" value="baguette_aile_ard" <?= isset($_POST['baguette_aile_ard']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="toit_ouvrant" id="toit_ouvrant" value="toit_ouvrant" <?= isset($_POST['toit_ouvrant']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="toit_panoramique" id="toit_panoramique" value="toit_panoramique" <?= isset($_POST['toit_panoramique']) ?  : '' ?>>
                                            </div>
                                            <div class="InputChe">
                                                <input type="checkbox" class="checkbox" name="balais_essuie_glace_av_2" id="balais_essuie_glace_av_2" value="balais_essuie_glace_av_2" <?= isset($_POST['balais_essuie_glace_av_2']) ?  : '' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-8 textAbimés2">
                                            <div class="">
                                                <h5 class="TextCheckAbime" >PC AR</h5>
                                                <h5 class="TextCheckAbime">COFFRE</h5>
                                                <h5 class="TextCheckAbime">AILE AVD</h5>
                                                <h5 class="TextCheckAbime">PORT AVD</h5>
                                                <h5 class="TextCheckAbime">PORT ARD</h5>
                                                <h5 class="TextCheckAbime">AILE ARD</h5>
                                                <h5 class="TextCheckAbime">BAS de CAISSE JANTE</h5>
                                                <h5 class="TextCheckAbime">AVD</h5>
                                                <h5 class="TextCheckAbime">JANTE ARD</h5>
                                                <h5 class="TextCheckAbime">RETROVISEUR D</h5>
                                                <h5 class="TextCheckAbime">CALANDRE</h5>
                                                <h5 class="TextCheckAbime">BAGUETTE Port AVD</h5>
                                                <h5 class="TextCheckAbime">BAGUETTE Port ARD</h5>
                                                <h5 class="TextCheckAbime">ENJOLIVER Aile AVD</h5>
                                                <h5 class="TextCheckAbime">ENJOLIVER Aile ARD</h5>
                                                <h5 class="TextCheckAbime">TOIT OUVRANT</h5>
                                                <h5 class="TextCheckAbime">TOIT Panoramique</h5>
                                                <h5 class="TextCheckAbime">Balais Essuie Glace AV</h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hrTablet" >

                    <div class="col-lg-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ENTRETIEN A PREVOIR</label>
                                <?php echo form_textarea('entretien', (isset($_POST['entretien']) ? $_POST['entretien'] : ''), 'class="form-control" id="note"'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>PIECE(S) A COMMANDER</label>
                                <?php echo form_textarea('piece', (isset($_POST['piece']) ? $_POST['piece'] : ''), 'class="form-control" id="note"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="col-md-6">
                            <div class="form-group all">
                                <?= lang('controle_image', 'controle_image') ?>
                                <input id="controle_image" type="file"  name="controle_image[]" <?= isset($_POST['controle_image']) ? $_POST['controle_image'] : '' ?> multiple="true" data-show-upload="false"
                                       data-show-preview="false" class="form-control file" >
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12">
                        <div class="col-md-6">
                            <div class="fprom-group"><?php echo form_submit('add_controle', $this->lang->line('submit'), 'id="add_controle" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                            </div>

                        </div>

                        <div class="col-md-6 ImpremierRespons">
                            <button type="button" class="btn btn-primary" id="reset">Imprimer
                        </div>
                    </div>
                </div>






            </div>


        </div>
    </div>
</div>
<?php echo form_close(); ?>

</div>

</div>
</div>
</div>
