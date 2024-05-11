<?= $this->extend('layouts/dashboardMaster') ?>
<?= $this->section('main') ?>
    <!-- tomselect -->
    <link rel="stylesheet" href="/tomselect/tom-select.bootstrap4.min.css">
<!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between">
                        <h1 class="m-0 font-weight-bold text-primary">Data Table <?= $title ?></h1>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambahModal">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mt-3" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tim</th>
                                        <th>Nama Pengusul</th>
                                        <th>KAK</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tim</th>
                                        <th>Nama Pengusul</th>
                                        <th>KAK</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                      $no = 1;
                                      foreach($penambahan_barang_barus as $penambahan_barang_baru) : 
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $penambahan_barang_baru->nama_tim ?></td>
                                            <td><?= $penambahan_barang_baru->nama_pengusul ?></td>
                                            <td><a href="<?= $penambahan_barang_baru->kak ?>" target="_blank">Lihat Data</a></td>
                                            <td><?= $penambahan_barang_baru->status ?></td>
                                            <td>
                                              <a href="/penambahan_barang_baru/<?= $penambahan_barang_baru->penambahan_barang_baru_id ?>/diterima" class="btn btn-success"><i class="fa fa-check"></i></a>
                                              <a href="/penambahan_barang_baru/<?= $penambahan_barang_baru->penambahan_barang_baru_id ?>/ditolak" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ubahModal"
                                                    onclick="setData('<?= $penambahan_barang_baru->penambahan_barang_baru_id ?>', '<?= $penambahan_barang_baru->tim_id ?>', '<?= $penambahan_barang_baru->nama_pengusul ?>')">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <form action="/penambahan_barang_baru/<?= $penambahan_barang_baru->penambahan_barang_baru_id ?>" method="post" class="d-inline">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i class="fa fa-trash"></i></button>
                                                </form>
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
        <form action="/penambahan_barang_baru" method="post" id="tambahForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Tim Kerja</label>
                <select name="tim_id" class="form-control tomSelectTambah">
                  <option value="">--- Pilih Tim ---</option>
                  <?php foreach($tims as $tim) : ?>
                    <option value="<?= $tim->tim_id ?>"><?= $tim->nama_tim ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Nama Pengusul</label>
                <input type="text" name="nama_pengusul" class="form-control">
            </div>
            <div class="mb-3">
                <label>KAK</label>
                <input type="file" name="kak" class="form-control">
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
                <label>Tim Kerja</label>
                <select name="tim_id" class="form-control tomSelectUbah" id="ubahTimID">
                  <option value="">--- Pilih Tim ---</option>
                  <?php foreach($tims as $tim) : ?>
                    <option value="<?= $tim->tim_id ?>"><?= $tim->nama_tim ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Nama Pengusul</label>
                <input type="text" name="nama_pengusul" id="ubahNamaPengusul" class="form-control">
            </div>
            <div class="mb-3">
                <label>KAK</label>
                <input type="file" name="kak" class="form-control">
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
    function setData(penambahanBarangBaruID, timID, namaPengusul) {
        ubahForm.action = '/penambahan_barang_baru/' + penambahanBarangBaruID;
        ubahTimID.setValue([timID]);
        ubahNamaPengusul.value = namaPengusul;
    }

    new TomSelect(".tomSelectTambah",{
      create: true,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });

    let ubahTimID = new TomSelect(".tomSelectUbah",{
      create: true,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });
</script>
<?= $this->endSection() ?>