<div class="content-wrapper" id="view_cicilan">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">Cicilan</h4>
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
                <small class="txt-semi-high">Search</small>
              </div>
            </div>
            <form id="search_form" action="<?= base_url('pembayaran/dataproses') ?>" method="post">
              <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                value="<?= $this->security->get_csrf_hash(); ?>">
              <input type="hidden" name="id_jenis" value="1">
              <div class="row">
                <div class="col-sm-8 col-lg-4">
                  <div class="form-group">
                    <select name="pilih_unit" class="form-control select-opt">
                      <option value="">-- Pilih Unit --</option>
                      <?php foreach ($unit as $key => $value) : ?>
                      <option value="<?= $value['id_unit'] ?>"><?= $value['nama_unit'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-3 col-lg-2">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                </div>
              </div>
            </form>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover table-striped" id="tbl_cicilan">
                    <thead>
                      <th>Pembayaran</th>
                      <th>Nama Unit</th>
                      <th>Status</th>
                      <th>Tagihan</th>
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