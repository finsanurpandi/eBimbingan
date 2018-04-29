<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ta extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('m_basic');
  }

  function load_view($url, $data=null)
  {
    $this->load->view('head');
    $this->load->view('ta/header');
    $this->load->view('ta/sidebar');

    if ($data==null) {
      $this->load->view($url);
    } else {
      $this->load->view($url, $data);
    }

    $this->load->view('ta/modal');
    $this->load->view('footer');
  }

	public function index()
	{
		$this->load_view('ta/dashboard');
	}

  function ta_detail()
  {
    $ta = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $this->session->npm))->result_array();
    $data['ta'] = $ta[0];

    $this->load_view('ta/detail_ta', $data);
  }

  function catatan_harian()
  {
    $this->load_view('ta/catatan_harian');
  }

  function detail_catatan_harian()
  {
    $this->load_view('ta/detail_catatan_harian');
  }

  function bimbingan_offline()
  {
    $bimbinganOffline = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $this->session->id_ta,'tipe' => 'offline'), array('tgl_input' => 'DESC'))->result_array();

    $data['bimbinganOffline'] = $bimbinganOffline;

    $this->load_view('ta/bimbingan_offline', $data);

    // add bimbingan
    $addBimbinganOffline = $this->input->post('addBimbinganOffline');

    if (isset($addBimbinganOffline)) {
      date_default_timezone_set("Asia/Bangkok");
      $date = new DateTime();
      $timenow = $date->format('Y-m-d H:i:s');
      $datenow = $date->format('Y-m-d');
      $id_bimbingan = hash('ripemd160', 'bimbingan_ta_'.$this->session->npm.'_'.$timenow);

      $data = array(
      'id_bimbingan_ta' => $id_bimbingan,
      'id_ta' => $this->session->id_ta,
      'topik' => $this->input->post('topik'),
      'pembahasan' => $this->input->post('pembahasan'),
      'tipe' => 'offline',
      'tgl_bimbingan' => $this->input->post('tgl_bimbingan'),
      'tgl_input' => $timenow
      );

      $this->m_basic->insertData('bimbingan_ta', $data);

      $this->session->set_flashdata('success', true);

      redirect($this->uri->uri_string());

    }
  }

  function detail_bimbingan_offline($id_bimbingan)
  {
    $id_bimbingan = $this->encrypt->decode($id_bimbingan);

    $data_bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_bimbingan_ta' => $id_bimbingan))->result_array();
    $data['bimbinganOffline'] = $data_bimbingan;

    $this->load_view('ta/detail_bimbingan_offline', $data);
  }

  function bimbingan_online()
  {
    $this->load_view('ta/bimbingan_online');
  }

  function detail_bimbingan_online()
  {
    $this->load_view('ta/detail_bimbingan_online');
  }

  function timeline_catatan_harian()
  {
    $this->load_view('ta/timeline_catatan_harian');
  }

  function timeline_bimbingan()
  {
    $this->load_view('ta/timeline_bimbingan');
  }
}
