<div class="content-wrapper" id="approve_bayar">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">Approve Pembayaran</h4>
                <img id="logo_perusahaan" width="50px"
                  src="<?php echo base_url().'assets/uploads/images/properti/'.$img->logo_perusahaan ?>"
                  class="float-right" alt="">
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
                <table class="table table-hover table-striped" id="tbl_to_tables">
                  <thead>
                    <th>Pembayaran</th>
                    <th>Properti</th>
                    <th>Unit</th>
                    <th>Jumlah Bayar</th>
                    <th>Rekening</th>
                    <th>Status Manager</th>
                    <th>Realisasi</th>
                    <th>Hutang</th>
                    <th>Tanggal Bayar</th>
                    <th>Bukti</th>
                    <th>Pembuat</th>
                    <th>Aksi</th>
                  </thead>
                  <tbody>
                    <?php foreach ($approve_bayar as $key => $value) : 
                      if ($value->bukti_bayar != '') {
                        $img = '<a href="'.base_url('assets/uploads/images/pembayaran/'.$value->bukti_bayar).'" data-lightbox="data'.$value->id_detail.'"><img src="'.base_url('assets/uploads/images/pembayaran/'.$value->bukti_bayar).'"></a>';
                      } else {
                        $img = '<i>Belum Upload</i>';
                      }
                      ?>
                    <tr>
                      <td><?= $value->nama_pembayaran ?></td>
                      <td><?= $value->nama_properti ?></td>
                      <td><?= $value->nama_unit ?></td>
                      <td> <?= number_format($value->jumlah_bayar,2,',','.') ?></td>
                      <td><?= $value->no_rekening." ".$value->bank ?></td>
                      <td><span
                          class="badge badge-info"><?= $value->status_manager == 's' ? '-' : ($value->status_manager == 'p' ? 'pending' : 'selesai') ; ?></span>
                      </td>
                      <td><?= number_format($value->total_bayar,2,',','.') ?></td>
                      <td><?= number_format($value->hutang,2,',','.') ?></td>
                      <td>
                        <?php $date = DateTime::createFromFormat('Y-m-d H:i:s',$value->tgl_bayar); echo tanggal($date->format('d'),$date->format('m'),$date->format('Y')).' '.$date->format('H:i:s') ?>
                      </td>
                      <td><?= $img ?>
                      <td><?php echo $value->nama_lengkap;?></td>
                      </td>
                      <td>
                        <button type="button" class="btn btn-icons btn-inverse-primary ml-2"
                          onclick="setItem('<?= base_url('approve/accept/'.$value->id_detail) ?>','Terima')">
                          <i class="fa fa-check"></i></button>
                        <button type="button" class="btn btn-icons btn-inverse-danger"
                          onclick="setItem('<?= base_url('approve/reject/'.$value->id_detail) ?>','Tolak')">
                          <i class="fa fa-ban"></i></button>
                      </td>
                    </tr>
                    <?php endforeach; ?>
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