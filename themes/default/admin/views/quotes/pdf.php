<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('OR') . ' ' . $inv->reference_no; ?></title>
    <link href="<?= $assets ?>styles/pdf/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $assets ?>styles/pdf/pdf.css" rel="stylesheet">
    <style type="text/css">
        html, body { height: 100%; background: #FFF; }
        
        @page {
    margin-top: 1cm;
    margin-bottom: 2cm;
}

.hovering-image{
    position: fixed;
    left: 20%;
    top:75%;
    height: 50%;
    width 50%;
}
        
    </style>
</head>

<body>
<div id="wrap">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($logo) {
                $path = base_url() . 'assets/uploads/logos/' . $biller->logo;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                ?>
                <div class="text-right" style="margin: 2px 1em 20px">
                    <img src="<?= $base64; ?>" alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                </div>
            <?php }
            ?>
            
            <div class="clearfix"></div>
            <div class="padding10">

                
    <div class="col-xs-6">
                        <h2 style="font-size:20px; color:#EAB331" class="">ORDRE DE REPARATION</h2>
                     
                     
                    <?php
                    echo '<p>';
                    if ($customer->company != '-' && $customer->company != '') {
                        echo '<br>' . lang('Immatricule') . ': ' . $customer->company; 
                    }
                    if ($customer->cf1 != '-' && $customer->cf1 != '') {
                        echo '<br>' . lang('Marque ') . ' : ' . $customer->postal_code;
                    }
                    if ($customer->cf2 != '-' && $customer->cf2 != '') {
                        echo '<br>' . lang('Modèle ') . ' : ' . $customer->country;
                    }
                    if ($customer->vat_no != '-' && $customer->vat_no != '') {
                        echo '<br>' . lang('VIN ') . ': ' . $customer->vat_no;
                    }
                    
                    echo '</p>';
                    
                    ?>
                     <div>Kilométrage du Véhicule :<?= $this->sma->decode_html($inv->note); ?></div>
                </div>
            
               
                <div class="col-xs-5">
                   <div class="bold">
                        <?=lang('date');?>: <?=$this->sma->hrld($inv->date);?><br>
                        <?=lang('ref');?>: <?=$inv->reference_no;?>
                        <div class="order_barcodes">
                            <?php
                            $path   = admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/74/0/1');
                            $type   = $Settings->barcode_img ? 'png' : 'svg+xml';
                            $data   = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                            ?>
                            <img src="<?= $base64; ?>" alt="<?= $inv->reference_no; ?>" class="bcimg" />
                            <?php /*echo $this->sma->qrcode('link', urlencode(admin_url('devis/view/' . $inv->id)), 2);*/ ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped print-table order-table" style="margin-top: 15px;">
                    <thead>
                    <tr>
                        <th><?= lang('N°'); ?></th>
                        <th><?= lang('Désignation'); ?></th>
                        <?php if ($Settings->indian_gst) {
                                ?>
                            <th><?= lang('hsn_sac_code'); ?></th>
                        <?php
                            } ?>
                        <th><?= lang('Qté'); ?></th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <?php $r = 1;
                    foreach ($rows as $row):
                        ?>
                        <tr>
                            <td style="text-align:center; width:30px; vertical-align:middle;"><?= $r; ?></td>
                            <td style="vertical-align:middle;">
                                <?= $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                <?= $row->second_name ? '<br>' . $row->second_name : ''; ?>
                                <?= $row->details ? '<br>' . $row->details : ''; ?>
                            </td>
                           
                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->unit_quantity); ?></td>
                     
                        </tr>
                        <?php
                        $r++;
                    endforeach;
                    ?>
                    </tbody>
                    
                </table>
            </div>
            <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, null, $inv->product_tax) : ''; ?>
            </div>
            <div class="clearfix"></div>


                
                <div class="clearfix"></div>
                <div class="col-xs-4  pull-left">
                    <p><?= lang('Pièce de Rechange Magasin :'); ?></p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>
                    <hr>
                    <p><?= lang('Accusée de Réception'); ?></p>
                </div>
                <div class="col-xs-4  pull-right">
                    <p><?= lang('Validation Atelier Par :'); ?></p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>
                    <hr>
                    <p><?= lang('Signature'); ?></p>
                </div>
               
        </div>
    </div>
</div> 

    <div class="hovering-image">
        <img src="http://agiml-atelierexperts.com/wms/assets/uploads/auto2.jpg">
    </div>
 

</body>

</html>
