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
      <h1><?=$ta['npm'].' - '.$ta['nama_mhs']?></h1>
      <h1>
        Timeline
        <small>Bimbingan</small>
      </h1>
      <a href="<?=base_url()?>dosen/ta" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>
      <br/><br/>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>dosen"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?=base_url()?>dosen/ta">Tugas Akhir</a></li>
        <li class="active"><strong>Timeline</strong></li>
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
if (count($bimbingan) > 0) {

        foreach ($bimbingan as $key => $value) {
          $detail = base_url('dosen/detail_bimbingan').'/'.$this->encrypt->encode($ta['npm']).'/'.$this->encrypt->encode($value['id_bimbingan_ta']).'/'.$this->encrypt->encode($value['tipe']);
?>

          
            <!-- timeline time label -->
            <li class="time-label">
            <?php
              if ($value['status_validasi'] == 0) {
            ?>
                  <span class="bg-red">
            <?php 
              } else {
                echo "<span class='bg-green'>";
              }
            ?>
                  <?=date("d M. Y", strtotime($value['tgl_bimbingan']))?>
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
            <?php 
              if ($value['tipe'] == 'offline') {
            ?>
              <i class="fa fa-pencil bg-blue"></i>
            
            <?php
              } else {
                echo "<i class='fa fa-comments bg-yellow'></i>";
              }
            ?>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($value['tgl_bimbingan'])) )?></span>

                <h3 class="timeline-header"><a href="<?=$detail?>"><?=$value['topik']?></a> <em><?=$value['tipe']?></em></h3>

                <div class="timeline-body">
                <?=limit_text($value['pembahasan'], 30)?>
                </div>
                <div class="timeline-footer">
                  <?php
                    if ($value['tipe'] === 'online') {
                      echo "<a class='btn btn-warning btn-xs' href='".$detail."'>See Conversation</a>";
                    } else {
                      echo "<a class='btn btn-primary btn-xs' href='".$detail."'>Read more</a>";
                    }
                    
                  ?>
                  
                </div>
              </div>
            </li>
            <!-- END timeline item -->
<?php } }?>
            


            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-green">
                    <?=date("d M. Y", strtotime($ta['tgl_acc']))?>
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-heart bg-aqua"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <?=time_elapsed_string( date('Y:m:d H:i:s', strtotime($ta['tgl_acc'])) )?></span>

                <h3 class="timeline-header no-border">Proposal Disetujui</h3>

                <div class="timeline-body">
                <img src="<?=base_url()?>assets/img/rocket-launch.jpg" class="img img-responsive" width="300px"/>
                </div>
              </div>
            </li>
            <!-- END timeline item -->

            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <hr><a href="<?=base_url()?>dosen/ta" class="btn btn-default btn-xs"><i class="fa fa-arrow-left"></i> Kembali</a>

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
