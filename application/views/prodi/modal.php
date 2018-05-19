<!-- Tambah data mahasiswa -->
<div class="modal fade modal-primary-custom" id="addMhs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Mahasiswa</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="">

        <div id="npm-prodi-group" class="form-group">
            <label for="npm">NPM</label>
            <input class="form-control" type="text" name="npm" id="npm-prodi" onchange="check_npm();" required>
            <div id="status-npm"></div>
        </div>

        <div class="form-group">
            <label for="npm">Nama Mahasiswa</label>
            <input class="form-control" name="nama_mhs" required>
        </div>

        <div class="form-group">
            <label for="nama">Tahun Masuk</label>
            <input class="form-control" type="year" name="tahun_masuk" required/>
        </div>

      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success btn-sm" id="btn-add-mhs" name="addMhs">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Tambah data tugas akhir -->
<div class="modal fade modal-primary-custom" id="addTa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Tugas Akhir</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="">

        <div class="form-group">
            <label for="npm">NPM</label>
            <select class="form-control select-add-ta" style="width:100%;" name="npm" required>
                <option></option>
<?php
    foreach ($mhs as $key => $value) {
        echo "<option value='".$value['npm']."'>".$value['npm']." - ".$value['nama_mhs']."</option>";
    }
?>
            </select>
        </div>

        <div class="form-group">
            <label for="npm">Dosen Pembimbing</label>
            <select class="form-control select-add-ta" style="width:100%;" name="nidn" required>
                <option></option>
<?php
    foreach ($dosen as $key => $value) {
        echo "<option value='".$value['nidn']."'>".$value['nidn']." - ".$value['nama_dosen']."</option>";
    }
?>
            </select>
        </div>

        <div class="form-group">
            <label for="npm">Judul</label>
            <textarea class="form-control" name="judul" rows="3"></textarea>
        </div>


      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success btn-sm" name="addTa" id="btnAddTa">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal ACC TA -->
<div class="modal fade modal-primary-custom" id="accTa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">ACC Tugas Akhir <span id="npm-nama"></span></h4>
      </div>
      <div class="modal-body">
        <h4>ACC Today???</h4>
        <button type="button" id="acc-not-today" class="btn btn-default btn-xs">Acc on another day</button>
        <form method="post" action="">

        <div id="tgl-acc-prodi" class="form-group">
            <label for="npm">Tanggal ACC</label>
            <input class="form-control" type="date" name="tgl_acc">
        </div>

      </div>
      <div class="modal-footer">
        <input type="hidden" id="acc-npm" name="npm"/>
        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success btn-sm" id="btn-add-mhs" name="accTa">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- view Detail Tugas Akhir -->
<div class="modal fade modal-info-custom" id="viewDetailTa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Data Tugas Akhir Mahasiswa</h4>
      </div>
      <div class="modal-body">
      <strong>Nama</strong>
      <p class="text-muted nama">
      
      </p>
      <hr>

      <strong>NPM</strong>
      <p class="text-muted npm">
    
      </p>
      <hr>

      <strong>Judul Tugas Akhir</strong>
      <p class="text-muted judul">
      <em>""</em>
      </p>
      <hr>

      <strong>Tanggal Acc Proposal</strong>
      <p class="text-muted acc">
      
      </p>

      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-danger btn-xs" data-dismiss="modal"><i class="fa fa-remove"></i> close</button>
        </form>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal LOGOUT -->
<div class="modal fade modal-danger-custom" id="logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Logout</h4>
      </div>
      <div class="modal-body">
        <h4>Are you sure want to logout?</h4>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <a href="<?=base_url()?>login/logout/prodi" class="btn btn-danger btn-flat btn-sm">Log out</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script>
$(document).ready(function (){
  var baseurl = "<?=base_url()?>";
    
  $('#tgl-acc-prodi').hide();

  $('#acc-not-today').click(function(){
    $('#tgl-acc-prodi').slideToggle();
  });

  $(document).on('click', '#btn-acc-ta', function(e){
    var npm = $(this).data('npm');
    var nama = $(this).data('nama');

    $('#acc-npm').val(npm);
    $('#npm-nama').html(' ('+npm+' - '+nama+')');
    
  });

  $(document).on('click', '#show-detail-ta', function(e){
    var nama = $(this).data('nama');
    var npm = $(this).data('npm');
    var judul = $(this).data('judul');
    var acc = $(this).data('acc');

    $('.nama').html(nama);
    $('.npm').html(npm);
    $('.judul').html(judul);
    $('.acc').html(acc);
    
  });

});



</script>