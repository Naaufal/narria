<?= $this->extend('author/layout/main') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <div class="section-header-back">
        <a href="<?= site_url('author/novels') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1><?= $title ?></h1>
    <div class="section-header-button">
        <a href="<?= site_url('author/novels/' . $novel->id . '/chapters/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Chapter Baru
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Novel: <?= esc($novel->title) ?></h4>
                    <div class="card-header-action">
                        <div class="badge badge-info">Total: <?= $totalChapters ?> chapters</div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($chapters)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Chapter</th>
                                        <th>Judul</th>
                                        <th>Views</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($chapters as $chapter): ?>
                                        <tr>
                                            <td>
                                                <div class="badge badge-primary">
                                                    Chapter <?= $chapter->chapter_number ?>
                                                </div>
                                            </td>
                                            <td>
                                                <strong><?= esc($chapter->title) ?></strong>
                                            </td>
                                            <td>
                                                <i class="fas fa-eye text-muted"></i> <?= number_format($chapter->views) ?>
                                            </td>
                                            <td>
                                                <?= date('d M Y', strtotime($chapter->created_at)) ?>
                                            </td>
                                            <td>
                                                <a href="<?= site_url('author/novels/' . $novel->id . '/chapters/' . $chapter->id . '/edit') ?>" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                
                                                <!-- Form untuk delete dengan method POST -->
                                                <form method="post" 
                                                      action="<?= site_url('author/novels/' . $novel->id . '/chapters/' . $chapter->id) ?>" 
                                                      style="display: inline-block;"
                                                      onsubmit="return confirmDelete('<?= esc($chapter->title) ?>')">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state" data-height="400">
                            <div class="empty-state-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h2>Belum ada chapter</h2>
                            <p class="lead">Mulai menulis chapter pertama untuk novel ini!</p>
                            <a href="<?= site_url('author/novels/' . $novel->id . '/chapters/create') ?>" class="btn btn-primary mt-4">
                                <i class="fas fa-plus"></i> Tambah Chapter Baru
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
function confirmDelete(chapterTitle) {
    return confirm(`Apakah Anda yakin ingin menghapus chapter "${chapterTitle}"?\n\nPeringatan: Data yang dihapus tidak dapat dikembalikan!`);
}
</script>
<?= $this->endSection() ?>