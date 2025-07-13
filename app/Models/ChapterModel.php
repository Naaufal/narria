<?php

namespace App\Models;

use CodeIgniter\Model;

class ChapterModel extends Model
{
    protected $table = 'chapters';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'novel_id', 'title', 'content', 'views',
        'chapter_number'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation - Sesuaikan dengan struktur database
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'novel_id' => 'required|integer',
        'chapter_number' => 'required|integer',
        'content' => 'required|min_length[10]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks - Disable callback yang bermasalah
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getNovelsByAuthor($authorId, $limit = null, $offset = null)
    {
        $builder = $this->where('author_id', $authorId);
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->orderBy('created_at', 'DESC')->findAll();
    }

    public function getNovelWithChapterCount($id)
    {
        return $this->select('novels.*, COUNT(chapters.id) as chapter_count')
                   ->join('chapters', 'chapters.novel_id = novels.id', 'left')
                   ->where('novels.id', $id)
                   ->groupBy('novels.id')
                   ->first();
    }

    public function chapterNovel($novelId)
    {
        return $this->where('novel_id', $novelId)
                    ->orderBy('chapter_number', 'ASC')
                    ->findAll();
    }
    
    public function hitungChapterNovel($novelId)
    {
        return $this->where('novel_id', $novelId)
                    ->countAllResults();
    }
    
    public function authorChapterNovel($authorId)
    {
        $builder = $this->db->table('chapters');
        $builder->select('chapters.*');
        $builder->join('novels', 'novels.id = chapters.novel_id');
        $builder->where('novels.author_id', $authorId);
        return $builder->countAllResults();
    }

    // Method helper untuk generate slug jika diperlukan
    public function generateSlugFromTitle($title)
    {
        return url_title($title, '-', true);
    }

    public function getChaptersByNovel($novelId, $limit = null, $offset = null)
    {
        $builder = $this->where('novel_id', $novelId);
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->orderBy('chapter_number', 'ASC')->findAll();
    }

    public function getNextChapterNumber($novelId)
    {
        $lastChapter = $this->where('novel_id', $novelId)
                           ->orderBy('chapter_number', 'DESC')
                           ->first();
        
        return $lastChapter ? $lastChapter->chapter_number + 1 : 1;
    }

    public function getChapterWithNovel($id)
    {
        return $this->select('chapters.*, novels.title as novel_title, novels.author_id')
                   ->join('novels', 'novels.id = chapters.novel_id')
                   ->where('chapters.id', $id)
                   ->first();
    }
}