<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prodi extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('m_basic');
    $this->load->library('upload');
  }

// Image Upload Configuration 
  function configImage()
	{
		$user = $this->session->username;
		$nmfile = "img_".$user."_".time();
		$config['upload_path']   =   "./assets/img/profiles/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png"; 
		$config['max_size']      =   "1000";
		$config['max_width']     =   "1907";
		$config['max_height']    =   "1280";
		$config['file_name']     =   $nmfile;
 
		$this->upload->initialize($config);
  }

// File upload configuration
  function configFile()
	{
		$user = $this->session->username;
		$nmfile = "file_".$user."_".time();
		$config['upload_path']   =   "./assets/files/";
		$config['allowed_types'] =   "doc|docx"; 
		$config['max_size']      =   "3000";
		$config['file_name']     =   $nmfile;
 
		$this->upload->initialize($config);
	}

// load->view Configuration
  function load_view($url, $data=null)
  {
    $this->load->view('head');
    $this->load->view('prodi/header',$data);
    $this->load->view('prodi/sidebar',$data);

    if ($data==null) {
      $this->load->view($url);
    } else {
      $this->load->view($url, $data);
    }

    $this->load->view('prodi/modal', $data);
    $this->load->view('footer');
  }

// session check configuration
  function check_session()
  {
    $session = $this->session->userdata('login_in');
    $role = $this->session->userdata('role');

		if ($session === FALSE || $session == null) {
			redirect('login/prodi', 'refresh');
		} 
  }

// Dashboard view
	public function index()
	{
    $this->check_session();

    $user = $this->m_basic->getAllData('prodi', array('username' => $this->session->username))->result_array();
    $data['user'] = $user[0];

    $ta = $this->m_basic->getAllData('v_tugas_akhir')->result_array();

    $data['ta'] = $ta;

		$this->load_view('prodi/dashboard', $data);
  }

// Show All Data Mahasiswa
  function mahasiswa()
  {
    $this->check_session();

    $user = $this->m_basic->getAllData('prodi', array('username' => $this->session->username))->result_array();
    $data['user'] = $user[0];

    $ta = $this->m_basic->getAllData('v_tugas_akhir')->result_array();
    $mhs = $this->m_basic->getsisaMhs();
    $dosen = $this->m_basic->getAllData('dosen')->result_array();
    $data['ta'] = $ta;
    $data['mhs'] = $mhs;
    $data['dosen'] = $dosen;

    $this->load_view('prodi/mahasiswa', $data);

    // Add Data Mahasiswa
    $addMhs = $this->input->post('addMhs');

    if (isset($addMhs)) {
      //random image profile
      $img = array('patrick.jpg', 'spongebob.jpg', 'squidward.jpg');

      // data for table mahasiswa
      $data1 = array(
        'npm' => $this->input->post('npm'),
        'nama_mhs' => $this->input->post('nama_mhs'),
        'img_profile' => $img[array_rand($img,1)],
        'tahun_masuk' => $this->input->post('tahun_masuk')
      );

      // data for table login_mhs
      $data2 = array(
        'npm' => $this->input->post('npm'),
        'password' => md5('123'),
        'status' => 1
      );

      // INSERT INTO TABLE MAHASISWA AND LOGIN_MHS
      $this->m_basic->insertTwoTables('mahasiswa', $data1, 'login_mhs', $data2);

      redirect($this->uri->uri_string());
    }

    // Add Data Tugas Akhir
    $addTa = $this->input->post('addTa');

    if (isset($addTa)) {
      date_default_timezone_set("Asia/Bangkok");
      $date = new DateTime();
      $timenow = $date->format('Y-m-d H:i:s');

      // data for table tugas_akhir
      $data = array(
        'id_ta' => hash('ripemd160', 'tugasakhir_'.$this->input->post('npm')),
        'npm' => $this->input->post('npm'),
        'nidn' => $this->input->post('nidn'),
        'judul' => $this->input->post('judul'),
        'tgl_input' => $timenow,
        'status' => 1
      );

      // INSERT INTO TABLE TUGAS_AKHIR
      $this->m_basic->insertData('tugas_akhir', $data);

      redirect($this->uri->uri_string());
    }

    // ACC Tugas Akhir
    $accTa = $this->input->post('accTa');
    if (isset($accTa)) {
      date_default_timezone_set("Asia/Bangkok");
      $date = new DateTime();
      $timeacc = $date->format('Y-m-d H:i:s');
      $waktu = $date->format('H:i:s');

      if (!empty($this->input->post('tgl_acc'))) {
        $timeacc = $this->input->post('tgl_acc').' '.$waktu;
      }

      // data update for table TA
      $data = array(
        'tgl_acc' => $timeacc,
      );

      // UPDATE TABLE TUGAS AKHIR
      $this->m_basic->updateData('tugas_akhir', $data, array('npm' => $this->input->post('npm')));
      
      redirect($this->uri->uri_string());
    }
  }

// SHOW ALL DATA DOSEN
  function dosen()
  {
    $this->check_session();

    $user = $this->m_basic->getAllData('prodi', array('username' => $this->session->username))->result_array();
    $data['user'] = $user[0];

    $dosen = $this->m_basic->getAllData('v_dosen')->result_array();
    $data['dosen'] = $dosen;

    $this->load_view('prodi/dosen', $data);
  }

// SHOW MAHASISWA PER DOSPEM
  function dosen_mahasiswa($nidn)
  {
    $this->check_session();

    $nidn = $this->encrypt->decode($nidn);

    $user = $this->m_basic->getAllData('prodi', array('username' => $this->session->username))->result_array();
    $data['user'] = $user[0];

    $mhs = $this->m_basic->getAllData('v_tugas_akhir', array('nidn' => $nidn))->result_array();
    $dosen = $this->m_basic->getAllData('dosen', array('nidn' => $nidn))->result_array();
    $npm = $this->m_basic->getDistinctData('v_tugas_akhir', 'npm')->result_array();
    $bimbinganValid = $this->m_basic->getAllData('v_bimbingan_ta', array('nidn' => $nidn, 'status_validasi'=> 1))->result_array();
    
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

    $data['dosen'] = $dosen[0];
    $data['mhs'] = $mhs;
    $data['count'] = $count;

    $this->load_view('prodi/dosen_mahasiswa', $data);
  }

  // Show All Data Tugas Akhir
  function ta()
  {
    $this->check_session();

    $user = $this->m_basic->getAllData('prodi', array('username' => $this->session->username))->result_array();
    $data['user'] = $user[0];

    $ta = $this->m_basic->getAllData('v_tugas_akhir')->result_array();
    $mhs = $this->m_basic->getsisaMhs();
    $dosen = $this->m_basic->getAllData('dosen')->result_array();
    $data['ta'] = $ta;
    $data['mhs'] = $mhs;
    $data['dosen'] = $dosen;

    $this->load_view('prodi/tugas_akhir', $data);
  
  // Edit Data TA
  $editTa = $this->input->post('editTa');  

    if (isset($editTa)) {
      # code...
    }
  }

  
}
