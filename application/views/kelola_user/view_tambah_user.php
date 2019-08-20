<div class="flash-data" flash-error="<?= $this->session->flashdata("error") ?>" flash-success="<?= $this->session->flashdata("success"); ?>"></div>
<div class="content-wrapper" id="tambah_user_content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="dark txt_title d-inline-block mt-2">Kelola User</h4>
                                <img id="logo_perusahaan" width="50px" src="<?= base_url().'assets/uploads/images/properti/'.$img->logo_perusahaan ?>" class="float-right" alt="">
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
                                <h5 class="d-inline-block">Tambah User</h5>
                            </div>
                        </div>
                        <hr>
                        <form action="<?= base_url("kelolauser/coretambah") ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_nama">Nama</label>
                                        <input type="text" name="txt_nama" class="form-control" id="txt_nama" value="<?= set_value("txt_nama") ?>">
                                        <small class="text-danger"><?= form_error("txt_nama") ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_username">Username</label>
                                        <input type="text" name="txt_username" class="form-control" id="txt_username" value="<?= set_value("txt_username") ?>">
                                        <small class="text-danger"><?= form_error("txt_username") ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Jenis Kelamin</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-radio">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="radio_jk" id="radio1" value="laki-laki" <?= (set_value('radio_jk') == "laki-laki") ? "checked" : "" ; ?> >Laki Laki
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-radio">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="custom-control-input" name="radio_jk" id="radio2" value="perempuan" <?= (set_value('radio_jk') == "perempuan") ? "checked" : "" ; ?>>Perempuan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-danger"><?= form_error("radio_jk"); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_telp">Telp </label>
                                        <input type="number" name="txt_telp" class="form-control" id="txt_telp" value="<?= set_value("txt_telp") ?>">
                                        <small class="text-info">* Max 13 Digit </small>
                                        <small class="text-danger"><?= form_error("txt_telp") ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_email">Email</label>
                                        <input type="text" name='txt_email' class="form-control" id="txt_email" value="<?= set_value("txt_email") ?>">
                                        <small class="text-danger"><?= form_error("txt_email") ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_akses">Akses</label>
                                        <select name="txt_akses" id="txt_akses" class="form-control">
                                            <option value="">-- Pilih Akses --</option>
                                            <?php foreach ($akses as $key => $value) : 
                                                $select = (set_value('txt_akses') == $value->id_akses) ? "selected" : "" ;
                                                ?>
                                                <option value="<?= $value->id_akses ?>" <?= $select ?>><?= $value->akses ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-danger"><?= form_error("txt_akses") ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_status">Status</label>
                                        <select name="txt_status" id="txt_status" class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="aktif" <?= (set_value('txt_status') == "aktif") ? "selected" : "" ; ?>>Aktif</option>
                                            <option value="nonaktif" <?= (set_value('txt_status') == "nonaktif") ? "selected" : "" ; ?>>Nonaktif</option>
                                        </select>
                                        <small class="text-danger"><?= form_error("txt_status") ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_username">Password</label>
                                        <input type="password" name="txt_password" id="txt_password" class="form-control"  value="<?= set_value("txt_password") ?>">
                                        <div class="mt-1">
                                            <input type="checkbox" class="float-left mr-1" name="show_pw" id="show_pw" onclick="showPass(this,'txt_password')">
                                            <label for="show_pw">show Password</label>
                                        </div>
                                        <small class="text-danger"><?= form_error("txt_password") ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_username_user">Retype Password</label>
                                        <input type="password" name="txt_retype_password" id="txt_retype_password" class="form-control" value="<?= set_value("txt_retype_password") ?>">
                                        <div class="mt-1">
                                            <input type="checkbox" class="float-left mr-1" name="show_pw2" id="show_pw2" onclick="showPass(this,'txt_retype_password')">
                                            <label for="show_pw2">show Password</label>
                                        </div>
                                        <small class="text-danger"><?= form_error("txt_retype_password") ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_alamat">Alamat</label>
                                        <textarea class="form-control" name="txt_alamat" id="txt_alamat" rows="4"><?= set_value("txt_alamat") ?></textarea>
                                        <small class="text-danger"><?= form_error("txt_alamat") ?></small>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txt_foto">Photo</label>
                                        <img class="img-profile" style="max-height: 150px;">
                                        <input type="file" name="txt_foto" id="txt_foto" class="form-control">
                                        <small class="text-info">* Max Size 1024 Kb</small>
                                        <small class="text-danger"><?= form_error("txt_foto") ?></small>
                                    </div>
                                </div>
                            </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a href="<?= base_url() ?>kelolauser" id="batal" class="btn btn-sm btn-dark float-right">Batal</a>
                                        <button type="submit" class="btn btn-sm btn-success float-right mr-2">Simpan</button>
                                    </div>
                                </div>
                                </form>                                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>