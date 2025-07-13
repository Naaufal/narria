<?= $this->extend('admin/layout/main')?>

<?php $this->section('title')?>
Novels
<?= $this->endSection() ?>

<?php $this->section('content')?>
<div class="section-header ml-auto shadow">
    <h1>Data Novels</h1>
    <div class="section-header-button">
        <a href="<?=site_url('admin/novel/upload')?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Novel</a>
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
        <div class="table-responsive">
            <table class="table table-striped" id="novelTabel">
                <thead>
                    <tr>
                        <th width="15px">#</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>status</th>
                        <th>Views</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($novels as $key => $value) : ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= esc($value->title) ?></td>
                            <td><?= esc($value->authorName) ?></td>
                            <td><?= esc(implode(', ', $value->categoryNames)) ?></td>
                            <td>
                                <?php if ($value->status == 'ongoing'):?>
                                    <div class="badge badge-warning">Ongoing</div>
                                <?php elseif ($value->status == 'completed'):?>
                                    <div class="badge badge-success">Completed</div>
                                <?php else:?>
                                    <div class="badge badge-secondary">Hiatus</div>
                                <?php endif; ?>
                            </td>
                            <td><?= $value->views ?></td>
                            <td>
                                <a href="<?=site_url('admin/novels/edit/'.$value->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="<?=site_url('admin/novels/'.$value->id)?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data?')">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?php $this->section('js')?>
<!-- Datatables -->
 <script src="<?=base_url('assets')?>/modules/sweetalert/sweetalert.min.js"></script>
<script src="<?=base_url('assets')?>/modules/datatables/datatables.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#novelTabel').DataTable({
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
});
</script>
<?= $this->endSection() ?>