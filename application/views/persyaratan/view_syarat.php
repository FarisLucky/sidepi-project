<div class="content-wrapper" id="v_persyaratan_sasaran">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">Kelola Persyaratan Sasaran</h4>
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
                <h5 class="d-inline-block"><i class="fa fa-m"></i>Kelola Persyaratan</h5>
                <a href="<?= base_url() ?>persyaratan/tambah" class="btn btn-primary btn-sm float-right"><i
                    class="fa fa-plus"></i>Tambah</a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover table-striped table-bordered" id="tbl_to_tables">
                    <thead>
                      <th>No</th>
                      <th>Nama Persyaratan</th>
                      <th>Kategori</th>
                      <th>Keterangan</th>
                      <th>Tipe Persyaratan</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach($persyaratan as $p) { ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $p->nama_kelompok ?></td>
                        <td><?php echo $p->kategori_persyaratan ?></td>
                        <td><?php echo $p->keterangan ?></td>
                        <td><?php echo $p->kategori_persyaratan ?></td>
                        <td>
                          <a href="<?= base_url('persyaratan/ubah/'.$p->id_sasaran) ?>"
                            class="btn btn-icons btn-inverse-info"><i class="fa fa-edit"></i></a>
                          <button class="btn btn-icons btn-inverse-danger"
                            onclick="deleteItem('<?= base_url('persyaratan/hapus/'.$p->id_sasaran) ?>')"><i
                              class="fa fa-trash"></i></button>
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