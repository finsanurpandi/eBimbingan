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
        Catatan Harian Tugas Akhir
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>dosen">Dashboard</a></li>
        <li>Tugas Akhir</li>
        <li><strong>Catatan Harian</strong></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$this->session->nama_dosen?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body box-profile">
<!-- Content Here -->

<table class="table table-border">
  <thead>
    <tr>
      <th>#</th>
      <th>NPM - Nama</th>
      <th>Jumlah Catatan Harian</th>
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
      <td><?=$i?></td>
      <td>
        <a href="<?=base_url()?>dosen/catatan_mahasiswa/<?=$this->encrypt->encode($value['npm'])?>">
        <strong><?=$value['npm'].' - '.$value['nama_mhs']?></strong>
        </a>
        
        <?php
        ?>
        <br />
        <small>Proposal approved <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($value['tgl_acc'])) )?></span></small>
    
      </td>
      <td>
<?php
$jmlCatatan = 0;
foreach ($count as $key => $nilai) {
    if ($key == $value['npm']) {
        echo "<strong>".$nilai.' Catatan</strong>';
        $jmlCatatan = $nilai;
    }
}
?>
      </td>
      <td>
        <a href="<?=base_url()?>dosen/catatan_mahasiswa/<?=$this->encrypt->encode($value['npm'])?>" class="btn btn-success btn-xs">detail </a>
        <a href="<?=base_url()?>dosen/timeline_catatan_harian/<?=$this->encrypt->encode($value['npm'])?>" class="btn btn-warning btn-xs">timeline</a>
      </td>

<?php
$i++;
?>

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
