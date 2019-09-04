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
        <div class="text-jual border-left-color py-2 mt-3">
          <div class="row">
            <div class="col-sm-12">
              <small class="txt-normal">Total Marketing</small>
              <small class="txt-normal-b" id="ttl">:&emsp;<?= $total['total'] ?></small>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card mt-4">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="table-responsive">
              <table id="tbl_data" class="table table-bordered table-striped">
                <thead>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Telp</th>
                  <th>Email</th>
                  <th>Total Calon</th>
                  <th>Penjualan</th>
                  <th>Aksi</th>
                </thead>
                <tbody>
                  <?php $no=1; foreach ($marketing as $key => $value) { ?>
                  <tr>
                    <td><?= $no ?></td>
                    <td><?= $value['nama_lengkap'] ?></td>
                    <td><?= $value['no_hp'] ?></td>
                    <td><?= $value['email'] ?></td>
                    <td>
                      <?php $c = getDataWhere('COUNT(id_konsumen) as calon','konsumen',['status_konsumen'=>'ck','id_user'=>$value['id_user']])->row_array(); echo $c['calon']; ?>
                    </td>
                    <td>
                      <?php $t = getDataWhere('COUNT(id_transaksi) as transaksi','transaksi',['id_user'=>$value['id_user'],'status_transaksi !='=>'s'])->row_array(); echo $t['transaksi'] ?>
                    </td>
                    <td>
                      <a href="<?= base_url('laporanmarketing/detailunit/'.$value['id_user']) ?>"
                        class="btn btn-icons btn-inverse-info"><i class="fa fa-eye"></i></a>
                    </td>
                  </tr>
                  <?php $no++; } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>