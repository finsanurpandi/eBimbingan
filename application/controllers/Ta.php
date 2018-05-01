<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ta extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('m_basic');
    $this->load->library('upload');
  }

  // function configImage()
	// {
	// 	$user = $this->session->npm;
	// 	$nmfile = "img_".$user."_".time();
	// 	$config['upload_path']   =   "./assets/img/profiles/";
	// 	$config['allowed_types'] =   "gif|jpg|jpeg|png"; 
	// 	$config['max_size']      =   "1000";
	// 	$config['max_width']     =   "1907";
	// 	$config['max_height']    =   "1280";
	// 	$config['file_name']     =   $nmfile;
 
	// 	$this->upload->initialize($config);
  // }
  
  function configFile()
	{
		$user = $this->session->npm;
		$nmfile = "file_".$user."_".time();
		$config['upload_path']   =   "./assets/files/";
		$config['allowed_types'] =   "doc|docx"; 
		$config['max_size']      =   "3000";
		$config['file_name']     =   $nmfile;
 
		$this->upload->initialize($config);
	}

  function load_view($url, $data=null)
  {
    $this->load->view('head');
    $this->load->view('ta/header',$data);
    $this->load->view('ta/sidebar',$data);

    if ($data==null) {
      $this->load->view($url);
    } else {
      $this->load->view($url, $data);
    }

    $this->load->view('ta/modal', $data);
    $this->load->view('footer');
  }

  function time_elapsed_string($datetime, $full = false) {
      $now = new DateTime;
      $ago = new DateTime($datetime);
      $diff = $now->diff($ago);

      $diff->w = floor($diff->d / 7);
      $diff->d -= $diff->w * 7;

      $string = array(
          'y' => 'year',
          'm' => 'month',
          'w' => 'week',
          'd' => 'day',
          'h' => 'hour',
          'i' => 'minute',
          's' => 'second',
      );
      foreach ($string as $k => &$v) {
          if ($diff->$k) {
              $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
          } else {
              unset($string[$k]);
          }
      }

      if (!$full) $string = array_slice($string, 0, 1);
      return $string ? implode(', ', $string) . ' ago' : 'just now';
  }

	public function index()
	{
		$this->load_view('ta/dashboard');
	}

  function ta_detail()
  {
    $ta = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $this->session->npm))->result_array();
    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $data['ta'] = $ta[0];

    $this->load_view('ta/detail_ta', $data);
  }

  function catatan_harian()
  {
    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $this->load_view('ta/catatan_harian');
  }

  function detail_catatan_harian()
  {
    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $this->load_view('ta/detail_catatan_harian');
  }

  function bimbingan()
  {
    $bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $this->session->id_ta), array('tgl_bimbingan' => 'DESC'))->result_array();
    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $data['bimbingan'] = $bimbingan;

    $this->load_view('ta/bimbingan', $data);

    // add bimbingan
    $addBimbingan = $this->input->post('addBimbingan');

    if (isset($addBimbingan)) {
      date_default_timezone_set("Asia/Bangkok");
      $date = new DateTime();
      $timenow = $date->format('Y-m-d H:i:s');
      $tgl_bimbingan = $this->input->post('tgl_bimbingan').' '.$this->input->post('waktu_bimbingan');
      $id_bimbingan = hash('ripemd160', 'bimbingan_ta_'.$this->session->npm.'_'.$timenow);

      if ($this->input->post('tipe') === 'offline') {
        $data = array(
          'id_bimbingan_ta' => $id_bimbingan,
          'id_ta' => $this->session->id_ta,
          'topik' => $this->input->post('topik'),
          'pembahasan' => $this->input->post('pembahasan'),
          'tipe' => $this->input->post('tipe'),
          'tgl_bimbingan' => date('Y-m-d H:m:s',strtotime($tgl_bimbingan)),
          'tgl_input' => $timenow
          );
    
          $this->m_basic->insertData('bimbingan_ta', $data);
    
      } else {
        $data = array(
          'id_bimbingan_ta' => $id_bimbingan,
          'id_ta' => $this->session->id_ta,
          'topik' => $this->input->post('topik'),
          'pembahasan' => $this->input->post('pembahasan'),
          'tipe' => $this->input->post('tipe'),
          'tgl_bimbingan' => $timenow,
          'tgl_input' => $timenow
          );
    
          $this->configFile();
    
          if (!$this->upload->do_upload('file_doc')) {
            $this->m_basic->insertData('bimbingan_ta', $data);
          } else {
    
            $fileinfo = $this->upload->data();
    
            $data['file'] = $fileinfo['file_name'];
            $this->m_basic->insertData('bimbingan_ta', $data);
          }
      }

      $this->session->set_flashdata('success', true);

      redirect($this->uri->uri_string());

    }
  }

  function detail_bimbingan($id_bimbingan, $tipe)
  {
    $id_bimbingan = $this->encrypt->decode($id_bimbingan);
    $tipe = $this->encrypt->decode($tipe);

    $data_bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_bimbingan_ta' => $id_bimbingan))->result_array();
    $data_komentar = $this->m_basic->getAllData('komentar_ta', array('id_bimbingan_ta' => $id_bimbingan), array('datetime_sent' => 'ASC'))->result_array();
    $jml_komentar = $this->m_basic->getAllData('komentar_ta', array('id_bimbingan_ta' => $id_bimbingan))->num_rows();
    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();

    $data['bimbingan'] = $data_bimbingan;
    $data['komentar'] = $data_komentar;
    $data['user'] = $user[0];
    $data['tipe'] = $tipe;
    $data['timeago'] = $this->time_elapsed_string( date('Y:m:d H:i:s', strtotime($data_bimbingan[0]['tgl_input'])) );

    $this->load_view('ta/detail_bimbingan', $data);

    //add komentar
    $addComment = $this->input->post('addComment');

    if (isset($addComment)) {
      date_default_timezone_set("Asia/Bangkok");
      $date = new DateTime();
      $timenow = $date->format('Y-m-d H:i:s');

      $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();

      $data = array(
        'id_bimbingan_ta' => $id_bimbingan,
        'pengirim' => $this->session->nama_mhs,
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
  }

  function timeline_catatan_harian()
  {
    $this->load_view('ta/timeline_catatan_harian');
  }

  function timeline_bimbingan()
  {
    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];

    $data_ta = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $this->session->npm))->result_array();
    $bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $this->session->id_ta), array('tgl_bimbingan' => 'DESC'))->result_array();

    $data['ta'] = $data_ta[0];
    $data['bimbingan'] = $bimbingan;

    $this->load_view('ta/timeline_bimbingan', $data);
  }

}
