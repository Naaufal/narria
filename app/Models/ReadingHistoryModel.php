<?php

namespace App\Models;

use CodeIgniter\Model;

class ReadingHistoryModel extends Model
{
    protected $table = 'reading_history';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'novel_id', 'chapter_id', 'created_at', 'updated_at'];
    protected $returnType       = 'object';
    protected $useTimestamps = false;

    public function getUserHistory($userId, $perPage = 12, $page = 1)
    {
        return $this->select('reading_history.*, novels.title, novels.cover_image, chapters.title as chapter_title, chapters.chapter_number, users.username as authorName')
                    ->join('novels', 'novels.id = reading_history.novel_id')
                    ->join('chapters', 'chapters.id = reading_history.chapter_id')
                    ->join('users', 'users.id = novels.author_id')
                    ->where('reading_history.user_id', $userId)
                    ->orderBy('reading_history.updated_at', 'DESC')
                    ->paginate($perPage, 'default', $page);
    }

    public function countUserHistory($userId)
    {
        return $this->where('user_id', $userId)->countAllResults();
    }

    public function getUserFavoriteGenre($userId)
    {
        $result = $this->select('categories.name, COUNT(*) as count')
                       ->join('novels', 'novels.id = reading_history.novel_id')
                       ->join('novel_categories', 'novel_categories.novel_id = novels.id')
                       ->join('categories', 'categories.id = novel_categories.category_id')
                       ->where('reading_history.user_id', $userId)
                       ->groupBy('categories.id')
                       ->orderBy('count', 'DESC')
                       ->first();

        return $result ? $result->name : 'Belum ada';
    }

    public function getUserReadingStreak($userId)
    {
        // Simple implementation - count consecutive days with reading activity
        $recentDays = $this->select('DATE(updated_at) as read_date')
                           ->where('user_id', $userId)
                           ->where('updated_at >=', date('Y-m-d', strtotime('-30 days')))
                           ->groupBy('DATE(updated_at)')
                           ->orderBy('read_date', 'DESC')
                           ->findAll();

        $streak = 0;
        $currentDate = date('Y-m-d');

        foreach ($recentDays as $day) {
            if ($day->read_date === $currentDate || $day->read_date === date('Y-m-d', strtotime($currentDate . ' -1 day'))) {
                $streak++;
                $currentDate = date('Y-m-d', strtotime($day->read_date . ' -1 day'));
            } else {
                break;
            }
        }

        return $streak;
    }

    public function addReadingHistory($userId, $novelId, $chapterId)
    {
        // Check if already exists
        $existing = $this->where('user_id', $userId)
                        ->where('novel_id', $novelId)
                        ->where('chapter_id', $chapterId)
                        ->first();

        if ($existing) {
            // Update timestamp
            return $this->update($existing->id, [
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Insert new record
            return $this->insert([
                'user_id' => $userId,
                'novel_id' => $novelId,
                'chapter_id' => $chapterId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function getReadingStats($userId)
    {
        // Total unique novels read
        $uniqueNovels = $this->select('novel_id')
                            ->where('user_id', $userId)
                            ->groupBy('novel_id')
                            ->countAllResults();

        // Total chapters read
        $totalChapters = $this->where('user_id', $userId)->countAllResults();

        // Recent reading activity (last 7 days)
        $recentActivity = $this->where('user_id', $userId)
                            ->where('updated_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
                            ->countAllResults();

        return [
            'unique_novels' => $uniqueNovels,
            'total_chapters' => $totalChapters,
            'recent_activity' => $recentActivity
        ];
    }

    public function getContinueReading($userId, $limit = 5)
    {
        // Get latest reading history for continue reading
        return $this->select('reading_history.*, novels.title, novels.cover_image, chapters.title as chapter_title, chapters.chapter_number')
                    ->join('novels', 'novels.id = reading_history.novel_id')
                    ->join('chapters', 'chapters.id = reading_history.chapter_id')
                    ->where('reading_history.user_id', $userId)
                    ->orderBy('reading_history.updated_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
