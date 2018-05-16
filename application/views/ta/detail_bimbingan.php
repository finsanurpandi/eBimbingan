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

    $panel = '';
    if ($bimbingan[0]['status_validasi'] == 0) {
      $panel = 'warning';
    } elseif ($bimbingan[0]['status_validasi'] == 1) {
      $panel = 'success';
    } elseif ($bimbingan[0]['status_validasi'] == 2) {
      $panel = 'danger';
    }

?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bimbingan <?=ucwords($tipe)?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li>Aktivitas</li>
        <li><a href="#">Bimbingan <?=ucwords($tipe)?></a></li>
        <li><strong>Detail</strong></li>
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

<div class="panel panel-<?=$panel?>">
  <div class="panel-heading">
    <h3 class="panel-title"><?=$bimbingan[0]['topik']?> <small> <span class="time pull-right"><i class="fa fa-clock-o"></i> <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($bimbingan[0]['tgl_input'])) )?></span></small></h3>
  </div>
  <div class="panel-body">
    <?=$bimbingan[0]['pembahasan']?>
  </div>
</div>

<?php
if ($bimbingan[0]['status_validasi'] == 2 && $tipe == 'offline') {
?>

<!-- komentar decline -->

<div class="row">
  <div class="col-md-1">
    <img src="<?=base_url()?>assets/img/profiles/<?=$komentar[0]['img_profile']?>" class="img-rounded img-responsive pull-right" width="60px" height="60px">
  </div>
  <div class="col-md-11">
    <div class="well well-sm">
      <strong><?=$komentar[0]['pengirim']?></strong>
      <br/>
      <?=$komentar[0]['komentar']?>
      <br />
      <small><i class="fa fa-clock-o"></i> <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($komentar[0]['datetime_sent'])) )?></small>
    </div>
  </div>
</div>

<?php } ?>

<?php
if ($tipe === 'online') {
?>

<!-- Bagian ketika bimbingan online  -->
<div class="well well-sm">
<a href="<?=base_url()?>download/file/<?=$this->encrypt->encode($bimbingan[0]['file'])?>" class="" target="_blank"><i class="fa fa-file-word-o"></i> <?=$bimbingan[0]['file']?></a>
</div>
<hr/>

<!-- Kolom komentar -->
<?php
if (!empty($komentar))
{
for ($i=0; $i < count($komentar); $i++) { 
?>
<div class="row">
  <div class="col-md-1">
    <img src="<?=base_url()?>assets/img/profiles/<?=$komentar[$i]['img_profile']?>" class="img-rounded img-responsive pull-right" width="60px" height="60px">
  </div>
  <div class="col-md-11">
    <div class="well well-sm">
      <strong><?=$komentar[$i]['pengirim']?></strong>
      <br/>
      <?=$komentar[$i]['komentar']?>
      <br />
      <small><i class="fa fa-clock-o"></i> <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($komentar[$i]['datetime_sent'])) )?></small>
    </div>
    <?php
    if (!empty($komentar[$i]['file'])) {
    ?>
    <div class="well well-sm">
    <a href="<?=base_url()?>download/file/<?=$this->encrypt->encode($komentar[$i]['file'])?>" class="" target="_blank"><i class="fa fa-file-word-o"></i> <?=$komentar[$i]['file']?></a>
    </div>
    <?php } ?>
  </div>
</div>
<?php } }?>
<!-- End of kolom komentar -->

<hr/>

<?php
if ($bimbingan[0]['status_validasi'] == 1) {
  echo "<div class='well well-sm'><strong>";
  echo "The topis is closed. Sorry, you cannot add comment anymore...";
  echo "</strong></div>";
} else {
?>
<div class="row">
  <div class="col-md-1">
    <img src="<?=base_url()?>assets/img/profiles/<?=$user['img_profile']?>" class="img-rounded img-responsive pull-right" width="60px" height="60px">
  </div>
  <div class="col-md-11">
    <!-- <input class="form-control" type="text" placeholder="Type a comment"> -->
    <ul class="nav nav-tabs">
      <li role="presentation" class="active"><a href="#">Write comment</a></li>
    </ul>
    <form method="post" action="" enctype="multipart/form-data">
    <textarea class="form-control" rows="3" name="komentar" required></textarea>
    <input class="form-control input-sm btn btn-default btn-sm" value="attach file" type="file" name="file_doc" />
    <br>
    <input class="btn btn-success btn-xs" value="submit" type="submit" name="addComment"/>
    </form>
  </div>
</div>
<?php } ?>
<hr/>
<!-- bagian akhir dari bimbingan online -->

<?php } ?>
<!-- <a href="<?=base_url()?>ta/bimbingan" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a> -->
<a href="<?=base_url($this->session->url)?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>
<!-- End of content -->
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
