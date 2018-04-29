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
        Bimbingan Offline
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li>Aktivitas</li>
        <li><strong>Bimbingan Offline</strong></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$this->session->npm.' - '.$this->session->nama_mhs?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body box-profile">
<!-- Content Here -->
<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#addBimbinganOffline"><i class="fa fa-plus"></i> Tambah Data</button>
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

<table class="table table-border">
  <thead>
    <tr>
      <th>#</th>
      <th>Topik</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>

<?php
$i = 1;
$id_ta = $this->session->id_ta;

foreach ($bimbinganOffline as $key => $value) {
  $detail = base_url('ta/detail_bimbingan_offline').'/'.$this->encrypt->encode($value['id_bimbingan_ta']);
?>

    <tr>
      <td><?=$i?></td>
      <td>
        <a href="<?=$detail?>" class=""><strong><?=$value['topik']?></strong></a>
        <br />
        <small><span class="time" id="time"><i class="fa fa-clock-o"></i> <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($value['tgl_input'])) )?></span></small>
      </td>
<?php
if ($value['status_validasi'] == 0) {
?>
      <td><span class="label label-warning">pending</span></td>

<?php
} else {
?>

      <td><span class="label label-success">approved</span></td>

<?php
}
$i++;
?>
    </tr>
<?php } ?>
    <!-- <tr>
      <td>2</td>
      <td><strong>Bimbingan 2</strong>
        <br />
        <small><span class="time"><i class="fa fa-clock-o"></i> 11 days ago</span></small>
      </td>
      <td><span class="label label-success">approved</span></td>
    </tr>
    <tr>
      <td>3</td>
      <td><strong>Bimbingan 3</strong>
        <br />
        <small><span class="time"><i class="fa fa-clock-o"></i> 15 days ago</span></small>
      </td>
      <td><span class="label label-danger">declined</span></td>
    </tr> -->
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
