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
        Dosen Pembimbing Tugas Akhir
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>prodi">Dashboard</a></li>
        <li>Tugas Akhir</li>
        <li><strong>Dosen Pembimbing</strong></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$this->session->nama_user?></h3>
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

<table class="table table-border table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>NIDN - Nama</th>
      <th>Jumlah Bimbingan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>

<?php
$i = 1;

foreach ($dosen as $key => $value) {
?>

    <tr>
      <td><?=$i++?></td>
      <td>
        <a href="<?=base_url()?>prodi/dosen_mahasiswa/<?=$this->encrypt->encode($value['nidn'])?>">
        <strong><?=$value['nidn'].' - '.$value['nama_dosen']?></strong>
        </a>
      </td>
      <td>
        <?php
        if($value['num'] == 0){
            echo "<span class='label label-success'>".$value['num']." mahasiswa</span>";
        } elseif ($value['num'] > 0 && $value['num'] <= 6) {
            echo "<span class='label label-info'>".$value['num']." mahasiswa</span>";
        } elseif ($value['num'] > 6 && $value['num'] <= 8) {
            echo "<span class='label label-warning'>".$value['num']." mahasiswa</span>";
        } elseif ($value['num'] > 8) {
            echo "<span class='label label-danger'>".$value['num']." mahasiswa</span>";
        }
        ?>
      </td>
      <td>
        <a href="<?=base_url()?>prodi/dosen_mahasiswa/<?=$this->encrypt->encode($value['nidn'])?>" class="btn btn-primary btn-xs"> 
        detail
        </a>
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
