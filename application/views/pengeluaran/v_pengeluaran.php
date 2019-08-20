<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">Kelola Pengeluaran</h4>
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
            <div class="row">
              <div class="col-sm-12">
                <h5 class="d-inline-block"><i class="fa fa-m"></i>Pengeluaran</h5>
                <a href="<?= base_url() ?>pengeluaran/tambah" class="btn btn-sm btn-primary btn-sm float-right"><i
                    class="fa fa-plus"></i>Tambah</a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover" id="tbl_pengeluaran">
                    <thead>
                      <th>No</th>
                      <th>Nama Pengeluaran</th>
                      <th>Kelompok</th>
                      <th>Unit</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                      <th>Total Harga</th>
                      <th>Bukti</th>
                      <th>Owner</th>
                      <th>Manager</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      <?php 
                        $no = 1;
                        foreach($pengeluaran as $p){ 
                          if (!empty($p->bukti_kwitansi)) {
                            $img = '<img src="'.base_url('assets/uploads/images/pengeluaran/'.$p->bukti_kwitansi).'"';
                          } else {
                            $img = '<i style="font-size:13px;">Belum Upload Bukti</i>';
                          }
                        ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $p->nama_pengeluaran ?></td>
                        <td><?php echo $p->nama_kelompok ?></td>
                        <td><?= $p->nama_unit ?></td>
                        <td><?php echo $p->volume." ".$p->satuan ?></td>
                        <td><?php echo number_format($p->harga_satuan,2,',','.') ?></td>
                        <td><?php echo number_format($p->total_harga,2,',','.') ?></td>
                        <td><?= $img ?></td>
                        <td><?= $p->status_owner == 's' ? '-' : ($p->status_owner == 'p' ? 'pending' : 'selesai') ?>
                        </td>
                        <td><?= $p->status_manager == 's' ? '-' : ($p->status_manager == 'p' ? 'pending' : 'selesai') ?>
                        </td>
                        <td>
                          <?php if ($p->status_owner == 's') { ?>

                          <a href="<?= base_url() .'pengeluaran/ubah/'.$p->id_pengeluaran ?>"
                            class="btn btn-icons btn-inverse-primary"><i class="fa fa-edit"></i></a>
                          <button onclick="deleteItem('<?= base_url('pengeluaran/hapus/'.$p->id_pengeluaran) ?>')"
                            class="btn btn-icons btn-inverse-danger"><i class="fa fa-trash"></i></button>
                          <button class="btn btn-icons btn-inverse-warning"><i class="fa fa-lock"></i></button>
                          <?php } elseif ($p->status_owner == 'sl' && $p->status_manager == 'sl') { ?>

                          <i>-</i>
                          <?php } else { ?>

                          <i style="font-size: 13px;">Menunggu Approve</i>
                          <?php } ?>
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
  </div>
</div>