<!-- Tambah data bimbingan offline -->
<div class="modal fade modal-primary-custom" id="addBimbinganOffline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Bimbingan Offline</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="">

        <div class="form-group">
            <label for="npm">Topik Bimbingan</label>
            <input class="form-control" type="text" name="topik">
        </div>

        <div class="form-group">
            <label for="npm">Pembahasan</label>
            <textarea class="form-control" name="pembahasan" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="nama">Tanggal Bimbingan</label>
            <input class="form-control" type="date" name="tgl_bimbingan"/>
        </div>


      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm" name="addBimbinganOffline" id="btnAddBimbinganOffline">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Tambah data bimbingan online -->
<div class="modal fade modal-primary-custom" id="addBimbinganOnline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
            <input class="form-control" type="file" name="file">
        </div>


      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-sm" name="addBimbinganOnline" id="btnAddBimbinganOnline">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
