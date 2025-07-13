<?php

namespace App\Controllers;

use App\Models\NovelModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\ChapterModel;

class Home extends BaseController
{
    protected $novelModel;
    protected $categoryModel;
    protected $userModel;
    protected $chapterModel;

    public function __construct()
    {
        $this->novelModel = new NovelModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->chapterModel = new ChapterModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Narria - Portal Novel Fantasi Modern',
            'novelPopuler' => $this->novelModel->novelPopuler(8),
            'novelTerbaru' => $this->novelModel->novelTerbaru(8),
            'categories' => $this->categoryModel->getCategoriesWithCount(),
            'topAuthors' => $this->novelModel->authorPopuler(6),
            'totalNovels' => $this->novelModel->countAll(),
            'totalAuthors' => $this->userModel->where('role', 'author')->countAllResults(),
            'featuredNovels' => $this->novelModel->novelPopuler(3),
        ];

        return view('home/index', $data);
    }

    public function novels()
    {
        $perPage = 12;
        $page = (int)($this->request->getGet('page') ?? 1);
        $sort = $this->request->getGet('sort') ?? 'latest';
        $category = $this->request->getGet('category');
        $status = $this->request->getGet('status');

        $novels = $this->novelModel->getFilteredNovels($sort, $category, $status, $perPage, $page);
        $totalNovels = $this->novelModel->countFilteredNovels($category, $status);

        $data = [
            'title' => 'Semua Novel - Narria',
            'novels' => $novels,
            'categories' => $this->categoryModel->findAll(),
            'currentSort' => $sort,
            'currentCategory' => $category,
            'currentStatus' => $status,
            'pagination' => [
                'current' => $page,
                'total' => ceil($totalNovels / $perPage),
                'perPage' => $perPage
            ]
        ];

        return view('home/novels', $data);
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        $categoryIds = $this->request->getGet('categories') ?? [];
        $page = (int)($this->request->getGet('page') ?? 1);
        $perPage = 12;
        
        if (empty($keyword) && empty($categoryIds)) {
            return redirect()->to('/novels');
        }

        $novels = $this->novelModel->searchNovels($keyword, $categoryIds, $perPage, $page);
        $totalResults = $this->novelModel->countSearchResults($keyword, $categoryIds);

        $data = [
            'title' => 'Pencarian: ' . ($keyword ?: 'Filter Kategori') . ' - Narria',
            'novels' => $novels,
            'keyword' => $keyword,
            'categories' => $this->categoryModel->findAll(),
            'selectedCategories' => $categoryIds,
            'totalResults' => $totalResults,
            'pagination' => [
                'current' => $page,
                'total' => ceil($totalResults / $perPage),
                'perPage' => $perPage
            ]
        ];

        return view('home/search', $data);
    }

    public function novel($id)
    {
        $novel = $this->novelModel->getNovelWithCategories($id);
        
        if (!$novel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Novel tidak ditemukan');
        }

        // Update views
        $this->novelModel->update($id, ['views' => $novel->views + 1]);

        // Get chapters
        $chapters = $this->chapterModel->where('novel_id', $id)
                                      ->orderBy('chapter_number', 'ASC')
                                      ->findAll();
        
        // Get related novels
        $relatedNovels = $this->novelModel->getRelatedNovels($id, 4);

        // Check if user bookmarked this novel
        $isBookmarked = false;
        if (session()->get('isLoggedIn')) {
            $bookmarkModel = new \App\Models\BookmarkModel();
            $isBookmarked = $bookmarkModel->isBookmarked(session()->get('user_id'), $id);
        }

        $data = [
            'title' => $novel->title . ' - Narria',
            'novel' => $novel,
            'chapters' => $chapters,
            'relatedNovels' => $relatedNovels,
            'isBookmarked' => $isBookmarked,
            'totalChapters' => count($chapters)
        ];

        return view('home/novel_detail', $data);
    }

    public function category($slug = null)
    {
        if ($slug) {
            $category = $this->categoryModel->where('slug', $slug)->first();
            
            if (!$category) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
            }

            $page = (int)($this->request->getGet('page') ?? 1);
            $perPage = 12;
            $sort = $this->request->getGet('sort') ?? 'latest';

            $novels = $this->categoryModel->getNovelsInCategory($category->id, $sort, $perPage, $page);
            $totalNovels = $this->categoryModel->countNovelsInCategory($category->id);

            $data = [
                'title' => 'Kategori: ' . $category->name . ' - Narria',
                'category' => $category,
                'novels' => $novels,
                'categories' => $this->categoryModel->findAll(),
                'currentSort' => $sort,
                'pagination' => [
                    'current' => $page,
                    'total' => ceil($totalNovels / $perPage),
                    'perPage' => $perPage
                ]
            ];

            return view('home/category', $data);
        } else {
            $data = [
                'title' => 'Semua Kategori - Narria',
                'categories' => $this->categoryModel->novelCount()
            ];

            return view('home/categories', $data);
        }
    }

    // AJAX endpoints
    public function toggleBookmark()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Login required']);
        }

        $novelId = $this->request->getPost('novel_id');
        $userId = session()->get('user_id');

        $bookmarkModel = new \App\Models\BookmarkModel();
        $result = $bookmarkModel->toggleBookmark($userId, $novelId);

        return $this->response->setJSON([
            'success' => true,
            'bookmarked' => $result,
            'message' => $result ? 'Novel ditambahkan ke bookmark' : 'Novel dihapus dari bookmark'
        ]);
    }

    public function chapter($novelId, $chapterNumber)
    {
        $novel = $this->novelModel->find($novelId);
        if (!$novel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Novel tidak ditemukan');
        }

        $chapter = $this->chapterModel->where('novel_id', $novelId)
                                     ->where('chapter_number', $chapterNumber)
                                     ->first();
        if (!$chapter) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Chapter tidak ditemukan');
        }

        // Get navigation chapters
        $prevChapter = $this->chapterModel->where('novel_id', $novelId)
                                         ->where('chapter_number <', $chapterNumber)
                                         ->orderBy('chapter_number', 'DESC')
                                         ->first();
        
        $nextChapter = $this->chapterModel->where('novel_id', $novelId)
                                         ->where('chapter_number >', $chapterNumber)
                                         ->orderBy('chapter_number', 'ASC')
                                         ->first();
        
        try {
            if (isset($chapter) && isset($chapter->id) && isset($chapter->views)) {
                $this->chapterModel->update($chapter->id, [
                    'views' => $chapter->views + 1
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to update chapter views: ' . $e->getMessage());
        }


        // Save reading history if user logged in
        if (session()->get('isLoggedIn')) {
            try {
                $this->saveReadingHistory(session()->get('user_id'), $novelId, $chapter->id);
            } catch (\Exception $e) {
                // Log error tapi jangan stop eksekusi
                log_message('error', 'Failed to save reading history: ' . $e->getMessage());
            }
        }

        $data = [
            'title' => $chapter->title . ' - ' . $novel->title . ' - Narria',
            'novel' => $novel,
            'chapter' => $chapter,
            'prevChapter' => $prevChapter,
            'nextChapter' => $nextChapter
        ];

        return view('home/chapter', $data);
    }

    private function saveReadingHistory($userId, $novelId, $chapterId)
    {
        $historyModel = new \App\Models\ReadingHistoryModel();
        
        // Cek apakah sudah ada record untuk user dan novel ini
        $existing = $historyModel->where('user_id', $userId)
                                ->where('novel_id', $novelId)
                                ->first();

        if ($existing) {
            // Update existing record - pastikan ada data yang diupdate
            $updateData = [
                'chapter_id' => $chapterId,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Pastikan ada perubahan data sebelum update
            if ($existing->chapter_id != $chapterId) {
                $historyModel->update($existing->id, $updateData);
            }
        } else {
            // Insert new record
            $insertData = [
                'user_id' => $userId,
                'novel_id' => $novelId,
                'chapter_id' => $chapterId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $historyModel->insert($insertData);
        }
    }
}
