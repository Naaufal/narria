<?php $this->extend('admin/layout/main')?>

<?php $this->section('title')?>
Kategori
<?=$this->endSection()?>

<?php $this->section('content')?>
<div class="section-header ml-auto shadow">
    <h1>Data Kategori</h1>
</div>
<div class="section-body">
<div class="card">
    <div class="card-header">
        <h4>Daftar Kategori</h4>
        <div class="card-header-action">
            <a href="<?= site_url('admin/categories/create') ?>" class="btn btn-primary">Tambah Kategori</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-md">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Novel</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categories as $key => $category): ?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td><?= esc($category->name) ?></td>
                        <td>
                            <span class="badge badge-primary"><?= $category->banyakNovel ?> novel</span>
                        </td>
                        <td>
                            <a href="<?= site_url('admin/categories/edit/'.$category->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                            <a href="<?= site_url('admin/categories/delete/'.$category->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<?=$this->endSection()?>