<div class="content-wrapper">
  <div class="row mt-4">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="clearfix">
            <div class="float-left">
              <i class="mdi mdi-widgets text-danger icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Transaksi</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0"><?= $total_transaksi['total'] ?></h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Total Bulan <?= bulan(date('m')) ?>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="clearfix">
            <div class="float-left">
              <i class="mdi mdi-account-convert text-warning icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Calon Konsumen</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0"><?= $total_konsumen['total'] ?></h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Total Bulan <?= bulan(date('m')) ?>
          </p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="clearfix">
            <div class="float-left">
              <i class="mdi mdi-chevron-double-right text-success icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Pengeluaran</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0">
                  <?= number_format($total_pengeluaran['total'],2,',','.') ?></h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Total Bulan <?= bulan(date('m')) ?>
          </p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-statistics">
        <div class="card-body">
          <div class="clearfix">
            <div class="float-left">
              <i class="mdi mdi-chevron-double-left text-info icon-lg"></i>
            </div>
            <div class="float-right">
              <p class="mb-0 text-right">Pemasukan</p>
              <div class="fluid-container">
                <h3 class="font-weight-medium text-right mb-0"><?= number_format($total_pemasukan['total'],2,',','.') ?>
                </h3>
              </div>
            </div>
          </div>
          <p class="text-muted mt-3 mb-0">
            <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Total Bulan <?= bulan(date('m')) ?>
          </p>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title d-inline-block">Approve Pembayaran</h4>
          <a href="#collapseOne" data-toggle="collapse" aria-expanded="true">
            <i class="fa fa-circle float-right"></i>
          </a>
          <hr>
          <div class="table-responsive collapse show" id="collapseOne">
            <table class="table table-hover table-striped" id="tbl_approve_pembayaran">
              <thead>
                <th>Pembayaran</th>
                <th>Jumlah Bayar</th>
                <th>Rekening</th>
                <th>Tanggal Bayar</th>
                <th>Bukti</th>
                <th>Pembuat</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                <?php foreach ($approve_bayar as $key => $value) :  ?>
                <tr>
                  <td><?= $value->nama_pembayaran ?></td>
                  <td> <?= number_format($value->jumlah_bayar,2,',','.') ?></td>
                  <td><?= $value->no_rekening." ".$value->bank ?></td>
                  <td><?= $value->tgl_bayar ?></td>
                  <td><img src="<?php echo base_url('assets/uploads/images/pembayaran/'.$value->bukti_bayar) ?>">
                  <td><?php echo $value->nama_lengkap;?></td>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-success ml-2"
                      onclick="setItem('<?= base_url('approve/accept/'.$value->id_detail) ?>','Terima')">
                      <i class="fa fa-check"></i>Accept</button>
                    <button type="button" class="btn btn-sm btn-danger ml-2">
                      <i class="fa fa-ban"></i>Reject</button>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>