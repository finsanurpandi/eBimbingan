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

    function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }


?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1><?=$mhs['npm'].' - '.$mhs['nama_mhs']?></h1>
      <h1>
        Timeline
        <small>Catatan Harian</small>
      </h1>
      <a href="<?=base_url()?>dosen/catatan_harian" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>
      <br/><br/>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>dosen"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Tugas Akhir</li>
        <li><a href="<?=base_url()?>dosen/catatan_harian"?>Catatan Harian</a></li>
        <li>Timeline</li>
        <li class="active"><strong><?=$mhs['npm']?></strong></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- row -->
      <div class="row">
        <div class="col-md-12">
        <!-- The time line -->
        <ul class="timeline">
<?php
if (count($catatan_harian) > 0) {
        foreach ($catatan_harian as $key => $value) {
          $detail = base_url('dosen/detail_catatan').'/'.$this->encrypt->encode($mhs['npm']).'/'.$this->encrypt->encode($value['id_catatan_harian']);
?>

          
            <!-- timeline time label -->
            <li class="time-label">
                <span class='bg-green'>
                  <?=date("d M. Y", strtotime($value['waktu_kegiatan']))?>
                </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
            <i class="fa fa-pencil bg-yellow"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($value['waktu_kegiatan'])) )?></span>

                <h3 class="timeline-header"><a href="<?=$detail?>"><?=$value['nama_kegiatan']?></a></h3>

                <div class="timeline-body">
                <?=limit_text($value['uraian_kegiatan'],40)?>
                </div>
                <div class="timeline-footer">
                  <a class='btn btn-primary btn-xs' href="<?=$detail?>">Read more</a>
                </div>
              </div>
            </li>
            <!-- END timeline item -->
<?php 
        } 
} else {

?>
            <!-- timeline item -->
            <li>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">Anda belum pernah mengisi catatan harian</h3>
              </div>
            </li>
            <!-- END timeline item -->

<?php } ?>
            


            
            

            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <hr/> <a href="<?=base_url()?>dosen/catatan_harian" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>


            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
