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
</div>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
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
                    <h4>Form Edit Novel</h4>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('author/novels/' . $novel->id) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Judul Novel <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= old('title', $novel->title) ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="sinopsis">Sinopsis <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="sinopsis" name="sinopsis" rows="8" required><?= old('sinopsis', $novel->sinopsis) ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status Novel <span class="text-danger">*</span></label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="">Pilih Status</option>
                                                <option value="ongoing" <?= old('status', $novel->status) == 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                                                <option value="completed" <?= old('status', $novel->status) == 'completed' ? 'selected' : '' ?>>Completed</option>
                                                <option value="hiatus" <?= old('status', $novel->status) == 'hiatus' ? 'selected' : '' ?>>Hiatus</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="categories">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-control select2" id="categories" name="categories[]" multiple required>
                                                <?php 
                                                $selectedCategories = old('categories') ?? array_column($novel->categories ?? [], 'id');
                                                ?>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?= $category->id ?>" 
                                                            <?= in_array($category->id, $selectedCategories) ? 'selected' : '' ?>>
                                                        <?= esc($category->name) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cover_image">Cover Novel</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="cover_image" name="cover_image" 
                                               accept="image/*">
                                        <label class="custom-file-label" for="cover_image">Pilih file...</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        Format: JPG, JPEG, PNG, WebP. Maksimal 2MB. Kosongkan jika tidak ingin mengubah cover.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <div class="text-center">
                                        <label>Cover Saat Ini:</label>
                                        <div>
                                            <img src="<?= base_url('uploads/covers/' . ($novel->cover_image ?? 'default.jpg')) ?>" 
                                                 alt="Current Cover" class="img-fluid rounded" style="max-height: 300px;" id="currentCover">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div id="imagePreview" class="text-center" style="display: none;">
                                        <label>Preview Baru:</label>
                                        <div>
                                            <img id="preview" src="/placeholder.svg" alt="Preview" class="img-fluid rounded" style="max-height: 300px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Novel
                            </button>
                            <a href="<?= site_url('author/novels') ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('assets') ?>/modules/select2/dist/css/select2.min.css">
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url('assets') ?>/modules/select2/dist/js/select2.full.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: 'Pilih kategori...',
        allowClear: true
    });

    // Image preview
    $('#cover_image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            reader.readAsDataURL(file);
            
            // Update label
            $(this).next('.custom-file-label').text(file.name);
        } else {
            $('#imagePreview').hide();
            $(this).next('.custom-file-label').text('Pilih file...');
        }
    });
});
</script>
<?= $this->endSection() ?>
