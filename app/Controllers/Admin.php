<?php
namespace App\Controllers;

use App\Models\NovelModel;
use App\Models\CategoryModel;
use App\Models\ChapterModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $novelModel;
    protected $categoryModel;
    protected $chapterModel;
    protected $userModel;

    public function __construct()
    {
        $this->novelModel = new NovelModel();
        $this->categoryModel = new CategoryModel();
        $this->chapterModel = new ChapterModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return $this->dashboard();
    }

    public function dashboard()
    {
        $data = [
            'totalNovels' => $this->novelModel->countAll(),
            'totalUsers' => $this->userModel->countAll(),
            'totalAuthors' => $this->userModel->where('role', 'author')->countAllResults(),
            'totalCategories' => $this->categoryModel->countAll(),
            'novels' => $this->novelModel->novelPopuler(5),
            'novelTerbaru' => $this->novelModel->novelTerbaru(7),
            'userBaru' => $this->userModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'authors' => $this->novelModel->authorPopuler(5),
            'categories' => $this->categoryModel->tabelKategori(),
        ];

        return view('admin/dashboard', $data);
    }

    public function users()
    {
        $data = [
            'admins' => $this->userModel->where('role', 'admin')->findAll(),
            'authors' => $this->userModel->where('role', 'author')->findAll(),
            'readers' => $this->userModel->where('role', 'reader')->findAll(),
        ];

        return view('admin/users', $data);
    }

    public function create()
    {
        return view('admin/user/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'username' => [
                'rules' => 'required|min_length[3]|max_length[50]|alpha_numeric_punct|is_unique[users.username]|regex_match[/^[a-z0-9_.]+$/]',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong.',
                    'is_unique'=> 'username sudah digunakan.',
                ]
            ],
            'display_name' => [
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong.',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan.',
                ]
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role harus dipilih.',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'display_name' => $this->request->getPost('display_name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'password' => $this->request->getPost('password'),
        ];

        if (!$this->userModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', ['Gagal menyimpan data ke database.']);
        }

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        if ($id != null) {
            $user = $this->userModel->find($id);
            
            if ($user) {
                $data['users'] = $user;
                return view('admin/user/edit', $data);
            } else {
                return redirect()->to('errors/404');
            }
        } else {
            return redirect()->to('errors/404');
        }
    }

    public function update($id)
    {
        // Ambil user yang akan diupdate
        $existingUser = $this->userModel->find($id);
        if (!$existingUser) {
            return redirect()->to('admin/users')->with('errors', ['User tidak ditemukan.']);
        }

        // Set validation rules khusus untuk update
        $rules = [
            'username' => 'required|min_length[3]|alpha_numeric_punct|regex_match[/^[a-z0-9_.]+$/]|is_unique[users.username,id,' . $id . ']',
            'display_name' => 'required|min_length[1]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'role' => 'required|in_list[admin,author,reader]',
        ];

        // Tambahkan validasi password jika diisi
        $password = trim($this->request->getPost('password'));
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }

        // Custom error messages
        $messages = [
            'username' => [
                'required' => 'Username tidak boleh kosong.',
                'min_length' => 'Username minimal 3 karakter.',
                'regex_match' => 'Username hanya boleh huruf kecil, angka, underscore, dan titik.',
                'is_unique' => 'Username sudah digunakan oleh user lain.'
            ],
            'display_name' => [
                'required' => 'Nama tampilan tidak boleh kosong.',
                'min_length' => 'Nama minimal 1 karakter.',
                'max_length' => 'Nama maksimal 100 karakter.'
            ],
            'email' => [
                'required' => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique' => 'Email sudah digunakan oleh user lain.'
            ],
            'password' => [
                'min_length' => 'Password minimal 6 karakter.'
            ],
            'role' => [
                'required' => 'Role harus dipilih.',
                'in_list' => 'Role tidak valid.'
            ]
        ];

        // Jalankan validasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Siapkan data untuk update
        $data = [
            'username' => trim($this->request->getPost('username')),
            'display_name' => trim($this->request->getPost('display_name')),
            'email' => trim($this->request->getPost('email')),
            'role' => $this->request->getPost('role'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Tambahkan password jika diisi
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Disable model validation karena kita sudah validasi manual
        $this->userModel->skipValidation(true);
        
        // Update data
        if (!$this->userModel->update($id, $data)) {
            $this->userModel->skipValidation(false);
            return redirect()->back()->withInput()->with('errors', ['Gagal mengupdate data.']);
        }

        // Enable kembali model validation
        $this->userModel->skipValidation(false);

        return redirect()->to('admin/users')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
    {
        if (!$this->userModel->delete($id)) {
            return redirect()->to(site_url('admin/users'))->with('errors', ['Gagal menghapus user.']);
        }

        return redirect()->to(site_url('admin/users'))->with('success', 'User berhasil dihapus.');
    }

    public function novels()
    {
        $data['novels'] = $this->novelModel->getAll();
        return view('admin/novels', $data);
    }

    // Method baru untuk upload novel
    public function novelCreate()
    {
        $data = [
            'title' => 'Upload Novel',
            'categories' => $this->categoryModel->findAll(),
            'authors' => $this->userModel->where('role', 'author')->findAll()
        ];
        
        return view('admin/novel/upload', $data);
    }

    public function novelStore()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        
        $rules = [
            'title' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Judul novel wajib diisi.',
                    'min_length' => 'Judul novel minimal 3 karakter.',
                    'max_length' => 'Judul novel maksimal 255 karakter.'
                ]
            ],
            'author_id' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Penulis harus dipilih.',
                    'integer' => 'Penulis tidak valid.'
                ]
            ],
            'categories' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori harus dipilih minimal satu.'
                ]
            ],
            'sinopsis' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Sinopsis wajib diisi.',
                    'min_length' => 'Sinopsis minimal 10 karakter.'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[ongoing,completed,hiatus]',
                'errors' => [
                    'required' => 'Status harus dipilih.',
                    'in_list' => 'Status tidak valid.'
                ]
            ],
            'cover_image' => [
                'rules' => 'uploaded[cover_image]|max_size[cover_image,2048]|is_image[cover_image]|mime_in[cover_image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Cover image wajib diupload.',
                    'max_size' => 'Ukuran cover image maksimal 2MB.',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in' => 'Format cover image harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle upload cover image
        $coverImage = $this->request->getFile('cover_image');
        $coverName = null;
        
        if ($coverImage && $coverImage->isValid() && !$coverImage->hasMoved()) {
            $coverName = $coverImage->getRandomName();
            
            // Pastikan folder exists
            $uploadPath = ROOTPATH . 'public/uploads/covers/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if (!$coverImage->move($uploadPath, $coverName)) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload cover image!');
            }
        }

        // Insert novel data
        $novelData = [
            'title' => $this->request->getPost('title'),
            'author_id' => $this->request->getPost('author_id'),
            'cover_image' => $coverName,
            'sinopsis' => $this->request->getPost('sinopsis'),
            'status' => $this->request->getPost('status'),
            'views' => 0
        ];

        $novelId = $this->novelModel->insert($novelData);

        if ($novelId) {
            // Insert categories (many-to-many relationship)
            $categories = $this->request->getPost('categories');
            if (!empty($categories) && is_array($categories)) {
                $this->novelModel->updateNovelCategories($novelId, $categories);
            }

            return redirect()->to('/admin/novels')->with('success', 'Novel berhasil diupload dengan ' . count($categories) . ' kategori!');
        } else {
            // Hapus file cover jika insert gagal
            if ($coverName && file_exists(ROOTPATH . 'public/uploads/covers/' . $coverName)) {
                unlink(ROOTPATH . 'public/uploads/covers/' . $coverName);
            }
            
            return redirect()->back()->withInput()->with('error', 'Gagal mengupload novel!');
        }
    }

    public function novelDestroy($id)
    {
        if (!$this->novelModel->delete($id)) {
            return redirect()->to(site_url('admin/novels'))->with('errors', ['Gagal menghapus novel.']);
        }

        return redirect()->to(site_url('admin/novels'))->with('success', 'User berhasil dihapus.');
    }
    
    public function category()   
    {
        $data['categories'] = $this ->categoryModel->tabelKategori();
                
        return view('admin/categories', $data);
    }
}
