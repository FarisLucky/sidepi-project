<div class="content-wrapper" id="view_marketing">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Detail Hasil Transaksi</h4>
            <a href="<?= base_url('laporanmarketing') ?>" class="btn btn-sm btn-dark float-right"><i
                class="fa fa-arrow-circle-left"></i> Kembali</a>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <h5 class="d-inline-block">Data Marketing</h5>
            <a href="#collapseOne" data-toggle="collapse" aria-expanded="true" class="float-right"><i
                class="fa fa-circle"></i></a>
          </div>
        </div>
        <hr>
        <div id="collapseOne" class="collapse">
          <div class="row justify-content-center">
            <div class="col-sm-6">
              <div class="alert alert-info p-3">
                <h5><?= ucfirst($marketing['nama_lengkap']) ?></h5>
                <hr>
                <div class="row">
                  <div class="col-sm-12">
                    <small class="txt-semi-high">Email</small>
                    <small class="txt-semi-high wht-medium"><?= $marketing['email'] ?></small>
                  </div>
                  <div class="col-sm-12">
                    <small class="txt-semi-high">Telp</small>
                    <small class="txt-semi-high wht-medium"><?= $marketing['no_hp'] ?></small>
                  </div>
                  <div class="col-sm-12">
                    <small class="txt-semi-high">Status</small>
                    <small class="txt-semi-high wht-medium"><?= $marketing['status_user'] ?></small>
                  </div>
                </div>
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
            <h5 class="d-inline-block">Data Transaksi</h5>
            <a href="#collapseTwo" data-toggle="collapse" aria-expended="true" class="float-right"><i
                class="fa fa-circle"></i></a>
          </div>
        </div>
        <hr>
        <div id="collapseTwo" class="collapse show">
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table id="tbl_data" class="table table-bordered table-striped">
                  <thead>
                    <th>PPJB</th>
                    <th>Unit</th>
                    <th>Properti</th>
                    <th>Tgl Transaksi</th>
                    <th>Kesepakatan</th>
                    <th>Type Bayar</th>
                    <th>Status Transaksi</th>
                  </thead>
                  <tbody>
                    <?php foreach ($transaksi as $key => $value) {
                      if ($value['status_transaksi'] == 's') {
                        $status = 'Sementara';
                      } elseif ($value['status_transaksi'] == 'p') {
                        $status = 'Progress';
                      } else { 
                        $status = 'Selesai';
                      }
                        ?>
                    <tr>
                      <td><?= $value['no_ppjb'] ?></td>
                      <td><?= $value['nama_unit'] ?></td>
                      <td><?= $value['nama_properti'] ?></td>
                      <td><?= $value['tgl_transaksi'] ?></td>
                      <td><?= number_format($value['total_kesepakatan'],2,',','.') ?></td>
                      <td><?= $value['type_bayar'] ?></td>
                      <td><span class="badge badge-info"><?= $status ?></span></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>