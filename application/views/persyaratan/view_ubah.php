<div class="content-wrapper" id="ubah_persyaratan">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Ubah Persyaratan</h4>
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
                <a href="<?= base_url() ?>persyaratankonsumen" class=" btn btn-dark btn-sm float-right"><i
                    class="fa fa-arrow-circle-left"></i> Kembali</a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="alert alert-info py-3">
                  <small class="txt-semi-high border-right border-info">ID Card :
                    <?= strtoupper($konsumen['id_type']).' '.$konsumen['id_card'] ?></small>
                  <small class="txt-semi-high">Nama Lengkap : <?= ucwords($konsumen['nama_lengkap']) ?></small>
                </div>
              </div>
            </div>
            <form action="<?= base_url('persyaratankonsumen/coreUbah') ?>" method="POST">
              <input type="hidden" name="konsumen" value="<?= $konsumen['id_konsumen'] ?>">
              <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                value="<?= $this->security->get_csrf_hash(); ?>">
              <div class="row">
                <div class="col-sm-12">
                  <div class="alert alert-primary">
                    <h5>Pilih Persyaratan</h5>
                    <hr>
                    <div class="row">
                      <?php foreach ($persyaratan as $key => $value) { 
                      $check = getKelompok('persyaratan_konsumen',['kelompok_persyaratan'=>$value['id_sasaran'],'id_konsumen'=>$konsumen['id_konsumen']]);
                    ?>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" name="persyaratan[]"
                                value="<?= $value['id_sasaran'] ?>" <?= $check ?>><?php echo $value['nama_kelompok'] ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-success mx-2"><i class="fa fa-save"></i> Simpan</button>
                  <button type="reset" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>