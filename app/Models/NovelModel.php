<?php

namespace App\Models;

use CodeIgniter\Model;

class NovelModel extends Model
{
    protected $table            = 'novels';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['title', 'author_id', 'cover_image', 'sinopsis', 'views', 'status'];
    protected $useTimestamps    = true;
    protected $returnType       = 'object';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Method untuk mengambil novel dengan kategori (many-to-many)
    public function getNovelWithCategories($id = null)
    {
        $builder = $this->db->table('novels n');
        $builder->select('n.*, u.username as authorName');
        $builder->join('users u', 'u.id = n.author_id', 'left');
        
        if ($id) {
            $builder->where('n.id', $id);
            $novel = $builder->get()->getRow();
            
            if ($novel) {
                // Ambil semua kategori untuk novel ini
                $categories = $this->getNovelCategories($id);
                $novel->categories = $categories;
                $novel->categoryNames = array_column($categories, 'name');
                $novel->categorySlugs = array_column($categories, 'slug');
            }
            
            return $novel;
        }
        
        return $builder->get()->getResult();
    }

    // Method untuk mengambil kategori dari novel tertentu
    public function getNovelCategories($novelId)
    {
        return $this->db->table('novel_categories nc')
            ->select('c.id, c.name, c.slug')
            ->join('categories c', 'c.id = nc.category_id')
            ->where('nc.novel_id', $novelId)
            ->get()
            ->getResult();
    }

    // Method untuk mengambil novel populer dengan kategori
    public function novelPopuler($limit = 10)
    {
        $novels = $this->db->table('novels n')
            ->select('n.*, u.username as authorName')
            ->join('users u', 'u.id = n.author_id', 'left')
            ->orderBy('n.views', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();

        // Tambahkan kategori untuk setiap novel
        foreach ($novels as $novel) {
            $novel->categories = $this->getNovelCategories($novel->id);
            $novel->categoryNames = array_column($novel->categories, 'name');
        }

        return $novels;
    }

    // Method untuk mengambil novel terbaru dengan kategori
    public function novelTerbaru($limit = 10)
    {
        $novels = $this->db->table('novels n')
            ->select('n.*, u.username as authorName')
            ->join('users u', 'u.id = n.author_id', 'left')
            ->orderBy('n.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();

        // Tambahkan kategori untuk setiap novel
        foreach ($novels as $novel) {
            $novel->categories = $this->getNovelCategories($novel->id);
            $novel->categoryNames = array_column($novel->categories, 'name');
        }

        return $novels;
    }

    // Tambahkan method baru untuk mendapatkan novel terpopuler berdasarkan kategori
    // Tambahkan di bawah method novelTerbaru

    public function novelPopulerByCategory($categoryId, $limit = 6)
    {
        $novels = $this->db->table('novels n')
            ->select('n.*, u.username as authorName')
            ->join('users u', 'u.id = n.author_id', 'left')
            ->join('novel_categories nc', 'nc.novel_id = n.id')
            ->where('nc.category_id', $categoryId)
            ->orderBy('n.views', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();

        // Tambahkan kategori untuk setiap novel
        foreach ($novels as $novel) {
            $novel->categories = $this->getNovelCategories($novel->id);
            $novel->categoryNames = array_column($novel->categories, 'name');
        }

        return $novels;
    }

    // Method untuk mengambil semua novel dengan kategori
    public function getAll()
    {
        $novels = $this->db->table('novels n')
            ->select('n.*, u.username as authorName')
            ->join('users u', 'u.id = n.author_id', 'left')
            ->orderBy('n.created_at', 'DESC')
            ->get()
            ->getResult();

        // Tambahkan kategori untuk setiap novel
        foreach ($novels as $novel) {
            $novel->categories = $this->getNovelCategories($novel->id);
            $novel->categoryNames = array_column($novel->categories, 'name');
        }

        return $novels;
    }

    // Method untuk mengambil novel berdasarkan kategori
    public function getNovelsByCategory($categoryId, $limit = 6)
    {
        $builder = $this->db->table('novels n')
            ->select('n.*, u.username as authorName')
            ->join('users u', 'u.id = n.author_id', 'left')
            ->join('novel_categories nc', 'nc.novel_id = n.id')
            ->where('nc.category_id', $categoryId)
            ->orderBy('n.created_at', 'DESC');

        if ($limit) {
            $builder->limit((int)$limit);
        }

        $novels = $builder->get()->getResult();

        // Tambahkan semua kategori untuk setiap novel
        foreach ($novels as $novel) {
            $novel->categories = $this->getNovelCategories($novel->id);
            $novel->categoryNames = array_column($novel->categories, 'name');
        }

        return $novels;
    }

    // Method untuk menambah kategori ke novel
    public function addCategoryToNovel($novelId, $categoryId)
    {
        return $this->db->table('novel_categories')->insert([
            'novel_id' => $novelId,
            'category_id' => $categoryId
        ]);
    }

    // Method untuk menghapus kategori dari novel
    public function removeCategoryFromNovel($novelId, $categoryId)
    {
        return $this->db->table('novel_categories')
            ->where('novel_id', $novelId)
            ->where('category_id', $categoryId)
            ->delete();
    }

    // Method untuk update kategori novel (hapus semua, lalu tambah yang baru)
    public function updateNovelCategories($novelId, $categoryIds)
    {
        // Hapus semua kategori lama
        $this->db->table('novel_categories')->where('novel_id', $novelId)->delete();
        
        // Tambah kategori baru
        if (!empty($categoryIds)) {
            $data = [];
            foreach ($categoryIds as $categoryId) {
                $data[] = [
                    'novel_id' => $novelId,
                    'category_id' => $categoryId
                ];
            }
            return $this->db->table('novel_categories')->insertBatch($data);
        }
        
        return true;
    }

    // Perbaiki method searchNovels untuk mendukung multiple categories
    public function searchNovels($keyword, $categoryIds = null)
    {
        $builder = $this->db->table('novels n')
            ->select('n.*, u.username as authorName')   
            ->join('users u', 'u.id = n.author_id', 'left');

        if ($categoryIds && !empty($categoryIds)) {
            $builder->join('novel_categories nc', 'nc.novel_id = n.id')
                   ->whereIn('nc.category_id', $categoryIds);
        }

        $builder->groupStart()
                ->like('n.title', $keyword)
                ->orLike('n.sinopsis', $keyword)
                ->orLike('u.username', $keyword)
                ->groupEnd();

        // Tambahkan group by untuk menghindari duplikasi jika menggunakan filter kategori
        if ($categoryIds && !empty($categoryIds)) {
            $builder->groupBy('n.id');
        }

        $novels = $builder->get()->getResult();

        // Tambahkan kategori untuk setiap novel
        foreach ($novels as $novel) {
            $novel->categories = $this->getNovelCategories($novel->id);
            $novel->categoryNames = array_column($novel->categories, 'name');
        }

        return $novels;
    }

    // Method untuk author populer (tidak berubah)
    public function authorPopuler($limit = 10)
    {
        return $this->db->table('novels n')
            ->select('u.id, u.username, COUNT(n.id) as novel_count, SUM(n.views) as total_views')
            ->join('users u', 'u.id = n.author_id')
            ->groupBy('u.id, u.username')
            ->orderBy('total_views', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();
    }

    public function totalView($authorId)
    {
        return $this->db->table('novels')
            ->selectSum('views')
            ->where('author_id', $authorId)
            ->get()
            ->getRow()
            ->views ?? 0;
    }

    public function getFilteredNovels($sort = 'latest', $category = null, $status = null, $perPage = 12, $page = 1)
    {
        $builder = $this->select('novels.*, users.username as authorName')
                        ->join('users', 'users.id = novels.author_id', 'left');

        // Filter by category
        if ($category) {
            $builder->join('novel_categories nc', 'nc.novel_id = novels.id')
                    ->where('nc.category_id', (int)$category);
        }

        // Filter by status
        if ($status) {
            $builder->where('novels.status', $status);
        }

        // Sorting
        switch ($sort) {
            case 'popular':
                $builder->orderBy('novels.views', 'DESC');
                break;
            case 'title':
                $builder->orderBy('novels.title', 'ASC');
                break;
            case 'views':
                $builder->orderBy('novels.views', 'DESC');
                break;
            default: // latest
                $builder->orderBy('novels.created_at', 'DESC');
                break;
        }

        // Ambil data paginated
        $novels = $builder->paginate((int)$perPage, 'default', (int)$page);

        // Tambahkan kategori untuk setiap novel
        foreach ($novels as $novel) {
            $novel->categories = $this->getNovelCategories($novel->id);
            $novel->categoryNames = array_column($novel->categories, 'name');
        }

        return $novels;
    }

    public function countFilteredNovels($category = null, $status = null)
    {
        $builder = $this->builder();

        if ($category) {
            $builder->join('novel_categories nc', 'nc.novel_id = novels.id')
                    ->where('nc.category_id', (int)$category);
        }

        if ($status) {
            $builder->where('novels.status', $status);
        }

        return $builder->countAllResults();
    }

    public function getRelatedNovels($novelId, $limit = 4)
    {
        // Get novels from same categories
        return $this->select('novels.*, users.username as authorName')
                    ->join('users', 'users.id = novels.author_id', 'left')
                    ->join('novel_categories nc', 'nc.novel_id = novels.id')
                    ->where('nc.category_id IN (SELECT category_id FROM novel_categories WHERE novel_id = ' . (int)$novelId . ')')
                    ->where('novels.id !=', (int)$novelId)
                    ->orderBy('novels.views', 'DESC')
                    ->limit((int)$limit)
                    ->get()
                    ->getResult();
    }

    public function countSearchResults($keyword = null, $categoryIds = [])
    {
        $builder = $this->builder()
                        ->join('users', 'users.id = novels.author_id', 'left');

        if ($keyword) {
            $builder->groupStart()
                    ->like('novels.title', $keyword)
                    ->orLike('novels.sinopsis', $keyword)
                    ->orLike('users.username', $keyword)
                    ->groupEnd();
        }

        if (!empty($categoryIds)) {
            $builder->join('novel_categories nc', 'nc.novel_id = novels.id')
                    ->whereIn('nc.category_id', $categoryIds);
        }

        return $builder->countAllResults();
    }

}
