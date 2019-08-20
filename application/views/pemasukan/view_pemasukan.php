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
                <a href="<?= base_url() ?>pemasukan/tambah" class="btn btn-sm btn-primary btn-sm float-right"><i
                    class="fa fa-plus"></i>Tambah</a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover" id="tbl_pemasukan">
                    <thead>
                      <th>No</th>
                      <th>Nama Pemasukan</th>
                      <th>Kelompok</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                      <th>Bukti</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      <?php 
                        $no = 1;
                        foreach($pengeluaran as $p){ 
                        ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $p->nama_pemasukan ?></td>
                        <td><?php echo $p->nama_kelompok ?></td>
                        <td><?php echo $p->volume." ".$p->satuan ?></td>
                        <td><?php echo number_format($p->harga_satuan,2,',','.') ?></td>
                        <td>
                          <img src="<?= base_url('assets/uploads/images/pemasukan/'.$p->bukti_kwitansi)?>"
                            style="max-width:50px;">
                        </td>
                        <td>
                          <a href="<?= base_url() .'pemasukan/ubah/'.$p->id_pemasukan ?>"
                            class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Ubah</a>
                          <button onclick="deleteItem('<?= base_url('pemasukan/hapus/'.$p->id_pemasukan) ?>')"
                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>Delete</button>
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