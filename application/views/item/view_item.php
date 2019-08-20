<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">Kelompok Item</h4>
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
                <h5 class="d-inline-block"><i class="fa fa-m"></i>All Item</h5>
                <a href="<?= base_url() ?>item/tambah" class="btn btn-info btn-sm float-right">Tambah</a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover" id="tbl_to_tables">
                    <thead>
                      <th>Nama Kelompok</th>
                      <th>Kategori</th>
                      <th>status</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      <?php 
                        foreach($kategori_item as $k){ 
                            $bg = $k->id_kategori;
                            $badge ="";
                            if ($bg == 1) {
                                $badge = "badge-primary";
                            }
                            else if ($bg == 2) {
                                $badge = "badge-info";
                            }
                            else if ($bg == 3) {
                                $badge = "badge-danger";
                            }
                            else {
                                $badge = "badge-success";
                            }
                        ?>
                      <tr>
                        <td><?php echo $k->nama_kelompok ?></td>
                        <td>
                          <div class="badge <?= $badge ?>"><?php echo $k->nama_kategori ?>
                        </td>
                        <td>
                          <div class="badge badge-dark"><?= ($k->status == 'a') ? 'Aktif' : 'Tidak Aktif' ; ?>
                        </td>
                        <td>
                          <a href="<?= base_url() .'item/ubah'?>/<?= $k->id_kelompok ?>"
                            class="btn btn-primary">Edit</a>
                          <?php if ($k->status == "a") { ?>
                          <button class="btn btn-sm btn-warning btn-nonaktif"
                            onclick="setItem('<?= base_url('item/status/'.$k->id_kelompok) ?>','Nonaktifkan')">Non
                            Aktifkan</button>
                          <?php }else{ ?>
                          <button class="btn btn-sm btn-danger btn-aktif"
                            onclick="setItem('<?= base_url('item/status/'.$k->id_kelompok) ?>','Aktifkan')">Aktifkan</button>
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