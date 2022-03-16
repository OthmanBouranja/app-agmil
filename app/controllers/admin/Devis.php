<?php

defined('BASEPATH') or exit('No direct script access allowed');

class devis extends MY_Controller
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
        $this->load->admin_model('devis_model');
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

    public function add()
    {
        $this->sma->checkPermissions();

        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
        $this->form_validation->set_rules('customer', $this->lang->line('customer'), 'required');

        if ($this->form_validation->run() == true) {
            $reference = $this->input->post('reference_no') ? $this->input->post('reference_no') : $this->site->getReference('dv');
            if ($this->Owner || $this->Admin) {
                $date = $this->sma->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $warehouse_id     = $this->input->post('warehouse');
            $customer_id      = $this->input->post('customer');
            $biller_id        = $this->input->post('biller');
            $supplier_id      = $this->input->post('supplier');
            $status           = $this->input->post('status');
            $shipping         = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $customer_details = $this->site->getCompanyByID($customer_id);
            $customer         = $customer_details->company && $customer_details->company != '-' ? $customer_details->company : $customer_details->name;
            $biller_details   = $this->site->getCompanyByID($biller_id);
            $biller           = $biller_details->company && $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
            if ($supplier_id) {
                $supplier_details = $this->site->getCompanyByID($supplier_id);
                $supplier         = $supplier_details->company && $supplier_details->company != '-' ? $supplier_details->company : $supplier_details->name;
            } else {
                $supplier = null;
            }
            $note = $this->sma->clear_tags($this->input->post('note'));

            $total            = 0;
            $product_tax      = 0;
            $product_discount = 0;
            $gst_data         = [];
            $total_cgst       = $total_sgst       = $total_igst       = 0;
            $i                = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id            = $_POST['product_id'][$r];
                $item_type          = $_POST['product_type'][$r];
                $item_code          = $_POST['product_code'][$r];
                $item_name          = $_POST['product_name'][$r];
                $item_option        = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : null;
                $real_unit_price    = $this->sma->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price         = $this->sma->formatDecimal($_POST['unit_price'][$r]);
                $item_unit_quantity = $_POST['quantity'][$r];
                $item_tax_rate      = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : null;
                $item_discount      = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : null;
                $item_unit          = $_POST['product_unit'][$r];
                $item_quantity      = $_POST['product_base_quantity'][$r];

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->devis_model->getProductByCode($item_code) : null;
                    // $unit_price = $real_unit_price;
                    $pr_discount      = $this->site->calculateDiscount($item_discount, $unit_price);
                    $unit_price       = $this->sma->formatDecimal($unit_price - $pr_discount);
                    $item_net_price   = $unit_price;
                    $pr_item_discount = $this->sma->formatDecimal($pr_discount * $item_unit_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_item_tax = $item_tax = 0;
                    $tax         = '';

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $tax_details = $this->site->getTaxRateByID($item_tax_rate);
                        $ctax        = $this->site->calculateTax($product_details, $tax_details, $unit_price);
                        $item_tax    = $ctax['amount'];
                        $tax         = $ctax['tax'];
                        if (!$product_details || (!empty($product_details) && $product_details->tax_method != 1)) {
                            $item_net_price = $unit_price - $item_tax;
                        }
                        $pr_item_tax = $this->sma->formatDecimal(($item_tax * $item_unit_quantity), 4);
                        if ($this->Settings->indian_gst && $gst_data = $this->gst->calculteIndianGST($pr_item_tax, ($biller_details->state == $customer_details->state), $tax_details)) {
                            $total_cgst += $gst_data['cgst'];
                            $total_sgst += $gst_data['sgst'];
                            $total_igst += $gst_data['igst'];
                        }
                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = (($item_net_price * $item_unit_quantity) + $pr_item_tax);
                    $unit     = $this->site->getUnitByID($item_unit);

                    $product = [
                        'product_id'        => $item_id,
                        'product_code'      => $item_code,
                        'product_name'      => $item_name,
                        'product_type'      => $item_type,
                        'option_id'         => $item_option,
                        'net_unit_price'    => $item_net_price,
                        'unit_price'        => $this->sma->formatDecimal($item_net_price + $item_tax),
                        'quantity'          => $item_quantity,
                        'product_unit_id'   => $item_unit,
                        'product_unit_code' => $unit->code,
                        'unit_quantity'     => $item_unit_quantity,
                        'warehouse_id'      => $warehouse_id,
                        'item_tax'          => $pr_item_tax,
                        'tax_rate_id'       => $item_tax_rate,
                        'tax'               => $tax,
                        'discount'          => $item_discount,
                        'item_discount'     => $pr_item_discount,
                        'subtotal'          => $this->sma->formatDecimal($subtotal),
                        'real_unit_price'   => $real_unit_price,
                    ];

                    $products[] = ($product + $gst_data);
                    $total += $this->sma->formatDecimal(($item_net_price * $item_unit_quantity), 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang('order_items'), 'required');
            } else {
                krsort($products);
            }

            $order_discount = $this->site->calculateDiscount($this->input->post('discount'), ($total + $product_tax));
            $total_discount = $this->sma->formatDecimal(($order_discount + $product_discount), 4);
            $order_tax      = $this->site->calculateOrderTax($this->input->post('order_tax'), ($total + $product_tax - $order_discount));
            $total_tax      = $this->sma->formatDecimal(($product_tax + $order_tax), 4);
            $grand_total    = $this->sma->formatDecimal(($total + $total_tax + $this->sma->formatDecimal($shipping) - $order_discount), 4);
            $data           = ['date' => $date,
                'reference_no'        => 'DV '.$reference,
                'customer_id'         => $customer_id,
                'customer'            => $customer,
                'biller_id'           => $biller_id,
                'biller'              => $biller,
                'supplier_id'         => $supplier_id,
                'supplier'            => $supplier,
                'warehouse_id'        => $warehouse_id,
                'note'                => $note,
                'total'               => $total,
                'product_discount'    => $product_discount,
                'order_discount_id'   => $this->input->post('discount'),
                'order_discount'      => $order_discount,
                'total_discount'      => $total_discount,
                'product_tax'         => $product_tax,
                'order_tax_id'        => $this->input->post('order_tax'),
                'order_tax'           => $order_tax,
                'total_tax'           => $total_tax,
                'shipping'            => $this->sma->formatDecimal($shipping),
                'grand_total'         => $grand_total,
                'status'              => $status,
                'created_by'          => $this->session->userdata('user_id'),
                'hash'                => hash('sha256', microtime() . mt_rand()),
            ];
            if ($this->Settings->indian_gst) {
                $data['cgst'] = $total_cgst;
                $data['sgst'] = $total_sgst;
                $data['igst'] = $total_igst;
            }

            $attachments        = $this->attachments->upload();
            $data['attachment'] = !empty($attachments);

            // $this->sma->print_arrays($data, $products);
        }

        if ($this->form_validation->run() == true && $this->devis_model->addDevis($data, $products,$attachments)) {
            $this->session->set_userdata('remove_dvls', 1);
            $this->session->set_flashdata('message', $this->lang->line('devis_added'));
            admin_redirect('devis');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['billers'] = ($this->Owner || $this->Admin || !$this->session->userdata('biller_id')) ? $this->site->getAllCompanies('biller') : null;
            //$this->data['currencies'] = $this->site->getAllCurrencies();
            $this->data['units']      = $this->site->getAllBaseUnits();
            $this->data['tax_rates']  = $this->site->getAllTaxRates();
            $this->data['warehouses'] = ($this->Owner || $this->Admin || !$this->session->userdata('warehouse_id')) ? $this->site->getAllWarehouses() : null;
            $this->data['dvnumber']   = ''; //$this->site->getReference('dv');
            $bc                       = [['link' => base_url(), 'page' => lang('home')], ['link' => admin_url('devis'), 'page' => lang('devis')], ['link' => '#', 'page' => lang('add_devis')]];
            $meta                     = ['page_title' => lang('add_devis'), 'bc' => $bc];
            $this->page_construct('devis/add', $meta, $this->data);
        }
    }










    public function combine_pdf($devis_id)
    {
        $this->sma->checkPermissions('pdf');

        foreach ($devis_id as $devis_id) {
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $inv                 = $this->devis_model->getDevisByID($devis_id);
            if (!$this->session->userdata('view_right')) {
                $this->sma->view_rights($inv->created_by);
            }
            $this->data['rows']      = $this->devis_model->getAllDevisItems($devis_id);
            $this->data['customer']  = $this->site->getCompanyByID($inv->customer_id);
            $this->data['biller']    = $this->site->getCompanyByID($inv->biller_id);
            $this->data['user']      = $this->site->getUser($inv->created_by);
            $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
            $this->data['inv']       = $inv;

            $html[] = [
                'content' => $this->load->view($this->theme . 'devis/pdf', $this->data, true),
                'footer'  => '',
            ];
        }

        $name = lang('Devis') . '.pdf';
        $this->sma->generate_pdf($html, $name);
    }

    public function delete($id = null)
    {
        $this->sma->checkPermissions(null, true);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->devis_model->deleteDevis($id)) {
            if ($this->input->is_ajax_request()) {
                $this->sma->send_json(['error' => 0, 'msg' => lang('devis_deleted')]);
            }
            $this->session->set_flashdata('message', lang('devis_deleted'));
            admin_redirect('welcome');
        }
    }


    public function edit($id = null)
    {
        $this->sma->checkPermissions();

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        $inv = $this->devis_model->getDevisByID($id);

        if (!$this->session->userdata('edit_right')) {
            $this->sma->view_rights($inv->created_by);
        }
        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));
        $this->form_validation->set_rules('reference_no', $this->lang->line('reference_no'), 'required');
        $this->form_validation->set_rules('customer', $this->lang->line('customer'), 'required');
        //$this->form_validation->set_rules('note', $this->lang->line("note"), 'xss_clean');

        if ($this->form_validation->run() == true) {
            $reference = $this->input->post('reference_no');
            if ($this->Owner || $this->Admin) {
                $date = $this->sma->fld(trim($this->input->post('date')));
            } else {
                date('Y-m-d H:i:s');
            }
            $warehouse_id     = $this->input->post('warehouse');
            $customer_id      = $this->input->post('customer');
            $biller_id        = $this->input->post('biller');
            $supplier_id      = $this->input->post('supplier');
            $status           = $this->input->post('status');
            $shipping         = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $customer_details = $this->site->getCompanyByID($customer_id);
            $customer         = $customer_details->company && $customer_details->company != '-' ? $customer_details->company : $customer_details->name;
            $biller_details   = $this->site->getCompanyByID($biller_id);
            $biller           = $biller_details->company && $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
            if ($supplier_id) {
                $supplier_details = $this->site->getCompanyByID($supplier_id);
                $supplier         = $supplier_details->company && $supplier_details->company != '-' ? $supplier_details->company : $supplier_details->name;
            } else {
                $supplier = null;
            }
            $note = $this->sma->clear_tags($this->input->post('note'));

            $total            = 0;
            $product_tax      = 0;
            $product_discount = 0;
            $gst_data         = [];
            $total_cgst       = $total_sgst       = $total_igst       = 0;
            $i                = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id            = $_POST['product_id'][$r];
                $item_type          = $_POST['product_type'][$r];
                $item_code          = $_POST['product_code'][$r];
                $item_name          = $_POST['product_name'][$r];
                $item_option        = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : null;
                $real_unit_price    = $this->sma->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price         = $this->sma->formatDecimal($_POST['unit_price'][$r]);
                $item_unit_quantity = $_POST['quantity'][$r];
                $item_tax_rate      = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : null;
                $item_discount      = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : null;
                $item_unit          = $_POST['product_unit'][$r];
                $item_quantity      = $_POST['product_base_quantity'][$r];

                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->devis_model->getProductByCode($item_code) : null;
                    // $unit_price = $real_unit_price;
                    $pr_discount      = $this->site->calculateDiscount($item_discount, $unit_price);
                    $unit_price       = $this->sma->formatDecimal($unit_price - $pr_discount);
                    $item_net_price   = $unit_price;
                    $pr_item_discount = $this->sma->formatDecimal($pr_discount * $item_unit_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_item_tax = $item_tax = 0;
                    $tax         = '';

                    if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $tax_details = $this->site->getTaxRateByID($item_tax_rate);
                        $ctax        = $this->site->calculateTax($product_details, $tax_details, $unit_price);
                        $item_tax    = $ctax['amount'];
                        $tax         = $ctax['tax'];
                        if (!$product_details || (!empty($product_details) && $product_details->tax_method != 1)) {
                            $item_net_price = $unit_price - $item_tax;
                        }
                        $pr_item_tax = $this->sma->formatDecimal(($item_tax * $item_unit_quantity), 4);
                        if ($this->Settings->indian_gst && $gst_data = $this->gst->calculteIndianGST($pr_item_tax, ($biller_details->state == $customer_details->state), $tax_details)) {
                            $total_cgst += $gst_data['cgst'];
                            $total_sgst += $gst_data['sgst'];
                            $total_igst += $gst_data['igst'];
                        }
                    }

                    $product_tax += $pr_item_tax;
                    $subtotal = (($item_net_price * $item_unit_quantity) + $pr_item_tax);
                    $unit     = $this->site->getUnitByID($item_unit);

                    $product = [
                        'product_id'        => $item_id,
                        'product_code'      => $item_code,
                        'product_name'      => $item_name,
                        'product_type'      => $item_type,
                        'option_id'         => $item_option,
                        'net_unit_price'    => $item_net_price,
                        'unit_price'        => $this->sma->formatDecimal($item_net_price + $item_tax),
                        'quantity'          => $item_quantity,
                        'product_unit_id'   => $item_unit,
                        'product_unit_code' => $unit->code,
                        'unit_quantity'     => $item_unit_quantity,
                        'warehouse_id'      => $warehouse_id,
                        'item_tax'          => $pr_item_tax,
                        'tax_rate_id'       => $item_tax_rate,
                        'tax'               => $tax,
                        'discount'          => $item_discount,
                        'item_discount'     => $pr_item_discount,
                        'subtotal'          => $this->sma->formatDecimal($subtotal),
                        'real_unit_price'   => $real_unit_price,
                    ];

                    $products[] = ($product + $gst_data);
                    $total += $this->sma->formatDecimal(($item_net_price * $item_unit_quantity), 4);
                }
            }
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang('order_items'), 'required');
            } else {
                krsort($products);
            }

            $order_discount = $this->site->calculateDiscount($this->input->post('discount'), ($total + $product_tax));
            $total_discount = $this->sma->formatDecimal(($order_discount + $product_discount), 4);
            $order_tax      = $this->site->calculateOrderTax($this->input->post('order_tax'), ($total + $product_tax - $order_discount));
            $total_tax      = $this->sma->formatDecimal(($product_tax + $order_tax), 4);
            $grand_total    = $this->sma->formatDecimal(($total + $total_tax + $this->sma->formatDecimal($shipping) - $order_discount), 4);
            $data           = ['date' => $date,
                'reference_no'        => $reference,
                'customer_id'         => $customer_id,
                'customer'            => $customer,
                'biller_id'           => $biller_id,
                'biller'              => $biller,
                'supplier_id'         => $supplier_id,
                'supplier'            => $supplier,
                'warehouse_id'        => $warehouse_id,
                'note'                => $note,
                'total'               => $total,
                'product_discount'    => $product_discount,
                'order_discount_id'   => $this->input->post('discount'),
                'order_discount'      => $order_discount,
                'total_discount'      => $total_discount,
                'product_tax'         => $product_tax,
                'order_tax_id'        => $this->input->post('order_tax'),
                'order_tax'           => $order_tax,
                'total_tax'           => $total_tax,
                'shipping'            => $shipping,
                'grand_total'         => $grand_total,
                'status'              => $status,
                'updated_by'          => $this->session->userdata('user_id'),
                'updated_at'          => date('Y-m-d H:i:s'),
            ];
            if ($this->Settings->indian_gst) {
                $data['cgst'] = $total_cgst;
                $data['sgst'] = $total_sgst;
                $data['igst'] = $total_igst;
            }

            $attachments        = $this->attachments->upload();
            $data['attachment'] = !empty($attachments) || $this->site->getAttachments($id, 'devis');

            // $this->sma->print_arrays($data, $products);
        }



        if ($this->form_validation->run() == true && $this->devis_model->updateDevis($id, $data, $products,$attachments)) {
            $this->session->set_userdata('remove_dvls', 1);
            $this->session->set_flashdata('message', $this->lang->line('devis_added'));
            admin_redirect('devis');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $this->data['inv'] = $this->devis_model->getDevisByID($id);
            $inv_items         = $this->devis_model->getAllDevisItems($id);
            // krsort($inv_items);
            $c = rand(100000, 9999999);
            foreach ($inv_items as $item) {
                $row = $this->site->getProductByID($item->product_id);
                if (!$row) {
                    $row             = json_decode('{}');
                    $row->tax_method = 0;
                } else {
                    unset($row->details, $row->product_details, $row->cost, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);
                }
                $row->quantity = 0;
                $pis           = $this->site->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);
                if ($pis) {
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                $row->id              = $item->product_id;
                $row->code            = $item->product_code;
                $row->name            = $item->product_name;
                $row->type            = $item->product_type;
                $row->base_quantity   = $item->quantity;
                $row->base_unit       = isset($row->unit) ? $row->unit : $item->product_unit_id;
                $row->base_unit_price = isset($row->price) ? $row->price : $item->unit_price;
                $row->unit            = $item->product_unit_id;
                $row->qty             = $item->unit_quantity;
                $row->discount        = $item->discount ? $item->discount : '0';
                $row->item_tax        = $item->item_tax      > 0 ? $item->item_tax           / $item->quantity : 0;
                $row->item_discount   = $item->item_discount > 0 ? $item->item_discount / $item->quantity : 0;
                $row->unit_price      = $row->tax_method ? $item->unit_price + $this->sma->formatDecimal($row->item_discount) + $this->sma->formatDecimal($row->item_tax) : $item->unit_price + ($row->item_discount);
                $row->real_unit_price = $item->real_unit_price;
                $row->tax_rate        = $item->tax_rate_id;
                $row->option          = $item->option_id;
                $options              = $this->devis_model->getProductOptions($row->id, $item->warehouse_id);

                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->site->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                        if ($pis) {
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if ($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }

                $combo_items = false;
                if ($row->type == 'combo') {
                    $combo_items = $this->devis_model->getProductComboItems($row->id, $item->warehouse_id);
                    foreach ($combo_items as $combo_item) {
                        $combo_item->quantity = $combo_item->qty * $item->quantity;
                    }
                }
                $units    = $this->site->getUnitsByBUID($row->base_unit);
                $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                $ri       = $this->Settings->item_addition ? $row->id : $c;

                $pr[$ri] = ['id' => $c, 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')', 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options];
                $c++;
            }
            $this->data['inv_items'] = json_encode($pr);
            $this->data['id']        = $id;
            //$this->data['currencies'] = $this->site->getAllCurrencies();
            $this->data['billers']    = ($this->Owner || $this->Admin || !$this->session->userdata('biller_id')) ? $this->site->getAllCompanies('biller') : null;
            $this->data['units']      = $this->site->getAllBaseUnits();
            $this->data['tax_rates']  = $this->site->getAllTaxRates();
            $this->data['warehouses'] = ($this->Owner || $this->Admin || !$this->session->userdata('warehouse_id')) ? $this->site->getAllWarehouses() : null;

            $bc   = [['link' => base_url(), 'page' => lang('home')], ['link' => admin_url('devis'), 'page' => lang('devis')], ['link' => '#', 'page' => lang('edit_devis')]];
            $meta = ['page_title' => lang('edit_devis'), 'bc' => $bc];
            $this->page_construct('devis/edit', $meta, $this->data);
        }
    }

    public function email($devis_id = null)
    {
        $this->sma->checkPermissions(false, true);

        if ($this->input->get('id')) {
            $devis_id = $this->input->get('id');
        }
        $inv = $this->devis_model->getDevisByID($devis_id);
        $this->form_validation->set_rules('to', $this->lang->line('to') . ' ' . $this->lang->line('email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('subject', $this->lang->line('subject'), 'trim|required');
        $this->form_validation->set_rules('cc', $this->lang->line('cc'), 'trim|valid_emails');
        $this->form_validation->set_rules('bcc', $this->lang->line('bcc'), 'trim|valid_emails');
        $this->form_validation->set_rules('note', $this->lang->line('message'), 'trim');

        if ($this->form_validation->run() == true) {
            if (!$this->session->userdata('view_right')) {
                $this->sma->view_rights($inv->created_by);
            }
            $to      = $this->input->post('to');
            $subject = $this->input->post('subject');
            if ($this->input->post('cc')) {
                $cc = $this->input->post('cc');
            } else {
                $cc = null;
            }
            if ($this->input->post('bcc')) {
                $bcc = $this->input->post('bcc');
            } else {
                $bcc = null;
            }
            $customer = $this->site->getCompanyByID($inv->customer_id);
            $biller   = $this->site->getCompanyByID($inv->biller_id);
            $this->load->library('parser');
            $parse_data = [
                'reference_number' => $inv->reference_no,
                'contact_person'   => $customer->name,
                'company'          => $customer->company,
                'site_link'        => base_url(),
                'site_name'        => $this->Settings->site_name,
                'logo'             => '<img src="' . base_url() . 'assets/uploads/logos/' . $biller->logo . '" alt="' . ($biller->company && $biller->company != '-' ? $biller->company : $biller->name) . '"/>',
            ];
            $msg        = $this->input->post('note');
            $message    = $this->parser->parse_string($msg, $parse_data);
            $attachment = $this->pdf($devis_id, null, 'S');

            try {
                if ($this->sma->send_email($to, $subject, $message, null, null, $attachment, $cc, $bcc)) {
                    delete_files($attachment);
                    $this->db->update('devis', ['status' => 'sent'], ['id' => $devis_id]);
                    $this->session->set_flashdata('message', $this->lang->line('email_sent'));
                    admin_redirect('devis');
                }
            } catch (Exception $e) {
                $this->session->set_flashdata('error', $e->getMessage());
                redirect($_SERVER['HTTP_REFERER']);
            }
        } elseif ($this->input->post('send_email')) {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->session->set_flashdata('error', $this->data['error']);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            if (file_exists('./themes/' . $this->Settings->theme . '/admin/views/email_templates/devis.html')) {
                $devis_temp = file_get_contents('themes/' . $this->Settings->theme . '/admin/views/email_templates/devis.html');
            } else {
                $devis_temp = file_get_contents('./themes/default/admin/views/email_templates/devis.html');
            }

            $this->data['subject'] = ['name' => 'subject',
                'id'                         => 'subject',
                'type'                       => 'text',
                'value'                      => $this->form_validation->set_value('subject', lang('devis') . ' (' . $inv->reference_no . ') ' . lang('from') . ' ' . $this->Settings->site_name),
            ];
            $this->data['note'] = ['name' => 'note',
                'id'                      => 'note',
                'type'                    => 'text',
                'value'                   => $this->form_validation->set_value('note', $devis_temp),
            ];
            $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);

            $this->data['id']       = $devis_id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'devis/email', $this->data);
        }
    }

    public function getDevis($warehouse_id = null)
    {
        $this->sma->checkPermissions('index');

        if ((!$this->Owner || !$this->Admin) && !$warehouse_id) {
            $user         = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }
        $detail_link  = anchor('admin/devis/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('Détails Devis'));
        $email_link   = anchor('admin/devis/email/$1', '<i class="fa fa-envelope"></i> ' . lang('Envoyer par Email'), 'data-toggle="modal" data-target="#myModal"');
        $edit_link    = anchor('admin/devis/edit/$1', '<i class="fa fa-edit"></i> ' . lang('Modfier Devis'));
        $convert_link = anchor('admin/quotes/add/$1', '<i class="fa fa fa-wrench"></i> ' . lang('create_or'));
        $pdf_link     = anchor('admin/devis/pdf/$1', '<i class="fa fa-file-pdf-o"></i> ' . lang('download_pdf'));
        $delete_link  = "<a href='#' class='po' title='<b>" . $this->lang->line('delete_devis') . "</b>' data-content=\"<p>"
        . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . admin_url('devis/delete/$1') . "'>"
        . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
        . lang('Supprimer Devis') . '</a>';
        $action = '<div class="text-center"><div class="btn-group text-left">'
        . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
        . lang('actions') . ' <span class="caret"></span></button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li>' . $detail_link . '</li>
                        <li>' . $edit_link . '</li>
                        <li>' . $convert_link . '</li>
                        <li>' . $pdf_link . '</li>
                        <li>' . $email_link . '</li>
                        <li>' . $delete_link . '</li>
                    </ul>
                </div></div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';

        $this->load->library('datatables');
        if ($warehouse_id) {
            $this->datatables
                ->select('devis.id, devis.date, devis.reference_no, devis.biller, c.company,c. name , devis.grand_total, devis.status, devis.attachment')
                ->from('devis')
                ->join('companies c','c.id = devis.customer_id','left')
                ->where('warehouse_id', $warehouse_id);
        } else {
            $this->datatables
                ->select('devis.id as id, devis.date, devis.reference_no, devis.biller,c.company,c. name , devis.grand_total, devis.status, devis.attachment')
                ->from('devis')
                ->join('companies c','c.id = devis.customer_id','left');
        }
        if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $this->datatables->where('created_by', $this->session->userdata('user_id'));
        } elseif ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
        $this->datatables->add_column('Actions', $action, 'id');
        echo $this->datatables->generate();
    }

    public function index($warehouse_id = null)
    {
        $this->sma->checkPermissions();

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        if ($this->Owner || $this->Admin || !$this->session->userdata('warehouse_id')) {
            $this->data['warehouses']   = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse']    = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : null;
        } else {
            $this->data['warehouses']   = null;
            $this->data['warehouse_id'] = $this->session->userdata('warehouse_id');
            $this->data['warehouse']    = $this->session->userdata('warehouse_id') ? $this->site->getWarehouseByID($this->session->userdata('warehouse_id')) : null;
        }

        $bc   = [['link' => base_url(), 'page' => lang('home')], ['link' => '#', 'page' => lang('devis')]];
        $meta = ['page_title' => lang('devis'), 'bc' => $bc];
        $this->page_construct('devis/index', $meta, $this->data);
    }

    public function modal_view($devis_id = null)
    {
        $this->sma->checkPermissions('index', true);

        if ($this->input->get('id')) {
            $devis_id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv                 = $this->devis_model->getDevisByID($devis_id);
        if (!$this->session->userdata('view_right')) {
            $this->sma->view_rights($inv->created_by, true);
        }
        $this->data['rows']       = $this->devis_model->getAllDevisItems($devis_id);
        $this->data['customer']   = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller']     = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : null;
        $this->data['warehouse']  = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv']        = $inv;
        $this->data['attachments'] = $this->site->getAttachments($devis_id, 'devis');

        $this->load->view($this->theme . 'devis/modal_view', $this->data);
    }

    public function pdf($devis_id = null, $view = null, $save_bufffer = null)
    {
        $this->sma->checkPermissions();

        if ($this->input->get('id')) {
            $devis_id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv                 = $this->devis_model->getDevisByID($devis_id);
        if (!$this->session->userdata('view_right')) {
            $this->sma->view_rights($inv->created_by);
        }
        $this->data['rows']       = $this->devis_model->getAllDevisItems($devis_id);
        $this->data['customer']   = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller']     = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse']  = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv']        = $inv;
        $this->data['customData']=array(
            'devis_id'=>$devis_id
        );

        /*echo "<pre>";
            print_r($this->data);
        echo "</pre>";die();*/

        $arr = array();

        foreach ($this->data['rows'] as $key => $item) {

            $arr[$item->tax][] = (array) $item;
        }

        ksort($arr, SORT_NUMERIC);



        $this->data['customData']['rows'] = $arr;

        $name                     = $this->lang->line('devis') . '_' . str_replace('/', '_', $inv->reference_no) . '.pdf';
        $html                     = $this->load->view($this->theme . 'devis/pdf', $this->data, true);
        if (!$this->Settings->barcode_img) {
            $html = preg_replace("'\<\?xml(.*)\?\>'", '', $html);
        }
        if ($view) {
            $this->load->view($this->theme . 'devis/pdf', $this->data);
        } elseif ($save_bufffer) {
            return $this->sma->generate_pdf($html, $name, $save_bufffer);
        } else {
                        $this->sma->generate_pdf($html, $name,null,$this->data['biller']->invoice_footer);
        }
    }

    public function pdf_beta($devis_id = null, $view = null, $save_bufffer = null)
    {
        $this->sma->checkPermissions();

        if ($this->input->get('id')) {
            $devis_id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv                 = $this->devis_model->getDevisByID($devis_id);
        if (!$this->session->userdata('view_right')) {
            $this->sma->view_rights($inv->created_by);
        }
        $this->data['rows']       = $this->devis_model->getAllDevisItems($devis_id);
        $this->data['customer']   = $this->site->getCompanyByID($inv->customer_id);
        $this->data['biller']     = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse']  = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv']        = $inv;
        $this->data['customData']=array(
            'devis_id'=>$devis_id
        );

        /*echo "<pre>";
            print_r($this->data);
        echo "</pre>";die();*/

        $arr = array();

        foreach ($this->data['rows'] as $key => $item) {

            $arr[$item->tax][] = (array) $item;
        }

        ksort($arr, SORT_NUMERIC);



        $this->data['customData']['rows'] = $arr;


        $name                     = $this->lang->line('devis') . '_' . str_replace('/', '_', $inv->reference_no) . '.pdf';
        $this->load->view($this->theme . 'devis/pdf_beta', $this->data);
        #return;
        $html                     = $this->load->view($this->theme . 'devis/pdf_beta', $this->data, true);
        if (!$this->Settings->barcode_img) {
            $html = preg_replace("'\<\?xml(.*)\?\>'", '', $html);
        }

        if ($view) {
            $this->load->view($this->theme . 'devis/pdf_beta', $this->data);
        } elseif ($save_bufffer) {
            return $this->sma->generate_pdf($html, $name, $save_bufffer);
        } else {
            $this->sma->generate_pdf($html, $name,null,$this->data['biller']->invoice_footer);
        }
    }

    public function devis_actions()
    {
        if (!$this->Owner && !$this->GP['bulk_actions']) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->form_validation->set_rules('form_action', lang('form_action'), 'required');

        if ($this->form_validation->run() == true) {
            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    $this->sma->checkPermissions('delete');
                    foreach ($_POST['val'] as $id) {
                        $this->devis_model->deleteDevis($id);
                    }
                    $this->session->set_flashdata('message', $this->lang->line('devis_deleted'));
                    redirect($_SERVER['HTTP_REFERER']);
                } elseif ($this->input->post('form_action') == 'combine') {
                    $html = $this->combine_pdf($_POST['val']);
                } elseif ($this->input->post('form_action') == 'export_excel') {
                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('devis'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('date'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('reference_no'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('biller'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('customer'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('total'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('status'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $dv = $this->devis_model->getDevisByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->sma->hrld($dv->date));
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $dv->reference_no);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $dv->biller);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $dv->customer);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $dv->total);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $dv->status);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'devis_' . date('Y_m_d_H_i_s');
                    $this->load->helper('excel');
                    create_excel($this->excel, $filename);
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('no_devis_selected'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function suggestions()
    {
        $term         = $this->input->get('term', true);
        $warehouse_id = $this->input->get('warehouse_id', true);
        $customer_id  = $this->input->get('customer_id', true);

        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . admin_url('welcome') . "'; }, 10);</script>");
        }

        $analyzed       = $this->sma->analyze_term($term);
        $sr             = $analyzed['term'];
        $option_id      = $analyzed['option_id'];
        $warehouse      = $this->site->getWarehouseByID($warehouse_id);
        $customer       = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $rows           = $this->devis_model->getProductNames($sr, $warehouse_id);
        if ($rows) {
            $r = 0;
            foreach ($rows as $row) {
                $c = uniqid(mt_rand(), true);
                unset($row->cost, $row->details, $row->product_details, $row->image, $row->barcode_symbology, $row->cf1, $row->cf2, $row->cf3, $row->cf4, $row->cf5, $row->cf6, $row->supplier1price, $row->supplier2price, $row->cfsupplier3price, $row->supplier4price, $row->supplier5price, $row->supplier1, $row->supplier2, $row->supplier3, $row->supplier4, $row->supplier5, $row->supplier1_part_no, $row->supplier2_part_no, $row->supplier3_part_no, $row->supplier4_part_no, $row->supplier5_part_no);
                $option               = false;
                $row->quantity        = 0;
                $row->item_tax_method = $row->tax_method;
                $row->qty             = 1;
                $row->discount        = '0';
                $options              = $this->devis_model->getProductOptions($row->id, $warehouse_id);
                if ($options) {
                    $opt = $option_id && $r == 0 ? $this->devis_model->getProductOptionByID($option_id) : $options[0];
                    if (!$option_id || $r > 0) {
                        $option_id = $opt->id;
                    }
                } else {
                    $opt        = json_decode('{}');
                    $opt->price = 0;
                    $option_id  = false;
                }
                $row->option = $option_id;
                $pis         = $this->site->getPurchasedItems($row->id, $warehouse_id, $row->option);
                if ($pis) {
                    foreach ($pis as $pi) {
                        $row->quantity += $pi->quantity_balance;
                    }
                }
                if ($options) {
                    $option_quantity = 0;
                    foreach ($options as $option) {
                        $pis = $this->site->getPurchasedItems($row->id, $warehouse_id, $row->option);
                        if ($pis) {
                            foreach ($pis as $pi) {
                                $option_quantity += $pi->quantity_balance;
                            }
                        }
                        if ($option->quantity > $option_quantity) {
                            $option->quantity = $option_quantity;
                        }
                    }
                }
                if ($row->promotion) {
                    $row->price = $row->promo_price;
                } elseif ($customer->price_group_id) {
                    if ($pr_group_price = $this->site->getProductGroupPrice($row->id, $customer->price_group_id)) {
                        $row->price = $pr_group_price->price;
                    }
                } elseif ($warehouse->price_group_id) {
                    if ($pr_group_price = $this->site->getProductGroupPrice($row->id, $warehouse->price_group_id)) {
                        $row->price = $pr_group_price->price;
                    }
                }
                $row->price           = $row->price + (($row->price * $customer_group->percent) / 100);
                $row->real_unit_price = $row->price;
                $row->base_quantity   = 1;
                $row->base_unit       = $row->unit;
                $row->base_unit_price = $row->price;
                $row->unit            = $row->sale_unit ? $row->sale_unit : $row->unit;
                $combo_items          = false;
                if ($row->type == 'combo') {
                    $combo_items = $this->devis_model->getProductComboItems($row->id, $warehouse_id);
                }
                $units    = $this->site->getUnitsByBUID($row->base_unit);
                $tax_rate = $this->site->getTaxRateByID($row->tax_rate);

                $pr[] = ['id' => sha1($c . $r), 'item_id' => $row->id, 'label' => $row->name . ' (' . $row->code . ')', 'category' => $row->category_id,
                    'row'     => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options, ];
                $r++;
            }
            $this->sma->send_json($pr);
        } else {
            $this->sma->send_json([['id' => 0, 'label' => lang('no_match_found'), 'value' => $term]]);
        }
    }

    public function update_status($id)
    {
        $this->form_validation->set_rules('status', lang('status'), 'required');

        if ($this->form_validation->run() == true) {
            $status = $this->input->post('status');
            $note   = $this->sma->clear_tags($this->input->post('note'));
        } elseif ($this->input->post('update')) {
            $this->session->set_flashdata('error', validation_errors());
            admin_redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'quotes');
        }

        if ($this->form_validation->run() == true && $this->devis_model->updateStatus($id, $status, $note)) {
            $this->session->set_flashdata('message', lang('status_updated'));
            admin_redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'quotes');
        } else {
            $this->data['inv']      = $this->devis_model->getDevisByID($id);
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'devis/update_status', $this->data);
        }
    }

    public function view($devis_id = null)
    {
        $this->sma->checkPermissions('index');

        if ($this->input->get('id')) {
            $devis_id = $this->input->get('id');
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv                 = $this->devis_model->getDevisByID($devis_id);
        if (!$this->session->userdata('view_right')) {
            $this->sma->view_rights($inv->created_by);
        }

        $this->data['customer']   = $this->site->getCompanyByID($inv->customer_id);

        $this->data['biller']     = $this->site->getCompanyByID($inv->biller_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['updated_by'] = $inv->updated_by ? $this->site->getUser($inv->updated_by) : null;
        $this->data['warehouse']  = $this->site->getWarehouseByID($inv->warehouse_id);

        $this->data['inv']        = $inv;

        $bc   = [['link' => base_url(), 'page' => lang('home')], ['link' => admin_url('devis'), 'page' => lang('devis')], ['link' => '#', 'page' => lang('view')]];
        $meta = ['page_title' => lang('view_devis_details'), 'bc' => $bc];
        $this->page_construct('devis/view', $meta, $this->data);
    }
}
