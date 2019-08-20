<div class="content-wrapper" id="view_surat_kpr">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">Surat SP3K</h4>
                <img id="logo_perusahaan" width="50px"
                  src="<?= base_url().'assets/uploads/images/properti/'.$img->logo_perusahaan ?>" class="float-right"
                  alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <form action="<?php echo base_url('pembayaran/coresuratkpr') ?>" method="post" enctype="multipart/form-data"
      id="kpr_form">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">
      <input type="hidden" name="input_hidden" value="<?= $id ?>">
      <div class="row mt-3">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <a href="<?= base_url("pembayaran/cicilan") ?>" class="btn btn-dark float-right"><i
                      class="fa fa-arrow-circle-left"></i>
                    Kembali</a>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12">
                  <label for="">Upload Surat</label>
                </div>
              </div>
              <br>
              <div class="row justify-content-md-center">
                <div class="col-sm-6">
                  <?php if ($image->sp3k == "") { ?>
                  <small class="txt-semi-high ml-3 p-2 border border-dark">Foto Kosong</small>
                  <?php } else { ?>
                  <img id="foto_sp3k" src="<?= base_url("assets/uploads/images/kpr/".$image->sp3k) ?>"
                    style="width:100%">
                  <?php } ?>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <input type="file" name="upload" class="form-control">
                    <small class="text-danger"><?php echo ($error != null) ? $error : "" ; ?></small>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                  <button type="reset" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>