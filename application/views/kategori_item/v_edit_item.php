<?php foreach($kategori_item as $k){ ?>
<form action="<?php echo base_url(). 'index.php/kategori_item/update'; ?>" method="post">
	<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="dark txt_title d-inline-block mt-2">Edit Kategori Item</h4>
                                <!-- <img id="logo_perusahaan" width="50px" src="<?= base_url().'assets/uploads/images/profil/user/'.$perusahaan[0]['logo_perusahaan'] ?>" class="float-right" alt=""> -->
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
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- <img id="logo_perusahaan" width="50px" src="<?= base_url().'assets/uploads/images/profil/user/'.$perusahaan[0]['logo_perusahaan'] ?>" class="float-right" alt=""> -->
			                    <div class="form-group">
			                      <label for="exampleInputName1">nama kelompok</label>
			                        <input type="hidden" name = "id_kelompok" value = "<?php echo $k->id_kelompok ?>"class="form-control" id="exampleInputName1" placeholder="">
			                      <input type="text" name = "nama_kelompok" value = "<?php echo $k->nama_kelompok ?>"class="form-control" id="exampleInputName1" placeholder="">
			                    </div>
			                    <td></td>
			                    <button type="submit" class="btn btn-sm btn-success float-right">Simpan</button>
			                </form>
			                 </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                <?php } ?>