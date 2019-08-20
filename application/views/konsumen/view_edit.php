<div class="content-wrapper">
  <div class="container">
    <div class="card">
      <div class="card-body p-4">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="dark txt_title d-inline-block mt-2">Ubah Data Konsumen</h4>
            <a href="<?= base_url("konsumen") ?>" class="btn btn-sm btn-dark float-right"><i
                class="fa fa-arrow-circle-left"></i> Kembali</a>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="card">
      <div class="card-body">
        <div id="tabs">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#data_diri" role="tab"
                aria-selected="true">Pemohon</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" id="profile-tab" data-toggle="tab" href="#pasangan" role="tab"
                aria-controls="profile" aria-selected="false">Pasangan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rh disabled" id="contact-tab" data-toggle="tab" href="#pekerjaan_pemohon" role="tab"
                aria-selected="false">Pekerjaan Pemohon</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" id="contact-tab" data-toggle="tab" href="#pekerjaan_pasangan" role="tab"
                aria-selected="false">Pekerjaan Pasangan</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="data_diri" role="tabpanel">
              <br>
              <h5>Data Diri Konsumen</h5>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="form-label-group">
                      <label>Pilih Type ID Card</label>
                      <select name="val_id_type" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="sim" <?php echo ($konsumen["id_type"] == "sim") ? "selected" : "" ; ?>>KTP
                        </option>
                        <option value="ktp" <?php echo ($konsumen["id_type"] == "ktp") ? "selected" : "" ; ?>>SIM
                        </option>
                      </select>
                      <small class="text-danger"><?php echo form_error('val_id_type') ?></small>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-label-group">
                      <label for="input_idcard">Id Card</label>
                      <input type="text" class="form-control" id="input_idcard" name="val_id_card"
                        value="<?= $konsumen['id_card'] ?>" placeholder="Masukan Id Card" required>
                      <small class="text-danger"><?= form_error("val_id_card") ?></small>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-label-group">
                      <label for="input_nama">Nama Lengkap</label>
                      <input type="text" class="form-control" id="input_nama" name="val_nama"
                        value="<?= $konsumen['nama_lengkap'] ?>" placeholder="Masukan Nama Lengkap" required>
                      <small class="text-danger"><?= form_error("val_nama") ?></small>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-label-group">
                      <label for="input_email">Email</label>
                      <input type="text" class="form-control" id="input_email" name="val_email"
                        value="<?= $konsumen['email'] ?>" placeholder="Masukan Email" required>
                      <small class="text-danger"><?= form_error("val_email") ?></small>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="input_telepon">No Telepon</label>
                    <input type="text" class="form-control" id="input_telepon" name="val_telepon"
                      value="<?= $konsumen['telp'] ?>" placeholder="Masukan Nomer Telepon" required>
                    <small class="text-danger"><?= form_error("val_telepon") ?></small>
                  </div>
                  <div class="form-group">
                    <label for="input_alamat">Alamat</label>
                    <textarea type="text" class="form-control" id="input_alamat" name="val_alamat" rows="3"
                      placeholder="Masukan Alamat" required><?= $konsumen['alamat'] ?></textarea>
                    <small class="text-danger"><?= form_error("val_alamat") ?></small>
                  </div>
                  <div class="form-group">
                    <label>NPWP</label>
                    <input type="text" class="form-control" name="npwp" value="<?= $konsumen['npwp'] ?>"
                      placeholder="Masukan NPWP" required>
                    <small class="text-danger"><?= form_error("npwp") ?></small>
                  </div>
                  <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgl_lahir" value="<?= $konsumen['tgl_lahir'] ?>"
                      required>
                    <small class="text-danger"><?= form_error("tgl_lahir") ?></small>
                  </div>
                  <div class="form-group">
                    <label>Status Pernikahan</label>
                    <select name="pernikahan" class="form-control" required>
                      <option value="">-- Pilih Pernikahan --</option>
                      <option value="m">Menikah</option>
                      <option value="bm">Belum Menikah</option>
                    </select>
                    <small class="text-danger"><?= form_error("pernikahan") ?></small>
                  </div>
                  <div class="form-group">
                    <label>Pendidikan</label>
                    <select name="pendidikan" class="form-control" required>
                      <option value="">-- Pilih Pendidikan --</option>
                      <option value="sd">SD</option>
                      <option value="smp">SMP</option>
                      <option value="sma">SMA</option>
                      <option value="diploma">Diploma</option>
                      <option value="s1">S1</option>
                      <option value="s2">S1/S2</option>
                    </select>
                    <small class="text-danger"><?= form_error("pendidikan") ?></small>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <button class="btn btn-sm btn-primary float-right mx-3 next">Next <i
                        class="fa fa-arrow-right"></i></button>
                    <button class="btn btn-sm btn-secondary float-right prev"><i
                        class="fa fa-arrow-left"></i>Prev</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
              <br>
              <h5>Data Pasangan Konsumen</h5>
              <hr>
              <div class="col-md-12">
                <div class="form-group">
                  <label>Nama Pasangan</label>
                  <input type="text" class="form-control" name="nama_pasangan" value="<?= $konsumen['nama_pasangan'] ?>"
                    required>
                  <small class="text-danger"><?= form_error("nama_pasangan") ?></small>
                </div>
                <div class="form-group">
                  <label>Hubungan dengan Pemohon</label>
                  <input type="text" class="form-control" name="hubungan_pasangan"
                    value="<?= $konsumen['hubungan_pasangan'] ?>" required>
                  <small class="text-danger"><?= form_error("hubungan_pasangan") ?></small>
                </div>
                <div class="form-group">
                  <label>Alamat Rumah</label>
                  <input type="text" class="form-control" name="alamat_pasangan"
                    value="<?= $konsumen['alamat_pasangan'] ?>" required>
                  <small class="text-danger"><?= form_error("alamat_pasangan") ?></small>
                </div>
                <div class="form-group">
                  <label>Telepon Pasangan</label>
                  <input type="text" class="form-control" name="telp_pasangan" value="<?= $konsumen['telp_pasangan'] ?>"
                    required>
                  <small class="text-danger"><?= form_error("telp_pasangan") ?></small>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pekerjaan_pemohon" role="tabpanel">
              <br>
              <h4>Data Pekerjaan Pemohon</h4>
              <hr>
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Nama Perusahaan</label>
                  <input type="text" class="form-control" name="nama_perusahaan"
                    value="<?= $konsumen['nama_perusahaan'] ?>" required>
                  <small class="text-danger"><?= form_error("nama_perusahaan") ?></small>
                </div>
                <div class="form-group">
                  <label>Telp Perusahaan</label>
                  <input type="text" class="form-control" name="telp_perusahaan"
                    value="<?= $konsumen['telp_perusahaan'] ?>" required>
                  <small class="text-danger"><?= form_error("telp_perusahaan") ?></small>
                </div>
                <div class="form-group">
                  <label>Jenis Pekerjaan</label>
                  <select name="jenis_pekerjaan" class="form-control">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="bumn">BUMN</option>
                    <option value="pns">PNS</option>
                    <option value="swasta">SWASTA</option>
                    <option value="tni">TNI</option>
                    <option value="lainnya">LAINNYA</option>
                  </select>
                  <small class="text-danger"><?= form_error("jenis_pekerjaan") ?></small>
                </div>
                <div class="form-group">
                  <label>Jabatan</label>
                  <input type="text" class="form-control" name="jabatan_perusahaan"
                    value="<?= $konsumen['telp_perusahaan'] ?>" required>
                  <small class="text-danger"><?= form_error("jabatan_perusahaan") ?></small>
                </div>
                <div class="form-group">
                  <label>Nama Atasan</label>
                  <input type="text" class="form-control" name="atasan_perusahaan"
                    value="<?= $konsumen['nama_atasan'] ?>" required>
                  <small class="text-danger"><?= form_error("atasan_perusahaan") ?></small>
                </div>
                <div class="form-group">
                  <label>Telepon Atasan</label>
                  <input type="text" class="form-control" name="telp_atasan" value="<?= $konsumen['telp_atasan'] ?>"
                    required>
                  <small class="text-danger"><?= form_error("telp_atasan") ?></small>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="pekerjaan_pasangan" role="tabpanel">
              <br>
              <h4>Data Pekerjaan Pasangan</h4>
              <hr>
              <div class="col-sm-12">
                <div class="form-group">
                  <label>Nama Perusahaan</label>
                  <input type="text" class="form-control" name="kantor_pasangan"
                    value="<?= $konsumen['kantor_pasangan'] ?>" required>
                  <small class="text-danger"><?= form_error("nama_perusahaan2") ?></small>
                </div>
                <div class="form-group">
                  <label>Telp Perusahaan</label>
                  <input type="text" class="form-control" name="telp_kantor_pasangan"
                    value="<?= $konsumen['telp_kantor_pasangan'] ?>" required>
                  <small class="text-danger"><?= form_error("telp_perusahaan2") ?></small>
                </div>
                <div class="form-group">
                  <label>Jenis Pekerjaan</label>
                  <select name="jenis_pekerjaan2" class="form-control">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="bumn">BUMN</option>
                    <option value="pns">PNS</option>
                    <option value="swasta">SWASTA</option>
                    <option value="tni">TNI</option>
                    <option value="wiraswasta">WIRASWASTA</option>
                    <option value="lainnya">LAINNYA</option>
                  </select>
                  <small class="text-danger"><?= form_error("jenis_pekerjaan") ?></small>
                </div>
                <div class="form-group">
                  <label>Jabatan</label>
                  <input type="text" class="form-control" name="jabatan_pasangan"
                    value="<?= $konsumen['telp_perusahaan'] ?>" required>
                  <small class="text-danger"><?= form_error("jabatan_perusahaan") ?></small>
                </div>
                <div class="form-group">
                  <label>Nama Atasan</label>
                  <input type="text" class="form-control" name="atasan_perusahaan"
                    value="<?= $konsumen['nama_atasan'] ?>" required>
                  <small class="text-danger"><?= form_error("atasan_perusahaan") ?></small>
                </div>
                <div class="form-group">
                  <label>Telepon Atasan</label>
                  <input type="text" class="form-control" name="telp_atasan" value="<?= $konsumen['telp_atasan'] ?>"
                    required>
                  <small class="text-danger"><?= form_error("telp_atasan") ?></small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <small class="txt-semi-high font-weight-medium">Dokumen Konsumen</small>
                <a data-target="#segment2" data-toggle="collapse" class="text-primary float-right"><i
                    class="fa fa-circle"></i></a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <button class="btn btn-sm btn-inverse-primary float-right" data-target="#modal_doc"
                  data-toggle="modal"><i class="fa fa-plus"></i> Tambah</button>
              </div>
            </div>
            <br>
            <div class="row collapse show" id="segment2">
              <div class="col-sm-12">
                <table class="table table-condensed table-striped" id="tbl_to_tables">
                  <thead>
                    <th>No</th>
                    <th>Nama Kelompok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </thead>
                  <tbody>
                    <?php $no = 1; foreach ($doc_konsumen as $key => $value) { ?>
                    <tr>
                      <td><?= $no ?></td>
                      <td><?= $value['nama_kelompok'] ?></td>
                      <td class="text-center">
                        <?php $path = './assets/uploads/files/konsumen'.$value['file'] ;echo file_exists($path) && !is_dir($path) ? '<i style="font-size: 13px;">sudah upload</i>' : '<i style="font-size: 13px;">belum upload</i>'; ?>
                      </td>
                      <td class="text-center">
                        <?php if (file_exists($path) && !is_dir($path)) { ?>
                        <a href="#" class="btn btn-icons btn-inverse-warning"><i class="fa fa-print"></i></a>
                        <button class="btn btn-icons btn-inverse-danger"
                          onclick="deleteItem('<?= base_url('konsumen/hapusfile/'.$value['id_persyaratan'].'/'.$konsumen['id_konsumen']) ?>')"><i
                            class="fa fa-remove"></i></button>
                        <?php } else { ?>
                        <button class="btn btn-icons btn-inverse-primary" id="upload_file"
                          data-id="<?= $value['id_persyaratan'] ?>"><i class="fa fa-file-archive-o"></i></button>
                        <button class="btn btn-icons btn-inverse-danger"
                          onclick="deleteItem('<?= base_url('konsumen/hapussyarat/'.$value['id_persyaratan'].'/'.$konsumen['id_konsumen']) ?>')"><i
                            class="fa fa-trash"></i></button>
                        <?php } ?>
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
</div>

<div class="modal fade" id="modal_doc">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Dokumen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('konsumen/coretambahsyarat') ?>" method="post" enctype="multipart/form-data"
          id="modal_user">
          <input type="hidden" name="input_hidden" value="<?= $konsumen['id_konsumen'] ?>">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name();?>"
            value="<?= $this->security->get_csrf_hash(); ?>">
          <div class="row">
            <div class="col-sm-12" id="form_change">
              <div class="form-group">
                <label>Pilih Kelompok</label>
                <select name="kelompok" class="select-opt">
                  <option value=""> -- Pilih Options -- </option>
                  <?php foreach ($kelompok as $key => $value) {
                    $where = get_where('persyaratan_konsumen',['id_konsumen'=>$konsumen['id_konsumen'],'kelompok_persyaratan'=>$value['id_sasaran']]);
                    if ($where->num_rows() < 1) {
                      echo '<option value="'.$value['id_sasaran'].'">'.$value['nama_kelompok'].'</option>';
                    } } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Upload File</label>
                <input type="file" name="file_img" class="form-control">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>