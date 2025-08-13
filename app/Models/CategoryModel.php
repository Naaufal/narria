<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'slug'];
    protected $useTimestamps    = true;
    protected $returnType       = 'object';
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Method untuk mengambil kategori dengan jumlah novel
    public function getCategoriesWithCount()
    {
        return $this->db->table('categories c')
            ->select('c.*, COUNT(nc.novel_id) as novel_count')
            ->join('novel_categories nc', 'nc.category_id = c.id', 'left')
            ->groupBy('c.id, c.name, c.slug')
            ->orderBy('c.name', 'ASC')
            ->get()
            ->getResult();
    }

    // Method untuk mengambil kategori berdasarkan slug
    public function getCategoryBySlug($slug)
    {
        return $this->where('slug', $slug)->first();
    }

    // Method untuk mengambil novel dalam kategori tertentu
    public function getNovelsInCategory($categoryId, $sort = 'latest', $perPage = 12, $page = 1)
    {
        $novelModel = new \App\Models\NovelModel();
        return $novelModel->getNovelsByCategory($categoryId, $sort, $perPage, $page);
    }
    
    public function countNovelsInCategory($categoryId)
    {
        return $this->db->table('novels n')
            ->join('novel_categories nc', 'nc.novel_id = n.id')
            ->where('nc.category_id', $categoryId)
            ->countAllResults();
    }

    // DIPERBAIKI: Menggunakan novel_categories table
    public function kategoriNovel()
    {
        $builder = $this->db->table('categories');
        $builder->select('categories.name, COUNT(nc.novel_id) as jumlahNovel');
        $builder->join('novel_categories nc', 'nc.category_id = categories.id', 'left');
        $builder->groupBy('categories.id');
        $builder->orderBy('jumlahNovel', 'DESC');
        return $builder->get()->getResult();
    }

    // DIPERBAIKI: Menggunakan novel_categories table
    public function tabelKategori()
    {
        $builder = $this->db->table('categories');
        $builder->select('categories.*, COUNT(nc.novel_id) as banyakNovel');
        $builder->join('novel_categories nc', 'nc.category_id = categories.id', 'left');
        $builder->groupBy('categories.id');
        $builder->orderBy('categories.name', 'ASC');

        return $builder->get()->getResult();
    } 

    public function novelCount()
    {
         return $this->db->table('categories')
            ->select('categories.*, COUNT(novel_categories.novel_id) as novel_count')
            ->join('novel_categories', 'novel_categories.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->get()
            ->getResult();
    }
}
