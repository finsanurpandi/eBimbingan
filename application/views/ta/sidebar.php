<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url()?>assets/img/profiles/<?=$user['img_profile']?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?=$this->session->nama_mhs?></p>
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
      <li id="taDashboard">
        <a href="<?=base_url()?>ta">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li id="taDetail">
        <a href="<?=base_url()?>ta/detail">
          <i class="fa fa-bandcamp"></i> <span>Tugas Akhir</span>
        </a>
      </li>
      <li id="taAktivitas" class="treeview">
        <a href="#">
          <i class="fa fa-th-list"></i> <span>Aktivitas</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li id="taBimbingan"><a href="<?=base_url()?>ta/bimbingan"><i class="fa fa-circle-o"></i> Bimbingan</a></li>
          <li id="taCatatanHarian"><a href="<?=base_url()?>ta/catatan_harian"><i class="fa fa-circle-o"></i> Catatan Harian</a></li>
          <!-- <li><a href="<?=base_url()?>ta/bimbingan_online"><i class="fa fa-circle-o"></i> Bimbingan Online</a></li> -->
        </ul>
      </li>
      <li id="taTimeline" class="treeview">
        <a href="#">
          <i class="fa fa-clock-o"></i> <span>Timeline</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li id="taTimelineBimbingan"><a href="<?=base_url()?>ta/timeline_bimbingan"><i class="fa fa-circle-o"></i> Bimbingan</a></li>
          <li id="taTimelineCatatanHarian"><a href="<?=base_url()?>ta/timeline_catatan_harian"><i class="fa fa-circle-o"></i> Catatan Harian</a></li>
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

  function taClearMenu(){
    $('#taDashboard').remove('.active');
    $('#taDetail').remove('.active');
    $('#taBimbingan').remove('.active');
    $('#taCatatanHarian').remove('.active');
    $('#taTimelineBimbingan').remove('.active');
    $('#taTimelineCatatanHarian').remove('.active');

    $('#taAktivitas').remove('.active');
    $('#taTimeline').remove('.active');
  }

  if (uri == '') {
    taClearMenu();
    $('#taDashboard').addClass('active');
  } else if (uri == 'detail') {
    $('#taDetail').addClass('active');
  } else if (uri == 'bimbingan' || uri == 'detail_bimbingan') {
    $('#taAktivitas').addClass('active');
    $('#taBimbingan').addClass('active');
  } else if (uri == 'catatan_harian' || uri == 'detail_catatan_harian') {
    $('#taAktivitas').addClass('active');
    $('#taCatatanHarian').addClass('active');
  } else if (uri == 'timeline_bimbingan') {
    $('#taTimeline').addClass('active');
    $('#taTimelineBimbingan').addClass('active');
  } else if (uri == 'timeline_catatan_harian') {
    $('#taTimeline').addClass('active');
    $('#taTimelineCatatanHarian').addClass('active');
  }
</script>

