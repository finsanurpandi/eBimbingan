<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('m_basic');
  }

  function load_view($url, $data=null)
  {
    $this->load->view($url);
  }

	// public function index()
	// {
	// 	$this->load_view('login/login');
	// }

// method Login TA
  function ta($npm=null)
  {
    $session = $this->session->userdata('login_in');
    $role = $this->session->userdata('role');

		if ($session === TRUE) {
			redirect('ta', 'refresh');
    }
    
    // if ($session == FALSE) {
    //   $this->load->view('login/login');
    // } else {
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

    if ($npm==null) {
      $this->load_view('login/login');
      $this->session->unset_userdata('npm');
      $this->session->unset_userdata('nama');

      $submit_npm = $this->input->post('submit_npm');

      if (isset($submit_npm)) {
        $npm = $this->input->post('npm');

        //set user
        $count = $this->m_basic->getNumRows('tugas_akhir', array('npm' => $npm, 'status' => 1, 'tgl_acc !=' => null));
        $user = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $npm))->result_array();

        // identify user
        if ($count === 1) {
          $npm_user = array (
            'npm' => $npm,
            'nama' => $user[0]['nama_mhs']
          );

          $this->session->set_userdata($npm_user);
          $url = 'login/ta/'.$this->encrypt->encode($npm);
          redirect($url, 'refresh');

        } else {
            $this->session->set_flashdata("error", true);
            redirect($this->uri->uri_string(), 'refresh');
        }
      }

    } else {
      $npm = $this->encrypt->decode($npm);

      if ($npm === $this->session->npm) {
        $this->load_view('login/password');

        $submit_pass = $this->input->post('submit_pass');

        if (isset($submit_pass)) {
          //check user
          $count = $this->m_basic->getNumRows('login_mhs', array('npm' => $this->session->npm, 'password' => md5($this->input->post('pass'))));

          //set date
    			date_default_timezone_set("Asia/Bangkok");
    			$date = new DateTime();
    			$lastlogin = $date->format('Y-m-d H:i:s');

    			//check device
    			if ($this->agent->is_browser())
    			{
    				$agent = $this->agent->platform(). ', ' .$this->agent->browser().' '.$this->agent->version();
    			}
    			elseif ($this->agent->is_robot())
    			{
    			    $agent = $this->agent->robot();
    			}
    			elseif ($this->agent->is_mobile())
    			{
    		        $agent = $this->agent->platform(). ', ' .$this->agent->mobile();
    			}
    			else
    			{
    			    $agent = 'Unidentified User Agent';
    			}

          if ($count === 1) {
            $user = $this->m_basic->getAllData('v_tugas_akhir', array('npm' => $this->session->npm))->result_array();

            $user_account = array (
              'login_in' => TRUE,
              'npm' => $npm,
              'nama_mhs' => $user[0]['nama_mhs'],
              'id_ta' => $user[0]['id_ta'],
              'role' => 1
            );

            $data = array(
              'last_login' => $lastlogin,
              'device' => $agent
            );

            $this->session->unset_userdata('npm');
            $this->session->unset_userdata('nama');

            $this->session->set_userdata($user_account);
            $this->m_basic->updateData('login_mhs', $data, array('npm' => $npm));

            redirect('ta', 'refresh');
          } else {
            $this->session->set_flashdata('error', true);
            redirect($this->uri->uri_string(), 'refresh');
          }
        }
      } else {
        redirect('login/ta', 'refresh');
      }
    }
  }
// end of method TA

// method Login KP
  function kp($npm=null)
  {
    $session = $this->session->userdata('login_in');
    $role = $this->session->userdata('role');

		if ($session == FALSE) {
      $this->load->view('login/login');
    } else {
      if ($role === 1) {
        redirect('ta', 'refresh');
      } elseif ($role === 2) {
        redirect('kp', 'refresh');
      } elseif ($role === 3) {
        redirect('dosen', 'refresh');
      } elseif ($role === 4) {
        redirect('prodi', 'refresh');
      }
    }

    if ($npm==null) {
      $this->load_view('login/login');
      $this->session->unset_userdata('npm');
      $this->session->unset_userdata('nama');

      $submit_npm = $this->input->post('submit_npm');

      if (isset($submit_npm)) {
        $npm = $this->input->post('npm');

        //set user
        $count = $this->m_basic->getNumRows('tugas_akhir', array('npm' => $npm));
        $user = $this->m_basic->getAllData('v_kerja_praktek', array('npm' => $npm))->result_array();

        // identify user
        if ($count === 1) {
          $npm_user = array (
            'npm' => $npm,
            'nama' => $user[0]['nama_mhs']
          );

          $this->session->set_userdata($npm_user);
          $url = 'login/kp/'.$this->encrypt->encode($npm);
          redirect($url, 'refresh');

        } else {
            $this->session->set_flashdata("error", true);
            redirect($this->uri->uri_string(), 'refresh');
        }
      }

    } else {
      $npm = $this->encrypt->decode($npm);

      if ($npm === $this->session->npm) {
        $this->load_view('login/password');

        $submit_pass = $this->input->post('submit_pass');

        if (isset($submit_pass)) {
          //check user
          $count = $this->m_basic->getNumRows('login_mhs', array('npm' => $this->session->npm, 'password' => md5($this->input->post('pass'))));

          //set date
    			date_default_timezone_set("Asia/Bangkok");
    			$date = new DateTime();
    			$lastlogin = $date->format('Y-m-d H:i:s');

    			//check device
    			if ($this->agent->is_browser())
    			{
    				$agent = $this->agent->platform(). ', ' .$this->agent->browser().' '.$this->agent->version();
    			}
    			elseif ($this->agent->is_robot())
    			{
    			    $agent = $this->agent->robot();
    			}
    			elseif ($this->agent->is_mobile())
    			{
    		        $agent = $this->agent->platform(). ', ' .$this->agent->mobile();
    			}
    			else
    			{
    			    $agent = 'Unidentified User Agent';
    			}

          if ($count === 1) {
            $user = $this->m_basic->getAllData('v_kerja_praktek', array('npm' => $this->session->npm))->result_array();

            $user_account = array (
              'login_in' => TRUE,
              'npm' => $npm,
              'nama_mhs' => $user[0]['nama_mhs'],
              'id_kp' => $user[0]['id_kp'],
              'role' => 2
            );

            $data = array(
              'last_login' => $lastlogin,
              'device' => $agent
            );

            $this->session->unset_userdata('npm');
            $this->session->unset_userdata('nama');

            $this->session->set_userdata($user_account);
            $this->m_basic->updateData('login_mhs', $data, array('npm' => $npm));

            redirect('kp', 'refresh');
          } else {
            $this->session->set_flashdata('error', true);
            redirect($this->uri->uri_string(), 'refresh');
          }
        }
      } else {
        redirect('login/kp', 'refresh');
      }
    }
  }
// end of method KP

// method Login Dosen
function dosen()
{
  $session = $this->session->userdata('login_in');
  $role = $this->session->userdata('role');

  if ($session == FALSE) {
    $this->load->view('login/login_dosen');
  } else {
    if ($role === 1) {
      redirect('ta', 'refresh');
    } elseif ($role === 2) {
      redirect('kp', 'refresh');
    } elseif ($role === 3) {
      redirect('dosen', 'refresh');
    } elseif ($role === 4) {
      redirect('prodi', 'refresh');
    }
  }

  $login = $this->input->post('login');

		if (isset($login)) {
			$nidn = $this->input->post('nidn');
			$pass = $this->input->post('pass');

			// check user
			$count = $this->m_basic->getNumRows('login_dosen', array('nidn' => $nidn, 'password' => md5($pass), 'status' => 1));

			//set date
			date_default_timezone_set("Asia/Bangkok");
			$date = new DateTime();
			$lastlogin = $date->format('Y-m-d H:i:s');

			//check device
			if ($this->agent->is_browser())
			{
				$agent = $this->agent->platform(). ', ' .$this->agent->browser().' '.$this->agent->version();
			}
			elseif ($this->agent->is_robot())
			{
			    $agent = $this->agent->robot();
			}
			elseif ($this->agent->is_mobile())
			{
		        $agent = $this->agent->platform(). ', ' .$this->agent->mobile();
			}
			else
			{
			    $agent = 'Unidentified User Agent';
			}

			if ($count == 1) {
				$user = $this->m_basic->getAllData('dosen', array('nidn' => $nidn))->result_array();

            $user_account = array (
              'login_in' => TRUE,
              'nidn' => $nidn,
              'nama_dosen' => $user[0]['nama_dosen'],
              'role' => 3
            );

            $data = array(
              'last_login' => $lastlogin,
              'device' => $agent
            );

            $this->session->set_userdata($user_account);
            $this->m_basic->updateData('login_dosen', $data, array('nidn' => $nidn));

            redirect('dosen', 'refresh');
				
			} else {

				$this->session->set_flashdata('error', true);
				redirect('login/dosen','refresh');

			}
		}
}
// end of method Dosen

// method Login Prodi
function prodi()
{
  $session = $this->session->userdata('login_in');
  $role = $this->session->userdata('role');

  if ($session == FALSE) {
    $this->load->view('login/login_prodi');
  } else {
    if ($role === 1) {
      redirect('ta', 'refresh');
    } elseif ($role === 2) {
      redirect('kp', 'refresh');
    } elseif ($role === 3) {
      redirect('dosen', 'refresh');
    } elseif ($role === 4) {
      redirect('prodi', 'refresh');
    }
  }

  $login = $this->input->post('login');

		if (isset($login)) {
			$username = $this->input->post('user');
			$pass = $this->input->post('pass');

			// check user
			$count = $this->m_basic->getNumRows('login_prodi', array('username' => $username, 'password' => md5($pass), 'status' => 1));

			//set date
			date_default_timezone_set("Asia/Bangkok");
			$date = new DateTime();
			$lastlogin = $date->format('Y-m-d H:i:s');

			//check device
			if ($this->agent->is_browser())
			{
				$agent = $this->agent->platform(). ', ' .$this->agent->browser().' '.$this->agent->version();
			}
			elseif ($this->agent->is_robot())
			{
			    $agent = $this->agent->robot();
			}
			elseif ($this->agent->is_mobile())
			{
		        $agent = $this->agent->platform(). ', ' .$this->agent->mobile();
			}
			else
			{
			    $agent = 'Unidentified User Agent';
			}

			if ($count == 1) {
				$user = $this->m_basic->getAllData('prodi', array('username' => $username))->result_array();

            $user_account = array (
              'login_in' => TRUE,
              'username' => $username,
              'nama_user' => $user[0]['nama_user'],
              'role' => 4
            );

            $data = array(
              'last_login' => $lastlogin,
              'device' => $agent
            );

            $this->session->set_userdata($user_account);
            $this->m_basic->updateData('login_prodi', $data, array('username' => $username));

            redirect('prodi', 'refresh');
				
			} else {

				$this->session->set_flashdata('error', true);
				redirect('login/prodi','refresh');

			}
		}
}
// end of method Prodi

  function logout($url)
	{
		$this->session->sess_destroy();
		redirect('login/'.$url, 'refresh');
	}

}
