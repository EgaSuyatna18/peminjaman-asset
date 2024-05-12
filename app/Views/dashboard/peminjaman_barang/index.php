<?= $this->extend('layouts/dashboardMaster') ?>
<?= $this->section('main') ?>
<!-- tomselect -->
<link rel="stylesheet" href="/tomselect/tom-select.bootstrap4.min.css">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between">
                        <h1 class="m-0 font-weight-bold text-primary">Data Table <?= $title ?></h1>
                        <?php if(session()->get('userdata')->role != 'Ketua Bagian Umum' && session()->get('userdata')->role != 'Kepala PSDMBP') : ?>
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahModal">
                              <i class="fa fa-plus"></i>
                          </button>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mt-3" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Deadline Kembali</th>
                                        <th>Penanggung Jawab Peminjam</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Deadline Kembali</th>
                                        <th>Penanggung Jawab Peminjam</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                      $no = 1;
                                      foreach($peminjamans as $peminjaman) : 
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $peminjaman->nama_barang ?></td>
                                            <td><?= $peminjaman->jumlah ?></td>
                                            <td><?= $peminjaman->tanggal_pinjam ?></td>
                                            <td><?= $peminjaman->deadline_kembali ?></td>
                                            <td><?= $peminjaman->penanggung_jawab_peminjaman ?></td>
                                            <td>
                                                <?php if(session()->get('userdata')->role == 'Ketua Bagian Umum' || session()->get('userdata')->role == 'Kepala PSDMBP') : ?>
                                                  <p class="text-muted">Aksi Tidak Mendapat Izin</p>
                                                <?php else : ?>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ubahModal"
                                                      onclick="setData('<?= $peminjaman->peminjaman_barang_id ?>', '<?= $peminjaman->kode_barang ?>', '<?= $peminjaman->jumlah ?>', '<?= $peminjaman->tanggal_pinjam ?>', '<?= $peminjaman->deadline_kembali ?>', '<?= $peminjaman->penanggung_jawab_peminjaman ?>')">
                                                      <i class="fa fa-edit"></i>
                                                  </button>
                                                  <form action="/peminjaman_barang/<?= $peminjaman->peminjaman_barang_id ?>" method="post" class="d-inline">
                                                      <input type="hidden" name="_method" value="DELETE">
                                                      <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i class="fa fa-trash"></i></button>
                                                  </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

<!-- Modal -->
<div class="modal fade" id="tambahModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Tambah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/peminjaman_barang" method="post" id="tambahForm">
            <div class="mb-3">
                <label>Barang</label>
                <select name="kode_barang" class="form-control tomSelectTambah">
                  <option value="">--- Pilih Barang ---</option>
                  <?php foreach($barangs as $barang) : ?>
                    <option value="<?= $barang->kode_barang ?>"><?= $barang->nama_barang ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control">
            </div>
            <div class="mb-3 row">
              <div class="col-6">
                <label>Tanggal Pinjam (Tanggal)</label>
                <input type="date" name="tanggal_pinjam_date" id="tanggal_pinjam_date" class="form-control" readonly>
              </div>
              <div class="col-6">
                <label>Tanggal Pinjam (Jam)</label>
                <input type="time" name="tanggal_pinjam_time" id="tanggal_pinjam_time" class="form-control" readonly>
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-6">
                <label>Deadline Kembali (Tanggal)</label>
                <input type="date" name="deadline_kembali_date" class="form-control">
              </div>
              <div class="col-6">
                <label>Deadline Kembali (Jam)</label>
                <input type="time" name="deadline_kembali_time" class="form-control">
              </div>
            </div>
            <div class="mb-3">
                <label>Penanggung Jawab Peminjaman</label>
                <input type="text" name="penanggung_jawab_peminjaman" class="form-control">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="tambahForm" class="btn btn-success">Submit</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="ubahModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ubahModalLabel">Ubah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="ubahForm">
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-3">
                <label>Barang</label>
                <select name="kode_barang" class="form-control tomSelectUbah">
                  <option value="">--- Pilih Barang ---</option>
                  <?php foreach($barangs as $barang) : ?>
                    <option value="<?= $barang->kode_barang ?>"><?= $barang->nama_barang ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" id="ubahJumlah" class="form-control">
            </div>
            <div class="mb-3 row">
              <div class="col-6">
                <label>Tanggal Pinjam (Tanggal)</label>
                <input type="date" name="tanggal_pinjam_date" id="ubahTanggalPinjamDate" class="form-control">
              </div>
              <div class="col-6">
                <label>Tanggal Pinjam (Jam)</label>
                <input type="time" name="tanggal_pinjam_time" id="ubahTanggalPinjamTime" class="form-control">
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-6">
                <label>Deadline Kembali (Tanggal)</label>
                <input type="date" name="deadline_kembali_date" id="ubahDeadlineKembaliDate" class="form-control">
              </div>
              <div class="col-6">
                <label>Deadline Kembali (Jam)</label>
                <input type="time" name="deadline_kembali_time" id="ubahDeadlineKembaliTime" class="form-control">
              </div>
            </div>
            <div class="mb-3">
                <label>Penanggung Jawab Peminjaman</label>
                <input type="text" name="penanggung_jawab_peminjaman" id="ubahPenanggungJawabPeminjaman" class="form-control">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="ubahForm" class="btn btn-success">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- tomselect -->
<script src="/tomselect/tom-select.complete.min.js"></script>

<script>
  const currentDate = new Date();
  const year = currentDate.getFullYear();
  const month = String(currentDate.getMonth() + 1).padStart(2, '0');
  const day = String(currentDate.getDate()).padStart(2, '0');
  const hours = String(currentDate.getHours()).padStart(2, '0');
  const minutes = String(currentDate.getMinutes()).padStart(2, '0');
  const formattedDate = `${year}-${month}-${day}`;
  const formattedTime = `${hours}:${minutes}`;

  tanggal_pinjam_date.value = formattedDate;
  tanggal_pinjam_time.value = formattedTime;

    function setData(peminjamanBarangID, kodeBarang, jumlah, tanggalPinjam, deadlineKembali, penanggungJawabPeminjaman) {
        ubahForm.action = '/peminjaman_barang/' + peminjamanBarangID;
        ubahKodeBarang.setValue([kodeBarang]);
        ubahJumlah.value = jumlah;
        ubahTanggalPinjamDate.value = tanggalPinjam.split(' ')[0];
        ubahTanggalPinjamTime.value = tanggalPinjam.split(' ')[1];
        ubahDeadlineKembaliDate.value = deadlineKembali.split(' ')[0];
        ubahDeadlineKembaliTime.value = deadlineKembali.split(' ')[1];
        ubahPenanggungJawabPeminjaman.value = penanggungJawabPeminjaman;
    }

    new TomSelect(".tomSelectTambah",{
      create: true,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });

    let ubahKodeBarang = new TomSelect(".tomSelectUbah",{
      create: true,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });
</script>
<?= $this->endSection() ?>