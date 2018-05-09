<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('m_basic');
    $this->load->library('upload');
  }

  function load_view($url, $data=null)
  {
    $this->load->view('head');
    $this->load->view('dosen/header',$data);
    $this->load->view('dosen/sidebar',$data);

    if ($data==null) {
      $this->load->view($url);
    } else {
      $this->load->view($url, $data);
    }

    $this->load->view('dosen/modal', $data);
    $this->load->view('footer');
  }

  function check_session()
  {
    $session = $this->session->userdata('login_in');
    $role = $this->session->userdata('role');

		if ($session === FALSE || $session == null) {
			redirect('login/dosen', 'refresh');
		} 
  }

	public function index()
	{
    $this->check_session();

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];

    $ta = $this->m_basic->getAllData('v_tugas_akhir', array('nidn' => $this->session->nidn))->result_array();
    $kp = $this->m_basic->getAllData('kerja_praktek', array('nidn' => $this->session->nidn))->result_array();
    $data['ta'] = $ta;
    $data['kp'] = $kp;

		$this->load_view('dosen/dashboard', $data);
  }

  function ta()
	{
    $this->check_session();

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];

    $ta = $this->m_basic->getAllData('v_tugas_akhir', array('nidn' => $this->session->nidn))->result_array();
    $bimbingan = $this->m_basic->getAllData('v_bimbingan_ta', array('nidn' => $this->session->nidn))->result_array();
    $bimbinganValid = $this->m_basic->getAllData('v_bimbingan_ta', array('nidn' => $this->session->nidn, 'status_validasi'=> 1))->result_array();
    $npm = $this->m_basic->getDistinctData('v_tugas_akhir', 'npm')->result_array();

    $count = array();

    for ($i=0; $i < count($npm); $i++) { 
      $count[$npm[$i]['npm']] = 0;
    }

    for ($i=0; $i < count($bimbinganValid) ; $i++) { 
      for ($j=0; $j < count($npm); $j++) { 
        if ($bimbinganValid[$i]['npm'] == $npm[$j]['npm']) {
          $count[$npm[$j]['npm']] += 1;
        }
      }
    }

    $data['ta'] = $ta;
    $data['bimbingan'] = $bimbingan;
    $data['count'] = $count;

		$this->load_view('dosen/tugas_akhir', $data);
  }

  function timeline_bimbingan_ta($npm, $id_ta)
  {
    $this->check_session();

    $npm = $this->encrypt->decode($npm);
    $id_ta = $this->encrypt->decode($id_ta);

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];

    $data_ta = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $npm))->result_array();
    $bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $id_ta), array('tgl_bimbingan' => 'DESC'))->result_array();

    $data['ta'] = $data_ta[0];
    $data['bimbingan'] = $bimbingan;

    $this->load_view('dosen/timeline_bimbingan_ta', $data);
  }
}
