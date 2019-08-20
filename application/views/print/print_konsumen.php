<?php 
$this->load->view('partials/print_header');
?>

<div class="cover-text">
  <h3 class="text-center mb-1">Data Konsumen</h3>
  <table class="no-border">
    <tbody class="unborder">
      <tr>
        <td>
          <h4>Data Diri</h4>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title"><?= ucwords($rs_konsumen['id_type']) ?></small>
        </td>
        <td>
          <small class="txt-title">: <?= ucwords($rs_konsumen['id_card']) ?></small>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title">Nama Konsumen</small>
        </td>
        <td>
          <small class="txt-title">: <?= ucwords($rs_konsumen['nama_lengkap']) ?></small>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title">Jenis Kelamin</small>
        </td>
        <td>
          <small class="txt-title">: <?= $rs_konsumen['jenis_kelamin'] == 'l' ? 'Laki laki' : 'Perempuan'; ?></small>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title">Alamat</small>
        </td>
        <td>
          <small class="txt-title">: <?= $rs_konsumen['alamat']; ?></small>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title">Telepon</small>
        </td>
        <td>
          <small class="txt-title">: <?= $rs_konsumen['telp']; ?></small>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title">Email</small>
        </td>
        <td>
          <small class="txt-title">: <?= $rs_konsumen['email']; ?></small>
        </td>
      </tr>
      <tr>
        <td>
          <h4>Data Pekerjaan</h4>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title">NPWP</small>
        </td>
        <td>
          <small class="txt-title">: <?= $rs_konsumen['npwp']; ?></small>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title">Pekerjaan</small>
        </td>
        <td>
          <small class="txt-title">: <?= $rs_konsumen['pekerjaan']; ?></small>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title">Alamat Kantor</small>
        </td>
        <td>
          <small class="txt-title">: <?= $rs_konsumen['alamat_kantor']; ?></small>
        </td>
      </tr>
      <tr>
        <td class="w-tr">
          <small class="txt-title">Telepon Kantor</small>
        </td>
        <td>
          <small class="txt-title">: <?= $rs_konsumen['telp_kantor']; ?></small>
        </td>
      </tr>
      <tr>
        <td>
          <div style="width: 130px;height: 130px;border:1px solid black;text-align: center;margin-top: 50px;">
            FOtO</div>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="row p-3">
  </div>
</div>

<?php
$this->load->view('partials/print_footer');
?>