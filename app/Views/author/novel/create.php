<?= $this->extend('author/layout/main') ?>

<?= $this->section('title') ?>Upload Novel<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section-header">
    <div class="section-header-back">
        <a href="<?=site_url('author/novels')?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Upload Novel</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="<?=site_url('author/dashboard')?>">Dashboard</a></div>
        <div class="breadcrumb-item active"><a href="<?=site_url('author/novels')?>">Novel</a></div>
        <div class="breadcrumb-item">Upload</div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Upload Novel</h4>
                    <div class="card-header-action">
                        <div class="badge badge-info">
                            <i class="fas fa-info-circle"></i> Novel dapat memiliki multiple kategori
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Terdapat kesalahan input:
                            <ul class="mb-0 mt-2">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif ?>

                    <form action="<?= base_url('author/novels') ?>" method="post" enctype="multipart/form-data" id="novelForm">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Judul Novel <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?= session()->getFlashdata('errors')['title'] ?? false ? 'is-invalid' : '' ?>" 
                                            id="title" name="title" value="<?= old('title') ?>" required 
                                            placeholder="Masukkan judul novel">
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['title'] ?? '' ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <div class="form-text text-muted mb-3">
                                        <i class="fas fa-info-circle"></i> Pilih satu atau lebih kategori dengan mencentang kotak di bawah ini
                                    </div>
                                    
                                    <div class="row">
                                        <?php foreach ($categories as $category): ?>
                                            <div class="col-md-6 col-lg-4 mb-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" 
                                                            class="custom-control-input category-checkbox" 
                                                            id="category_<?= $category->id ?>" 
                                                            name="categories[]" 
                                                            value="<?= $category->id ?>"
                                                            <?= in_array($category->id, old('categories') ?? []) ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="category_<?= $category->id ?>">
                                                        <span class="font-weight-medium"><?= esc($category->name) ?></span>
                                                        <?php if (isset($category->banyakNovel)): ?>
                                                            <small class="text-muted d-block"><?= $category->banyakNovel ?> novel</small>
                                                        <?php endif ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                    
                                    <div id="category-error" class="text-danger mt-2" style="display: none;">
                                        <small><i class="fas fa-exclamation-triangle"></i> Pilih minimal satu kategori</small>
                                    </div>
                                    
                                    <?php if (session()->getFlashdata('errors')['categories'] ?? false): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= session()->getFlashdata('errors')['categories'] ?>
                                        </div>
                                    <?php endif ?>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control <?= session()->getFlashdata('errors')['status'] ?? false ? 'is-invalid' : '' ?>" 
                                            id="status" name="status" required>
                                        <option value="">Pilih Status</option>
                                        <option value="ongoing" <?= old('status') == 'ongoing' ? 'selected' : '' ?>>
                                            Ongoing
                                        </option>
                                        <option value="completed" <?= old('status') == 'completed' ? 'selected' : '' ?>>
                                            Completed
                                        </option>
                                        <option value="hiatus" <?= old('status') == 'hiatus' ? 'selected' : '' ?>>
                                            Hiatus
                                        </option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['status'] ?? '' ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sinopsis">Sinopsis <span class="text-danger">*</span></label>
                                    <textarea class="form-control <?= session()->getFlashdata('errors')['sinopsis'] ?? false ? 'is-invalid' : '' ?>" 
                                                id="sinopsis" name="sinopsis" rows="6" required 
                                                placeholder="Masukkan sinopsis novel..."><?= old('sinopsis') ?></textarea>
                                    <small class="form-text text-muted">
                                        <span id="char-count">0</span> karakter (minimal 10 karakter)
                                    </small>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['sinopsis'] ?? '' ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cover_image">Cover Novel <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input <?= session()->getFlashdata('errors')['cover_image'] ?? false ? 'is-invalid' : '' ?>" 
                                                id="cover_image" name="cover_image" accept="image/*" required>
                                        <label class="custom-file-label" for="cover_image">Pilih file...</label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        Format: JPG, JPEG, PNG, WebP. Maksimal 2MB
                                    </small>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['cover_image'] ?? '' ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Preview Cover</label>
                                    <div class="border rounded p-3 text-center bg-light">
                                        <img id="cover-preview" src="#" alt="Preview Cover" 
                                                class="img-fluid rounded shadow" style="max-height: 300px; display: none;">
                                        <div id="no-preview" class="text-muted">
                                            <i class="fas fa-image fa-3x mb-2 text-secondary"></i>
                                            <p class="mb-0">Preview cover akan muncul di sini</p>
                                            <small>Ukuran ideal: 400x600px</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Selected Categories Display -->
                                <div class="form-group">
                                    <label>Kategori Terpilih <span id="category-count" class="badge badge-secondary">0</span></label>
                                    <div id="selected-categories" class="border rounded p-3 bg-light" style="min-height: 60px;">
                                        <div id="no-categories" class="text-muted text-center">
                                            <i class="fas fa-tags fa-2x mb-2 text-secondary"></i>
                                            <p class="mb-0">Belum ada kategori dipilih</p>
                                            <small>Centang kategori di sebelah kiri</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                <div class="form-group">
                                    <label>Aksi Cepat</label>
                                    <div class="btn-group-vertical btn-block">
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="select-all-categories">
                                            <i class="fas fa-check-double"></i> Pilih Semua
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" id="clear-all-categories">
                                            <i class="fas fa-times"></i> Hapus Semua
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                        <i class="fas fa-upload"></i> Upload Novel
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-undo"></i> Reset Form
                                    </button>
                                </div>
                                <a href="<?= base_url('author/novels') ?>" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const coverInput = document.getElementById('cover_image');
    const coverPreview = document.getElementById('cover-preview');
    const noPreview = document.getElementById('no-preview');
    const fileLabel = document.querySelector('.custom-file-label');
    const sinopsisTextarea = document.getElementById('sinopsis');
    const charCount = document.getElementById('char-count');
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    const selectedCategoriesDiv = document.getElementById('selected-categories');
    const noCategoriesDiv = document.getElementById('no-categories');
    const categoryCount = document.getElementById('category-count');
    const categoryError = document.getElementById('category-error');
    const selectAllBtn = document.getElementById('select-all-categories');
    const clearAllBtn = document.getElementById('clear-all-categories');

    // Handle cover image preview
    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            if (file.size > 2048 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                this.value = '';
                fileLabel.textContent = 'Pilih file...';
                return;
            }

            fileLabel.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                coverPreview.src = e.target.result;
                coverPreview.style.display = 'block';
                noPreview.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            fileLabel.textContent = 'Pilih file...';
            coverPreview.style.display = 'none';
            noPreview.style.display = 'block';
        }
    });

    // Character count for synopsis
    function updateCharCount() {
        const count = sinopsisTextarea.value.length;
        charCount.textContent = count;
        charCount.className = count < 10 ? 'text-danger' : 'text-success';
    }

    sinopsisTextarea.addEventListener('input', updateCharCount);
    updateCharCount();

    // Handle category selection
    function updateSelectedCategories() {
        const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
        const count = checkedBoxes.length;
        
        // Update counter
        categoryCount.textContent = count;
        categoryCount.className = count > 0 ? 'badge badge-success' : 'badge badge-secondary';
        
        // Hide error if categories selected
        if (count > 0) {
            categoryError.style.display = 'none';
        }
        
        if (count === 0) {
            selectedCategoriesDiv.innerHTML = '';
            selectedCategoriesDiv.appendChild(noCategoriesDiv);
            noCategoriesDiv.style.display = 'block';
            return;
        }

        // Create badges for selected categories
        noCategoriesDiv.style.display = 'none';
        const badges = Array.from(checkedBoxes).map(checkbox => {
            const label = document.querySelector(`label[for="${checkbox.id}"]`);
            const categoryName = label.querySelector('.font-weight-medium').textContent;
            return `<span class="badge badge-primary mr-1 mb-1 p-2">
                        <i class="fas fa-tag"></i> ${categoryName}
                        <button type="button" class="btn btn-sm ml-1 p-0" onclick="uncheckCategory('${checkbox.id}')" style="background: none; border: none; color: white;">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>`;
        }).join('');
        
        selectedCategoriesDiv.innerHTML = `
            <div class="d-flex flex-wrap align-items-center">
                ${badges}
            </div>
            <small class="text-muted mt-2 d-block">
                <i class="fas fa-info-circle"></i> ${count} kategori dipilih. Klik X untuk menghapus.
            </small>
        `;
    }

    // Add event listeners to checkboxes
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCategories);
    });

    // Quick actions
    selectAllBtn.addEventListener('click', function() {
        categoryCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        updateSelectedCategories();
    });

    clearAllBtn.addEventListener('click', function() {
        categoryCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectedCategories();
    });

    // Global function to uncheck category from badge
    window.uncheckCategory = function(checkboxId) {
        const checkbox = document.getElementById(checkboxId);
        if (checkbox) {
            checkbox.checked = false;
            updateSelectedCategories();
        }
    };

    // Form validation
    document.getElementById('novelForm').addEventListener('submit', function(e) {
        const checkedCategories = document.querySelectorAll('.category-checkbox:checked');
        
        if (checkedCategories.length === 0) {
            e.preventDefault();
            categoryError.style.display = 'block';
            
            // Scroll to categories section
            document.querySelector('label').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            
            return false;
        }

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
        submitBtn.disabled = true;
    });

    // Reset form handling
    document.querySelector('button[type="reset"]').addEventListener('click', function() {
        setTimeout(function() {
            coverPreview.style.display = 'none';
            noPreview.style.display = 'block';
            fileLabel.textContent = 'Pilih file...';
            updateCharCount();
            updateSelectedCategories();
        }, 100);
    });

    // Initial updates
    updateSelectedCategories();
});
</script>

<style>
.badge {
    font-size: 0.875em;
}

#selected-categories {
    max-height: 120px;
    overflow-y: auto;
}

.custom-control-label {
    cursor: pointer;
}

.btn-group-vertical .btn {
    margin-bottom: 0.25rem;
}

.card-header-action .badge {
    font-size: 0.75rem;
}
</style>
<?= $this->endSection() ?>