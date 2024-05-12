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
                                        <th>Nama Barang</th>
                                        <th>Klasifikasi</th>
                                        <th>Tanggal Beli</th>
                                        <th>Jumlah</th>
                                        <th>Kondisi</th>
                                        <th>Merk</th>
                                        <th>Supplier</th>
                                        <th>Lokasi</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Klasifikasi</th>
                                        <th>Tanggal Beli</th>
                                        <th>Jumlah</th>
                                        <th>Kondisi</th>
                                        <th>Merk</th>
                                        <th>Supplier</th>
                                        <th>Lokasi</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                      $no = 1;
                                      foreach($barangs as $barang) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $barang->nama_barang ?></td>
                                            <td><?= $barang->klasifikasi ?></td>
                                            <td><?= $barang->tanggal_beli ?></td>
                                            <td><?= $barang->jumlah ?></td>
                                            <td><?= $barang->kondisi ?></td>
                                            <td><?= $barang->merk ?></td>
                                            <td><?= $barang->nama_supplier ?></td>
                                            <td><?= $barang->lokasi ?></td>
                                            <td><?= $barang->penanggung_jawab ?></td>
                                            <td>
                                                <?php if(session()->get('userdata')->role == 'Ketua Bagian Umum' || session()->get('userdata')->role == 'Kepala PSDMBP') : ?>
                                                  <p class="text-muted">Aksi Tidak Mendapat Izin</p>
                                                <?php else : ?>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ubahModal"
                                                      onclick="setData('<?= $barang->kode_barang ?>', '<?= $barang->nama_barang ?>', '<?= $barang->klasifikasi ?>', '<?= $barang->tanggal_beli ?>', '<?= $barang->jumlah ?>', '<?= $barang->kondisi ?>', '<?= $barang->merk ?>', '<?= $barang->supplier_id ?>', '<?= $barang->lokasi ?>', '<?= $barang->penanggung_jawab ?>')">
                                                      <i class="fa fa-edit"></i>
                                                  </button>
                                                  <form action="/barang/<?= $barang->kode_barang ?>" method="post" class="d-inline">
                                                      <input type="hidden" name="_method" value="DELETE">
                                                      <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i class="fa fa-trash"></i></button>
                                                  </form>
                                                <?php endif ?>
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
        <form action="/barang" method="post" id="tambahForm">
            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control">
            </div>
            <div class="mb-3">
                <label>Klasifikasi</label>
                <input type="text" name="klasifikasi" class="form-control">
            </div>
            <div class="mb-3">
                <label>jumlah</label>
                <input type="number" name="jumlah" class="form-control">
            </div>
            <div class="mb-3">
                <label>Kondisi</label>
                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                  <label class="btn btn-light" id="label">
                    <input type="radio" name="kondisi" value="Baik"> Baik
                  </label>
                  <label class="btn btn-light" id="label">
                    <input type="radio" name="kondisi" value="Tidak Lengkap"> Tidak Lengkap
                  </label>
                  <label class="btn btn-light" id="label">
                    <input type="radio" name="kondisi" value="Rusak"> Rusak
                  </label>
                </div>
            </div>
            <div class="mb-3">
                <label>Merk</label>
                <input type="text" name="merk" class="form-control">
            </div>
            <div class="mb-3">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control tomSelectTambah">
                  <option value="">--- Pilih Supplier ---</option>
                  <?php foreach($suppliers as $supplier) : ?>
                    <option value="<?= $supplier->supplier_id ?>"><?= $supplier->nama_supplier ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Lokasi</label>
                <input type="text" name="lokasi" class="form-control">
            </div>
            <div class="mb-3">
                <label>Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" class="form-control">
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
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" id="ubahNamaBarang" class="form-control">
            </div>
            <div class="mb-3">
                <label>Klasifikasi</label>
                <input type="text" name="klasifikasi" id="ubahKlasifikasi" class="form-control">
            </div>
            <div class="mb-3 row">
              <div class="col-6">
                <label>Tanggal Beli (Tanggal)</label>
                <input type="date" name="tanggal_beli_date" id="ubahTanggalBeliDate" class="form-control">
              </div>
              <div class="col-6">
                <label>Tanggal Beli (Jam)</label>
                <input type="time" name="tanggal_beli_time" id="ubahTanggalBeliTime" class="form-control">
              </div>
            </div>
            <div class="mb-3">
                <label>jumlah</label>
                <input type="number" name="jumlah" id="ubahJumlah" class="form-control">
            </div>
            <div class="mb-3">
                <label>Kondisi</label>
                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                  <label class="btn btn-light" id="labelBaik">
                    <input type="radio" name="kondisi" value="Baik" id="ubahBaik"> Baik
                  </label>
                  <label class="btn btn-light" id="labelTidakLengkap">
                    <input type="radio" name="kondisi" value="Tidak Lengkap" id="ubahTidakLengkap"> Tidak Lengkap
                  </label>
                  <label class="btn btn-light" id="labelRusak">
                    <input type="radio" name="kondisi" value="Rusak" id="ubahRusak"> Rusak
                  </label>
                </div>
            </div>
            <div class="mb-3">
                <label>Merk</label>
                <input type="text" name="merk" id="ubahMerk" class="form-control">
            </div>
            <div class="mb-3">
                <label>Supplier</label>
                <select name="supplier_id" id="ubahSupplier" class="form-control tomSelectUbah">
                  <option value="">--- Pilih Supplier ---</option>
                  <?php foreach($suppliers as $supplier) : ?>
                    <option value="<?= $supplier->supplier_id ?>"><?= $supplier->nama_supplier ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Lokasi</label>
                <input type="text" name="lokasi" id="ubahLokasi" class="form-control">
            </div>
            <div class="mb-3">
                <label>Penanggung Jawab</label>
                <input type="text" name="penanggung_jawab" id="ubahPenanggungJawab" class="form-control">
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
    function setData(kodeBarang, namaBarang, klasifikasi, tanggalBeli, jumlah, kondisi, merk, supplierID, lokasi, penanggungJawab) {
        ubahForm.action = '/barang/' + kodeBarang;
        ubahNamaBarang.value = namaBarang;
        ubahKlasifikasi.value = klasifikasi;
        ubahTanggalBeliDate.value = tanggalBeli.split(' ')[0];
        ubahTanggalBeliTime.value = tanggalBeli.split(' ')[1];
        ubahJumlah.value = jumlah;
        if(kondisi == 'Baik') {
          ubahBaik.checked = true;
          labelBaik.classList.add('active');
          labelBaik.classList.add('focus');
        }else if(kondisi == 'Tidak Lengkap') {
          ubahTidakLengkap.checked = true;
          labelTidakLengkap.classList.add('active');
          labelTidakLengkap.classList.add('focus');
        }else if(kondisi == 'Rusak') {
          ubahRusak.checked = true;
          labelRusak.classList.add('active');
          labelRusak.classList.add('focus')
        }
        ubahMerk.value = merk;
        ubahSupplierID.setValue([supplierID]);
        ubahLokasi.value = lokasi;
        ubahPenanggungJawab.value = penanggungJawab;
    }

    new TomSelect(".tomSelectTambah",{
      create: true,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });

    let ubahSupplierID = new TomSelect(".tomSelectUbah",{
      create: true,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });
</script>
<?= $this->endSection() ?>