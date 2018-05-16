<!-- Tambah data bimbingan offline -->
<div class="modal fade modal-primary-custom" id="addBimbingan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Bimbingan</h4>
      </div>
      <div class="modal-body">
      <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
        <label for="npm">Tipe Bimbingan</label>
        <br>
          <label class="radio-inline">
            <input type="radio" id="offline" name="tipe" value="offline" checked> Offline
          </label>
          <label class="radio-inline">
            <input type="radio" id="online" name="tipe" value="online"> Online
          </label>
        </div>
        <hr/>

        
        <div class="form-group">
            <label for="npm">Topik Bimbingan</label>
            <input class="form-control" type="text" name="topik" required>
        </div>

        <div class="form-group">
            <label for="npm">Pembahasan</label>
            <textarea class="form-control" name="pembahasan" rows="3" required></textarea>
        </div>

        <div id="bimbinganOffline">
        <div class="form-group">
            <label for="nama">Tanggal Bimbingan</label>
            <input class="form-control" type="date" name="tgl_bimbingan" id="tgl_bimbingan"/>
            <p class="text-muted">mm/dd/yyyy</p>
        </div>

        <div class="form-group">
            <label for="nama">Waktu Bimbingan</label>
            <input class="form-control" type="time" name="waktu_bimbingan" id="waktu_bimbingan"/>
            <p class="text-muted">hh:mm PM</p>
        </div>
      </div>

      <div id="bimbinganOnline">
          <div class="form-group">
              <label for="npm">File Bimbingan</label>
              <input type="file" name="file_doc" value="error" id="file_doc">
          </div>
      </div>


      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success btn-sm" name="addBimbingan" id="btnAddBimbinganOffline">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Tambah data bimbingan online -->
<div class="modal fade modal-primary-custom" id="addCatatanHarian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Catatan Harian</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="">

        <div class="form-group">
            <label for="npm">Nama Kegiatan</label>
            <input class="form-control" type="text" name="nama_kegiatan" required>
        </div>

        <div class="form-group">
            <label for="npm">Uraian Kegiatan</label>
            <textarea class="form-control" name="uraian_kegiatan" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="nama">Tanggal Kegiatan</label>
            <input class="form-control" type="date" name="tgl_kegiatan" required/>
        </div>

        <div class="form-group">
            <label for="nama">Waktu Kegiatan</label>
            <input class="form-control" type="time" name="waktu_kegiatan" required/>
        </div>

      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success btn-sm" name="addCatatanHarian">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Tambah data bimbingan online -->
<!-- <div class="modal fade modal-primary-custom" id="addBimbinganOnline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Bimbingan Offline</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="" enctype="multipart/form-data">

        <div class="form-group">
            <label for="npm">Topik Bimbingan</label>
            <input class="form-control" type="text" name="topik">
        </div>

        <div class="form-group">
            <label for="npm">Pembahasan</label>
            <textarea class="form-control" name="pembahasan" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="npm">File Bimbingan</label>
            <input type="file" id="exampleInputFile" name="file_doc" value="error">
        </div>


      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm" name="addBimbinganOnline" id="btnAddBimbinganOnline">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div> -->

<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script>
$(document).ready(function (){
  $('#bimbinganOnline').hide();

  $('#tgl_bimbingan').prop('required', true);
  $('#waktu_bimbingan').prop('required', true);
  $('#file_doc').prop('required', false);

  $('#online').click(function(){
    $('#bimbinganOffline').hide();
    $('#bimbinganOnline').show();
    $('#tgl_bimbingan').val('');
    $('#waktu_bimbingan').val('');

    $('#tgl_bimbingan').prop('required', false);
    $('#waktu_bimbingan').prop('required', false);
    $('#file_doc').prop('required', true);
  });

  $('#offline').click(function(){
      $('#bimbinganOffline').show();
      $('#bimbinganOnline').hide();
      $('#file_doc').val('');

      $('#tgl_bimbingan').prop('required', true);
      $('#waktu_bimbingan').prop('required', true);
      $('#file_doc').prop('required', false);
  });

});

</script>