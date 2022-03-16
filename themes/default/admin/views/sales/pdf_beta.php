<?php
/*echo "<pre>";
print_r($customer);
echo "</pre>";die();

*/ ?>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->lang->line('PROFORMA') . ' ' . $inv->reference_no; ?></title>
    <link href="<?= $assets ?>styles/pdf/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $assets ?>styles/pdf/pdf.css" rel="stylesheet">
    <style type="text/css">
        html, body {
            height: 100%;
            background: #FFF;
        }



        .small-font{
            font-size: 11px;
        }

        body:before, body:after {
            display: none !important;
        }

        table.table-bordered{
            border:1px solid black;
            margin-top:20px;
        }
        table.table-bordered > thead > tr > th{
            border:1px solid black;
        }
        table.table-bordered > tbody > tr > td{
            border:1px solid black;
        }

        .table th td{
            text-align: center;
            padding: 5px;
            background-color:#FFF9EA
            border-color: black !important;

        }
        .table td {
            padding: 2px;
        }


        #resume-montant td{
            text-align: center;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        #resume-montant thead td{
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            text-align: center;
        }

        #resume-montant tfoot td{
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            text-align: center;
        }

        .bold{
            font-weight: bold;
        }

        @page {
            margin-top: 1cm;
            margin-bottom: 1cm;
        }

        .info {
            overflow: hidden;
            height:100px;
        }

        #products table,#products th,#products td {
            padding: 5px;
            border: 1px solid black;
            border-collapse: collapse;
        }

    </style>

</head>

<body>


<div id="wrap">



    <div class="row">
        <div class="col-xs-5 bold text-center" >
            <p style="font-size: 30px;">PROFORMA</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5 small-font">

            <div style="padding:5px; background-color:#FFFFFF; border:1px solid black; -moz-border-radius:9px; -khtml-border-radius:9px; -webkit-border-radius:9px; border-radius:9px;">
                <p style="max-width: 70%;"><?= $biller->address ?></p>
                <div class="clearfix"></div>
                <p>@Mail : <?= $biller->email ?></p>
                <p>Téléphone : <?= $biller->phone ?></p>
                <p>ICE : 001767009000013</p>
                <p>RC : 362171</p>
                <p>IF : 20695346</p>

            </div>
        </div>

        <div class="col-xs-4 small-font" style="margin-left: 85px; margin-top: 40px;">
            <div class="info" style="padding:5px; background-color:#FFFFFF; border:1px solid black; -moz-border-radius:9px; -khtml-border-radius:9px; -webkit-border-radius:9px; border-radius:9px;">
               <p class=""><?= $customer->name ? $customer->name : $customer->name; ?><?php if ($customer->price_group_name != '-' && $customer->price_group_name != '') {
                        echo '<br>' . $customer->price_group_name;
                    }?></p>
                    <?= $customer->company ? '' : 'Attn: ' . $customer->name; ?>
                    <?php
                    if ($customer->gst_no != '-' && $customer->gst_no != '') {
                        echo '<br>' . lang('N° ICE ') . ': ' . $customer->gst_no;
                    }
                        echo "<br />Ville : " . $customer->city;
                    
                    ?>
            </div>
        </div>

        <!--Fin de partie 1-->


    </div>

    <div class="row" style="margin-bottom: 0;">
        <div class="col-xs-7" style="margin-top: 15px;">
            <div style="padding:5px; background-color:#FFFFFF; border:1px solid black; -moz-border-radius:9px; -khtml-border-radius:9px; -webkit-border-radius:9px; border-radius:9px;">

                <table style="width: 100%;" class="small-font">

                    <tr>
                        <td style="padding: 0 50px 0 10px; "><span class="bold">PROFORMA N°</span> : <?= $inv->reference_no; ?> </td>
                        <td style="padding: 2px 10px; text-align: right;"><span class="bold"> Date</span>: <?= $this->sma->hrld($inv->date); ?> </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-xs-5" style="margin-top: 5px;">

        </div>

        <!--Fin de partie 2-->
    </div>


    <div class="row">



        <div class="col-xs-8 small-font" style="padding-right: 3px">
            <div style="padding:5px; background-color:#FFFFFF; border:1px solid black; ">
                <div class="row">
                    <div style="padding-bottom: 20px;" class="col-xs-6"><span class="bold">Numéro Serie</span> : <?= $customer->vat_no; ?></div>
                    <div style="padding-bottom: 20px;" class="col-xs-4"><span class="bold">Immatriculation</span> : <?= $customer->company; ?></div>
                </div>
                <div class="row">
                    <div style="padding-bottom: 20px;" class="col-xs-6"><span class="bold">Marque</span>  : <?= $customer->postal_code; ?></div>
                    <div style="padding-bottom: 20px;" class="col-xs-4"><span class="bold">Kilometrage</span> : <?= strip_tags($this->sma->decode_html($inv->note));?> </div>
                </div>
                <div class="row">
                    <div class="col-xs-5"><span class="bold">Modele</span> : <?= $customer->country; ?></div>
                </div>
            </div>

        </div>

    </div>
    <div class="row">


        <div class="col-lg-12" style="display: none;">


            <div class="clearfix"></div>
            <div class="padding10">

                <div class="col-xs-5">
                    <br></br>
                    <br></br>
                    <h2 style="font-size:40px; color:#AFAFAF" class="">PROFORMA</h2>
                    <p></p>

                    <?= lang('date'); ?>: <?= $this->sma->hrld($inv->date); ?><br>
                    <?= lang('PROFORMA N°'); ?>: <?= $inv->reference_no; ?><br>
                    <?php if (!empty($inv->return_sale_ref)) {
                        echo lang("Retour N° ") . ': ' . $inv->return_sale_ref . '<br>';
                    } ?>

                </div>
                <div class="col-xs-6">
                    <div style="padding:5px; background-color:#FFFFFF; border:2px solid #C0C0C0; -moz-border-radius:9px; -khtml-border-radius:9px; -webkit-border-radius:9px; border-radius:9px;">
                        <h2 class="">À l'attention de :</h2>
                        <p class=""><?= $customer->company ? $customer->company : $customer->name; ?></p>
                        <?= $customer->company ? '' : 'Attn: ' . $customer->name; ?>
                        <?php
                        echo "<br />Ville : " . $customer->city;
                        if ($customer->gst_no != "-" && $customer->gst_no != "") {
                            echo "<br>" . lang("N° ICE") . ": " . $customer->gst_no;
                        }

                        ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="padding10">
                <div class="col-xs-5">


                    <br/>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="clearfix"></div>
        <?php
        $col = 4;
        if ($Settings->product_discount && $inv->product_discount != 0) {
            $col++;
        }
        if ($Settings->tax1 && $inv->product_tax > 0) {
            $col++;
        }
        if ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) {
            $tcol = $col - 2;
        } elseif ($Settings->product_discount && $inv->product_discount != 0) {
            $tcol = $col - 1;
        } elseif ($Settings->tax1 && $inv->product_tax > 0) {
            $tcol = $col - 1;
        } else {
            $tcol = $col;
        }
        ?>
        <div class="col-xs-12">
            <div id="products" class="table-responsive">
                <table
                       style="margin-top: 15px;">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th><?= lang('Désignation'); ?></th>
                        <th>Quantité</th>
                        <th>Prix TTC</th>
                        <th>Remise</th>
                        <th>Prix net</th>
                        <th>Prix total</th>
                        <th>TVA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $r = 1;
                    foreach ($rows as $row):
                        ?>
                        <tr>
                            <td style="text-align:center; width:40px; vertical-align:middle; font-size:11px;"><?= $r; ?></td>
                            <td style="vertical-align:middle; font-size:11px;">
                                <?= $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                <?= $row->details ? '<br>' . $row->details : ''; ?>
                                <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
                            </td>
                            <td style="width: 80px; text-align:center; vertical-align:middle; font-size:11px;"><?= $this->sma->formatQuantity($row->unit_quantity) . ' '; ?></td>
                            <td style="text-align:center; width:90px; font-size:11px;"><?= $this->sma->formatMoney($row->real_unit_price); ?></td>

                            <td style="text-align:center; width:90px; font-size:11px;">
                                <?= $row->discount=="0"? "0%": $row->discount; ?>
                            </td>

                            <td style="text-align:center; width:90px; font-size:11px;">
                                <?= $this->sma->formatMoney($row->net_unit_price); ?>
                            </td>

                            <td style="text-align:center; width:90px; font-size:11px;">
                                <?= $this->sma->formatMoney($row->subtotal); ?>
                            </td>

                            <td style="text-align:center; width:90px; font-size:11px;">
                                <?= $row->tax_rate=="0" || $row->tax_rate=="" ? "0%" : $row->tax_rate; ?>
                            </td>

                        </tr>
                        <?php
                        $r++;
                    endforeach;
                    if ($return_rows) {
                        echo '<tr class="warning"><td colspan="' . ($col + 1) . '" class="no-border"><strong>' . lang('Articles retournés') . '</strong></td></tr>';
                        foreach ($return_rows as $row):
                            ?>
                            <tr class="warning">
                                <td style="text-align:center; width:40px; vertical-align:middle; font-size:11px;"><?= $r; ?></td>
                                <td style="vertical-align:middle;">
                                    <?= $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                    <?= $row->details ? '<br>' . $row->details : ''; ?>
                                    <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
                                </td>
                                <td style="width: 80px; text-align:center; vertical-align:middle; font-size:11px;"><?= $this->sma->formatQuantity($row->quantity) . ' '; ?></td>
                                <td style="text-align:center; width:100px;"><?= $this->sma->formatMoney($row->real_unit_price); ?></td>
                                <?php
                                if ($Settings->tax1 && $inv->product_tax > 0) {
                                    echo '<td style="text-align:right; vertical-align:middle; font-size:11px;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>(' . $row->tax_code . ')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                                }
                                if ($Settings->product_discount && $inv->product_discount != 0) {
                                    echo '<td style="text-align:right; vertical-align:middle; font-size:11px;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                }
                                ?>
                                <td style="text-align:right; width:120px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                            </tr>
                            <?php
                            $r++;
                        endforeach;
                    }
                    ?>
                    </tbody>

                </table>

            </div>
            <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, $return_rows, ($return_sale ? $inv->product_tax + $return_sale->product_tax : $inv->product_tax)) : ''; ?>
        </div>
        <div class="clearfix"></div>





        <div style="margin-top: 20px;" class="col-xs-4">
            <div style="padding:0; background-color:#FFFFFF; border-right:1px solid black;border-left:1px solid black;">
                <table class="small-font" id="resume-montant" style="width: 100%;">
                    <thead>
                        <tr>
                            <td></td>
                            <td class="bold">Base</td>
                            <td class="bold">Taux</td>
                            <td class="bold">Taxe</td>
                        </tr>
                    </thead>

                    <?php foreach ($customData['rows'] as $key => $row){ ?>
                    <tr>
                        <td></td>
                        <td><?= number_format(array_sum(array_column($row,'subtotal'))-array_sum(array_column($row,'item_tax')),2,',',' ');  ?></td>
                        <td>
                            <?php
                            if($key=="0"){
                                echo "0%";
                            }else{
                                echo $key;
                            }
                            ?>
                        </td>
                        <td><?= number_format(array_sum(array_column($row,'item_tax')),2,',',' ');  ?></td>
                    </tr>
                    <?php } ?>



                    <tfoot>
                    <?php
                        $totalTTC = number_format(array_sum(array_column($rows,'subtotal')),2,',',' ');
                        $TVA = number_format(array_sum(array_column($rows,'item_tax')),2,',',' ');
                        $totalHT = array_sum(array_column($rows,'subtotal')) - array_sum(array_column($rows,'item_tax'));
                    ?>
                        <tr>
                            <td>Total</td>
                            <td class="bold">
                                <?= number_format($totalHT,2,',',' ');  ?>
                            </td>
                            <td class="bold"></td>
                            <td class="bold"><?= $TVA;  ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>



        <div style="margin-top: 63px;margin-left: 70px;" class="col-xs-6 small-font clearfix">
            <div>
                <table>
                    <tr>
                        <td style="padding: 0 20px 5px;"><span class="bold small-font"></span></td>
                        <td style="padding: 0 20px 5px;" class="pull-right"></td>
                    </tr>
                </table>

            </div>
        </div>


        <div class="clearfix"></div>
        <div class="col-xs-4" style="margin-top: 20px;">

            <div class="bold" style="font-size: 10px;margin-bottom: 10px;padding-left: 20px;">Coupon à retourner avec le règlement</div>
            <div style="padding:5px; background-color:#FFFFFF; border:1px solid black; -moz-border-radius:9px; -khtml-border-radius:9px; -webkit-border-radius:9px; border-radius:9px;">
                <table class="small-font">
                    <tr>
                        <td>Véhicule</td>
                        <td style="padding: 2px 20px 10px;">:</td>
                        <td><?= $customer->company ?></b></td>
                    </tr>

                    <tr>
                        <td>Montant</td>
                        <td style="padding: 2px 20px 10px;">:</td>
                        <td><?= $this->sma->formatMoney($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total); ?></td>
                    </tr>
                </table>
            </div>
        </div>




        <div class="col-xs-4" style="margin-left: 200px;margin-top: 25px;">
            <div style="padding:5px; background-color:#FFFFFF; border:1px solid black; -moz-border-radius:9px; -khtml-border-radius:9px; -webkit-border-radius:9px; border-radius:9px;">
                <table class="small-font">
                    <tr>
                        <td>Total HT</td>
                        <td style="padding: 2px 20px 10px;">:</td>
                        <td><?= number_format($totalHT,2,',',' ');  ?></td>
                    </tr>
                    <tr>
                        <td>TOTAL TVA</td>
                        <td style="padding: 2px 20px 10px;">:</td>
                        <td><?= $TVA;  ?></td>
                    </tr>
                    <tr>
                        <td>Total TTC</td>
                        <td style="padding: 2px 20px 10px;">:</td>
                        <td><?= $this->sma->formatMoney($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total); ?></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

</div>

</body>
</html>
