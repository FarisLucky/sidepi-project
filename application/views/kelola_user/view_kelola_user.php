<div class="content-wrapper" id="view_kelola_user">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">Kelola User</h4>
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
                <h5 class="d-inline-block"><i class="fa fa-m"></i>Kelola Perusahaan</h5>
                <a href="<?= base_url() ?>kelolauser/tambah" class="btn btn-primary btn-sm float-right"><i
                    class="fa fa-plus"></i>Tambah</a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover" id="tbl_users">
                    <thead>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Telp</th>
                      <th>Role</th>
                      <th>Status</th>
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

<div class="modal fade" id="modal_kelola">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Ganti Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('kelolauser/changepassword/') ?>" method="post" id="modal_user">
        <input type="hidden" name="input_hidden">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>"
          value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="">Masukkan Password</label>
                  <input type="password" class="form-control" name="pw_baru" id="pw_baru">
                  <div class="form-check form-check-flat my-1">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" name="tampil_pw1"
                        onclick="showPass(this,'pw_baru')">Show Password
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Confirm Password</label>
                  <input type="password" class="form-control" name="confirm_pw_baru" id="confirm_pw_baru">
                  <div class="form-check form-check-flat my-1">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" name="tampil_pw2"
                        onclick="showPass(this,'confirm_pw_baru')">Show Password
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>