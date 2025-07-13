<?php $this->extend('admin/layout/main') ?>

<?php $this->section('title')?>
Edit User
<?php $this->endSection() ?>

<?= $this->section('style')?>
    <link rel="stylesheet" href="<?=site_url('assets')?>/modules/select2/dist/css/select2.min.css">
<?= $this->endSection() ?>

<?php $this->section('content')?>
<div class="section-header ml-auto shadow">
    <div class="section-header-back">
        <a href="<?=site_url('admin/users')?>" class="btn"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Data User</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a></div>
        <div class="breadcrumb-item active"><a href="<?= site_url('admin/users') ?>">Users</a></div>
        <div class="breadcrumb-item">Edit User</div>
    </div>
</div>
<div class="section-body">
    <?php if (session()->getFlashdata('errors')) :?>
    <div class="alert alert-danger alert-dismissible m-2 show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">&times;</button>
            <?php
            if(is_array(session()->getFlashdata('errors'))) {
                echo '<ul class="mb-0">';
                foreach(session()->getFlashdata('errors') as $error) {
                    echo '<li>' . esc($error) . '</li>';
                }
                echo '</ul>';
            } else {
                echo session()->getFlashdata('errors');
            }
            ?>
        </div>
    </div>
    <?php endif ?>

    <form action="<?=site_url('admin/users/'.$users->id)?>" method="POST" autocomplete="off">
        <?=csrf_field()?>
        <input type="hidden" name="_method" value="PUT">

        <div class="col-md-5">
            <input type="hidden" name="id" value="<?= esc($users->id) ?>">
            <div class="form-group">    
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?=esc($users->username)?>" required autofocus>
                <small class="text-muted">Username hanya boleh huruf kecil, angka, underscore, dan titik</small>
            </div>
            <div class="form-group">    
                <label>Nama Tampilan</label>
                <input type="text" name="display_name" class="form-control" value="<?=esc($users->display_name)?>" required>
                <small class="text-muted">Nama yang akan ditampilkan kepada pengguna lain</small>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?=esc($users->email)?>" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah Password" class="form-control pwstrength" data-indicator="pwindicator">
                </div>
                <div class="pwindicator" id="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control select2" required>
                    <option value="reader" <?= $users->role == 'reader' ? 'selected' : '' ?>>Reader</option>
                    <option value="admin" <?= $users->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="author" <?= $users->role == 'author' ? 'selected' : '' ?>>Author</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Update User</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </form>
</div>
<?php $this->endSection() ?>

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