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
              <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                class="float-right"><span class="fa fa-circle text-dark"></span></a>
            </div>
          </div>
          <hr>
          <div class="collapse" id="collapseOne">
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
            <div class="row">
              <?php if ($_SESSION['id_akses'] == "1") { ?>
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
              <?php } ?>
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
                  onclick="searchData(['id_properti','id_unit'],'<?= $this->security->get_csrf_hash() ?>','#tbl_laporan_unit','<?= base_url('laporanunit/dataproses') ?>')"
                  class="btn btn-primary mr-2" id="btn_search">
                  <i class="fa fa-search"></i>Search</button>
                <button type="submit" class="btn btn-warning"><i class="fa fa-print"></i> Print</button>
              </div>
            </div>
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
            <a href="<?= base_url('laporanunit/getJumlah') ?>" id="lihat">Lihat Unit</a>
            <a href="#collapseTwo" class="float-right" data-toggle="collapse" aria-expanded="true"
              aria-controls="collapseTwo"><i class="fa fa-circle text-dark"></i></a>
          </div>
        </div>
        <hr>
        <div class="row collapse show" id="collapseTwo">
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
      </div>
    </div>
  </div>
</div>
<!-- End Page -->
<div class="modal fade" id="modal_unit" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Jumlah Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <h5 class="jumlah">Jumlah Unit</h5>
          <small class="bt">Belum Terjual</small><br>
          <small class="b">Booking</small><br>
          <small class="t">Terjual</small>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->