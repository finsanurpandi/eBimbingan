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
        Profile Settings
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li><strong>Settings</strong></li>
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
    <div class="alert alert-success">Data berhasil di-update!
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

<?php
  }
?>

<form role="form" method="post" enctype="multipart/form-data">
              
    <div class="form-group">
        <label for="exampleInputFile">Picture Image</label>
            <div class="row">
                <div class="col-md-2">
                    <img src="<?=base_url('assets/img/profiles/'.$user['img_profile'])?>" class="profile-user-img img-responsive img-circle" alt="User Image">
                </div>
                <div class="col-md-8">
                    <input type="file" id="exampleInputFile" name="gambar">
                    <input type="hidden" name="path" value="<?=$user['img_profile']?>">
                    <p class="help-block">- Disarankan menggunakan gambar dengan ratio 1:1</p>
                    <p class="help-block">- Kosongkan jika tidak akan mengganti picture image</p>
                    <button type="submit" class="btn btn-success btn-xs" name="updateProfil"><i class="fa fa-recycle"></i> Update</button>
                </div>
            </div>                          
    </div>
    <hr/>

</form>



<a href="<?=base_url()?>ta" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>
<!-- End of content -->
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
