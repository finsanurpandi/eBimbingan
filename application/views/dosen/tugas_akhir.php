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
              <h3 class="box-title"><?=$this->session->nama_dosen?></h3>
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

foreach ($ta as $key => $value) {
  //$detail = base_url('ta/detail_bimbingan').'/'.$this->encrypt->encode($value['id_bimbingan_ta']).'/'.$this->encrypt->encode($value['tipe']);
?>

    <tr>
      <td><?=$i?></td>
      <td>
        <strong><?=$value['npm'].' - '.$value['nama_mhs']?></strong>
        
        <?php
        //   foreach ($count as $key => $nilai) {
        //     if ($key === $value['id_bimbingan_ta']) {
        //       echo "<span class='badge badge-danger'>";
        //       echo $nilai;
        //       echo "</span>";
        //     }
        //   }
        ?>
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
      <a href="#" class="btn btn-info btn-xs btn-detail-ta" 
        data-toggle="modal" 
        data-target="#viewDetailTa"
        data-nama="<?=$value['nama_mhs']?>"
        data-npm="<?=$value['npm']?>"
        data-judul="<?=$value['judul']?>"
        data-acc="<?=date('d M. Y',strtotime($value['tgl_acc']))?>"
        >detail</a>
      <a href="#" class="btn btn-success btn-xs">bimbingan</a>
<?php
if ($jmlBimbingan !== 0) {
?>
      <a href="<?=base_url()?>dosen/timeline_bimbingan_ta/<?=$this->encrypt->encode($value['npm'])?>/<?=$this->encrypt->encode($value['id_ta'])?>" class="btn btn-warning btn-xs">timeline</a>
<?php $jmlBimbingan = 0; } else { ?>
    <a href="#" class="btn btn-warning btn-xs" disabled>timeline</a>
<?php } ?>
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
