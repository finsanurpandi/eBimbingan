<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('m_basic');
  }

  function index()
  {
    echo "This is AJAX endpoint!!!";
  }

    function getNumComment()
    {
        $id_bimbingan_ta = $this->input->post('id_bimbingan_ta');

        $row = $this->m_basic->getAllData('komentar_ta', array('id_bimbingan_ta' => $id_bimbingan_ta, 'pengirim !=' => $this->session->nama_mhs))->num_rows();

        echo $row;
    }

    function npmAvailability()
    {
      $npm = $this->input->post('npm');
      $res = $this->m_basic->getNumRows('mahasiswa', array('npm' => $npm));

      echo $res;
    }
}
