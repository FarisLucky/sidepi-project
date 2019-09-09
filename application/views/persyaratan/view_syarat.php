<div class="content-wrapper" id="v_persyaratan_sasaran">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Kelola Persyaratan Sasaran</h4>
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
                      <th>Tipe</th>
                      <th>Status</th>
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
                        <td><?= $p->status == '1' ? 'aktif' : 'tidak aktif' ?></td>
                        <td>
                          <a href="<?= base_url('persyaratan/ubah/'.$p->id_sasaran) ?>"
                            class="btn btn-icons btn-inverse-info"><i class="fa fa-edit"></i></a>
                          <?php if ($p->status == '1') { ?>
                          <button class="btn btn-icons btn-inverse-warning"
                            onclick="setItem('<?= base_url('persyaratan/lock/'.$p->id_sasaran) ?>','NonAktifkan')"><i
                              class="fa fa-times"></i></button>
                          <?php } else { ?>
                          <button class="btn btn-icons btn-inverse-success"
                          onclick="setItem('<?= base_url('persyaratan/lock/'.$p->id_sasaran) ?>','Aktifkan')"><i
                            class="fa fa-check"></i></button>
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