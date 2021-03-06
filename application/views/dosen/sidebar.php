<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url()?>assets/img/profiles/<?=$user['img_profile']?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?=$this->session->nama_dosen?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li id="dosenDashboard">
        <a href="<?=base_url()?>dosen">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <!-- <li id="dosenTugasAkhir">
        <a href="<?=base_url()?>dosen/ta">
          <i class="fa fa-bandcamp"></i> <span>Tugas Akhir</span>
        </a>
      </li> -->
      <li id="dosenTugasAkhir" class="treeview">
        <a href="#">
          <i class="fa fa-th-list"></i> <span>Tugas Akhir</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li id="dosenBimbingan"><a href="<?=base_url()?>dosen/ta"><i class="fa fa-circle-o"></i> Bimbingan</a></li>
          <li id="dosenCatatanHarian"><a href="<?=base_url()?>dosen/catatan_harian"><i class="fa fa-circle-o"></i> Catatan Harian</a></li>
        </ul>
      </li>
      <li id="dosenKerjaPraktek">
        <a href="<?=base_url()?>dosen/ta">
          <i class="fa fa-th-list"></i> <span>Kerja Praktek</span>
        </a>
      </li>
      <li id="dosenPengajuan">
        <a href="<?=base_url()?>">
          <i class="fa fa-thumbs-up"></i> <span>Pengajuan Seminar/Sidang</span>
        </a>
      </li>
    </ul>

  </section>
  <!-- /.sidebar -->
</aside>

<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
  var uri = '<?=$this->uri->segment(2)?>';

  function dosenClearMenu(){
    $('#dosenDashboard').remove('.active');
    $('#dosenTugasAkhir').remove('.active');
    $('#dosenBimbingan').remove('.active');
    $('#dosenKerjaPraktek').remove('.active');
    $('#dosenPengajuan').remove('.active');
  }

  if (uri == '') {
    dosenClearMenu();
    $('#dosenDashboard').addClass('active');
  } else if (uri == 'ta' || uri == 'timeline_bimbingan_ta' || uri == 'bimbingan' || uri == 'detail_bimbingan') {
    $('#dosenTugasAkhir').addClass('active');
    $('#dosenBimbingan').addClass('active');
  } else if (uri == 'catatan_harian' || uri == 'timeline_catatan_harian' || uri == 'catatan_mahasiswa' || uri == 'detail_catatan') {
    $('#dosenTugasAkhir').addClass('active');
    $('#dosenCatatanHarian').addClass('active');
  } else if (uri == 'kp' || uri == 'timeline_bimbingan_kp' || uri == 'catatan_harian') {
    $('#dosenTugasAkhir').addClass('active');
  } else if (uri == 'pengajuan') {
    $('#dosenPengajuan').addClass('active');
  } 
</script>

