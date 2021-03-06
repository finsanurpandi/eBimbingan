<body class="hold-transition skin-black-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>T</b>IF</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>e</b>Bimbingan TA</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=base_url()?>assets/img/profiles/<?=$user['img_profile']?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$this->session->nama_mhs?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=base_url()?>assets/img/profiles/<?=$user['img_profile']?>" class="img-circle" onclick="confirm('Are you sure to logout?')" alt="User Image">

                <p>
                  <?=$user['npm'].' - '.$user['nama_mhs']?>
                  <small>Angkatan <?=$user['tahun_masuk']?></small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                <a href="<?=base_url()?>ta/settings/<?=$this->encrypt->encode($this->uri->uri_string())?>" class="btn btn-default btn-flat btn-sm">Settings</a>
                </div>
                <div class="pull-right">
                  <!-- <a href="<?=base_url()?>login/logout/ta" class="btn btn-default btn-flat btn-sm">Log out</a> -->
                  <a href="#" class="btn btn-default btn-flat btn-sm" data-toggle="modal" data-target="#logout">Log out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
