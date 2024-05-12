<?= $this->extend('layouts/dashboardMaster') ?>
<?= $this->section('main') ?>
    <!-- tomselect -->
    <link rel="stylesheet" href="/tomselect/tom-select.bootstrap4.min.css">
    <!-- DataTales Example -->
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
                                        <th>Barang</th>
                                        <th>Kondisi Barang Kembali</th>
                                        <th>Dokumentasi</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Lokasi</th>
                                        <th>Penanggung Jawab Pengembalian</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Barang</th>
                                        <th>Kondisi Barang Kembali</th>
                                        <th>Dokumentasi</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Lokasi</th>
                                        <th>Penanggung Jawab Pengembalian</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                      $no = 1;
                                      foreach($pengembalians as $pengembalian) : 
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $pengembalian->nama_barang ?></td>
                                            <td><?= $pengembalian->kondisi_barang_kembali ?></td>
                                            <td><a href="<?= $pengembalian->dokumentasi ?>" target="_blank">Lihat Data</a></td>
                                            <td><?= $pengembalian->tanggal_kembali ?></td>
                                            <td><?= $pengembalian->lokasi ?></td>
                                            <td><?= $pengembalian->penanggung_jawab_pengembalian ?></td>
                                            <td><?= $pengembalian->jumlah ?></td>
                                            <td>
                                                <?php if(session()->get('userdata')->role == 'Ketua Bagian Umum' || session()->get('userdata')->role == 'Kepala PSDMBP') : ?>
                                                  <p class="text-muted">Aksi Tidak Mendapat Izin</p>
                                                <?php else : ?>
                                                  <button type="button" class="btn btn-warning mb-2" data-toggle="modal" data-target="#ubahModal"
                                                      onclick="setData('<?= $pengembalian->pengembalian_barang_id ?>', '<?= $pengembalian->kondisi_barang_kembali ?>', '<?= $pengembalian->tanggal_kembali ?>', '<?= $pengembalian->lokasi ?>', '<?= $pengembalian->penanggung_jawab_pengembalian ?>')">
                                                      <i class="fa fa-edit"></i>
                                                  </button>
                                                  <form action="/pengembalian_barang/<?= $pengembalian->pengembalian_barang_id ?>" method="post" class="d-inline">
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
        <form action="/pengembalian_barang" method="post" id="tambahForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Peminjaman Barang</label>
                <select onchange="setJumlahTambah()" name="peminjaman_barang_id" id="tambahPeminjamanBarangID" class="form-control tomSelectTambah">
                  <option value="">--- Pilih Peminjaman Barang ---</option>
                  <?php foreach($peminjamans as $peminjaman) : ?>
                    <option data-jumlah="<?= $peminjaman->jumlah ?>" value="<?= $peminjaman->peminjaman_barang_id ?>"><?= $peminjaman->nama_barang . ' - ' . $peminjaman->penanggung_jawab_peminjaman ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Kondisi Barang Kembali</label>
                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                  <label class="btn btn-light" id="label">
                    <input type="radio" name="kondisi_barang_kembali" value="Baik"> Baik
                  </label>
                  <label class="btn btn-light" id="label">
                    <input type="radio" name="kondisi_barang_kembali" value="Tidak Lengkap"> Tidak Lengkap
                  </label>
                  <label class="btn btn-light" id="label">
                    <input type="radio" name="kondisi_barang_kembali" value="Rusak"> Rusak
                  </label>
                </div>
            </div>
            <div class="mb-3">
                <label>Dokumentasi</label>
                <input type="file" name="dokumentasi" class="form-control">
            </div>
            <div class="mb-3 row">
              <div class="col-6">
                <label>Tanggal Kembali (Tanggal)</label>
                <input type="date" name="tanggal_kembali_date" id="tanggal_kembali_date" class="form-control" readonly>
              </div>
              <div class="col-6">
                <label>Tanggal Kembali (Jam)</label>
                <input type="time" name="tanggal_kembali_time" id="tanggal_kembali_time" class="form-control" readonly>
              </div>
            </div>
            <div class="mb-3">
                <label>Lokasi</label>
                <textarea name="lokasi" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Penanggung Jawab Pengembalian</label>
                <input type="text" name="penanggung_jawab_pengembalian" class="form-control">
            </div>
            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number" name="jumlah" id="tambahJumlah" class="form-control" readonly>
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
        <form method="post" id="ubahForm" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-3">
                <label>Kondisi Barang Kembali</label>
                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                  <label class="btn btn-light" id="labelBaik">
                    <input type="radio" name="kondisi_barang_kembali" value="Baik" id="ubahBaik"> Baik
                  </label>
                  <label class="btn btn-light" id="labelTidakLengkap">
                    <input type="radio" name="kondisi_barang_kembali" value="Tidak Lengkap" id="ubahTidakLengkap"> Tidak Lengkap
                  </label>
                  <label class="btn btn-light" id="labelRusak">
                    <input type="radio" name="kondisi_barang_kembali" value="Rusak" id="ubahRusak"> Rusak
                  </label>
                </div>
            </div>
            <div class="mb-3">
                <label>Dokumentasi</label>
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="dokumentasi" class="form-control">
            </div>
            <div class="mb-3 row">
              <div class="col-6">
                <label>Tanggal Kembali (Tanggal)</label>
                <input type="date" name="tanggal_kembali_date" id="ubahTanggalKembaliDate" class="form-control">
              </div>
              <div class="col-6">
                <label>Tanggal Kembali (Jam)</label>
                <input type="time" name="tanggal_kembali_time" id="ubahTanggalKembaliTime" class="form-control">
              </div>
            </div>
            <div class="mb-3">
                <label>Lokasi</label>
                <textarea name="lokasi" id="ubahLokasi" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Penanggung Jawab Pengembalian</label>
                <input type="text" name="penanggung_jawab_pengembalian" id="ubahPenanggungJawabPengembalian" class="form-control">
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

  tanggal_kembali_date.value = formattedDate;
  tanggal_kembali_time.value = formattedTime;

    function setJumlahTambah() {
      let tambahPeminjamanBarangID = document.getElementById('tambahPeminjamanBarangID');
      let selectedIndex = tambahPeminjamanBarangID.selectedIndex;
      let selectedOption = tambahPeminjamanBarangID.options[selectedIndex];
      let jumlah = selectedOption.getAttribute('data-jumlah');

      console.log(jumlah);
      tambahJumlah.value = jumlah;
    }

    function setData(pengambalianBarangID, kondisiBarangKembali, tanggalKembali, lokasi, penanggungJawabPengembalian) {
        ubahForm.action = '/pengembalian_barang/' + pengambalianBarangID;
        if(kondisiBarangKembali == 'Baik') {
          ubahBaik.checked = true;
          labelBaik.classList.add('active');
          labelBaik.classList.add('focus');
        }else if(kondisiBarangKembali == 'Tidak Lengkap') {
          ubahTidakLengkap.checked = true;
          labelTidakLengkap.classList.add('active');
          labelTidakLengkap.classList.add('focus');
        }else if(kondisiBarangKembali == 'Rusak') {
          ubahRusak.checked = true;
          labelRusak.classList.add('active');
          labelRusak.classList.add('focus');
        }
        ubahTanggalKembaliDate.value = tanggalKembali.split(' ')[0];
        ubahTanggalKembaliTime.value = tanggalKembali.split(' ')[1];
        ubahLokasi.value = lokasi;
        ubahPenanggungJawabPengembalian.value = penanggungJawabPengembalian;
    }

    new TomSelect(".tomSelectTambah",{
      create: true,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });
</script>
<?= $this->endSection() ?>