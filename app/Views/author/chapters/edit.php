<?= $this->extend('author/layout/main') ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <div class="section-header-back">
        <a href="<?= site_url('author/novels/' . $novel->id . '/chapters') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                    <h4>Novel: <?= esc($novel->title) ?></h4>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('author/novels/' . $novel->id . '/chapters/' . $chapter->id) ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chapter_number">Nomor Chapter <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="chapter_number" name="chapter_number" 
                                           value="<?= old('chapter_number', $chapter->chapter_number) ?>" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Judul Chapter <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= old('title', $chapter->title) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="content">Konten Chapter <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="content" name="content" rows="20" required><?= old('content', $chapter->content) ?></textarea>
                            <small class="form-text text-muted">Minimal 50 karakter</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Chapter
                            </button>
                            <a href="<?= site_url('author/novels/' . $novel->id . '/chapters') ?>" class="btn btn-secondary">
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
<style>
#content {
    font-family: 'Georgia', serif;
    line-height: 1.6;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
// Auto-resize textarea
document.getElementById('content').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// Character counter
document.getElementById('content').addEventListener('input', function() {
    const length = this.value.length;
    const minLength = 50;
    
    if (length < minLength) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.add('is-valid');
        this.classList.remove('is-invalid');
    }
});

// Initial resize
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('content');
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
});
</script>
<?= $this->endSection() ?>
