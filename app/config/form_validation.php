<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'auth/login' => array(
        array(
            'field' => 'identity',
            'label' => lang('username'),
            'rules' => 'required'
        ),
        array(
            'field' => 'password',
            'label' => lang('password'),
            'rules' => 'required'
        )
    ),
    'auth/create_user' => array(
        array(
            'field' => 'first_name',
            'label' => lang('first_name'),
            'rules' => 'required'
        ),
        array(
            'field' => 'last_name',
            'label' => lang('last_name'),
            'rules' => 'required'
        ),
        array(
            'field' => 'username',
            'label' => lang('username'),
            'rules' => 'required|alpha_dash'
        ),
        array(
            'field' => 'email',
            'label' => lang('email'),
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'phone',
            'label' => lang('phone'),
            'rules' => 'required'
        ),
        array(
            'field' => 'company',
            'label' => lang('company'),
            'rules' => 'required'
        ),
        array(
            'field' => 'gender',
            'label' => lang('gender'),
            'rules' => 'required'
        ),
        array(
            'field' => 'password',
            'label' => lang('password'),
            'rules' => 'required|min_length[7]|max_length[20]'
        ),
        array(
            'field' => 'confirm_password',
            'label' => lang('confirm_password'),
            'rules' => 'required|min_length[7]|max_length[20]|matches[password]'
        ),
    ),
    'auth/edit_user' => array(
        array(
            'field' => 'first_name',
            'label' => lang('first_name'),
            'rules' => 'required'
        ),
        array(
            'field' => 'last_name',
            'label' => lang('last_name'),
            'rules' => 'required'
        ),
        array(
            'field' => 'username',
            'label' => lang('username'),
            'rules' => 'required|alpha_dash'
        ),
        array(
            'field' => 'email',
            'label' => lang('email'),
            'rules' => 'required|valid_email'
        ),
        array(
            'field' => 'phone',
            'label' => lang('phone'),
            'rules' => 'required'
        ),
        array(
            'field' => 'company',
            'label' => lang('company'),
            'rules' => 'required'
        ),
        array(
            'field' => 'gender',
            'label' => lang('gender'),
            'rules' => 'required'
        ),
    ),
    'products/add' => array(
        array(
            'field' => 'code',
            'label' => lang('product_code'),
            'rules' => 'trim|min_length[2]|max_length[20]|required|alpha_dash'
        ),
        array(
            'field' => 'name',
            'label' => lang('product_name'),
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'category',
            'label' => lang('cname'),
            'rules' => 'required'
        ),
        array(
            'field' => 'barcode_symbology',
            'label' => lang('barcode_symbology'),
            'rules' => 'required'
        ),
        array(
            'field' => 'unit',
            'label' => lang('product_unit'),
            'rules' => 'required'
        ),
        array(
            'field' => 'price',
            'label' => lang('product_price'),
            'rules' => 'required|numeric'
        )
    ),
    'companies/add' => array(
        array(
            'field' => 'company',
            'label' => lang('company'),
            'rules' => 'trim|required'
        ),

    ),
    'companies/add_user' => array(
        array(
            'field' => 'first_name',
            'label' => lang('first_name'),
            'rules' => 'required'
        ),
        array(
            'field' => 'last_name',
            'label' => lang('last_name'),
            'rules' => 'required'
        ),
        array(
            'field' => 'email',
            'label' => lang('email'),
            'rules' => 'required|valid_email'
        )
    ),

    'customerCard/edit' => array(
        array(
            'field' => 'name',
            'label' => "Nom",
            'rules' => 'required'
        ),
        array(
            'field' => 'company',
            'label' => "Société",
            'rules' => 'required'
        ),array(
            'field' => 'address',
            'label' => "Adresse",
            'rules' => 'required'
        ),array(
            'field' => 'city',
            'label' => "Ville",
            'rules' => 'required'
        ),
        array(
            'field' => 'gst_no',
            'label' => lang('N° ICE de la Société'),
            'rules' => 'required'
        )
    ),
    'customers/add' => array(
        array(
            'field' => 'postal_code',
            'label' => "Marque",
            'rules' => 'required'
        ),
        array(
            'field' => 'company',
            'label' => lang('company'),
            'rules' => 'trim|required'
        ),
    ),
);

