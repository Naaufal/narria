<?= $this->extend('admin/layout/main') ?>

<?php $this->section('title') ?>   
User
<?= $this->endSection() ?>

<?php $this->section('content') ?>
<div class="section-header ml-auto shadow">
    <h1>Tabel Users</h1>
    <div class="section-header-button">
        <a href="<?=site_url('admin/users/create')?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
    </div>
</div>
<div class="section-body">
    <?php if (session()->getFlashdata('success')) :?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                swal({
                    title   : "Berhasil",
                    text    : "<?= session()->getFlashdata('success') ?>",
                    icon    : "success",
                    button  : "OK",
                })
            })
        </script>
    <?php endif ?>
    
    <div class="card">
        <ul class="nav nav-pills" id="myTab3" role="tablist">
            <li class="nav-item">
                <a href="#admin" class="nav-link active" id="admin-tab" data-toggle="tab" role="tab" aria-controls="admin" aria-selected="True">Admins</a>
            </li>
            <li class="nav-item">
                <a href="#author" class="nav-link" id="author-tab" data-toggle="tab" role="tab" aria-controls="author" aria-selected="True">Authors</a>
            </li>
            <li class="nav-item">
                <a href="#reader" class="nav-link" id="reader-tab" data-toggle="tab" role="tab" aria-controls="reader" aria-selected="True">Readers</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="admin" role="tabpanel" aria-labelledby="admin-tab">
                <div class="table-responsive">
                    
                    <!-- Tabel Admin -->

                    <table class="table table-striped" id="adminTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="15px">#</th>
                                <th>username</th>
                                <th>display Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="130px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($admins as $key => $value): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= esc($value->username) ?></td>
                                <td><?= esc($value->display_name) ?></td>
                                <td><?= esc($value->email) ?></td>
                                <td><?= esc($value->role) ?></td>
                                <td>
                                    <a href="<?=site_url('admin/users/edit/'.$value->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="<?=site_url('admin/users/'.$value->id) ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade show" id="author" role="tabpanel" aria-labelledby="author-tab">
                <div class="table-responsive">

                    <!-- Tabel Author -->

                    <table class="table table-striped" id="authorTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="15px">#</th>
                                <th>username</th>
                                <th>display Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="130px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($authors as $key => $value): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= esc($value->username) ?></td>
                                <td><?= esc($value->display_name) ?></td>
                                <td><?= esc($value->email) ?></td>
                                <td><?= esc($value->role) ?></td>
                                <td>
                                    <a href="<?=site_url('admin/users/edit/'.$value->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="<?=site_url('admin/users/'.$value->id)?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data?')">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade show" id="reader" role="tabpanel" aria-labelledby="reader-tab">
                <div class="table-responsive">

                    <!-- Tabel Reader -->

                    <table class="table table-striped" id="readerTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="15px">#</th>
                                <th>Username</th>
                                <th>display Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="130px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($readers as $key => $value): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= esc($value->username) ?></td>
                                
                                <td><?= esc($value->email) ?></td>
                                <td><?= esc($value->role) ?></td>
                                <td>
                                    <a href="<?=site_url('admin/users/edit/'.$value->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="<?=site_url('admin/users/'.$value->id)?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>  
<?= $this->endSection() ?>

<?php $this->section('js')?>
<!-- Datatables -->
<script src="<?=base_url('assets')?>/modules/datatables/datatables.min.js"></script>
<script src="<?=base_url('assets')?>/modules/sweetalert/sweetalert.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#adminTable').DataTable({
             
            language    : {
                search      : "Cari:",
                lengthMenu  : "Tampilkan _MENU_ data per halaman",
                zeroRecords : "Tidak ada data yang ditemukan",
                info        : "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty   : "Tidak ada data tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate    : {
                    first   : "Pertama",
                    last    : "Terakhir",
                    next    : "Selanjutnya",
                    previous: "Sebelumnya"
                },
            },
        });
        $('#authorTable').DataTable({
             
            language    : {
                search      : "Cari:",
                lengthMenu  : "Tampilkan _MENU_ data per halaman",
                zeroRecords : "Tidak ada data yang ditemukan",
                info        : "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty   : "Tidak ada data tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate    : {
                    first   : "Pertama",
                    last    : "Terakhir",
                    next    : "Selanjutnya",
                    previous: "Sebelumnya"
                },
            },
        });
        $('#readerTable').DataTable({
             
            language    : {
                search      : "Cari:",
                lengthMenu  : "Tampilkan _MENU_ data per halaman",
                zeroRecords : "Tidak ada data yang ditemukan",
                info        : "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty   : "Tidak ada data tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate    : {
                    first   : "Pertama",
                    last    : "Terakhir",
                    next    : "Selanjutnya",
                    previous: "Sebelumnya"
                },
            },
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });
    })
</script>
<?= $this->endSection() ?>