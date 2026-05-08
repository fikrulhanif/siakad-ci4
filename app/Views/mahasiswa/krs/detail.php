<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h3>Detail KRS</h3>

<table class="table table-bordered">
<tr>
  <th>Semester</th>
  <td><?= $krs['semester'] ?></td>
</tr>
<tr>
  <th>Tahun Ajaran</th>
  <td><?= $krs['tahun_ajaran'] ?></td>
</tr>
<tr>
  <th>Tanggal KRS</th>
  <td><?= $krs['tgl_krs'] ?></td>
</tr>
</table>

<hr>

<table class="table table-striped">
<thead>
<tr>
  <th>No</th>
  <th>Kode MK</th>
  <th>Nama Matakuliah</th>
  <th>SKS</th>
</tr>
</thead>
<tbody>
<?php $no = 1;
foreach ($detail as $d): ?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= $d['kd_mk'] ?></td>
  <td><?= $d['nama_mk'] ?></td>
  <td><?= $d['sks'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
<tfoot>
<tr>
  <th colspan="3" class="text-right">Total SKS</th>
  <th><?= $total_sks ?></th>
</tr>
</tfoot>
</table>

<a href="<?= site_url('mahasiswa/krs') ?>" class="btn btn-secondary">
  Kembali
</a>

<?= $this->endSection() ?>
