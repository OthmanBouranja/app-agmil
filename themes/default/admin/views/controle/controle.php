<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-heart-o"></i>
        </h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang('actions') ?>"></i></a>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li>
                            <a href="<?= admin_url('controle/add') ?>">
                                <i class="fa fa-plus-circle"></i> <?= lang('add_devis') ?>
                            </a>
                        </li>

                        <li>
                            <a href="#" id="combine" data-action="combine">
                                <i class="fa fa-file-pdf-o"></i> <?=lang('combine_to_pdf')?>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>

                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?= lang('warehouses') ?>"></i></a>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="<?= admin_url('devis') ?>"><i class="fa fa-building-o"></i> <?= lang('all_warehouses') ?></a></li>
                        <li class="divider"></li>

                    </ul>
                </li>

            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('list_results'); ?></p>

                <div class="table-responsive">
                    <table id="DVData" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr class="active">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkft" type="checkbox" name="check"/>
                            </th>
                            <th><?= lang('date'); ?></th>
                            <th>Immatriculation</th>
                            <th>Marque</th>
                            <th>Kilometrage</th>
                            <th style="min-width:30px; width: 30px; text-align: center;"><i class="fa fa-chain"></i></th>
                            <th style="width:115px; text-align:center;"><?= lang('actions'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <?php
                        foreach ($controle as $item){
                            ?>
                            <tr class="active">



                                <th style="min-width:30px; width: 30px; text-align: center;">
                                    <input class="checkbox checkft" type="checkbox" name="check"/>
                                </th>
                                <th><?php echo $item['date']; ?></th>
                                <th><?php echo $item['immatriculation']; ?></th>
                                <th><?php echo $item['marque']; ?></th>
                                <th><?php echo $item['kilometrage']; ?></th>
                                <th style="min-width:30px; width: 30px; text-align: center;"><i class="fa fa-chain"></i></th>
                                <th style="width:115px; text-align:center;">
                                    <div class="text-center">
                                        <div class="btn-group text-left">
                                            <button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">
                                                actions<span class="caret"></span></button>
                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li><a href="<?= admin_url('controle/viewControle'.'/'.$item['id']); ?>">
                                                        <i class="fa fa-file-text-o"></i>detail</a></li>

                                                <li><a href="<?= admin_url('controle/deleteControle'.'/'.$item['id']); ?>"><i class="fa fa-trash-o"></i>delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </th>

                            </tr>
                            <?php
                        }
                        ?>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

