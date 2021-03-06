<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PinjamBendera extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('proposal');
        $this->load->model('ModPinjamBendera');
        $this->status_ppn = [0 => "Non Aktif", 1 => "Aktif"];
    }

    public function index()
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['from'] =  date('Y-m-01');
            $data['to'] = date('Y-m-t');
        }

        $data['items'] = $this->ModPinjamBendera->getItems(2,  $data['from'], $data['to']);

        // if ($this->input->post('date_from') && $this->input->post('date_to')) {
        //     $data['from'] = $this->input->post('date_from');
        //     $data['to'] = $this->input->post('date_to');
        // } else {
        //     $data['items'] = $this->ModPinjamBendera->getItems(2);
        // }

        $data['array_status_ppn'] = $this->status_ppn;
        $this->parser->parse('pinjam-bendera.tpl', $data);
    }

    public function detail($id_proposal)
    {
        $type = 2;
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['penjualan'] = $this->ModPinjamBendera->getPenjualan($type, $id_proposal, $this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['penjualan'] = $this->ModPinjamBendera->getPenjualan($type, $id_proposal);
        }
        
        $data['total_penjualan'] = $this->ModPinjamBendera->getTotalPenjualan($type, $id_proposal);

        $data['id_proposal'] = $id_proposal;
        $this->parser->parse('penjualan-pinjam-bendera.tpl', $data);
    }
}