<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tugas Akhir
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Tugas Akhir Mahasiswa</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body box-profile">
<!-- Content Here -->
<strong>Nama</strong>
<p class="text-muted">
<?=$ta['nama_mhs']?>
</p>
<hr>

<strong>NPM</strong>
<p class="text-muted">
<?=$ta['npm']?>
</p>
<hr>

<strong>Judul Tugas Akhir</strong>
<p class="text-muted">
<em>"<?=$ta['judul']?>"</em>
</p>
<hr>

<strong>Dosen Pembimbing</strong>
<p class="text-muted">
<?=$ta['nidn']." - ".$ta['nama_dosen']?>
</p>
<hr>

<strong>Tanggal Acc Proposal</strong>
<p class="text-muted">
<?=$ta['tgl_acc']?>
</p>
<hr>
<!-- End of content -->
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
