<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tugas Akhir Mahasiswa
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>prodi">Dashboard</a></li>
        <li>Tugas Akhir</li>
        <li><strong>Mahasiswa</strong></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Program Studi Teknik Informatika</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body box-profile">
<!-- Content Here -->
<br/>
<br />

<?php
  if (@$this->session->flashdata('success') == true) {
?>
    <div class="alert alert-success">Data berhasil ditambahkan!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <br/>
    </div>

<?php
  }
?>

<table id="tbl-mhs" class="table table-hover ui-corner-tr ui-helper-clearfix">
  <thead>
    <tr>
      <th>#</th>
      <th>NPM</th>
      <th>Nama</th>
      <th>Judul</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>

<?php
$i = 1;

foreach ($ta as $key => $value) {
  //$detail = base_url('ta/detail_bimbingan').'/'.$this->encrypt->encode($value['id_bimbingan_ta']).'/'.$this->encrypt->encode($value['tipe']);
?>

    <tr>
        <td><?=$i++?></td>
        <td><?=$value['npm']?></td>
        <td><?=$value['nama_mhs']?></td>
        <td><?=$value['judul']?></td>
        <td>
<?php
if ($value['status'] == 0) {
    echo "<span class='label label-danger'>Tdk Aktif</span>";
} elseif ($value['status'] == 1) {
    echo "<span class='label label-warning'>Proses</span>";
} elseif ($value['status'] == 2) {
    echo "<span class='label label-success'>Lulus</span>";
}
?>
        </td>
    </tr>
<?php } ?>

  </tbody>
</table>
<!-- End of content -->
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <script>
    

  </script>
