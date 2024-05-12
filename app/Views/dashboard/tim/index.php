<?= $this->extend('layouts/dashboardMaster') ?>
<?= $this->section('main') ?>
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
                                        <th>Nama Tim</th>
                                        <th>NIP</th>
                                        <th>Gender</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>No</th>
                                        <th>Nama Tim</th>
                                        <th>NIP</th>
                                        <th>Gender</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                      $no = 1;
                                      foreach($tims as $tim) : 
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $tim->nama_tim ?></td>
                                            <td><?= $tim->nip ?></td>
                                            <td><?= $tim->gender ?></td>
                                            <td><?= $tim->telepon ?></td>
                                            <td>
                                                <?php if(session()->get('userdata')->role == 'Ketua Bagian Umum' || session()->get('userdata')->role == 'Kepala PSDMBP') : ?>
                                                  <p class="text-muted">Aksi Tidak Mendapat Izin</p>
                                                <?php else : ?>
                                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ubahModal"
                                                      onclick="setData('<?= $tim->tim_id ?>', '<?= $tim->nama_tim ?>', '<?= $tim->nip ?>', '<?= $tim->gender ?>', '<?= $tim->telepon ?>')">
                                                      <i class="fa fa-edit"></i>
                                                  </button>
                                                  <form action="/tim/<?= $tim->tim_id ?>" method="post" class="d-inline">
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
        <form action="/tim" method="post" id="tambahForm">
            <div class="mb-3">
                <label>Nama Tim</label>
                <input type="text" name="nama_tim" class="form-control">
            </div>
            <div class="mb-3">
                <label>NIP</label>
                <input type="text" name="nip" class="form-control">
            </div>
            <div class="mb-3">
                <label class="d-block">Gender</label>
                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                  <label class="btn btn-light">
                    <input type="radio" name="gender" value="Laki-laki" id="laki"> Laki-laki
                  </label>
                  <label class="btn btn-light">
                    <input type="radio" name="gender" value="Perempuan" id="perempuan"> Perempuan
                  </label>
                </div>
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="number" name="telepon" class="form-control">
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
                <label>Nama Tim</label>
                <input type="text" name="nama_tim" id="ubahNamaTim" class="form-control">
            </div>
            <div class="mb-3">
                <label>NIP</label>
                <input type="text" name="nip" id="ubahNIP" class="form-control">
            </div>
            <div class="mb-3">
                <label class="d-block">Gender</label>
                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                  <label class="btn btn-light" id="labelLaki">
                    <input type="radio" name="gender" value="Laki-laki" id="ubahLaki"> Laki-laki
                  </label>
                  <label class="btn btn-light" id="labelPerempuan">
                    <input type="radio" name="gender" value="Perempuan" id="ubahPerempuan"> Perempuan
                  </label>
                </div>
            </div>
            <div class="mb-3">
                <label>Telepon</label>
                <input type="number" name="telepon" id="ubahTelepon" class="form-control">
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

<script>
    function setData(timID, namaTim, nip, gender, telepon) {
        ubahForm.action = '/tim/' + timID;
        ubahNamaTim.value = namaTim;
        ubahNIP.value = nip;
        if(gender == 'Laki-laki') {
          ubahLaki.checked = true;
          labelLaki.classList.add('active');
          labelLaki.classList.add('focus');
        }else {
          ubahPerempuan.checked = true;
          labelPerempuan.classList.add('active');
          labelPerempuan.classList.add('focus')
        }
        ubahTelepon.value = telepon;
    }
</script>
<?= $this->endSection() ?>