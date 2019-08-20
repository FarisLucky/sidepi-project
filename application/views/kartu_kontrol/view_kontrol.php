<div class="content-wrapper" id="view_kontrol">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Kartu Kontrol </h4>
            <img id="logo_perusahaan" width="50px"
              src="<?php echo base_url().'assets/uploads/images/properti/'.$img->logo_perusahaan ?>" class="float-right"
              alt="">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-10">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="properti_id">Pilih Properti</label>
                  <select name="id_properti" id="id_properti" class="form-control text-center"
                    onchange="changeElement(this,'post','<?= base_url('kartukontrol/getunit/') ?>','<?= $this->security->get_csrf_hash() ?>','#id_unit')">
                    <option value=""> -- Properti -- </option>
                    <?php foreach ($properti as $key => $value) { ?>
                    <option value="<?= $value->id_properti ?>"><?= $value->nama_properti ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="unit_id">Pilih Unit</label>
                  <select name="id_unit" id="id_unit" class="form-control text-center">
                    <option value=""> -- Unit -- </option>
                  </select>
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <input type="date" name="tgl_mulai" class="form-control" id="tgl_mulai">
                </div>
              </div>
              <div class="col-md-3 col-sm-6">
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="date" name="tgl_akhir" class="form-control" id="tgl_akhir">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-2 pt-4">
            <button type="button"
              onclick="searchData(['id_properti','id_unit','tgl_mulai','tgl_akhir'],'<?= $this->security->get_csrf_hash() ?>','#tbl_kontrol','<?= base_url('kartukontrol/dataproses') ?>')"
              class="btn btn-primary mr-2" id="search_kontrol"><i class="fa fa-search"></i>Search</button>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <table class="table" id="tbl_kontrol">
              <thead>
                <tr>
                  <th>No SPR</th>
                  <th>Nama Konsumen</th>
                  <th>unit</th>
                  <th>Tanda Jadi</th>
                  <th>Uang Muka</th>
                  <th>Cicilan</th>
                  <th>Status Transaksi</th>
                  <th>Tgl Transaksi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>