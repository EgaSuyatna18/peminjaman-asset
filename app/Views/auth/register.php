<?= $this->extend('layouts/authMaster') ?>
<?= $this->section('main') ?>
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-7 m-auto">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                            </div>
                            <form action="/register" method="post" class="user">
                                <div class="form-group">
                                    <input type="text" name="nama" class="form-control form-control-user" placeholder="Nama..." required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-user" placeholder="Username" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_konfirmasi" class="form-control form-control-user" placeholder="Password Konfirmasi" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select name="role" class="form-control" style="border-radius: 50px; height: 50px;" placeholder="123" required>
                                        <option value="" selected>-- pilih peran ---</option>
                                        <option>Petugas BMN</option>
                                        <option>Ketua Bagian Umum</option>
                                        <option>Pengurus Peralatan Pengeboran / Survei Explorasi</option>
                                        <option>Ketua Tim Kelompok Kerja</option>
                                        <option>Kepala PSDMBP</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="/">Sudah punya akun? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?= $this->endSection() ?>