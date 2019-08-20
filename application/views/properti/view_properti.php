<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">Kelola Properti</h4>
                <img id="logo_perusahaan" width="50px"
                  src="<?php echo base_url().'assets/uploads/images/properti/'.$img->logo_perusahaan ?>"
                  class="float-right" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <h5 class="d-inline-block"><i class="fa fa-m"></i>Table Properti</h5>
                <a href="<?= base_url() ?>properti/tambah" class="btn btn-sm btn-primary float-right"><i
                    class="fa fa-plus"></i> Tambah</a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover" id="tbl_properti">
                    <thead>
                      <th>Nama</th>
                      <th>Luas Tanah</th>
                      <th>Bank</th>
                      <th>Foto</th>
                      <th>Aksi</th>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_dialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url() ?>properti/rab" method="POST" id="form_modal">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
          value="<?= $this->security->get_csrf_hash() ?>">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group name">
                <label>Nama RAB</label>
                <input type="text" class="form-control" name="txt_nama">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group">
                <button type="submit" class="btn btn-success">Tambah</button>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" name="properti">
        <input type="hidden" name="rab">
      </form>
    </div>
  </div>
</div>