<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Factures_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addFacture($data = [], $items = [],$attachments=[])
    {
        if ($this->db->insert('factures', $data)) {
            $facture_id = $this->db->insert_id();
            if ($this->site->getReference('ft') == $data['reference_no']) {
                $this->site->updateReference('ft');
            }
            foreach ($items as $item) {
                $item['facture_id'] = $facture_id;
                $this->db->insert('facture_items', $item);
            }

            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $attachment['subject_id']   = $facture_id;
                    $attachment['subject_type'] = 'facture';
                    $this->db->insert('attachments', $attachment);
                }
            }
            return true;
        }
        return false;
    }

    public function deleteFacture($id)
    {
        $this->site->log('Quotation', ['model' => $this->getFactureByID($id), 'items' => $this->getAllFactureItems($id)]);
        if ($this->db->delete('facture_items', ['facture_id' => $id]) && $this->db->delete('factures', ['id' => $id])) {
            return true;
        }
        return false;
    }

    public function getAllFactureItems($facture_id)
    {
        $this->db->select('facture_items.*, tax_rates.code as tax_code, tax_rates.name as tax_name, tax_rates.rate as tax_rate, products.unit, products.image, products.details as details, product_variants.name as variant, products.hsn_code as hsn_code, products.second_name as second_name')
            ->join('products', 'products.id=facture_items.product_id', 'left')
            ->join('product_variants', 'product_variants.id=facture_items.option_id', 'left')
            ->join('tax_rates', 'tax_rates.id=facture_items.tax_rate_id', 'left')
            ->group_by('facture_items.id')
            ->order_by('id', 'asc');
        $q = $this->db->get_where('facture_items', ['facture_id' => $facture_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllFactureItemsWithDetails($facture_id)
    {
        $this->db->select('facture_items.id, facture_items.product_name, facture_items.product_code, facture_items.quantity, facture_items.serial_no, facture_items.tax, facture_items.unit_price, facture_items.val_tax, facture_items.discount_val, facture_items.gross_total, products.details, products.hsn_code as hsn_code, products.second_name as second_name');
        $this->db->join('products', 'products.id=facture_items.product_id', 'left');
        $this->db->order_by('id', 'asc');
        $q = $this->db->get_where('factures_items', ['facture_id' => $facture_id]);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getItemByID($id)
    {
        $q = $this->db->get_where('facture_items', ['id' => $id], 1);
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
        $this->db->where('warehouses_products.warehouse_id',$warehouse_id);

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

    public function getFactureByID($id)
    {
        $q = $this->db->get_where('factures', ['id' => $id], 1);
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

    public function getWarehouseProduct($pid, $wid)
    {
        $this->db->select($this->db->dbprefix('products') . '.*, ' . $this->db->dbprefix('warehouses_products') . '.quantity as quantity')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left');
        $q = $this->db->get_where('products', ['warehouses_products.product_id' => $pid, 'warehouses_products.warehouse_id' => $wid]);
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

    public function updateFacture($id, $data, $items = [],$attachments)
    {
        if ($this->db->update('factures', $data, ['id' => $id]) && $this->db->delete('facture_items', ['facture_id' => $id])) {
            foreach ($items as $item) {
                $item['facture_id'] = $id;
                $this->db->insert('facture_items', $item);
            }
            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    $attachment['subject_id']   = $id;
                    $attachment['subject_type'] = 'facture';
                    $this->db->insert('attachments', $attachment);
                }
            }

            return true;
        }
        return false;
    }

    public function updateStatus($id, $status, $note)
    {
        if ($this->db->update('factures', ['status' => $status, 'note' => $note], ['id' => $id])) {
            return true;
        }
        return false;
    }
}
