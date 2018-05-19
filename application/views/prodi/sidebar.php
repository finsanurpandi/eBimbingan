<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url()?>assets/img/profiles/<?=$user['img_profile']?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?=$this->session->nama_user?></p>
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
      <li id="prodiDashboard">
        <a href="<?=base_url()?>prodi">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li id="prodiTugasAkhir" class="treeview">
        <a href="#">
          <i class="fa fa-th-list"></i> <span>Tugas Akhir</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li id="prodiMahasiswa"><a href="<?=base_url()?>prodi/mahasiswa"><i class="fa fa-circle-o"></i> Mahasiswa</a></li>
          <li id="prodiDosen"><a href="<?=base_url()?>prodi/dosen"><i class="fa fa-circle-o"></i> Dosen</a></li>
          <li id="prodiTa"><a href="<?=base_url()?>prodi/ta"><i class="fa fa-circle-o"></i> Histori TA</a></li>
          <!-- <li><a href="<?=base_url()?>ta/bimbingan_online"><i class="fa fa-circle-o"></i> Bimbingan Online</a></li> -->
        </ul>
      </li>
      <li>
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

  function prodiClearMenu(){
    $('#prodiDashboard').remove('.active');
    $('#prodiTugasAkhir').remove('.active');
    $('#prodiMahasiswa').remove('.active');
    $('#prodiDosen').remove('.active');
    $('#prodiTa').remove('.active');

  }

  if (uri == '') {
    prodiClearMenu();
    $('#prodiDashboard').addClass('active');
  } else if (uri == 'mahasiswa') {
    $('#prodiTugasAkhir').addClass('active');
    $('#prodiMahasiswa').addClass('active');
  } else if (uri == 'dosen') {
    $('#prodiTugasAkhir').addClass('active');
    $('#prodiDosen').addClass('active');
  } else if (uri == 'ta') {
    $('#prodiTugasAkhir').addClass('active');
    $('#prodiTa').addClass('active');
  } 
</script>

