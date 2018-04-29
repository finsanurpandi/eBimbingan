<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

  function __construct()
  {
    parent::__construct();
  }

  function load_view($url, $data=null)
  {
    $this->load->view('head');
    $this->load->view('header');
    $this->load->view('sidebar');
    $this->load->view($url);
    $this->load->view('footer');
  }

	public function index()
	{
		$this->load_view('pages/test');
	}
}
