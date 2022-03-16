<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Controle_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function getControle(){
        $this->db->select('*');
        $this->db->from('controle');
        $controles = $this->db->get()->result_array();
        //var_dump($controles);die();
        return $controles;

    }

    public function addControle($data){

        $this->db->insert('controle', $data);
        $id_controle = $this->db->insert_id();
        return $id_controle;

    }

    public function addControleCar($items,$itemAbimes,$photo,$id_controle){
        $this->db->insert('controle_car', $items);
        $this->db->insert('controle_abimes', $itemAbimes);

        if ($photo) {
            foreach ($photo as $pho) {
                $this->db->insert('controle_image', ['id_controle' => $id_controle, 'image' => $pho]);
            }
        }

        //$this->db->insert('controle_image', $controle_image);
    }

    public function updateControle($id,$dataEdit,$itemsEdit,$dataEditCar,$photo){

        if ($this->db->update('controle', $dataEdit, ['id' => $id])){
            $this->db->update('controle_car', $itemsEdit, ['id_controle' => $id]);
            $this->db->update('controle_abimes', $dataEditCar, ['id_controle' => $id]);
            // $this->db->update('controle_image', $photo, ['id_controle' => $id]);

            if ($photo) {
                foreach ($photo as $pho) {
                    $this->db->insert('controle_image', ['id_controle' => $id, 'image' => $pho]);
                }
            }
            return true;
        }

        return false;

    }


    public function getControlePhotos($id)
    {
        $q = $this->db->get_where('controle_image', ['id_controle' => $id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }


    public function getOneControle($id){

        $this->db->select('controle.*,controle_car.*,controle_abimes.*');
        $this->db->from('controle');
        $this->db->join('controle_car','controle_car.id_controle=controle.id');
        $this->db->join('controle_abimes','controle_abimes.id_controle=controle.id');
        //$this->db->join('controle_image','controle_image.id_controle=controle.id');
        $this->db->where('controle.id', $id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;

    }


    public function deleteControle($id){
        if ($this->db->delete('controle_car', ['id_controle' => $id]) &&
            $this->db->delete('controle_abimes', ['id_controle' => $id]) &&
            $this->db->delete('controle_image', ['id_controle' => $id]) &&
            $this->db->delete('controle', ['id' => $id])) {
            return true;
        }
        return false;
    }

    public function deleteImage($id){
        if($this->db->delete('controle_image', ['id' => $id])){
            return true;
        }
        return false;


    }

}