<?= $this->extend('admin/layout/main')?>

<?= $this->section('style')?>
    <link rel="stylesheet" href="<?=site_url('assets')?>/modules/select2/dist/css/select2.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header ml-auto shadow">
    <div class="section-header-back">
        <a href="<?=site_url('admin/users')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah Data User</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a></div>
        <div class="breadcrumb-item active"><a href="<?= site_url('admin/users') ?>">Users</a></div>
        <div class="breadcrumb-item">Tambah user</div>
    </div>
</div>
<div class="section-body">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
    <form action="<?=site_url('admin/users')?>" method="POST">
        <?=csrf_field()?>
        <div class="col-md-5">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?=old('username')?>" required autofocus>
                <small class="text-muted">Username hanya boleh huruf kecil, angka, underscore, dan titik</small>
            </div>
            <div class="form-group">
                <label>Nama Tampilan</label>
                <input type="text" name="display_name" class="form-control" value="<?=old('display_name')?>" required>
                <small class="text-muted">Nama yang akan ditampilkan kepada pengguna lain</small>
            </div>
            <div class="form-group">
                <label>Masukkan Email</label>
                <input type="email" name="email" class="form-control" value="<?=old('email')?>" required>
            </div>
            <div class="form-group">
                <label>Masukkan Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <input type="password" name="password" class="form-control pwstrength" data-indicator="pwindicator" value="<?=old('password')?>" required>
                </div>
                <div class="pwindicator" id="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control select2" required>
                    <option value="">Pilih Role</option>
                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="author" <?= old('role') == 'author' ? 'selected' : '' ?>>Author</option>
                    <option value="reader" <?= old('role') == 'reader' ? 'selected' : '' ?>>Reader</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Tambah User</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </form>
</div>
<?= $this->endSection()?>

<?= $this->section('js') ?>
<script src="<?=base_url('assets')?>/modules/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url('assets')?>/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
<script>
    $(document).ready(function() {
        $(".pwstrength").pwstrength({
            ui: {
                container: "#pwindicator",
                showVerdictsInsideProgressBar: false,
                viewports: {
                    progress: ".bar",
                    verdict: ".label"
                }
            }
        });
    });
</script>
<?= $this->endSection()?>