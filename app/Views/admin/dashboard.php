<?= $this->extend('admin/layout/main') ?>

<?= $this->section('content') ?>



<?php if (isset($error)): ?>
    <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle"></i> <?= esc($error) ?>
    </div>
<?php endif; ?>

<div class="section-header shadow ml-auto">
    <h1>Admin Dashboard</h1>
</div>

<div class="section-body">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
        <div class="col mb-4">
            <div class="card card-statistic-1 shadow h-100">
                <div class="card-icon bg-primary"><i class="fas fa-book"></i></div>
                <div class="card-wrap">
                    <div class="card-header"><h4>Total Novel</h4></div>
                    <div class="card-body"><?= $totalNovels ?></div>
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card card-statistic-1 shadow h-100">
                <div class="card-icon bg-danger"><i class="fas fa-users"></i></div>
                <div class="card-wrap">
                    <div class="card-header"><h4>Total User</h4></div>
                    <div class="card-body"><?= $totalUsers ?></div>
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card card-statistic-1 shadow h-100">
                <div class="card-icon bg-warning"><i class="fas fa-user-edit"></i></div>
                <div class="card-wrap">
                    <div class="card-header"><h4>Total Penulis</h4></div>
                    <div class="card-body"><?= $totalAuthors ?></div>
                </div>
            </div>
        </div>
        <div class="col mb-4">
            <div class="card card-statistic-1 shadow h-100">
                <div class="card-icon bg-success"><i class="fas fa-chart-pie"></i></div>
                <div class="card-wrap">
                    <div class="card-header"><h4>Total Category</h4></div>
                    <div class="card-body"><?= $totalCategories ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Novel Populer -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h4>Novel Hangat Minggu ini</h4>
                    <div class="card-header-action">
                        <a href="<?= site_url('admin/novels') ?>" class="btn btn-primary">Lihat Semua Novel</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Views</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($novels)): ?>
                                    <?php foreach($novels as $key => $value): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= esc($value->title) ?></td>
                                        <td><?= esc($value->authorName) ?></td>
                                        <td>
                                            <?php if (!empty($value->categoryNames)): ?>
                                                <?php foreach (array_slice($value->categoryNames, 0, 2) as $categoryName): ?>
                                                    <span class="badge badge-secondary"><?= esc($categoryName) ?></span>
                                                <?php endforeach; ?>
                                                <?php if (count($value->categoryNames) > 2): ?>
                                                    <span class="badge badge-light">+<?= count($value->categoryNames) - 2 ?></span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="badge badge-light">Belum dikategorikan</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= number_format($value->views) ?></td>
                                        <td>
                                            <?php if ($value->status == 'ongoing'): ?>
                                                <div class="badge badge-warning">Ongoing</div>
                                            <?php elseif ($value->status == 'completed'): ?>
                                                <div class="badge badge-success">Completed</div>
                                            <?php else: ?>
                                                <div class="badge badge-secondary">Hiatus</div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data novel</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori Populer -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header"><h4>Kategori Populer</h4></div>
    <div class="card-body">
        <?php if (!empty($categories)): ?>
            <pre style="display:none;" id="debugCategories"><?= json_encode($categories, JSON_PRETTY_PRINT) ?></pre>
            <div style="height: 300px; position: relative;">
                <canvas id="categoryChart"></canvas>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">Belum ada data kategori</p>
        <?php endif; ?>
    </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top Authors -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header"><h4>Top Authors</h4></div>
                <div class="card-body">
                    <?php if (!empty($authors)): ?>
                        <ul class="list-unstyled user-progress list-unstyled-border">
                            <?php foreach ($authors as $index => $author): ?>
                            <?php
                                $avatarBg = ['bg-primary', 'bg-danger', 'bg-warning', 'bg-success'][$index % 4];
                                $maxCount = $authors[0]->novel_count ?? 1;
                                $widthPercentage = ($author->novel_count / $maxCount) * 100;
                            ?>
                            <li class="media">
                                <div class="user-avatar mr-3">
                                    <div class="avatar-item <?= $avatarBg ?> text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px;">
                                        <?= strtoupper(substr($author->username, 0, 1)) ?>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="media-title"><?= esc($author->username) ?></div>
                                    <div class="text-job text-muted">Author</div>
                                </div>
                                <div class="media-progressbar w-100">
                                    <div class="progress-text"><?= $author->novel_count ?> novels</div>
                                    <div class="progress" data-height="6">
                                        <div class="progress-bar bg-primary" style="width: <?= $widthPercentage ?>%"></div>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-center text-muted">Belum ada data author</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- User Terbaru -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h4>User Terbaru</h4>
                    <div class="card-header-action">
                        <a href="<?= site_url('admin/users') ?>" class="btn btn-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($userBaru)): ?>
                        <ul class="list-unstyled list-unstyled-border">
                            <?php foreach ($userBaru as $user): ?>
                            <li class="media">
                                <div class="avatar-item bg-primary text-white d-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 50px; height: 50px;">
                                    <?= strtoupper(substr($user->username, 0, 1)) ?>
                                </div>
                                <div class="media-body">
                                    <div class="mt-0 mb-1 font-weight-bold"><?= esc($user->username) ?></div>
                                    <div class="text-muted text-small">
                                        <span class="text-primary"><?= ucfirst($user->role) ?></span> -
                                        <span class="text-muted"><?= date('d M Y', strtotime($user->created_at ?? date('Y-m-d'))) ?></span>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-center text-muted">Belum ada user baru</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Novel Terbaru -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h4>Novel Terbaru</h4>
                    <div class="card-header-action">
                        <a href="<?= site_url('admin/novels') ?>" class="btn btn-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($novelTerbaru)): ?>
                                    <?php foreach($novelTerbaru as $novel): ?>
                                    <tr>
                                        <td>
                                            <?= esc($novel->title) ?>
                                            <div class="table-links">
                                                <?php if (!empty($novel->categoryNames)): ?>
                                                    in <span class="text-muted"><?= esc(implode(', ', array_slice($novel->categoryNames, 0, 2))) ?></span>
                                                <?php endif; ?>
                                                <div class="bullet"></div>
                                                <a href="<?= site_url('novel/' . $novel->id) ?>">Detail</a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-item bg-primary text-white d-flex align-items-center justify-content-center rounded-circle mr-2" style="width: 30px; height: 30px; font-size: 12px;">
                                                    <?= strtoupper(substr($novel->authorName, 0, 1)) ?>
                                                </div>
                                                <?= esc($novel->authorName) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('novel/' . $novel->id) ?>" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Lihat"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada novel terbaru</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?=base_url('assets')?>/modules/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if (!empty($categories)): ?>
        var ctxCategory = document.getElementById('categoryChart').getContext('2d');
        var labels = <?= json_encode(array_column($categories, 'name')) ?>;
        var dataValues = <?= json_encode(array_column($categories, 'banyakNovel')) ?>;
        console.log('Chart labels:', labels);
        console.log('Chart data:', dataValues);
        new Chart(ctxCategory, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: ['#6777ef', '#fc544b', '#ffa426', '#3abaf4', '#63ed7a', '#ccc6fe', '#fc8888', '#fdd74f', '#80F1D0'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        fontFamily: "'Nunito', 'Segoe UI', 'Arial'",
                        fontSize: 12,
                        padding: 15
                    }
                }
            }
        });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>
