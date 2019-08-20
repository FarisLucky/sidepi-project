<div class="content-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <h4 class="dark txt_title d-inline-block mt-2">Kelola RAB Bangunan</h4>
            <a href="<?= base_url().'properti' ?>" class="btn btn-dark float-right"><i
                class="fa fa-arrow-circle-left"></i> Lihat Properti</a>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <h4 class="mb-3">Data RAB Unit </h4>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="txt_names">Nama Rab</label>
                    <input type="text" name="nama_rab" value="<?php echo $rab_unit->nama_rab?> " class="form-control"
                      id="txt_names" readonly>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="txt_total">Total Anggaran</label>
                    <input type="text" name="total_anggaran"
                      value="<?php echo number_format($rab_unit->total_anggaran,2,',','.')?> " class="form-control"
                      id="txt_total" readonly>
                  </div>
                </div>
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
                <h5 class="d-inline-block"><i class="fa fa-m"></i>Kelola RAB</h5>
                <a href="<?= base_url() ?>rab/tambahunit/<?= $rab_unit->id_rab ?>"
                  class="btn btn-info btn-sm float-right">Tambah</a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-hover" id="tbl_to_tables">
                    <thead>
                      <th>No</th>
                      <th>Nama Detail</th>
                      <th>Volume</th>
                      <th>Satuan</th>
                      <th>Harga Satuan</th>
                      <th>Total Harga</th>
                      <th>Kelompok</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach($kelola_rab as $k){ 
                                        ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $k->nama_detail ?></td>
                        <td><?php echo $k->volume ?></td>
                        <td><?php echo $k->satuan ?></td>
                        <td><?php echo number_format($k->harga_satuan,2,',','.') ?></td>
                        <td><?php echo number_format($k->total_harga,2,',','.') ?></td>
                        <td><?php echo $k->kelompok_pengeluaran ?></td>
                        <td><a href="<?= base_url() .'rab/editunit'?>/<?= $k->id_detail ?>"
                            class="btn btn-sm btn-primary mx-2"><i class="fa fa-edit"></i> Edit</a><button type="button"
                            class="btn btn-sm btn-danger"
                            onclick="deleteItem('<?= base_url('rab/hapus/'.$k->id_detail) ?>')"><i
                              class="fa fa-trash"></i> Delete</a></td>
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