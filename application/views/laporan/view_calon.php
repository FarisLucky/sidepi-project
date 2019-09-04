<div class="content-wrapper" id="view_konsumen">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Laporan Calon</h4>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <div class="border-left-color py-3">
              <small class="txt-normal">Total Calon : <b><?= $total_konsumen['jumlah_konsumen'] ?></b></small>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="tbl_laporan_calon" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Card</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Telp</th>
                    <th>email</th>
                    <th>alamat</th>
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
</div>