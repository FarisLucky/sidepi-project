<div class="content-wrapper" id="history">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">History Bayar</h4>
                <img id="logo_perusahaan" width="50px"
                  src="<?= base_url().'assets/uploads/images/properti/'.$img->logo_perusahaan ?>" class="float-right"
                  alt="">
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
            <hr>
            <div class="row">
              <div class="col-sm-12 text-center mb-3">
                <a href="<?= base_url('pembayaran/bayar/'.$id_pembayaran) ?>"
                  class="btn btn-sm btn-warning float-left"><i class="fa fa-print"></i>&nbsp;print</a>
                <small class="kh-title">Detail History</small>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered" id="tbl_to_tables">
                    <thead>
                      <th>Tanggal buat</th>
                      <th>Jumlah Bayar</th>
                      <th>Status Owner</th>
                      <th>Status Manager</th>
                      <th>Bukti</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      <?php foreach ($detail as $key => $value) :
                        if ($value['bukti_bayar'] != '') {
                          $img = '<img src="'.base_url('assets/uploads/images/pembayaran/'.$value['bukti_bayar']).'">';
                        } else {
                          $img = '<i>Belum Upload</i>';
                        }
                        $url = base_url('pembayaran/');
                        if($value['status_owner'] == 's' && $value['status_manager'] == 's'){
                            $status = '<span class="badge badge-primary">Sementara</span>';
                            $button = '<a href='.base_url("pembayaran/ubahbayar/".$value['id_detail']).' class="btn btn-icons btn-inverse-info"><i class="fa fa-info"></i></a>';
                        } elseif($value['status_owner'] == 'p' && $value['status_manager'] == 'p') {
                            $status = '<span class="badge badge-warning">Pending</span>';
                            $button = "<i>Menunggu Approve</i>";
                        } else {
                            $status = '<span class="badge badge-success">Selesai</span>';
                            $button = '<a href="'.base_url('pembayaran/printdata/'.$value['id_pembayaran']).'" class="btn btn-icons btn-inverse-warning mr-1" ><i class="fa fa-print"></i></a>';
                        }?>
                      <tr>
                        <td><?= $value['tgl_bayar'] ?></td>
                        <td><?= number_format($value['jumlah_bayar'],2,',','.') ?></td>
                        <td>
                          <?= $value['status_owner'] == 's' ? '-' : ($value['status_owner'] == 'p' ? 'pending' : 'selesai') ?>
                        </td>
                        <td>
                          <?= $value['status_manager'] == 's' ? '-' : ($value['status_manager'] == 'p' ? 'pending' : 'selesai') ?>
                        </td>
                        <td><?= $img ?>
                        </td>
                        <td><?= $button ?></td>
                      </tr>
                      <?php endforeach;  ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <small class="txt-semi-high">Total Tagihan : <small
                    class="txt-filter border-0"><?= number_format($pembayaran['total_tagihan'],2,',','.') ?></small></small>
              </div>
              <div class="col-sm-12">
                <small class="txt-semi-high">Total Bayar : <small
                    class="txt-filter border-0"><?= number_format($pembayaran['total_bayar'],2,',','.') ?></small></small>
              </div>
              <div class="col-sm-12">
                <small class="txt-semi-high">Total Hutang : <small
                    class="txt-filter border-0"><?= number_format($pembayaran['hutang'],2,',','.') ?></small></small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>