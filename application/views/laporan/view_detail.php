<div class="content-wrapper" id="detail_konsumen">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Detail Konsumen</h4>
            <a href="<?= base_url('laporankonsumen') ?>" class="btn btn-dark float-right"><i
                class="fa fa-arrow-circle-left"></i> Kembali</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End Title  -->
    <br>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <h5 class="d-inline-block">Data Diri</h5>
            <a href="#collapseOne" class="float-right" data-toggle="collapse" aria-expended="true"><i
                class="fa fa-circle"></i></a>
          </div>
        </div>
        <hr>
        <div id="collapseOne" class="collapse show">
          <div class="row">
            <div class="col-sm-12">
              <div class="alert alert-success">
                <h5>Data konsumen</h5>
                <hr>
                <div class="row">
                  <div class="col-md-6 border-right border-info">
                    <div class="row">
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Id Card :</small>
                        <small
                          class="txt-semi-high wht-medium"><?= strtoupper($konsumen['id_type']).' '.$konsumen['id_card'] ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Nama :</small>
                        <small class="txt-semi-high wht-medium"><?= $konsumen['nama_lengkap'] ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Jenis Kelamin :</small>
                        <small
                          class="txt-semi-high wht-medium"><?= $konsumen['jenis_kelamin'] == 'l' ? 'Laki-Laki' : 'Perempuan'; ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Telepon :</small>
                        <small class="txt-semi-high wht-medium"><?= $konsumen['telp'] ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Email :</small>
                        <small class="txt-semi-high wht-medium"><?= $konsumen['email'] ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Tgl Buat :</small>
                        <small class="txt-semi-high wht-medium"><?= $konsumen['tgl_buat'] ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Alamat :</small>
                        <small class="txt-semi-high wht-medium"><?= $konsumen['alamat'] ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">NPWP :</small>
                        <small class="txt-semi-high wht-medium"><?= $konsumen['npwp'] ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Pekerjaan :</small>
                        <small class="txt-semi-high wht-medium"><?= $konsumen['pekerjaan'] ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Alamat Kantor :</small>
                        <small class="txt-semi-high wht-medium"><?= $konsumen['alamat_kantor'] ?></small>
                      </div>
                      <div class="col-sm-12">
                        <small class="txt-semi-high">Telepon Kantor :</small>
                        <small class="txt-semi-high wht-medium"><?= $konsumen['telp_kantor'] ?></small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 text-center my-auto">

                    <?php if (!empty($konsumnen['foto_ktp'])) { ?>
                    <img src="" class="img-thumbnail">
                    <?php } else { ?>
                    <h5>Tidak Ada Foto</h5>
                    <?php } ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Data Konsumen -->
    <br>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <h5 class="d-inline-block">Data Persyaratan</h5>
            <a href="#collapseTwo" class="float-right" data-toggle="collapse" aria-expended="true"><i
                class="fa fa-circle"></i></a>
          </div>
        </div>
        <hr>
        <div id="collapseTwo" class="collapse">
          <div class="row">

            <?php $no = 1; if (!empty($sasaran)) { ?>
            <div class="col-md-12">
              <div class="alert alert-info">
                <h5>Persyaratan Konsumen</h5>
                <div class="row">
                  <?php foreach ($sasaran as $key => $value) { 
                    $data = getKelompok('persyaratan_konsumen',['id_konsumen'=>$konsumen['id_konsumen'],'kelompok_persyaratan'=>$value['id_sasaran']]);
                  ?>
                  <div class="col-md-4">
                    <div class="form-check form-check-flat">
                      <label class="form-check-label">
                        <input type="checkbox" value="<?= $data ?>" class="form-check-input">
                        <?= $value['nama_kelompok'] ?>
                      </label>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <?php $no++; } else { ?>
            <div class="col-md-6">
              <div class="alert alert-info">
                <h4>Data Kosong</h4>
              </div>
            </div>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
    <!-- End Follow -->
  </div>
</div>