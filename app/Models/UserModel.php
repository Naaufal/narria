<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'display_name', 'email', 'password', 'role', 'profile', 'bio', 'website', 'location', 'twitter', 'instagram', 'facebook'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation rules untuk update profile
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            // Remove password from data if empty (for profile updates without password change)
            unset($data['data']['password']);
        }
        
        return $data;
    }

    // Method untuk generate username yang clean (masih ada untuk keperluan lain)
    public function generateCleanUsername($displayName)
    {
        // Convert to lowercase
        $clean = strtolower($displayName);
        
        // Replace spaces with underscores
        $clean = str_replace(' ', '_', $clean);
        
        // Remove special characters except underscore and dot
        $clean = preg_replace('/[^a-z0-9_.]/', '', $clean);
        
        // Remove multiple consecutive underscores
        $clean = preg_replace('/_+/', '_', $clean);
        
        // Remove leading/trailing underscores
        $clean = trim($clean, '_');
        
        // Ensure minimum length
        if (strlen($clean) < 3) {
            $clean = 'user_' . $clean;
        }
        
        // Ensure maximum length
        if (strlen($clean) > 50) {
            $clean = substr($clean, 0, 50);
        }

        return $this->ensureUniqueUsername($clean);
    }

    private function ensureUniqueUsername($username)
    {
        $originalUsername = $username;
        $counter = 1;

        while ($this->where('username', $username)->first()) {
            $username = $originalUsername . '_' . $counter;
            $counter++;
            
            if ($counter > 100) {
                $username = $originalUsername . '_' . uniqid();
                break;
            }
        }

        return $username;
    }
    
    // DIPERBAIKI: Menggunakan novel_categories table untuk multiple categories
    public function novelTrending($authorId, $limit = 5)
    {
        $builder = $this->db->table('novels');
        $builder->select('novels.*, users.username as authorName, users.display_name as authorDisplayName');
        $builder->join('users', 'users.id = novels.author_id');
        $builder->where('novels.author_id', $authorId);
        $builder->orderBy('novels.views', 'DESC'); 
        $builder->limit($limit);
        
        $novels = $builder->get()->getResult();
        
        // Tambahkan kategori untuk setiap novel
        if (class_exists('\App\Models\NovelModel')) {
            $novelModel = new \App\Models\NovelModel();
            foreach ($novels as $novel) {
                $categories = $novelModel->getNovelCategories($novel->id);
                $novel->categories = $categories;
                $novel->categoryNames = array_column($categories, 'name');
                // Untuk backward compatibility, ambil kategori pertama sebagai categoryName
                $novel->categoryName = !empty($categories) ? $categories[0]->name : 'Tidak ada kategori';
            }
        }
        
        return $novels;
    }

    // Method baru untuk mendapatkan statistik author
    public function getAuthorStats($authorId)
    {
        $stats = [
            'total_novels' => $this->db->table('novels')->where('author_id', $authorId)->countAllResults(),
            'total_views' => 0,
            'trending_novels' => $this->novelTrending($authorId, 5)
        ];
        
        if (class_exists('\App\Models\NovelModel')) {
            $novelModel = new \App\Models\NovelModel();
            $stats['total_views'] = $novelModel->totalView($authorId);
        }
        
        return $stats;
    }

    public function getUserWithStats($userId)
    {
        $user = $this->find($userId);
        if (!$user) return null;
        
        if ($user->role === 'author') {
            $stats = $this->getAuthorStats($userId);
            $user->stats = $stats;
        }
        
        return $user;
    }

    // Method untuk mendapatkan display name atau fallback ke username
    public function getDisplayName($user)
    {
        if (is_object($user)) {
            return !empty($user->display_name) ? $user->display_name : $user->username;
        } elseif (is_array($user)) {
            return !empty($user['display_name']) ? $user['display_name'] : $user['username'];
        }
        return $user;
    }
}
