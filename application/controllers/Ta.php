<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ta extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('m_basic');
    $this->load->library('upload');
  }

  function configImage()
	{
		$user = $this->session->npm;
		$nmfile = "img_".$user."_".time();
		$config['upload_path']   =   "./assets/img/profiles/";
		$config['allowed_types'] =   "gif|jpg|jpeg|png"; 
		$config['max_size']      =   "1000";
		$config['max_width']     =   "1907";
		$config['max_height']    =   "1280";
		$config['file_name']     =   $nmfile;
 
		$this->upload->initialize($config);
  }
  
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

  function check_session()
  {
    $session = $this->session->userdata('login_in');
    $role = $this->session->userdata('role');

		if ($session == FALSE || $session == null) {
			redirect('login/ta', 'refresh');
    } 
    // else {
    //   if ($role === 1) {
    //     redirect('ta', 'refresh');
    //   } elseif ($role === 2) {
    //     redirect('kp', 'refresh');
    //   } elseif ($role === 3) {
    //     redirect('dosen', 'refresh');
    //   } elseif ($role === 4) {
    //     redirect('prodi', 'refresh');
    //   }
    // }

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
    $this->check_session();

    $ta = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $this->session->npm))->result_array();
    $bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $this->session->id_ta, 'status_validasi' => 1));
    $catatan_harian = $this->m_basic->getAllData('catatan_harian', array('id_ta' => $this->session->id_ta));
    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $data['ta'] = $ta[0];
    $data['bimbingan'] = $bimbingan;
    $data['catatan'] = $catatan_harian;

		$this->load_view('ta/dashboard', $data);
	}

  function detail()
  {
    $this->check_session();

    $ta = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $this->session->npm))->result_array();
    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $data['ta'] = $ta[0];

    $this->load_view('ta/detail_ta', $data);
  }

  function catatan_harian()
  {
    $this->check_session();

    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $catatan_harian = $this->m_basic->getAllData('catatan_harian', array('id_ta' => $this->session->id_ta), array('waktu_kegiatan' => 'DESC'))->result_array();
    $data['catatan_harian'] = $catatan_harian;

    $this->load_view('ta/catatan_harian', $data);

    // add catatan harian
    $addCatatan = $this->input->post('addCatatanHarian');

    if(isset($addCatatan))
    {
      date_default_timezone_set("Asia/Bangkok");
      $date = new DateTime();
      $timenow = $date->format('Y-m-d H:i:s');
      $tgl_kegiatan = $this->input->post('tgl_kegiatan').' '.$this->input->post('waktu_kegiatan');
      $id_catatan_harian = hash('ripemd160', 'catatan_harian_'.$this->session->npm.'_'.$timenow);

      $data = array(
        'id_catatan_harian' => $id_catatan_harian,
        'id_ta' => $this->session->id_ta,
        'nama_kegiatan' => $this->input->post('nama_kegiatan'),
        'uraian_kegiatan' => $this->input->post('uraian_kegiatan'),
        'waktu_kegiatan' => date('Y-m-d H:m:s',strtotime($tgl_kegiatan)),
        'waktu_input' => $timenow
      );

      $this->m_basic->insertData('catatan_harian', $data);

      $this->session->set_flashdata('success', true);

      redirect($this->uri->uri_string());
    }

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

  function detail_catatan_harian($id_catatan_harian)
  {
    $this->check_session();

    $id_catatan_harian = $this->encrypt->decode($id_catatan_harian);

    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $data_catatan_harian = $this->m_basic->getAllData('catatan_harian', array('id_catatan_harian' => $id_catatan_harian))->result_array();

    $data['catatan_harian'] = $data_catatan_harian;
    $data['user'] = $user[0];
    $data['timeago'] = $this->time_elapsed_string( date('Y:m:d H:i:s', strtotime($data_catatan_harian[0]['waktu_kegiatan'])) );

    $this->load_view('ta/detail_catatan_harian', $data);
  }

  function bimbingan()
  {
    $this->check_session();

    $bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $this->session->id_ta), array('tgl_bimbingan' => 'DESC'))->result_array();
    $bimbinganOnline = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $this->session->id_ta, 'tipe' => 'online'))->result_array();
    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $data['bimbingan'] = $bimbingan;
    $komentar = $this->m_basic->getAllData('komentar_ta', array('id_ta' => $this->session->id_ta, 'pengirim !=' => $this->session->nama_mhs,'status' => 0))->result_array();

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

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

  function detail_bimbingan($id_bimbingan, $tipe)
  {
    $this->check_session();

    $id_bimbingan = $this->encrypt->decode($id_bimbingan);
    $tipe = $this->encrypt->decode($tipe);

    // update koment
    $komentar = $this->m_basic->getAllData('komentar_ta', array('id_bimbingan_ta' => $id_bimbingan, 'pengirim !=' => $this->session->nama_mhs,'status' => 0))->result_array();
    $komentarNum = $this->m_basic->getAllData('komentar_ta', array('id_bimbingan_ta' => $id_bimbingan, 'pengirim !=' => $this->session->nama_mhs,'status' => 0))->num_rows();
    
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
        'id_ta' => $this->session->id_ta,
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
    $this->check_session();

    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];

    $data_ta = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $this->session->npm))->result_array();
    $catatan_harian = $this->m_basic->getAllData('catatan_harian', array('id_ta' => $this->session->id_ta), array('waktu_kegiatan' => 'DESC'))->result_array();

    $data['ta'] = $data_ta[0];
    $data['catatan_harian'] = $catatan_harian;

    $this->load_view('ta/timeline_catatan_harian', $data);

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

  function timeline_bimbingan()
  {
    $this->check_session();

    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];

    $data_ta = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $this->session->npm))->result_array();
    $bimbingan = $this->m_basic->getAllData('bimbingan_ta', array('id_ta' => $this->session->id_ta, 'status_validasi' => 1), array('tgl_bimbingan' => 'DESC'))->result_array();

    $data['ta'] = $data_ta[0];
    $data['bimbingan'] = $bimbingan;

    $this->load_view('ta/timeline_bimbingan', $data);

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

  function settings($url)
  {
    $this->check_session();

    $url = $this->encrypt->decode($url);

    $user = $this->m_basic->getAllData('mahasiswa', array('npm' => $this->session->npm))->result_array();
    $data['user'] = $user[0];
    $data['url'] = $url;

    $this->load_view('ta/settings', $data);

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
        
				$this->m_basic->updateData('mahasiswa', $dataupload, array('npm' => $this->session->npm));

				$this->session->set_flashdata('success', true);

        redirect($this->uri->uri_string());

			}
    }

    //create session url
    $this->session->set_userdata('url', $this->uri->uri_string());
  }

}
