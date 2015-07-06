<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ModWarehouse extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductStock($id_product)
    {
        $row = $this->db->get_where('product', array('id_product' => $id_product))->row();
        if ($row->stock > 0) {
            return $row->stock;
        } else {
            return '0';
        }
    }


    public function getProductOnlyForDropdown()
    {
        $this->db
            ->select('p.*, pu.*')
            ->from('product p')
            ->join('warehouse_rack_detail r', 'r.id_product = p.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
            ->where('r.id_product is null');
        $result = $this->db->get();
        $data = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[$row['id_product']] = $row['name'] . ' ( ' . $row['unit'] . ' / ' . $row['value'] . " )";
            }
        } else {
            $data = array('' => '');
        }

        return $data;
    }
    public function getProductDetailName($id){
        $this->db
            ->from('product p')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
            ->where('p.id_product',$id);
        $result = $this->db->get()->row_array();
        return $result['name'].' '.$result['unit'].'-'.$result['value'];
    }

}