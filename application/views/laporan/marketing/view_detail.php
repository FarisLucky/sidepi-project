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
        <div id="collapseOne" class="collapse border-left-color">
          <div class="row">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-12">
                  <small class="txt-semi-high">Nama</small>
                  <small class="txt-semi-high wht-medium"><?= ucfirst($marketing['nama_lengkap']) ?></small>
                </div>
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
                    <th>No</th>
                    <th>SPR</th>
                    <th>Unit</th>
                    <th>Properti</th>
                    <th>Tgl Transaksi</th>
                    <th>Kesepakatan</th>
                    <th>Type Bayar</th>
                    <th>Status Transaksi</th>
                  </thead>
                  <tbody>
                    <?php $no= 1;  foreach ($transaksi as $key => $value) {
                      if ($value['status_transaksi'] == 's') {
                        $status = 'Sementara';
                      } elseif ($value['status_transaksi'] == 'p') {
                        $status = 'Progress';
                      } else { 
                        $status = 'Selesai';
                      }
                        ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $value['no_spr'] ?></td>
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