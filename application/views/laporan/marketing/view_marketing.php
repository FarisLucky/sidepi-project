<div class="content-wrapper" id="view_marketing">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Laporan Marketing</h4>
            <img id="logo_perusahaan" width="50px"
              src="<?php echo base_url().'assets/uploads/images/properti/'.$img->logo_perusahaan ?>" class="float-right"
              alt="">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <div class="alert alert-info">
              <small class="txt-normal">Total Marketing : <b><?= $total['total'] ?></b></small>
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="tbl_data" class="table table-bordered table-striped">
                <thead>
                  <th>Nama</th>
                  <th>Telp</th>
                  <th>Email</th>
                  <th>Total Konsumen</th>
                  <th>Total Calon</th>
                  <th>Detail Penjualan</th>
                </thead>
                <tbody>
                  <?php foreach ($marketing as $key => $value) { ?>
                  <tr>
                    <td><?= $value['nama_lengkap'] ?></td>
                    <td><?= $value['no_hp'] ?></td>
                    <td><?= $value['email'] ?></td>
                    <td>
                      <?php $konsumen =  getDataWhere('COUNT(id_konsumen) as konsumen','konsumen',['status_konsumen'=>'k'])->row_array(); echo $konsumen['konsumen'] ?>
                    </td>
                    <td>
                      <?php $calon =  getDataWhere('COUNT(id_konsumen) as calon','konsumen',['status_konsumen'=>'ck'])->row_array(); echo $calon['calon'] ?>
                    </td>
                    <td>
                      <a href="<?= base_url('laporanmarketing/detailunit/'.$value['id_user']) ?>"
                        class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Lihat</a>
                    </td>
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