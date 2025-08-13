<?php

namespace App\Controllers;

use App\Models\NovelModel;
use App\Models\CategoryModel;
use App\Models\ChapterModel;
use App\Models\UserModel;

class Author extends BaseController
{
    protected $novelModel;
    protected $categoryModel;
    protected $chapterModel;
    protected $userModel;
    protected $idAuthor;

    public function __construct()
    {
        $this->novelModel = new NovelModel();
        $this->categoryModel = new CategoryModel();
        $this->chapterModel = new ChapterModel();
        $this->userModel = new UserModel();
        
        // Get author ID from session
        $this->idAuthor = session()->get('user_id');
        
        // Check if author is logged in
        if (!$this->idAuthor) {
            header("Location: " . base_url('login'));
            exit();
        }
    }

    public function index()
    {
        return $this->dashboard();
    }

    // =====================================================
    // DASHBOARD METHODS
    // =====================================================

    public function dashboard()
    {
        // Get all novels for the author
        $novels = $this->novelModel->where('author_id', $this->idAuthor)->findAll();
        
        // Add categories to each novel
        foreach ($novels as $novel) {
            $novel->categories = $this->novelModel->getNovelCategories($novel->id);
            $novel->categoryNames = array_column($novel->categories, 'name');
        }

        $data = [
            'title' => 'Dashboard Author',
            'novelTrending' => $this->userModel->novelTrending($this->idAuthor),
            'totalNovel' => $this->novelModel->where('author_id', $this->idAuthor)->countAllResults(),
            'totalView' => $this->novelModel->totalView($this->idAuthor),
            'totalChapter' => $this->chapterModel->authorChapterNovel($this->idAuthor),
            'novels' => $novels,
            // Session data for topbar
            'userSession' => [
                'user_id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'full_name' => session()->get('full_name'),
                'email' => session()->get('email'),
                'avatar' => session()->get('avatar'),
                'logged_in' => session()->get('logged_in')
            ]
        ];
        
        return view('author/dashboard', $data);
    }

    // =====================================================
    // NOVEL CRUD METHODS
    // =====================================================

    public function novels()
    {
        // Get novels with categories for each status
        $ongoingNovels = $this->getNovelsByStatus('ongoing');
        $completedNovels = $this->getNovelsByStatus('completed');
        $hiatusNovels = $this->getNovelsByStatus('hiatus');

        $data = [
            'title' => 'My Novels',
            'Ongoing' => $ongoingNovels,
            'Completed' => $completedNovels,
            'Hiatus' => $hiatusNovels,
            // Session data for topbar
            'userSession' => [
                'user_id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'full_name' => session()->get('full_name'),
                'email' => session()->get('email'),
                'avatar' => session()->get('avatar'),
                'logged_in' => session()->get('logged_in')
            ]
        ];

        return view('author/novels', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Upload Novel Baru',
            'categories' => $this->categoryModel->findAll(),
            // Session data for topbar
            'userSession' => [
                'user_id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'full_name' => session()->get('full_name'),
                'email' => session()->get('email'),
                'avatar' => session()->get('avatar'),
                'logged_in' => session()->get('logged_in')
            ]
        ];

        return view('author/novel/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => [
                'rules' => 'required|min_length[3]|max_length[255]|is_unique[novels.title]',
                'errors' => [
                    'required' => 'Judul novel harus diisi',
                    'min_length' => 'Judul novel minimal 3 karakter',
                    'max_length' => 'Judul novel maksimal 255 karakter',
                    'is_unique' => 'Judul novel sudah ada, gunakan judul lain'
                ]
            ],
            'sinopsis' => [
                'rules' => 'required|min_length[10]|max_length[5000]',
                'errors' => [
                    'required' => 'Sinopsis harus diisi',
                    'min_length' => 'Sinopsis minimal 10 karakter',
                    'max_length' => 'Sinopsis maksimal 5000 karakter'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[ongoing,completed,hiatus]',
                'errors' => [
                    'required' => 'Status novel harus dipilih',
                    'in_list' => 'Status novel tidak valid'
                ]
            ],
            'categories' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Minimal pilih satu kategori'
                ]
            ],
            'cover_image' => [
                'rules' => 'uploaded[cover_image]|is_image[cover_image]|mime_in[cover_image,image/jpg,image/jpeg,image/png,image/webp]|max_size[cover_image,2048]',
                'errors' => [
                    'uploaded' => 'Cover image harus diupload',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format gambar harus JPG, JPEG, PNG, atau WebP',
                    'max_size' => 'Ukuran gambar maksimal 2MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle file upload
        $coverImage = $this->request->getFile('cover_image');
        $coverImageName = null;

        if ($coverImage && $coverImage->isValid() && !$coverImage->hasMoved()) {
            $coverImageName = $coverImage->getRandomName();
            
            // Pastikan folder exists
            $uploadPath = ROOTPATH . 'public/uploads/covers/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if (!$coverImage->move($uploadPath, $coverImageName)) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload cover image');
            }

            // Resize image if needed
            $this->resizeImage($uploadPath . $coverImageName);
        }

        // Prepare novel data
        $novelData = [
            'title' => $this->request->getPost('title'),
            'author_id' => $this->idAuthor,
            'sinopsis' => $this->request->getPost('sinopsis'),
            'status' => $this->request->getPost('status'),
            'cover_image' => $coverImageName,
            'views' => 0
        ];

        $novelId = $this->novelModel->insert($novelData);

        if ($novelId) {
            // Insert categories
            $categories = $this->request->getPost('categories');
            if (!empty($categories)) {
                $this->novelModel->updateNovelCategories($novelId, $categories);
            }

            return redirect()->to('author/novels')->with('success', 'Novel berhasil diupload! Sekarang Anda bisa menambahkan chapter.');
        } else {
            // Delete uploaded file if insert failed
            if ($coverImageName && file_exists(ROOTPATH . 'public/uploads/covers/' . $coverImageName)) {
                unlink(ROOTPATH . 'public/uploads/covers/' . $coverImageName);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal mengupload novel');
        }
    }

    public function edit($id)
    {
        $novel = $this->novelModel->getNovelWithCategories($id);
        
        if (!$novel || $novel->author_id != $this->idAuthor) {
            return redirect()->to('author/novels')->with('error', 'Novel tidak ditemukan atau Anda tidak memiliki akses');
        }

        $data = [
            'title' => 'Edit Novel: ' . $novel->title,
            'novel' => $novel,
            'categories' => $this->categoryModel->findAll(),
            // Session data for topbar
            'userSession' => [
                'user_id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'full_name' => session()->get('full_name'),
                'email' => session()->get('email'),
                'avatar' => session()->get('avatar'),
                'logged_in' => session()->get('logged_in')
            ]
        ];

        return view('author/novel/edit', $data);
    }

    public function update($id)
    {
        $novel = $this->novelModel->find($id);
        
        if (!$novel || $novel->author_id != $this->idAuthor) {
            return redirect()->to('author/novels')->with('error', 'Novel tidak ditemukan atau Anda tidak memiliki akses');
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => [
                'rules' => $novel->title == $this->request->getPost('title') 
                          ? 'required|min_length[3]|max_length[255]'
                          : 'required|min_length[3]|max_length[255]|is_unique[novels.title]',
                'errors' => [
                    'required' => 'Judul novel harus diisi',
                    'min_length' => 'Judul novel minimal 3 karakter',
                    'max_length' => 'Judul novel maksimal 255 karakter',
                    'is_unique' => 'Judul novel sudah ada, gunakan judul lain'
                ]
            ],
            'sinopsis' => [
                'rules' => 'required|min_length[10]|max_length[5000]',
                'errors' => [
                    'required' => 'Sinopsis harus diisi',
                    'min_length' => 'Sinopsis minimal 10 karakter',
                    'max_length' => 'Sinopsis maksimal 5000 karakter'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[ongoing,completed,hiatus]',
                'errors' => [
                    'required' => 'Status novel harus dipilih',
                    'in_list' => 'Status novel tidak valid'
                ]
            ],
            'categories' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Minimal pilih satu kategori'
                ]
            ]
        ];

        // Add cover image validation only if new file is uploaded
        $coverImage = $this->request->getFile('cover_image');
        if ($coverImage && $coverImage->isValid()) {
            $rules['cover_image'] = [
                'rules' => 'is_image[cover_image]|mime_in[cover_image,image/jpg,image/jpeg,image/png,image/webp]|max_size[cover_image,2048]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format gambar harus JPG, JPEG, PNG, atau WebP',
                    'max_size' => 'Ukuran gambar maksimal 2MB'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle file upload if new file provided
        $coverImageName = $novel->cover_image; // Keep existing if no new upload

        if ($coverImage && $coverImage->isValid() && !$coverImage->hasMoved()) {
            // Delete old cover if exists
            if ($novel->cover_image && file_exists(ROOTPATH . 'public/uploads/covers/' . $novel->cover_image)) {
                unlink(ROOTPATH . 'public/uploads/covers/' . $novel->cover_image);
            }

            $coverImageName = $coverImage->getRandomName();
            
            $uploadPath = ROOTPATH . 'public/uploads/covers/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if (!$coverImage->move($uploadPath, $coverImageName)) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload cover image');
            }

            $this->resizeImage($uploadPath . $coverImageName);
        }

        // Prepare update data
        $updateData = [
            'title' => $this->request->getPost('title'),
            'sinopsis' => $this->request->getPost('sinopsis'),
            'status' => $this->request->getPost('status'),
            'cover_image' => $coverImageName
        ];

        if ($this->novelModel->update($id, $updateData)) {
            // Update categories
            $categories = $this->request->getPost('categories');
            if (!empty($categories)) {
                $this->novelModel->updateNovelCategories($id, $categories);
            }

            return redirect()->to('author/novels')->with('success', 'Novel berhasil diupdate!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate novel');
        }
    }

    public function destroy($id)
    {
        $novel = $this->novelModel->find($id);
        
        if (!$novel || $novel->author_id != $this->idAuthor) {
            return redirect()->to('author/novels')->with('error', 'Novel tidak ditemukan atau Anda tidak memiliki akses');
        }

        // Delete novel categories
        $this->novelModel->updateNovelCategories($id, []);

        // Delete chapters (if any)
        $this->chapterModel->where('novel_id', $id)->delete();

        // Delete cover image file
        if ($novel->cover_image && file_exists(ROOTPATH . 'public/uploads/covers/' . $novel->cover_image)) {
            unlink(ROOTPATH . 'public/uploads/covers/' . $novel->cover_image);
        }

        if ($this->novelModel->delete($id)) {
            return redirect()->to('author/novels')->with('success', 'Novel berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus novel');
        }
    }

    // =====================================================
    // CHAPTER CRUD METHODS
    // =====================================================

    public function chapters($novelId)
    {
        $novel = $this->novelModel->find($novelId);
        
        if (!$novel || $novel->author_id != $this->idAuthor) {
            return redirect()->to('author/novels')->with('error', 'Novel tidak ditemukan atau Anda tidak memiliki akses');
        }

        $chapters = $this->chapterModel->chapterNovel($novelId);
        $totalChapters = $this->chapterModel->hitungChapterNovel($novelId);

        $data = [
            'title' => 'Chapters - ' . $novel->title,
            'novel' => $novel,
            'chapters' => $chapters,
            'totalChapters' => $totalChapters,
            // Session data for topbar
            'userSession' => [
                'user_id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'full_name' => session()->get('full_name'),
                'email' => session()->get('email'),
                'avatar' => session()->get('avatar'),
                'logged_in' => session()->get('logged_in')
            ]
        ];

        return view('author/chapters/index', $data);
    }

    public function createChapter($novelId)
    {
        $novel = $this->novelModel->find($novelId);
        
        if (!$novel || $novel->author_id != $this->idAuthor) {
            return redirect()->to('author/novels')->with('error', 'Novel tidak ditemukan atau Anda tidak memiliki akses');
        }

        // Get next chapter number
        $lastChapter = $this->chapterModel->where('novel_id', $novelId)
                                         ->orderBy('chapter_number', 'DESC')
                                         ->first();
        $nextChapterNumber = $lastChapter ? $lastChapter->chapter_number + 1 : 1;

        $data = [
            'title' => 'Tambah Chapter Baru - ' . $novel->title,
            'novel' => $novel,
            'nextChapterNumber' => $nextChapterNumber,
            // Session data for topbar
            'userSession' => [
                'user_id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'full_name' => session()->get('full_name'),
                'email' => session()->get('email'),
                'avatar' => session()->get('avatar'),
                'logged_in' => session()->get('logged_in')
            ]
        ];

        return view('author/chapters/create', $data);
    }

    public function storeChapter($novelId)
    {
        $novel = $this->novelModel->find($novelId);
        
        if (!$novel || $novel->author_id != $this->idAuthor) {
            return redirect()->to('author/novels')->with('error', 'Novel tidak ditemukan atau Anda tidak memiliki akses');
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Judul chapter harus diisi',
                    'min_length' => 'Judul chapter minimal 3 karakter',
                    'max_length' => 'Judul chapter maksimal 255 karakter'
                ]
            ],
            'content' => [
                'rules' => 'required|min_length[50]',
                'errors' => [
                    'required' => 'Konten chapter harus diisi',
                    'min_length' => 'Konten chapter minimal 50 karakter'
                ]
            ],
            'chapter_number' => [
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'Nomor chapter harus diisi',
                    'integer' => 'Nomor chapter harus berupa angka',
                    'greater_than' => 'Nomor chapter harus lebih dari 0'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Check if chapter number already exists
        $existingChapter = $this->chapterModel->where([
            'novel_id' => $novelId,
            'chapter_number' => $this->request->getPost('chapter_number')
        ])->first();

        if ($existingChapter) {
            return redirect()->back()->withInput()->with('error', 'Nomor chapter sudah ada untuk novel ini');
        }

        $chapterData = [
            'novel_id' => $novelId,
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'chapter_number' => $this->request->getPost('chapter_number'),
            'views' => 0
        ];

        if ($this->chapterModel->insert($chapterData)) {
            return redirect()->to("author/novels/{$novelId}/chapters")->with('success', 'Chapter berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan chapter');
        }
    }

    public function editChapter($novelId, $chapterId)
    {
        $novel = $this->novelModel->find($novelId);
        
        if (!$novel || $novel->author_id != $this->idAuthor) {
            return redirect()->to('author/novels')->with('error', 'Novel tidak ditemukan atau Anda tidak memiliki akses');
        }

        $chapter = $this->chapterModel->where([
            'id' => $chapterId,
            'novel_id' => $novelId
        ])->first();

        if (!$chapter) {
            return redirect()->to("author/novels/{$novelId}/chapters")->with('error', 'Chapter tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Chapter - ' . $chapter->title,
            'novel' => $novel,
            'chapter' => $chapter,
            // Session data for topbar
            'userSession' => [
                'user_id' => session()->get('user_id'),
                'username' => session()->get('username'),
                'full_name' => session()->get('full_name'),
                'email' => session()->get('email'),
                'avatar' => session()->get('avatar'),
                'logged_in' => session()->get('logged_in')
            ]
        ];

        return view('author/chapters/edit', $data);
    }

    public function updateChapter($novelId, $chapterId)
    {
        $novel = $this->novelModel->find($novelId);
        
        if (!$novel || $novel->author_id != $this->idAuthor) {
            return redirect()->to('author/novels')->with('error', 'Novel tidak ditemukan atau Anda tidak memiliki akses');
        }

        $chapter = $this->chapterModel->where([
            'id' => $chapterId,
            'novel_id' => $novelId
        ])->first();

        if (!$chapter) {
            return redirect()->to("author/novels/{$novelId}/chapters")->with('error', 'Chapter tidak ditemukan');
        }

        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Judul chapter harus diisi',
                    'min_length' => 'Judul chapter minimal 3 karakter',
                    'max_length' => 'Judul chapter maksimal 255 karakter'
                ]
            ],
            'content' => [
                'rules' => 'required|min_length[50]',
                'errors' => [
                    'required' => 'Konten chapter harus diisi',
                    'min_length' => 'Konten chapter minimal 50 karakter'
                ]
            ],
            'chapter_number' => [
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    'required' => 'Nomor chapter harus diisi',
                    'integer' => 'Nomor chapter harus berupa angka',
                    'greater_than' => 'Nomor chapter harus lebih dari 0'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Check if chapter number already exists (except current chapter)
        $existingChapter = $this->chapterModel->where([
            'novel_id' => $novelId,
            'chapter_number' => $this->request->getPost('chapter_number'),
            'id !=' => $chapterId
        ])->first();

        if ($existingChapter) {
            return redirect()->back()->withInput()->with('error', 'Nomor chapter sudah ada untuk novel ini');
        }

        $updateData = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'chapter_number' => $this->request->getPost('chapter_number')
        ];

        if ($this->chapterModel->update($chapterId, $updateData)) {
            return redirect()->to("author/novels/{$novelId}/chapters")->with('success', 'Chapter berhasil diupdate!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate chapter');
        }
    }

    // Controller Method - ubah destroyChapter menjadi seperti ini:
    public function destroyChapter($novelId, $chapterId)
    {
        $novel = $this->novelModel->find($novelId);
        
        if (!$novel || $novel->author_id != $this->idAuthor) {
            return redirect()->to(site_url('author/novels/' . $novelId . '/chapters'))
                            ->with('error', 'Novel tidak ditemukan atau Anda tidak memiliki akses');
        }

        $chapter = $this->chapterModel->where([
            'id' => $chapterId,
            'novel_id' => $novelId
        ])->first();

        if (!$chapter) {
            return redirect()->to(site_url('author/novels/' . $novelId . '/chapters'))
                            ->with('error', 'Chapter tidak ditemukan');
        }

        if (!$this->chapterModel->delete($chapterId)) {
            return redirect()->to(site_url('author/novels/' . $novelId . '/chapters'))
                            ->with('error', 'Gagal menghapus chapter');
        }

        return redirect()->to(site_url('author/novels/' . $novelId . '/chapters'))
                        ->with('success', 'Chapter berhasil dihapus');
    }

    // =====================================================
    // HELPER METHODS
    // =====================================================

    private function getNovelsByStatus($status)
    {
        $novels = $this->novelModel
            ->where('author_id', $this->idAuthor)
            ->where('status', $status)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Add categories to each novel
        foreach ($novels as $novel) {
            $novel->categories = $this->novelModel->getNovelCategories($novel->id);
            $novel->categoryNames = array_column($novel->categories, 'name');
        }

        return $novels;
    }

    private function resizeImage($imagePath)
    {
        try {
            $image = \Config\Services::image();
            
            // Get image info
            $imageInfo = getimagesize($imagePath);
            $width = $imageInfo[0];
            $height = $imageInfo[1];
            
            // Only resize if image is too large
            $maxWidth = 400;
            $maxHeight = 600;
            
            if ($width > $maxWidth || $height > $maxHeight) {
                $image->withFile($imagePath)
                      ->fit($maxWidth, $maxHeight, 'center')
                      ->save($imagePath, 85); // 85% quality
            }
            
        } catch (\Exception $e) {
            // Log error but don't fail the upload
            log_message('error', 'Failed to resize image: ' . $e->getMessage());
        }
    }
}
