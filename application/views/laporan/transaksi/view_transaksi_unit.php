<div class="content-wrapper" id="laporan_transaksi">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Laporan Transaksi Unit</h4>
            <img id="logo_perusahaan" width="50px"
              src="<?php echo base_url().'assets/uploads/images/properti/'.$img->logo_perusahaan ?>" class="float-right"
              alt="">
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <small class="txt-semi-high font-weight-medium">Filter</small>
            <a href="" class="text-primary float-right" data-target="#filter" data-toggle="collapse"><i
                class="fa fa-circle"></i></a>
          </div>
        </div>
        <hr>
        <div class="collapse" id="filter">
          <div class="border-left-color">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="properti_id">Pilih Properti</label>
                  <select name="id_properti" id="id_properti" class="form-control text-center select-opt"
                    onchange="changeElement(this,'POST','<?= base_url('listtransaksi/getunit') ?>','<?= $this->security->get_csrf_hash() ?>','#id_unit')">
                    <option value=""> -- Properti -- </option>
                    <?php foreach ($properti as $key => $value) { ?>
                    <option value="<?= $value->id_properti ?>"><?= $value->nama_properti ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="unit_id">Pilih Unit</label>
                  <select name="id_unit" id="id_unit" class="form-control text-center select-opt">
                    <option value=""> -- Unit -- </option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <input type="date" name="tgl_mulai" class="form-control" id="tgl_mulai">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="date" name="tgl_akhir" class="form-control" id="tgl_akhir">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary float-right" id="search_kontrol"
                  onclick="searchData(['id_properti','id_unit','tgl_mulai','tgl_akhir'],'<?= $this->security->get_csrf_hash() ?>','#tbl_list','<?= base_url('listtransaksi/dataproses') ?>'),updateTransaksi('id_properti')"><i
                    class="fa fa-search"></i> Cari</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <h5 class="d-inline">List Semua Transaksi Unit</h5>
            <?php if ($_SESSION['id_akses'] == 1) { ?>
            <a href="<?= base_url('listunlocktransaksi') ?>" class="btn btn-icons btn-inverse-warning float-right"><i
                class="fa fa-unlock"></i></a>
            <?php } ?>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="tbl_list">
                <thead class="thead-light">
                  <tr>
                    <th>No SPR</th>
                    <th>Konsumen</th>
                    <th>Unit</th>
                    <th>Tanggal Transaksi</th>
                    <th>Status Transaksi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
        <hr>
        <div class="border-right-color">
          <div class="row text-right">
            <div class="col-md-12">
              <small class="txt-normal">Sementara</small>
              <small class="txt-normal-b" id="s">: &emsp;<?= $sementara['sementara'] ?></small>
            </div>
            <div class="col-md-12">
              <small class="txt-normal">Progress</small>
              <small class="txt-normal-b" id="p">: &emsp;<?= $progress['progress'] ?></small>
            </div>
            <div class="col-md-12">
              <small class="txt-normal">Selesai</small>
              <small class="txt-normal-b" id="sl">: &emsp;<?= $selesai['selesai'] ?></small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>