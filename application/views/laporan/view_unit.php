<div class="content-wrapper" id="laporan_view_unit">
  <div class="container">
    <form action="<?= base_url('laporanunit/printunit') ?>" method="post">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
        value="<?= $this->security->get_csrf_hash(); ?>">
      <div class="card">
        <div class="card-body p-4">
          <div class="row">
            <div class="col-sm-12">
              <h4 class="dark txt_title d-inline-block mt-2">Laporan Unit</h4>
              <a data-toggle="collapse" href="#collapseOne" class="text-primary float-right"><span
                  class="fa fa-circle"></span></a>
            </div>
          </div>
          <hr>
          <div class="collapse show" id="collapseOne">
            <?php if ($_SESSION['id_akses'] != '1') { ?>
            <div class="row">
              <div class="col-sm-12 text-center">
                <img src="<?= base_url('assets/uploads/images/properti/'.$site_plan["foto_properti"]) ?>"
                  style="max-width:100%;max-height:300px">
              </div>
            </div>
            <!-- Title Page -->
            <small class="txt-normal text-danger">* yang di centang berarti sudah terjual</small>
            <div class="row">
              <?php 
                foreach ($list_unit as $key => $value) : 
                    if ($value->status_unit == "sudah terjual") {
                        $check = "checked";
                    }else{
                        $check="";
                    } 
                ?>
              <div class="col-sm-3">
                <div class="form-check form-check-flat">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="unit_properti" disabled
                      <?php echo $check ?>><?php echo $value->nama_unit ?>
                  </label>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <!-- Site Plan Unit -->
            <hr>
            <?php } ?>
            <?php if ($_SESSION['id_akses'] == "1") { ?>
            <div class="filter border-left-color py-3">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="properti_id">Pilih Properti</label>
                    <select name="properti" id="id_properti" class="form-control text-center"
                      onchange="changeElement(this,'post','<?= base_url('laporanunit/getunit/') ?>','<?= $this->security->get_csrf_hash() ?>','#id_unit')">
                      <option value=""> -- Properti -- </option>
                      <?php foreach ($properti as $key => $value) { ?>
                      <option value="<?= $value->id_properti ?>"><?= $value->nama_properti ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="unit_id">Pilih Unit</label>
                    <select name="id_unit" id="id_unit" class="form-control text-center">
                      <option value=""> -- Unit -- </option>

                      <?php if ($_SESSION['id_akses'] != '1' && $_SESSION['id_properti']) { 
                    foreach ($unit as $key => $value) { ?>
                      <option value="<?= $value['id_unit'] ?>"><?= $value['nama_unit'] ?></option>
                      <?php } } ?>

                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <button
                    onclick="searchData(['id_properti','id_unit'],'<?= $this->security->get_csrf_hash() ?>','#tbl_laporan_unit','<?= base_url('laporanunit/dataproses') ?>'),updateData('id_properti')"
                    class="btn btn-primary mr-2">
                    <i class="fa fa-search"></i>Search</button>
                  <a href="<?= base_url('laporanunit/printunit') ?>" class="btn btn-warning"><i class="fa fa-print"></i>
                    Print</a>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </form>
    <!-- box filter -->
    <br>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <a href="#collapseTwo" class="text-primary float-right" data-toggle="collapse"><i
                class="fa fa-circle"></i></a>
          </div>
        </div>
        <hr>
        <div class="collapse show" id="collapseTwo">
          <div class="row">
            <div class="col-sm-12">
              <table id="tbl_laporan_unit" class="table table-bordered table-striped table-hover">
                <thead>
                  <th>Nama Unit</th>
                  <th>Properti</th>
                  <th>Type</th>
                  <th>Tanah</th>
                  <th>Bangunan</th>
                  <th>Harga</th>
                  <th>Status</th>
                  <th>Foto</th>
                  <th>Aksi</th>
                </thead>
              </table>
            </div>
          </div>
          <hr>
          <div class="text-jual text-right border-right-color py-2">
            <div class="row">
              <div class="col-sm-12">
                <small class="txt-normal">Jumlah Unit</small>
                <small class="txt-normal-b" id="ttl">:&emsp;<?= $total['total'] ?></small>
              </div>
              <div class="col-sm-12">
                <small class="txt-normal ">Belum Terjual</small>
                <small class="txt-normal-b" id="bt">:&emsp;<?= $bt['bt'] ?></small>
              </div>
              <div class="col-sm-12">
                <small class="txt-normal ">Booking</small>
                <small class="txt-normal-b" id="b">:&emsp;<?= $b['b'] ?></small>
              </div>
              <div class="col-sm-12">
                <small class="txt-normal ">Terjual</small>
                <small class="txt-normal-b" id="t">:&emsp;<?= $t['t'] ?></small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Page -->