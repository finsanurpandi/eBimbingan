<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

  function __construct()
  {
    parent::__construct();
  }

	function file($file)
	{
		$file = $this->encrypt->decode($file);
        $url = base_url().'assets/files/'.$file;
        force_download($file, $url);
	}
}
