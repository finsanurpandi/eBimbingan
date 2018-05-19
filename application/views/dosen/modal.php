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

<!-- Decline Bimbingan -->
<div class="modal modal-danger-custom fade" id="declineBimbingan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"><i class="fa fa-remove"></i> Decline</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure want to decline this subject?</p>
      </div>
      <div class="modal-footer">
        <form method="post">
          <input type="hidden" name="komentar" id="commentValue">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
          <button class="btn btn-danger btn-sm" name="decline">Decline</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
        <a href="<?=base_url()?>login/logout/dosen" class="btn btn-danger btn-flat btn-sm">Log out</a>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script>
$(document).on('click', '.btn-detail-ta', function(e){
    var nama = $(this).data('nama');
    var npm = $(this).data('npm');
    var judul = $(this).data('judul');
    var acc = $(this).data('acc');

    $('.nama').html(nama);
    $('.npm').html(npm);
    $('.judul').html(judul);
    $('.acc').html(acc);
    
})

</script>