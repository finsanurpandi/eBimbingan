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
        Bimbingan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li>Aktivitas</li>
        <li><strong>Bimbingan</strong></li>
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
<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#addBimbingan"><i class="fa fa-plus"></i> Tambah Data</button>
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
      <th>Tipe Bimbingan</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>

<?php
$i = 1;
$id_ta = $this->session->id_ta;

foreach ($bimbingan as $key => $value) {
  $detail = base_url('ta/detail_bimbingan').'/'.$this->encrypt->encode($value['id_bimbingan_ta']).'/'.$this->encrypt->encode($value['tipe']);
?>

    <tr>
      <td><?=$i?></td>
      <td>
        <a href="<?=$detail?>" class=""><strong><?=$value['topik']?></strong></a>
        <br />
        <small><span class="time" id="time"><i class="fa fa-clock-o"></i> <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($value['tgl_input'])) )?></span></small>
      </td>
      <td>
      <?php

        if($value['tipe'] == 'offline')
        {
            echo "<span class='label label-primary'>".ucwords($value['tipe']);
        } else {
            echo "<span class='label label-warning'>".ucwords($value['tipe']);
        }
      
      ?>
      </td>

<?php
if($value['tipe'] == 'offline')
{
    if ($value['status_validasi'] == 0) {
        echo "<td><span class='label label-warning'>pending</span></td>";
    } else {
        echo "<td><span class='label label-success'>approved</span></td>";
    }

} else {

    if ($value['status_open'] == 0 && $value['status_validasi'] == 0) {
        echo "<td><span class='label label-danger'>unread</span></td>";
    } elseif ($value['status_open'] == 1 && $value['status_validasi'] == 0) {
        echo "<td><span class='label label-warning'>on process</span></td>";
    } elseif ($value['status_open'] == 1 && $value['status_validasi'] == 1) {
        echo "<td><span class='label label-success'>closed</span></td>";
    }

}
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
