<div class="content-wrapper" id="list_transaksi">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-sm-12">
                <h4 class="dark txt_title d-inline-block mt-2">List Transaksi</h4>
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
              <div class="col-sm-6">
                <h5 class="d-inline-block">Tambah Transaksi</h5>
              </div>
              <div class="col-sm-6 text-right">
                <a href="<?= base_url() ?>transaksi/tambah" class="btn btn-sm btn-primary ml-4"><i class="fa fa-plus">
                    Tambah</i></a>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-hover display responsive no-wrap" id="tbl_to_tables">
                  <thead>
                    <th>No SPR</th>
                    <th>Nama Konsumen</th>
                    <th>Unit</th>
                    <th>Total Kesepakatan</th>
                    <th>Pembayaran</th>
                    <th>Tanggal Transaksi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    <th>Lock</th>
                  </thead>
                  <tbody>
                    <?php foreach ($list_transaksi as $key => $value) : 
                      if ($value->status_transaksi == "s") {
                          $status = "Sementara";
                      } elseif ($value->status_transaksi == "p") {
                          $status = "Pending";
                      } else {
                          $status = "Selesai";
                      }
                      ?>
                    <tr>
                      <td><?= $value->no_spr ?></td>
                      <td><?= $value->nama_lengkap ?></td>
                      <td><?= $value->nama_unit ?></td>
                      <td><?= number_format($value->total_kesepakatan,2,',','.') ?></td>
                      <td><?= $value->type_bayar ?></td>
                      <td><?= $value->tgl_transaksi ?></td>
                      <td>
                        <div class="badge badge-primary"><?= $status ?></div>
                      </td>
                      <td>
                        <?php if (($value->kunci != "l") && ($value->status_transaksi == "s")) { ?>
                        <a href="<?= base_url() ?>transaksi/detail/<?= $value->id_transaksi ?>" class="btn btn-sm"><i
                            class="fa fa-info" data-toggle="tooltip" data-placement="bottom" title="Detail"></i></a>
                        <a onclick="deleteItem('<?= base_url('transaksi/delete/'.$value->id_transaksi) ?>')"
                          class="delete-transaksi"><i class="fa fa-trash text-danger" data-toggle="tooltip"
                            data-placement="bottom" title="Hapus"></i></a>
                        <a href="<?= base_url() ?>transaksi/edit/<?= $value->id_transaksi ?>" class="btn btn-sm"><i
                            class="fa fa-pencil-square text-info" data-toggle="tooltip" data-placement="bottom"
                            title="Edit"></i></a>
                        <?php } elseif (($value->kunci != "lock") && ($value->status_transaksi == "progress")) { ?>
                        <a href="<?= base_url() ?>transaksi/detail/<?= $value->id_transaksi ?>" class="btn btn-sm"><i
                            class="fa fa-info" data-toggle="tooltip" data-placement="bottom" title="Detail"></i></a>
                        <a href="<?= base_url() ?>transaksi/edit/<?= $value->id_transaksi ?>" class="btn btn-sm"><i
                            class="fa fa-pencil-square text-info" data-toggle="tooltip" data-placement="bottom"
                            title="Edit"></i></a>
                        <?php } else{ ?>
                        <a href="<?= base_url() ?>transaksi/detail/<?= $value->id_transaksi ?>" class="btn btn-sm"><i
                            class="fa fa-info" data-toggle="tooltip" data-placement="bottom" title="Detail"></i></a>
                        <a href="<?= base_url() ?>transaksi/printspr/<?= $value->id_transaksi ?>" class="btn btn-sm"
                          data-id="<?= $value->id_transaksi ?>"><i class="fa fa-print text-warning"
                            data-toggle="tooltip" data-placement="bottom" title="Print SPR "></i></a>
                        <?php }?>
                      </td>
                      <td>
                        <?php if ($value->kunci != "l") { ?>
                        <a onclick="setItem('<?= base_url('transaksi/lock/'.$value->id_transaksi) ?>','Lock')"
                          class="btn btn-sm lock" data-id="<?= $value->id_transaksi ?>"><i
                            class="fa fa-unlock text-danger lock" data-toggle="tooltip" data-placement="bottom"
                            title="Lock ?"></i></a></td>
                      <?php }else{ ?>
                      <i class="fa fa-lock text-success" data-toggle="tooltip" data-placement="bottom"
                        title="Lock ?"></i></td>
                      <?php } ?>
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