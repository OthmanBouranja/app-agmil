<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Devis_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addDevis($data = [], $items = [],$attachments = [])
    {
        if ($this->db->insert('devis', $data)) {
            $devis_id = $this->db->insert_id();
            if ($this->site->getReference('dv') == $data['reference_no']) {
                $this->site->updateReference('dv');
            }
            foreach ($items as $item) {
                $item['devis_id'] = $devis_id;
                $this->db->insert('devis_items', $item);
            }

            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $attachment['subject_id']   = $devis_id;
                    $attachment['subject_type'] = 'devis';
                    $this->db->insert('attachments', $attachment);
                }
            }
            return true;
        }


        return false;
    }






    public function getControle(){
        $this->db->select('*');
        $this->db->from('controle');
        $controles = $this->db->get()->result_array();
        //var_dump($controles);die();
        return $controles;

    }

    public function deleteDevis($id)
    {
        if ($this->db->delete('devis_items', ['devis_id' => $id]) && $this->db->delete('devis', ['id' => $id])) {
            return true;
        }
        return false;
    }



    public function getAllDevisItems($devis_id)
    {
        $this->db->select('devis_items.*, tax_rates.code as tax_code, tax_rates.name as tax_name, tax_rates.rate as tax_rate, products.unit, products.image, products.details as details, product_variants.name as variant, products.hsn_code as hsn_code, products.second_name as second_name')
            ->join('products', 'products.id=devis_items.product_id', 'left')
            ->join('product_variants', 'product_variants.id=devis_items.option_id', 'left')
            ->join('tax_rates', 'tax_rates.id=devis_items.tax_rate_id', 'left')
            ->group_by('devis_items.id')
            ->order_by('id', 'asc');
        $q = $this->db->get_where('devis_items', ['devis_id' => $devis_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllDevisItemsWithDetails($devis_id)
    {
        $this->db->select('devis_items.id, devis_items.product_name, devis_items.product_code, devis_items.quantity, devis_items.serial_no, devis_items.tax, devis_items.unit_price, devis_items.val_tax, devis_items.discount_val, devis_items.gross_total, products.details, products.hsn_code as hsn_code, products.second_name as second_name');
        $this->db->join('products', 'products.id=devis_items.product_id', 'left');
        $this->db->order_by('id', 'asc');
        $q = $this->db->get_where('devis_items', ['devis_id' => $devis_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getItemByID($id)
    {
        $q = $this->db->get_where('devis_items', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }





    public function getProductByCode($code)
    {
        $q = $this->db->get_where('products', ['code' => $code], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getProductByName($name)
    {
        $q = $this->db->get_where('products', ['name' => $name], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getProductComboItems($pid, $warehouse_id)
    {
        $this->db->select('products.id as id, combo_items.item_code as code, combo_items.quantity as qty, products.name as name, products.type as type, warehouses_products.quantity as quantity')
            ->join('products', 'products.code=combo_items.item_code', 'left')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->where('warehouses_products.warehouse_id', $warehouse_id)
            ->group_by('combo_items.id');
        $q = $this->db->get_where('combo_items', ['combo_items.product_id' => $pid]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
        return false;
    }

    public function getProductNames($term, $warehouse_id, $limit = 5)
    {
        $this->db->select('products.*, warehouses_products.quantity')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->group_by('products.id');

        $this->db->where("(name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");

        $this->db->limit($limit);
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getProductOptionByID($id)
    {
        $q = $this->db->get_where('product_variants', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    public function getProductOptions($product_id)
    {
        $q = $this->db->get_where('product_variants', ['product_id' => $product_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getDevisByID($id)
    {
        $q = $this->db->get_where('devis', ['id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getWarehouseProductQuantity($warehouse_id, $product_id)
    {
        $q = $this->db->get_where('warehouses_products', ['warehouse_id' => $warehouse_id, 'product_id' => $product_id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getWHProduct($id)
    {
        $this->db->select('products.id, code, name, warehouses_products.quantity, cost, tax_rate')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->group_by('products.id');
        $q = $this->db->get_where('products', ['warehouses_products.product_id' => $id], 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function updateDevis($id, $data, $items = [],$attachments = [])
    {
        if ($this->db->update('devis', $data, ['id' => $id]) && $this->db->delete('devis_items', ['devis_id' => $id])) {
            foreach ($items as $item) {
                $item['devis_id'] = $id;
                $this->db->insert('devis_items', $item);
            }

            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $attachment['subject_id']   = $id;
                    $attachment['subject_type'] = 'devis';
                    $this->db->insert('attachments', $attachment);
                }
            }


            return true;
        }


        return false;
    }

    public function updateStatus($id, $status, $note)
    {
        if ($this->db->update('devis', ['status' => $status, 'note' => $note], ['id' => $id])) {
            return true;
        }
        return false;
    }
}
