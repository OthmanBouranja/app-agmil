<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Controle extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }
        if ($this->Supplier) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->lang->admin_load('devis', $this->Settings->user_language);
        $this->load->library('form_validation');
        $this->load->admin_model('controle_model');
        $this->digital_upload_path = 'files/';
        $this->upload_path         = 'assets/images/';
        $this->thumbs_path         = 'assets/uploads/thumbs/';
        $this->image_types         = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types  = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
        $this->allowed_file_size   = '5024';
        $this->popup_attributes    = ['width' => '900', 'height' => '600', 'window_name' => 'sma_popup', 'menubar' => 'yes', 'scrollbars' => 'yes', 'status' => 'no', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0'];
        $this->data['logo']        = true;
        $this->load->library('attachments', [
            'path'     => $this->digital_upload_path,
            'types'    => $this->digital_file_types,
            'max_size' => $this->allowed_file_size,
        ]);
    }

    public function controle(){

        $this->data['controle'] = $this->controle_model->getControle();
        //var_dump($this->data['controle']);die();

        $bc   = [['link' => base_url(), 'page' => lang('home')], ['link' => '#', 'page' => lang('controle')]];
        $meta = ['page_title' => lang('controle'), 'bc' => $bc];

        $this->page_construct('controle/controle', $meta, $this->data);
    }

    //Start function add ficher controle
    public function add_controle(){

        $this->sma->checkPermissions();

        $this->form_validation->set_rules('controle_image', lang('controle_image'), 'xss_clean');

        if($this->form_validation->run() == true){
            if ($this->Owner || $this->Admin) {
                $date = $this->sma->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $immatriculation     = $this->input->post('immatriculation');
            $marque     = $this->input->post('marque');
            $kilometrage        = $this->input->post('kilometrage');
            $dealtis_car     = $this->input->post('dealtis_car');
            $entretien        = $this->input->post('entretien');
            $piece        = $this->input->post('piece');
            $pneu_avd      = $this->input->post('pneu_avd');
            $pneu_avg      = $this->input->post('pneu_avg');
            $pneu_ard      = $this->input->post('pneu_ard');
            $pneu_arg      = $this->input->post('pneu_arg');
            $jante_avd      = $this->input->post('jante_avd');
            $jante_avg      = $this->input->post('jante_avg');
            $jante_ard      = $this->input->post('jante_ard');
            $jante_arg      = $this->input->post('jante_arg');
            $siege_avg      = $this->input->post('siege_avg');
            $siege_avd      = $this->input->post('siege_avd');
            $siege_arg      = $this->input->post('siege_arg');
            $siege_ard      = $this->input->post('siege_ard');
            $banquettes      = $this->input->post('banquettes');
            $moquettes      = $this->input->post('moquettes');
            $ciel_de_toit      = $this->input->post('ciel_de_toit');
            $niv_carburant      = $this->input->post('niv_carburant');
            $phare_avant      = $this->input->post('phare_avant');
            $anti_brouillard      = $this->input->post('anti_brouillard');
            $clignotant_retro      = $this->input->post('clignotant_retro');
            $optique_arriere      = $this->input->post('optique_arriere');
            $vitre_avant      = $this->input->post('vitre_avant');
            $vitre_arriere      = $this->input->post('vitre_arriere');
            $carte_grise      = $this->input->post('carte_grise');
            $assurance      = $this->input->post('assurance');
            $carnet_entretien      = $this->input->post('carnet_entretien');
            $livre_bord      = $this->input->post('livre_bord');
            $constat      = $this->input->post('constat');
            $kit_secours      = $this->input->post('kit_secours');
            $double_clefs      = $this->input->post('double_clefs');
            $roue_secours      = $this->input->post('roue_secours');
            $pv_av              =  $this->input->post('pv_av');
            $capot              =  $this->input->post('capot');
            $aile_avg              =  $this->input->post('aile_avg');
            $porte_avg              =  $this->input->post('porte_avg');
            $porte_arg              =  $this->input->post('porte_arg');
            $aile_arg              =  $this->input->post('aile_arg');
            $bas_caisse_g             =  $this->input->post('bas_caisse_g');
            $jante_avg2             =  $this->input->post('jante_avg2');
            $jante_arg2            = $this->input->post('jante_arg2');
            $retroviseur_g              =  $this->input->post('retroviseur_g');
            $enjoliveur_pc_av              =  $this->input->post('enjoliveur_pc_av');
            $baguette_porte_avg              =  $this->input->post('baguette_porte_avg');
            $baguette_porte_arg              =  $this->input->post('baguette_porte_arg');
            $enjoliveur_aile_avg              =  $this->input->post('enjoliveur_aile_avg');
            $enjoliveur_aile_arg              =  $this->input->post('enjoliveur_aile_arg');
            $pare_brise                         =  $this->input->post('pare_brise');
            $lunette_arriere                    =  $this->input->post('lunette_arriere');
            $balais_essuie_glace_av                    =  $this->input->post('balais_essuie_glace_av');
            $pc_ar                    =  $this->input->post('pc_ar');
            $coffre                    =  $this->input->post('coffre');
            $aile_avd                    =  $this->input->post('aile_avd');
            $porte_avd                    =  $this->input->post('porte_avd');
            $porte_ard                    =  $this->input->post('porte_ard');
            $aile_ard                    =  $this->input->post('aile_ard');
            $bas_de_caisse_jante                    =  $this->input->post('bas_de_caisse_jante');
            $avd                    =  $this->input->post('avd');
            $jante_ard2                    =  $this->input->post('jante_ard2');
            $retriviseur_d                    =  $this->input->post('retriviseur_d');
            $calandre                    =  $this->input->post('calandre');
            $baguette_porte_avd                    =  $this->input->post('baguette_porte_avd');
            $baguette_porte_ard                   =  $this->input->post('baguette_porte_ard');
            $baguette_aile_avd                    =  $this->input->post('baguette_aile_avd');
            $baguette_aile_ard                    =  $this->input->post('baguette_aile_ard');
            $toit_ouvrant                    =  $this->input->post('toit_ouvrant');
            $toit_panoramique                    =  $this->input->post('toit_panoramique');
            $balais_essuie_glace_av_2                    =  $this->input->post('balais_essuie_glace_av_2');
            //$controle_image                    =  $this->input->post('controle_image');

            $data  = [
                'date'                    => $date,
                'immatriculation'        => $immatriculation,
                'marque'                 => $marque,
                'kilometrage'           => $kilometrage,
                'dealtis_car'           => $dealtis_car,
                'entretien'             => $entretien,
                'piece'                 => $piece,
            ];
        }


        if ( $this->form_validation->run() == true ){
            $this->load->library('upload');
            if($_FILES['controle_image']['name'][0] != ''){
                $config['upload_path']   = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size']      = $this->allowed_file_size;
                $config['max_width']     = $this->Settings->iwidth;
                $config['max_height']    = $this->Settings->iheight;
                $config['overwrite']     = false;
                $config['encrypt_name']  = true;
                $config['max_filename']  = 25;
                $files                   = $_FILES;
                $cpt                     = count($_FILES['controle_image']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['controle_image']['name'] = $files['controle_image']['name'][$i];
                    $_FILES['controle_image']['type']     = $files['controle_image']['type'][$i];
                    $_FILES['controle_image']['tmp_name'] = $files['controle_image']['tmp_name'][$i];
                    $_FILES['controle_image']['error']    = $files['controle_image']['error'][$i];
                    $_FILES['controle_image']['size']     = $files['controle_image']['size'][$i];

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('controle_image')) {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        admin_redirect('controle/add_controle ');
                    }else{
                        $pho = $this->upload->file_name;
                        $photo[] = $pho;
                        // var_dump($photo);die();
                    }
                }
                $config = null;

            }else{
                $photo = null;
            }

            $id_controle  =   $this->controle_model->addControle($data);

            $items = [
                'id_controle'  =>$id_controle,
                'pneu_avd'    =>$pneu_avd,
                'pneu_avg'    =>$pneu_avg,
                'pneu_ard'    =>$pneu_ard,
                'pneu_arg'    =>$pneu_arg,
                'jante_avd'    =>$jante_avd,
                'jante_avg'    =>$jante_avg,
                'jante_ard'    =>$jante_ard,
                'jante_arg'    =>$jante_arg,
                'siege_avg'    =>$siege_avg,
                'siege_avd'    =>$siege_avd,
                'siege_arg'    =>$siege_arg,
                'siege_ard'    =>$siege_ard,
                'banquettes'    =>$banquettes,
                'moquettes'    =>$moquettes,
                'ciel_de_toit'    =>$ciel_de_toit,
                'niv_carburant'    =>$niv_carburant,
                'phare_avant'    =>$phare_avant,
                'anti_brouillard'    =>$anti_brouillard,
                'clignotant_retro'    =>$clignotant_retro,
                'optique_arriere'    =>$optique_arriere,
                'vitre_avant'    =>$vitre_avant,
                'vitre_arriere'    =>$vitre_arriere,
                'carte_grise'    =>$carte_grise,
                'assurance'    =>  $assurance,
                'carnet_entretien'    =>$carnet_entretien,
                'livre_bord'    =>$livre_bord,
                'constat'    =>$constat,
                'kit_secours'    =>$kit_secours,
                'double_clefs'    =>$double_clefs,
                'roue_secours'    =>$roue_secours,
            ];
            $itemAbimes  =  [
                'id_controle'  =>$id_controle,
                'pv_av'                    => $pv_av,
                'capot'                    => $capot,
                'aile_avg'                    => $aile_avg,
                'porte_avg'                    => $porte_avg,
                'porte_arg'                    => $porte_arg,
                'aile_arg'                    => $aile_arg,
                'bas_caisse_g'                    => $bas_caisse_g,
                'jante_avg2'                    => $jante_avg2,
                'jante_arg2'                    => $jante_arg2,
                'retroviseur_g'                    => $retroviseur_g,
                'enjoliveur_pc_av'                    => $enjoliveur_pc_av,
                'baguette_porte_avg'                    => $baguette_porte_avg,
                'baguette_porte_arg'                    => $baguette_porte_arg,
                'enjoliveur_aile_avg'                    => $enjoliveur_aile_avg,
                'enjoliveur_aile_arg'                    => $enjoliveur_aile_arg,
                'pare_brise'                    => $pare_brise,
                'lunette_arriere'                    => $lunette_arriere,
                'balais_essuie_glace_av'                    => $balais_essuie_glace_av,
                'pc_ar'                    => $pc_ar,
                'coffre'                    => $coffre,
                'aile_avd'                    => $aile_avd,
                'porte_avd'                    => $porte_avd,
                'porte_ard'                    => $porte_ard,
                'aile_ard'                    => $aile_ard,
                'bas_de_caisse_jante'                    => $bas_de_caisse_jante,
                'avd'                    => $avd,
                'jante_ard2'                    => $jante_ard2,
                'retriviseur_d'                    => $retriviseur_d,
                'calandre'                    => $calandre,
                'baguette_porte_avd'                    => $baguette_porte_avd,
                'baguette_porte_ard'                    => $baguette_porte_ard,
                'baguette_aile_avd'                    => $baguette_aile_avd,
                'baguette_aile_ard'                    => $baguette_aile_ard,
                'toit_ouvrant'                    => $toit_ouvrant,
                'toit_panoramique'                    => $toit_panoramique,
                'balais_essuie_glace_av_2'                    => $balais_essuie_glace_av_2,
            ];

            if($this->form_validation->run() == true && $this->controle_model->addControleCar($items,$itemAbimes,$photo,$id_controle)) {
                $this->session->set_flashdata('message', $this->lang->line('controle_added'));
                admin_redirect('controle/controle');
            }
                $this->session->set_flashdata('message', $this->lang->line('controle_added'));
                admin_redirect('controle/controle');

        }
        //admin_redirect('devis');

        $bc   = [['link' => base_url(), 'page' => lang('home')], ['link' => '#', 'page' => lang('add_controle')]];
        $meta = ['page_title' => lang('add_controle'), 'bc' => $bc];

        $this->page_construct('controle/add_controle', $meta, $this->data);

    }
    //End function add ficher controle


    public function viewControle($id){
        $this->sma->checkPermissions();
        $oneControle =   $this->controle_model->getOneControle($id);
        //var_dump($oneControle);die();

        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
        $this->form_validation->set_rules('immatriculation', $this->lang->line('immatriculation'));
        $this->form_validation->set_rules('marque', $this->lang->line('marque'));
        $this->form_validation->set_rules('controle_image', lang('controle_image'), 'xss_clean');


        if($this->form_validation->run() == true){

            //$date = ($this->Owner || $this->Admin) ? $this->sma->fld(trim($this->input->post('date'))) : $oneControle->date;

            if ($this->Owner || $this->Admin) {
                $date = $this->sma->fld(trim($this->input->post('date')));
            } else {
                $date = $oneControle->date;
            }

            //$date             = $this->input->post('date');
            $immatriculation     = $this->input->post('immatriculation');
            $marque     = $this->input->post('marque');
            $kilometrage        = $this->input->post('kilometrage');
            $dealtis_car     = $this->input->post('dealtis_car');
            $entretien        = $this->input->post('entretien');
            $piece        = $this->input->post('piece');

            $pneu_avd      = $this->input->post('pneu_avd');
            $pneu_avg      = $this->input->post('pneu_avg');
            $pneu_ard      = $this->input->post('pneu_ard');
            $pneu_arg      = $this->input->post('pneu_arg');
            $jante_avd      = $this->input->post('jante_avd');
            $jante_avg      = $this->input->post('jante_avg');
            $jante_ard      = $this->input->post('jante_ard');
            $jante_arg      = $this->input->post('jante_arg');
            $siege_avg      = $this->input->post('siege_avg');
            $siege_avd      = $this->input->post('siege_avd');
            $siege_arg      = $this->input->post('siege_arg');
            $siege_ard      = $this->input->post('siege_ard');
            $banquettes      = $this->input->post('banquettes');
            $moquettes      = $this->input->post('moquettes');
            $ciel_de_toit      = $this->input->post('ciel_de_toit');
            $niv_carburant      = $this->input->post('niv_carburant');
            $phare_avant      = $this->input->post('phare_avant');
            $anti_brouillard      = $this->input->post('anti_brouillard');
            $clignotant_retro      = $this->input->post('clignotant_retro');
            $optique_arriere      = $this->input->post('optique_arriere');
            $vitre_avant      = $this->input->post('vitre_avant');
            $vitre_arriere      = $this->input->post('vitre_arriere');
            $carte_grise      = $this->input->post('carte_grise');
            $assurance      = $this->input->post('assurance');
            $carnet_entretien      = $this->input->post('carnet_entretien');
            $livre_bord      = $this->input->post('livre_bord');
            $constat      = $this->input->post('constat');
            $kit_secours      = $this->input->post('kit_secours');
            $double_clefs      = $this->input->post('double_clefs');
            $roue_secours      = $this->input->post('roue_secours');

            $pv_av              =  $this->input->post('pv_av');
            $capot              =  $this->input->post('capot');
            $aile_avg              =  $this->input->post('aile_avg');
            $porte_avg              =  $this->input->post('porte_avg');
            $porte_arg              =  $this->input->post('porte_arg');
            $aile_arg              =  $this->input->post('aile_arg');
            $bas_caisse_g             =  $this->input->post('bas_caisse_g');
            $jante_avg2             =  $this->input->post('jante_avg2');
            $jante_arg2            = $this->input->post('jante_arg2');
            $retroviseur_g              =  $this->input->post('retroviseur_g');
            $enjoliveur_pc_av              =  $this->input->post('enjoliveur_pc_av');
            $baguette_porte_avg              =  $this->input->post('baguette_porte_avg');
            $baguette_porte_arg              =  $this->input->post('baguette_porte_arg');
            $enjoliveur_aile_avg              =  $this->input->post('enjoliveur_aile_avg');
            $enjoliveur_aile_arg              =  $this->input->post('enjoliveur_aile_arg');
            $pare_brise                         =  $this->input->post('pare_brise');
            $lunette_arriere                    =  $this->input->post('lunette_arriere');
            $balais_essuie_glace_av                    =  $this->input->post('balais_essuie_glace_av');
            $pc_ar                    =  $this->input->post('pc_ar');
            $coffre                    =  $this->input->post('coffre');
            $aile_avd                    =  $this->input->post('aile_avd');
            $porte_avd                    =  $this->input->post('porte_avd');
            $porte_ard                    =  $this->input->post('porte_ard');
            $aile_ard                    =  $this->input->post('aile_ard');
            $bas_de_caisse_jante                    =  $this->input->post('bas_de_caisse_jante');
            $avd                    =  $this->input->post('avd');
            $jante_ard2                    =  $this->input->post('jante_ard2');
            $retriviseur_d                    =  $this->input->post('retriviseur_d');
            $calandre                    =  $this->input->post('calandre');
            $baguette_porte_avd                    =  $this->input->post('baguette_porte_avd');
            $baguette_porte_ard                   =  $this->input->post('baguette_porte_ard');
            $baguette_aile_avd                    =  $this->input->post('baguette_aile_avd');
            $baguette_aile_ard                    =  $this->input->post('baguette_aile_ard');
            $toit_ouvrant                    =  $this->input->post('toit_ouvrant');
            $toit_panoramique                    =  $this->input->post('toit_panoramique');
            $balais_essuie_glace_av_2                    =  $this->input->post('balais_essuie_glace_av_2');


            $this->load->library('upload');
            if($_FILES['controle_image']['name'][0] != ''){
                $config['upload_path']   = $this->upload_path;
                $config['allowed_types'] = $this->image_types;
                $config['max_size']      = $this->allowed_file_size;
                $config['max_width']     = $this->Settings->iwidth;
                $config['max_height']    = $this->Settings->iheight;
                $config['overwrite']     = false;
                $config['encrypt_name']  = true;
                $config['max_filename']  = 25;
                $files                   = $_FILES;
                $cpt                     = count($_FILES['controle_image']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['controle_image']['name'] = $files['controle_image']['name'][$i];
                    $_FILES['controle_image']['type']     = $files['controle_image']['type'][$i];
                    $_FILES['controle_image']['tmp_name'] = $files['controle_image']['tmp_name'][$i];
                    $_FILES['controle_image']['error']    = $files['controle_image']['error'][$i];
                    $_FILES['controle_image']['size']     = $files['controle_image']['size'][$i];

                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('controle_image')) {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $error);
                        redirect($_SERVER['HTTP_REFERER']);

                    }else{
                        $pho = $this->upload->file_name;
                        $photo[] = $pho;
                        // var_dump($photo);die();
                    }
                }
                $config = null;

            }else{
                $photo = null;
            }


            $dataEdit = [
                'date'                  =>  $date,
                'immatriculation'        =>  $immatriculation,
                'marque'                 => $marque,
                'kilometrage'           => $kilometrage,
                'dealtis_car'           => $dealtis_car,
                'entretien'             => $entretien,
                'piece'                 => $piece,
            ];

            //var_dump($dataEdit);die();

            $itemsEdit = [
                'pneu_avd'    =>$pneu_avd,
                'pneu_avg'    =>$pneu_avg,
                'pneu_ard'    =>$pneu_ard,
                'pneu_arg'    =>$pneu_arg,
                'jante_avd'    =>$jante_avd,
                'jante_avg'    =>$jante_avg,
                'jante_ard'    =>$jante_ard,
                'jante_arg'    =>$jante_arg,
                'siege_avg'    =>$siege_avg,
                'siege_avd'    =>$siege_avd,
                'siege_arg'    =>$siege_arg,
                'siege_ard'    =>$siege_ard,
                'banquettes'    =>$banquettes,
                'moquettes'    =>$moquettes,
                'ciel_de_toit'    =>$ciel_de_toit,
                'niv_carburant'    =>$niv_carburant,
                'phare_avant'    =>$phare_avant,
                'anti_brouillard'    =>$anti_brouillard,
                'clignotant_retro'    =>$clignotant_retro,
                'optique_arriere'    =>$optique_arriere,
                'vitre_avant'    =>$vitre_avant,
                'vitre_arriere'    =>$vitre_arriere,
                'carte_grise'    =>$carte_grise,
                'assurance'    =>  $assurance,
                'carnet_entretien'    =>$carnet_entretien,
                'livre_bord'    =>$livre_bord,
                'constat'    =>$constat,
                'kit_secours'    =>$kit_secours,
                'double_clefs'    =>$double_clefs,
                'roue_secours'    =>$roue_secours,
            ];

            $dataEditCar = [
                'pv_av'                 => $pv_av,
                'capot'                 => $capot,
                'aile_avg'                    => $aile_avg,
                'porte_avg'                    => $porte_avg,
                'porte_arg'                    => $porte_arg,
                'aile_arg'                    => $aile_arg,
                'bas_caisse_g'                    => $bas_caisse_g,
                'jante_avg2'                    => $jante_avg2,
                'jante_arg2'                    => $jante_arg2,
                'retroviseur_g'                    => $retroviseur_g,
                'enjoliveur_pc_av'                    => $enjoliveur_pc_av,
                'baguette_porte_avg'                    => $baguette_porte_avg,
                'baguette_porte_arg'                    => $baguette_porte_arg,
                'enjoliveur_aile_avg'                    => $enjoliveur_aile_avg,
                'enjoliveur_aile_arg'                    => $enjoliveur_aile_arg,
                'pare_brise'                    => $pare_brise,
                'lunette_arriere'                    => $lunette_arriere,
                'balais_essuie_glace_av'                    => $balais_essuie_glace_av,
                'pc_ar'                    => $pc_ar,
                'coffre'                    => $coffre,
                'aile_avd'                    => $aile_avd,
                'porte_avd'                    => $porte_avd,
                'porte_ard'                    => $porte_ard,
                'aile_ard'                    => $aile_ard,
                'bas_de_caisse_jante'                    => $bas_de_caisse_jante,
                'avd'                    => $avd,
                'jante_ard2'                    =>$jante_ard2,
                'retriviseur_d'                    => $retriviseur_d,
                'calandre'                    => $calandre,
                'baguette_porte_avd'                    => $baguette_porte_avd,
                'baguette_porte_ard'                    => $baguette_porte_ard,
                'baguette_aile_avd'                    => $baguette_aile_avd,
                'baguette_aile_ard'                    => $baguette_aile_ard,
                'toit_ouvrant'                    => $toit_ouvrant,
                'toit_panoramique'                    => $toit_panoramique,
                'balais_essuie_glace_av_2'                    => $balais_essuie_glace_av_2,
            ];
        }

        //var_dump($oneControle);die();
        if($this->form_validation->run() == true && $this->controle_model->updateControle($id,$dataEdit,$itemsEdit,$dataEditCar,$photo)){
            $this->session->set_flashdata('message', $this->lang->line('controle_update'));
            //admin_redirect('devis/controle');
            admin_redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'quotes');

        }
            $this->data['oneControle']  = $oneControle;
            $this->data['images']         = $this->controle_model->getControlePhotos($id);
            //var_dump($this->data);die();

            $this->data['id']        = $id;
            $bc   = [['link' => base_url(), 'page' => lang('home')], ['link' => '#', 'page' => lang('edit_controle')]];
            $meta = ['page_title' => lang('edit_controle'), 'bc' => $bc];
            $this->page_construct('controle/viewControle', $meta, $this->data);




    }

    public function deleteControle($id)
    {
        $this->sma->checkPermissions(null, true);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->controle_model->deleteControle($id)) {
            if ($this->input->is_ajax_request()) {
                $this->sma->send_json(['error' => 0, 'msg' => lang('controle_deleted')]);
            }
            $this->session->set_flashdata('message', $this->lang->line('controle_deleted'));
            //var_dump($id);die();
            admin_redirect('controle/controle');
        }
    }

    public function deleteImage($id){
        $this->sma->checkPermissions(null, true);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->controle_model->deleteImage($id)) {
            if ($this->input->is_ajax_request()) {
                $this->sma->send_json(['error' => 0, 'msg' => lang('image_deleted')]);
            }
            $this->session->set_flashdata('message', $this->lang->line('image_deleted'));
            //var_dump($id);die();
            //admin_redirect('devis/controle');
            admin_redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'quotes');

        }
    }






























}