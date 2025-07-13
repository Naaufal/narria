<?= $this->extend('author/layout/main') ?>

<?= $this->section('title') ?>
My Novels
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <h1>My Novels</h1>
    <div class="section-header-button">
        <a href="<?= site_url('author/novels/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Novel Baru
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
    <!-- Ongoing Novels -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-play text-success"></i> Ongoing Novels</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($Ongoing)): ?>
                        <div class="row">
                            <?php foreach ($Ongoing as $novel): ?>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="<?= base_url('uploads/covers/' . ($novel->cover_image ?? 'default.jpg')) ?>" 
                                                         alt="<?= esc($novel->title) ?>" 
                                                         class="img-fluid rounded">
                                                </div>
                                                <div class="col-8">
                                                    <h6 class="card-title mb-2"><?= esc($novel->title) ?></h6>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-eye"></i> <?= number_format($novel->views) ?> views
                                                    </p>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-tags"></i> 
                                                        <?= !empty($novel->categoryNames) ? implode(', ', $novel->categoryNames) : 'No category' ?>
                                                    </p>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="<?= site_url('author/novels/' . $novel->id . '/chapters') ?>" 
                                                           class="btn btn-info btn-sm">
                                                            <i class="fas fa-list"></i> Chapters
                                                        </a>
                                                        <a href="<?= site_url('author/novels/edit/' . $novel->id) ?>" 
                                                           class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <button class="btn btn-danger btn-sm" 
                                                                onclick="deleteNovel(<?= $novel->id ?>, '<?= esc($novel->title) ?>')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state" data-height="400">
                            <div class="empty-state-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h2>Belum ada novel ongoing</h2>
                            <p class="lead">Mulai menulis novel pertama Anda!</p>
                            <a href="<?= site_url('author/novels/create') ?>" class="btn btn-primary mt-4">
                                <i class="fas fa-plus"></i> Tambah Novel Baru
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Novels -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-check text-success"></i> Completed Novels</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($Completed)): ?>
                        <div class="row">
                            <?php foreach ($Completed as $novel): ?>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="<?= base_url('uploads/covers/' . ($novel->cover_image ?? 'default.jpg')) ?>" 
                                                         alt="<?= esc($novel->title) ?>" 
                                                         class="img-fluid rounded">
                                                </div>
                                                <div class="col-8">
                                                    <h6 class="card-title mb-2"><?= esc($novel->title) ?></h6>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-eye"></i> <?= number_format($novel->views) ?> views
                                                    </p>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-tags"></i> 
                                                        <?= !empty($novel->categoryNames) ? implode(', ', $novel->categoryNames) : 'No category' ?>
                                                    </p>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="<?= site_url('author/novels/' . $novel->id . '/chapters') ?>" 
                                                           class="btn btn-info btn-sm">
                                                            <i class="fas fa-list"></i> Chapters
                                                        </a>
                                                        <a href="<?= site_url('author/novels/edit/' . $novel->id) ?>" 
                                                           class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <button class="btn btn-danger btn-sm" 
                                                                onclick="deleteNovel(<?= $novel->id ?>, '<?= esc($novel->title) ?>')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state" data-height="200">
                            <div class="empty-state-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <h2>Belum ada novel yang diselesaikan</h2>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Hiatus Novels -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-pause text-warning"></i> Hiatus Novels</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($Hiatus)): ?>
                        <div class="row">
                            <?php foreach ($Hiatus as $novel): ?>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="<?= base_url('uploads/covers/' . ($novel->cover_image ?? 'default.jpg')) ?>" 
                                                         alt="<?= esc($novel->title) ?>" 
                                                         class="img-fluid rounded">
                                                </div>
                                                <div class="col-8">
                                                    <h6 class="card-title mb-2"><?= esc($novel->title) ?></h6>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-eye"></i> <?= number_format($novel->views) ?> views
                                                    </p>
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-tags"></i> 
                                                        <?= !empty($novel->categoryNames) ? implode(', ', $novel->categoryNames) : 'No category' ?>
                                                    </p>
                                                    <div class="btn-group btn-group-sm " role="group">
                                                        <a href="<?= site_url('author/novels/' . $novel->id . '/chapters') ?>" 
                                                           class="btn btn-info btn-sm">
                                                            <i class="fas fa-list"></i> Chapters
                                                        </a>
                                                        <a href="<?= site_url('author/novels/edit/' . $novel->id) ?>" 
                                                           class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <button class="btn btn-danger btn-sm" 
                                                                onclick="deleteNovel(<?= $novel->id ?>, '<?= esc($novel->title) ?>')">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state" data-height="200">
                            <div class="empty-state-icon">
                                <i class="fas fa-pause"></i>
                            </div>
                            <h2>Tidak ada novel hiatus</h2>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus novel "<span id="novelTitle"></span>"?</p>
                <p class="text-danger"><strong>Peringatan:</strong> Semua chapter dalam novel ini juga akan terhapus!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
let novelIdToDelete = null;

function deleteNovel(id, title) {
    novelIdToDelete = id;
    document.getElementById('novelTitle').textContent = title;
    $('#deleteModal').modal('show');
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (novelIdToDelete) {
        fetch(`<?= site_url('author/novels/') ?>${novelIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            $('#deleteModal').modal('hide');
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus novel');
        });
    }
});
</script>
<?= $this->endSection() ?>
