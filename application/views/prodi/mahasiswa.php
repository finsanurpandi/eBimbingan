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
<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#addMhs"><i class="fa fa-plus"></i> Data MHS</button>
<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#addTa"><i class="fa fa-plus"></i> Data TA</button>
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
      <th>Angkatan</th>
      <th>ACC</th>
      <th>Aksi</th>
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
        <td><?=$value['tahun_masuk']?></td>
        <td>
<?php
if ($value['tgl_acc'] !== null) {
  echo date('d M. Y', strtotime($value['tgl_acc']));  
} else {
  echo "<button id='btn-acc-ta' type='button' class='btn btn-primary btn-xs'>cetak</button>&nbsp;";
  echo "<button id='btn-acc-ta' type='button' class='btn btn-danger btn-xs' data-toggle='modal' data-target='#accTa' data-npm='".$value['npm']."' data-nama='".$value['nama_mhs']."'>acc</button>";
}

?>
        </td>
        <td>
        <button id="show-detail-ta" class='btn btn-info btn-xs' 
        data-toggle="modal" 
        data-target="#viewDetailTa"
        data-nama="<?=$value['nama_mhs']?>"
        data-npm="<?=$value['npm']?>"
        data-judul="<?=$value['judul']?>"
        data-acc="<?=date('d M. Y H:i:s',strtotime($value['tgl_acc']))?>"
        >detail</button>
        <button class='btn btn-success btn-xs'>bimbingan</button>
        <button class='btn btn-warning btn-xs'>timeline</button>
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
