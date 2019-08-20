<div class="content-wrapper" id="view_konsumen">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Laporan Semua Konsumen</h4>
            <img id="logo_perusahaan" width="50px"
              src="<?php echo base_url().'assets/uploads/images/properti/'.$img->logo_perusahaan ?>" class="float-right"
              alt="">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <div class="alert alert-info">
              <small class="txt-normal">Total semua konsumen : <b><?= $total_konsumen['jumlah_konsumen'] ?></b></small>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="tbl_laporan_konsumen" class="table table-bordered table-striped">
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