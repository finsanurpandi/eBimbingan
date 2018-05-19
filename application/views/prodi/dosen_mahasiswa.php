<?php

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bimbingan Tugas Akhir
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>dosen">Dashboard</a></li>
        <li><strong>Tugas Akhir</strong></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$dosen['nidn'].' - '.$dosen['nama_dosen']?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body box-profile">
<!-- Content Here -->

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

<table class="table table-border">
  <thead>
    <tr>
      <th>#</th>
      <th>NPM - Nama</th>
      <th>Jumlah Bimbingan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>

<?php
$i = 1;

foreach ($mhs as $key => $value) {
  //$detail = base_url('ta/detail_bimbingan').'/'.$this->encrypt->encode($value['id_bimbingan_ta']).'/'.$this->encrypt->encode($value['tipe']);
?>

    <tr>
      <td><?=$i?></td>
      <td>
        <a href="<?=base_url()?>dosen/bimbingan/<?=$this->encrypt->encode($value['id_ta'])?>/<?=$this->encrypt->encode($value['npm'])?>">
        <strong><?=$value['npm'].' - '.$value['nama_mhs']?></strong>
        </a>
        <br />
        <small>Proposal approved <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($value['tgl_acc'])) )?></span></small>
    
      </td>
      <td>
<?php
$jmlBimbingan = 0;
foreach ($count as $key => $nilai) {
    if ($key == $value['npm']) {
        echo "<strong>".$nilai.'x</strong>';
        $jmlBimbingan = $nilai;
    }
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
        <a href="<?=base_url()?>dosen/bimbingan/<?=$this->encrypt->encode($value['id_ta'])?>/<?=$this->encrypt->encode($value['npm'])?>" class="btn btn-success btn-xs">bimbingan 
        </a>


      
      <a href="<?=base_url()?>dosen/timeline_bimbingan_ta/<?=$this->encrypt->encode($value['npm'])?>/<?=$this->encrypt->encode($value['id_ta'])?>" class="btn btn-warning btn-xs">timeline</a>

      </td>

<?php
$i++;
?>

    </tr>
<?php } ?>

  </tbody>
</table>
<hr/>
<a href="<?=base_url()?>prodi/dosen" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> kembali</a>
<!-- End of content -->
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
