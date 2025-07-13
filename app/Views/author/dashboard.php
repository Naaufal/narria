<?= $this->extend('author/layout/main') ?>

<?= $this->section('title') ?>
Dashboard Author
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="section-header">
    <h1>Author Dashboard</h1>
    <div class="section-header-button">
        <a href="<?= site_url('author/novels/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Upload Novel Baru
        </a>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <!-- Total Novels -->
        <div class="col-lg-3 col-md-6">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-book"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Novel</h4>
                    </div>
                    <div class="card-body">
                        <?= number_format($totalNovel) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Chapter -->
        <div class="col-lg-3 col-md-6">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Chapter</h4>
                    </div>
                    <div class="card-body">
                        <?= number_format($totalChapter) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Views -->
        <div class="col-lg-3 col-md-6">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Views</h4>
                    </div>
                    <div class="card-body">
                        <?= number_format($totalView) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata Views -->
        <div class="col-lg-3 col-md-6">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Rata-rata View</h4>
                    </div>
                    <div class="card-body">
                        <?= $totalNovel > 0 ? number_format($totalView / $totalNovel) : 0 ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Novel Trending -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Novel Trending</h4>
                    <div class="card-header-action">
                        <a href="<?= site_url('author/novels') ?>" class="btn btn-primary">Lihat Semua Novel</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($novelTrending)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Views</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($novelTrending as $key => $novel): ?>
                                        <tr>
                                            <td><?= $key + 1 ?></td>
                                            <td>
                                                <strong><?= esc($novel->title) ?></strong>
                                            </td>
                                            <td>
                                                <?php if (!empty($novel->categoryNames)): ?>
                                                    <?= implode(', ', array_slice($novel->categoryNames, 0, 2)) ?>
                                                    <?php if (count($novel->categoryNames) > 2): ?>
                                                        <small class="text-muted">+<?= count($novel->categoryNames) - 2 ?> lainnya</small>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Tidak ada kategori</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <i class="fas fa-eye text-muted"></i> <?= number_format($novel->views) ?>
                                            </td>
                                            <td>
                                                <?php if ($novel->status == 'ongoing'): ?>
                                                    <span class="badge badge-warning">Ongoing</span>
                                                <?php elseif ($novel->status == 'completed'): ?>
                                                    <span class="badge badge-success">Completed</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Hiatus</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('author/novels/' . $novel->id . '/chapters') ?>" 
                                                       class="btn btn-sm btn-info" title="Kelola Chapter">
                                                        <i class="fas fa-list"></i>
                                                    </a>
                                                    <a href="<?= site_url('author/novels/edit/' . $novel->id) ?>" 
                                                       class="btn btn-sm btn-warning" title="Edit Novel">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state" data-height="300">
                            <div class="empty-state-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h2>Belum ada novel</h2>
                            <p class="lead">Mulai menulis novel pertama Anda!</p>
                            <a href="<?= site_url('author/novels/create') ?>" class="btn btn-primary mt-4">
                                <i class="fas fa-plus"></i> Upload Novel Baru
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="<?= site_url('author/novels/create') ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="fas fa-plus text-primary"></i> Upload Novel Baru</h6>
                            </div>
                            <p class="mb-1">Mulai menulis novel baru</p>
                        </a>
                        
                        <?php if (!empty($novels)): ?>
                            <?php foreach (array_slice($novels, 0, 3) as $novel): ?>
                                <a href="<?= site_url('author/novels/' . $novel->id . '/chapters/create') ?>" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><i class="fas fa-file-alt text-success"></i> Tambah Chapter</h6>
                                    </div>
                                    <p class="mb-1"><?= esc($novel->title) ?></p>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <a href="<?= site_url('author/novels') ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1"><i class="fas fa-list text-info"></i> Kelola Novel</h6>
                            </div>
                            <p class="mb-1">Lihat dan kelola semua novel</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h4>Statistik Singkat</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="font-weight-bold text-primary" style="font-size: 2rem;">
                                    <?= count(array_filter($novels, function($n) { return $n->status == 'ongoing'; })) ?>
                                </div>
                                <div class="text-muted">Ongoing</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="font-weight-bold text-success" style="font-size: 2rem;">
                                    <?= count(array_filter($novels, function($n) { return $n->status == 'completed'; })) ?>
                                </div>
                                <div class="text-muted">Completed</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="font-weight-bold text-warning" style="font-size: 2rem;">
                                    <?= count(array_filter($novels, function($n) { return $n->status == 'hiatus'; })) ?>
                                </div>
                                <div class="text-muted">Hiatus</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="font-weight-bold text-info" style="font-size: 2rem;">
                                    <?= $totalChapter ?>
                                </div>
                                <div class="text-muted">Total Chapter</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
