<div class="content-wrapper" id="persyaratan_konsumen">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Persyaratan Konsumen</h4>
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
                <div class="table-responsive">
                  <table class="table table-hover table-striped table-bordered" id="tbl_syarat">
                    <thead>
                      <th>Id Card</th>
                      <th>Konsumen</th>
                      <th>Jenis Kelamin</th>
                      <th>Telp</th>
                      <th>Email</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      <?php foreach ($konsumen as $key => $value) { ?>
                      <tr>
                        <td><?= strtoupper($value['id_type'])." ".$value['id_card'] ?></td>
                        <td><?= $value['nama_lengkap'] ?></td>
                        <td><?= $value['jenis_kelamin'] == 'l' ? 'Laki - Laki' : 'Perempuan'; ?></td>
                        <td><?= $value['telp'] ?></td>
                        <td><?= $value['email'] ?></td>
                        <td>
                          <a href="<?= base_url('persyaratankonsumen/ubah/'.$value['id_konsumen']) ?>"
                            class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Ubah</a>
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