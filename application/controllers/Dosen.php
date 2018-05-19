<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('m_basic');
    $this->load->library('upload');
  }

// Image Upload Configuration 
  function configImage()
	{
		$user = $this->session->nidn;
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
		$user = $this->session->nidn;
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

// session check configuration
  function check_session()
  {
    $session = $this->session->userdata('login_in');
    $role = $this->session->userdata('role');

		if ($session === FALSE || $session == null) {
			redirect('login/dosen', 'refresh');
		} 
  }

// Dashboard view
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

// List Mahasiswa Bimbingan TA
  function ta()
	{
    $this->check_session();

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];

    $ta = $this->m_basic->getAllData('v_tugas_akhir', array('nidn' => $this->session->nidn),array('npm' => 'ASC'))->result_array();
    $bimbingan = $this->m_basic->getAllData('v_bimbingan_ta', array('nidn' => $this->session->nidn))->result_array();
    $bimbinganValid = $this->m_basic->getAllData('v_bimbingan_ta', array('nidn' => $this->session->nidn, 'status_validasi'=> 1))->result_array();
    $unreadNum = $this->m_basic->getAllData('v_bimbingan_ta', array('nidn' => $this->session->nidn, 'status_open' => 0))->num_rows();
    $unreadData = $this->m_basic->getAllData('v_bimbingan_ta', array('nidn' => $this->session->nidn, 'status_open' => 0))->result_array();
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

    $unread = array();

    for ($i=0; $i < count($npm); $i++) { 
      $unread[$npm[$i]['npm']] = 0;
    }

    for ($i=0; $i < count($unreadData); $i++) { 
      for ($j=0; $j < count($npm); $j++) { 
        if ($unreadData[$i]['npm'] == $npm[$j]['npm']) {
          $unread[$npm[$j]['npm']] += 1;
        }
      }
    }

    $data['ta'] = $ta;
    $data['bimbingan'] = $bimbingan;
    $data['count'] = $count;
    $data['unread'] = $unread;


		$this->load_view('dosen/tugas_akhir', $data);
  }

// List Data Bimbingan TA Mahasiswa
  function bimbingan($id_ta, $npm)
  {
    $this->check_session();

    $id_ta = $this->encrypt->decode($id_ta);
    $npm = $this->encrypt->decode($npm);
    //$nama_mhs = $this->encrypt->decode($nama_mhs);

    $bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $id_ta), array('tgl_bimbingan' => 'DESC'))->result_array();
    $bimbinganOnline = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $id_ta, 'tipe' => 'online'))->result_array();
    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];
    $data['bimbingan'] = $bimbingan;
    $komentar = $this->m_basic->getAllData('komentar_ta', array('id_ta' => $id_ta, 'pengirim !=' => $this->session->nama_dosen,'status' => 0))->result_array();
    $mhs = $this->m_basic->getAllData('mahasiswa', array('npm' => $npm))->result_array();
    $data['mhs'] = $mhs[0];

    $count = array();

    for ($i=0; $i < count($bimbinganOnline); $i++) { 
      $index = 0;
      for ($j=0; $j < count($komentar); $j++) { 
        if ($bimbinganOnline[$i]['id_bimbingan_ta'] === $komentar[$j]['id_bimbingan_ta']) {
          @$count[$bimbinganOnline[$i]['id_bimbingan_ta']] += 1;
        }
      }
    }

    $data['count'] = $count;

    $this->load_view('dosen/bimbingan', $data);

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

// Detail Bimbingan TA
  function detail_bimbingan($npm, $id_bimbingan, $tipe)
  {
    $this->check_session();

    $npm = $this->encrypt->decode($npm);
    $id_bimbingan = $this->encrypt->decode($id_bimbingan);
    $tipe = $this->encrypt->decode($tipe);

    // update koment
    $komentar = $this->m_basic->getAllData('komentar_ta', array('id_bimbingan_ta' => $id_bimbingan, 'pengirim !=' => $this->session->nama_dosen,'status' => 0))->result_array();
    $komentarNum = $this->m_basic->getAllData('komentar_ta', array('id_bimbingan_ta' => $id_bimbingan, 'pengirim !=' => $this->session->nama_dosen,'status' => 0))->num_rows();
    
    if ($komentarNum > 0) {
      for ($i=0; $i < count($komentar); $i++) { 
        if ($komentar[$i]['id_bimbingan_ta'] == $id_bimbingan) {
          $this->m_basic->updateData('komentar_ta', array('status' => 1), array('id_bimbingan_ta' => $komentar[$i]['id_bimbingan_ta']));
        }
      }
    }

    $data_bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_bimbingan_ta' => $id_bimbingan))->result_array();
    $data_komentar = $this->m_basic->getAllData('komentar_ta', array('id_bimbingan_ta' => $id_bimbingan), array('datetime_sent' => 'ASC'))->result_array();
    $jml_komentar = $this->m_basic->getAllData('komentar_ta', array('id_bimbingan_ta' => $id_bimbingan))->num_rows();
    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $mhs = $this->m_basic->getAllData('mahasiswa', array('npm' => $npm))->result_array();
    
    $data['mhs'] = $mhs[0];
    $data['bimbingan'] = $data_bimbingan;
    $data['komentar'] = $data_komentar;
    $data['user'] = $user[0];
    $data['tipe'] = $tipe;
    //$data['timeago'] = $this->time_elapsed_string( date('Y:m:d H:i:s', strtotime($data_bimbingan[0]['tgl_input'])) );

    // status read...
    if ($data_bimbingan[0]['status_open'] == 0) {
      $this->m_basic->updateData('bimbingan_ta', array('status_open' => 1), array('id_bimbingan_ta' => $id_bimbingan));
    }

    $this->load_view('dosen/detail_bimbingan', $data);

    //add komentar
    $addComment = $this->input->post('addComment');

    if (isset($addComment)) {
      date_default_timezone_set("Asia/Bangkok");
      $date = new DateTime();
      $timenow = $date->format('Y-m-d H:i:s');

      // $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();

      $data = array(
        'id_ta' => $data_bimbingan[0]['id_ta'],
        'id_bimbingan_ta' => $id_bimbingan,
        'pengirim' => $this->session->nama_dosen,
        'komentar' => $this->input->post('komentar'),
        'datetime_sent' => $timenow,
        'img' => $user[0]['img_profile']
      );

      $this->configFile();

			if (!$this->upload->do_upload('file_doc')) {

				$this->m_basic->insertData('komentar_ta', $data);

      } else {

				$fileinfo = $this->upload->data();

				$data['file'] = $fileinfo['file_name'];
				$this->m_basic->insertData('komentar_ta', $data);

      }
      
      $this->session->set_flashdata('success', true);

      redirect($this->uri->uri_string());
    }

    // Validasi
    // accepted and closed
    $accept = $this->input->post('accept');
    if (isset($accept)) {
      $data = array('status_validasi' => 1);

      $this->m_basic->updateData('bimbingan_ta', $data, array('id_bimbingan_ta' => $id_bimbingan));

      $this->session->set_flashdata('success', true);

      redirect($this->uri->uri_string());
    }

    // decline
    $decline = $this->input->post('decline');
    if (isset($decline)) {

      date_default_timezone_set("Asia/Bangkok");
      $date = new DateTime();
      $timenow = $date->format('Y-m-d H:i:s');

      // $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();

      $data1 = array(
        'id_ta' => $data_bimbingan[0]['id_ta'],
        'id_bimbingan_ta' => $id_bimbingan,
        'pengirim' => $this->session->nama_dosen,
        'komentar' => $this->input->post('komentar'),
        'datetime_sent' => $timenow,
        'img' => $user[0]['img_profile']
      );

      $data2 = array('status_validasi' => 2);

      $this->m_basic->decline('komentar_ta', $data1, 'bimbingan_ta', $data2, array('id_bimbingan_ta' => $id_bimbingan));

			// $this->m_basic->insertData('komentar_ta', $data);

      // $this->m_basic->updateData('bimbingan_ta', $data, array('id_bimbingan_ta' => $id_bimbingan));

      $this->session->set_flashdata('danger', true);

      redirect($this->uri->uri_string());
    }
  }

// Timeline Bimbingan TA
  function timeline_bimbingan_ta($npm, $id_ta)
  {
    $this->check_session();

    $npm = $this->encrypt->decode($npm);
    $id_ta = $this->encrypt->decode($id_ta);

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];

    $data_ta = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $npm))->result_array();
    $bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $id_ta, 'status_validasi' => 1), array('tgl_bimbingan' => 'DESC'))->result_array();

    $data['ta'] = $data_ta[0];
    $data['bimbingan'] = $bimbingan;

    $this->load_view('dosen/timeline_bimbingan_ta', $data);

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

// List Mahasiswa Bimbingan TA untuk Catatan Harian
  function catatan_harian()
  {
    $this->check_session();

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];

    $ta = $this->m_basic->getAllData('v_tugas_akhir', array('nidn' => $this->session->nidn),array('npm' => 'ASC'))->result_array();
    $catatan = $this->m_basic->getAllData('v_catatan_harian', array('nidn' => $this->session->nidn))->result_array();
    $npm = $this->m_basic->getDistinctData('v_tugas_akhir', 'npm')->result_array();

    $count = array();

      for ($i=0; $i < count($npm); $i++) { 
        $count[$npm[$i]['npm']] = 0;
      }

      for ($i=0; $i < count($catatan) ; $i++) { 
        for ($j=0; $j < count($npm); $j++) { 
          if ($catatan[$i]['npm'] == $npm[$j]['npm']) {
            $count[$npm[$j]['npm']] += 1;
          }
        }
      }

    $data['ta'] = $ta;
    $data['count'] = $count;

    $this->load_view('dosen/catatan_harian', $data);

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

// List data catatan setiap mahasiswa
  function catatan_mahasiswa($npm)
  {
    $this->check_session();

    $npm = $this->encrypt->decode($npm);

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];

    $catatan = $this->m_basic->getAllData('v_catatan_harian', array('npm' => $npm), array('waktu_kegiatan' => 'DESC'))->result_array();
    $mhs = $this->m_basic->getAllData('mahasiswa', array('npm' => $npm))->result_array();
    $data['catatan'] = $catatan;
    $data['mhs'] = $mhs[0];

    $this->load_view('dosen/catatan_mahasiswa', $data);

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

// Detail catatan mahasiswa
  function detail_catatan($npm, $id_catatan_harian)
  {
    $this->check_session();

    $npm = $this->encrypt->decode($npm);
    $id_catatan_harian = $this->encrypt->decode($id_catatan_harian);

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];

    $data_catatan_harian = $this->m_basic->getAllData('catatan_harian', array('id_catatan_harian' => $id_catatan_harian))->result_array();
    $mhs = $this->m_basic->getAllData('mahasiswa', array('npm' => $npm))->result_array();

    $data['catatan_harian'] = $data_catatan_harian;
    $data['user'] = $user[0];
    $data['mhs'] = $mhs[0];

    $this->load_view('dosen/detail_catatan', $data);
  }

// Timeline catatan harian
  function timeline_catatan_harian($npm)
  {
    $this->check_session();

    $npm = $this->encrypt->decode($npm);

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];

    $catatan_harian = $this->m_basic->getAllData('v_catatan_harian', array('npm' => $npm), array('waktu_kegiatan' => 'DESC'))->result_array();
    $mhs = $this->m_basic->getAllData('mahasiswa', array('npm' => $npm))->result_array();

    $data['catatan_harian'] = $catatan_harian;
    $data['mhs'] = $mhs[0];

    $this->load_view('dosen/timeline_catatan_harian', $data);

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

// setting image profile
  function settings($url)
  {
    $this->check_session();

    $url = $this->encrypt->decode($url);

    $user = $this->m_basic->getAllData('dosen', array('nidn' => $this->session->nidn))->result_array();
    $data['user'] = $user[0];
    $data['url'] = $url;

    $this->load_view('dosen/settings', $data);

    $updateProfil = $this->input->post('updateProfil');

    if (isset($updateProfil)) {

      $img_path = $this->input->post('path');
      
      if ($img_path !== 'patrick.jpg' || $img_path !== 'spongebob.jpg' || $img_path !== 'squidward.jpg') {
        @unlink("./assets/img/profiles/". $img_path);
      }

      $this->configImage('profiles');

      if ($this->upload->do_upload('gambar')) {

        $fileinfo = $this->upload->data();

        $dataupload['img_profile'] = $fileinfo['file_name'];
        
        //$this->m_basic->updateData('dosen', $dataupload, array('nidn' => $this->session->nidn));
        $this->m_basic->updateImage('dosen', 'v_komentar_ta', $dataupload, array('nidn' => $this->session->nidn), array('pengirim' => $this->session->nama_dosen));

        $this->session->set_flashdata('success', true);

        redirect($this->uri->uri_string());

      }
    }
  }
}
