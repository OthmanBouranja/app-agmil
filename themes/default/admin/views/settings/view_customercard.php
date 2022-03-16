<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= $customercard->company && $customercard->company != '-' ? $customercard->company : $customercard->name; ?></h4>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="margin-bottom:0;">
                    <tbody>
                    <tr>
                        <td><strong>Société</strong></td>
                        <td><?= $customercard->company; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang('name'); ?></strong></td>
                        <td><?= $customercard->name; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang('Type Client'); ?></strong></td>
                        <td><?= $customercard->customer_group_name; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang('N° ICE'); ?></strong></td>
                        <td><?= $customercard->gst_no; ?></strong></td>
                    </tr>

                    <tr>
                        <td><strong><?= lang('address'); ?></strong></td>
                        <td><?= $customercard->address; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang('Ville'); ?></strong></td>
                        <td><?= $customercard->city; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang('Email'); ?></strong></td>
                        <td><?= $customercard->email; ?></strong></td>
                    </tr>
                    <tr>
                        <td><strong><?= lang('phone'); ?></strong></td>
                        <td><?= $customercard->phone; ?></strong></td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= lang('close'); ?></button>

                <?php if ($Owner || $Admin || $GP['customers-edit']) {
        ?>
                    <a href="<?=admin_url('system_settings/edit_customercard/' . $customercard->id); ?>" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">Modifier la fiche client</a>
                <?php
    } ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
