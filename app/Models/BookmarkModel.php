<?php

namespace App\Models;

use CodeIgniter\Model;

class BookmarkModel extends Model
{
    protected $table = 'bookmarks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'novel_id', 'created_at'];
    protected $returnType       = 'object';
    protected $useTimestamps = false;

    public function getUserBookmarks($userId, $perPage = 12, $page = 1)
    {
        return $this->select('bookmarks.*, novels.title, novels.cover_image, novels.sinopsis, novels.views, users.username as authorName')
                    ->join('novels', 'novels.id = bookmarks.novel_id')
                    ->join('users', 'users.id = novels.author_id')
                    ->where('bookmarks.user_id', $userId)
                    ->orderBy('bookmarks.created_at', 'DESC')
                    ->paginate($perPage, 'default', $page);
    }

    public function countUserBookmarks($userId)
    {
        return $this->where('user_id', $userId)->countAllResults();
    }

    public function isBookmarked($userId, $novelId)
    {
        return $this->where('user_id', $userId)
                    ->where('novel_id', $novelId)
                    ->first() !== null;
    }

    public function toggleBookmark($userId, $novelId)
    {
        $existing = $this->where('user_id', $userId)
                         ->where('novel_id', $novelId)
                         ->first();

        if ($existing) {
            $this->delete($existing->id);
            return false;
        } else {
            $this->insert([
                'user_id' => $userId,
                'novel_id' => $novelId,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return true;
        }
    }

    public function getUserBookmarkIds($userId)
    {
        $bookmarks = $this->select('novel_id')
                        ->where('user_id', $userId)
                        ->findAll();
        
        return array_column($bookmarks, 'novel_id');
    }

    public function getRecentBookmarks($userId, $limit = 5)
    {
        return $this->select('bookmarks.*, novels.title, novels.cover_image')
                    ->join('novels', 'novels.id = bookmarks.novel_id')
                    ->where('bookmarks.user_id', $userId)
                    ->orderBy('bookmarks.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getBookmarkStats($userId)
    {
        // Get bookmark statistics
        $totalBookmarks = $this->countUserBookmarks($userId);
        
        // Get most bookmarked categories
        $favoriteCategories = $this->db->table('bookmarks b')
            ->select('c.name, COUNT(*) as count')
            ->join('novels n', 'n.id = b.novel_id')
            ->join('novel_categories nc', 'nc.novel_id = n.id')
            ->join('categories c', 'c.id = nc.category_id')
            ->where('b.user_id', $userId)
            ->groupBy('c.id, c.name')
            ->orderBy('count', 'DESC')
            ->limit(3)
            ->get()
            ->getResult();

        return [
            'total' => $totalBookmarks,
            'favorite_categories' => $favoriteCategories
        ];
    }
}
