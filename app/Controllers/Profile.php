<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\NovelModel;
use App\Models\ReadingHistoryModel;
use App\Models\BookmarkModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $novelModel;
    protected $historyModel;
    protected $bookmarkModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->novelModel = new NovelModel();
        $this->historyModel = new ReadingHistoryModel();
        $this->bookmarkModel = new BookmarkModel();
    }

    public function index($username = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        
        if ($username) {
            $user = $this->userModel->where('username', $username)->first();
            if (!$user) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
            }
            $isOwnProfile = ($user->id == $userId);
        } else {
            $user = $this->userModel->find($userId);
            $isOwnProfile = true;
        }

        // Gunakan display_name untuk tampilan
        $displayName = !empty($user->display_name) ? $user->display_name : $user->username;

        $data = [
            'title' => 'Profile ' . $displayName . ' - Narria',
            'user' => $user,
            'displayName' => $displayName,
            'isOwnProfile' => $isOwnProfile
        ];

        if ($user->role === 'author') {
            $data['authorStats'] = $this->userModel->getAuthorStats($user->id);
        }

        if ($isOwnProfile) {
            $data['readerStats'] = $this->getReaderStats($userId);
        }

        return view('profile/index', $data);
    }

    public function edit()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Edit Profile - Narria',
            'user' => $user
        ];

        return view('profile/edit', $data);
    }

    public function update()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        
        // Debug: Log received data
        log_message('info', 'Profile update attempt for user ID: ' . $userId);
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));

        $validation = \Config\Services::validation();

        $rules = [
            'username' => [
                'rules' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$userId}]|regex_match[/^[a-z0-9_.]+$/]",
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'max_length' => 'Username maksimal 50 karakter.',
                    'is_unique' => 'Username sudah digunakan.',
                    'regex_match' => 'Username hanya boleh mengandung huruf kecil, angka, underscore, dan titik.'
                ]
            ],
            'display_name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama tampilan wajib diisi.',
                    'min_length' => 'Nama tampilan minimal 3 karakter.',
                    'max_length' => 'Nama tampilan maksimal 100 karakter.'
                ]
            ],
            'email' => [
                'rules' => "required|valid_email|is_unique[users.email,id,{$userId}]",
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $currentUser = $this->userModel->find($userId);
        $newDisplayName = $this->request->getPost('display_name');
        $newUsername = $this->request->getPost('username');

        log_message('info', 'Current user: ' . json_encode($currentUser));
        log_message('info', 'New display name: ' . $newDisplayName);
        log_message('info', 'New username: ' . $newUsername);

        $data = [
            'username' => $newUsername,
            'display_name' => $newDisplayName,
            'email' => $this->request->getPost('email'),
            'bio' => $this->request->getPost('bio'),
            'website' => $this->request->getPost('website'),
            'location' => $this->request->getPost('location'),
            'twitter' => $this->request->getPost('twitter'),
            'instagram' => $this->request->getPost('instagram'),
            'facebook' => $this->request->getPost('facebook')
        ];

        // Handle profile image upload
        $profileImage = $this->request->getFile('profile');
        if ($profileImage && $profileImage->isValid() && !$profileImage->hasMoved()) {
            $profileName = $profileImage->getRandomName();
            
            $uploadPath = ROOTPATH . 'public/uploads/profile/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            if ($profileImage->move($uploadPath, $profileName)) {
                $data['profile'] = $profileName;
                
                // Delete old profile image
                if ($currentUser->profile && file_exists($uploadPath . $currentUser->profile)) {
                    unlink($uploadPath . $currentUser->profile);
                }
            }
        }

        log_message('info', 'Data to update: ' . json_encode($data));

        // Try to update with detailed error logging
        try {
            $result = $this->userModel->update($userId, $data);
            log_message('info', 'Update result: ' . ($result ? 'success' : 'failed'));
            
            if ($result) {
                // Update session data
                session()->set([
                    'user_name' => $newUsername,
                    'user_display_name' => $newDisplayName
                ]);
                
                log_message('info', 'Profile updated successfully for user ID: ' . $userId);
                return redirect()->to('/profile')->with('success', 'Profile berhasil diupdate!');
            } else {
                // Get model errors if available
                $modelErrors = $this->userModel->errors();
                log_message('error', 'Model update failed. Errors: ' . json_encode($modelErrors));
                
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate profile. ' . (is_array($modelErrors) ? implode(', ', $modelErrors) : ''));
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception during profile update: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ... rest of the methods remain the same ...
    
    public function bookmarks()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 12;

        $bookmarks = $this->bookmarkModel->getUserBookmarks($userId, $perPage, $page);
        $totalBookmarks = $this->bookmarkModel->countUserBookmarks($userId);
        $bookmarkStats = $this->bookmarkModel->getBookmarkStats($userId);

        $data = [
            'title' => 'Bookmark Saya - Narria',
            'bookmarks' => $bookmarks,
            'bookmarkStats' => $bookmarkStats,
            'pagination' => [
                'current' => $page,
                'total' => ceil($totalBookmarks / $perPage),
                'perPage' => $perPage
            ]
        ];

        return view('profile/bookmarks', $data);
    }

    public function toggleBookmark()
    {
        // Debug log
        log_message('info', 'toggleBookmark method called');
        
        if (!session()->get('isLoggedIn')) {
            log_message('info', 'User not logged in');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu'
            ]);
        }

        if (!$this->request->isAJAX()) {
            log_message('info', 'Not AJAX request');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Request harus AJAX'
            ]);
        }

        $userId = session()->get('user_id');
        $novelId = $this->request->getPost('novel_id');

        log_message('info', 'User ID: ' . $userId . ', Novel ID: ' . $novelId);

        if (!$novelId) {
            log_message('info', 'Novel ID empty');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Novel ID tidak valid'
            ]);
        }

        // Check if novel exists
        $novel = $this->novelModel->find($novelId);
        if (!$novel) {
            log_message('info', 'Novel not found: ' . $novelId);
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Novel tidak ditemukan'
            ]);
        }

        try {
            log_message('info', 'Attempting to toggle bookmark');
            $isBookmarked = $this->bookmarkModel->toggleBookmark($userId, $novelId);
            
            $message = $isBookmarked ? 
                'Novel berhasil ditambahkan ke bookmark' : 
                'Novel berhasil dihapus dari bookmark';

            log_message('info', 'Bookmark toggle success: ' . ($isBookmarked ? 'added' : 'removed'));

            return $this->response->setJSON([
                'success' => true,
                'bookmarked' => $isBookmarked,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Bookmark toggle error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function checkBookmark($novelId)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['bookmarked' => false]);
        }

        $userId = session()->get('user_id');
        $isBookmarked = $this->bookmarkModel->isBookmarked($userId, $novelId);

        return $this->response->setJSON(['bookmarked' => $isBookmarked]);
    }

    public function history()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 12;

        $history = $this->historyModel->getUserHistory($userId, $perPage, $page);
        $totalHistory = $this->historyModel->countUserHistory($userId);
        $readingStats = $this->historyModel->getReadingStats($userId);
        $continueReading = $this->historyModel->getContinueReading($userId, 5);

        $data = [
            'title' => 'Riwayat Baca - Narria',
            'history' => $history,
            'readingStats' => $readingStats,
            'continueReading' => $continueReading,
            'pagination' => [
                'current' => $page,
                'total' => ceil($totalHistory / $perPage),
                'perPage' => $perPage
            ]
        ];

        return view('profile/history', $data);
    }

    public function settings()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Pengaturan - Narria',
            'user' => $user
        ];

        return view('layout/header', $data) . 
               view('profile/settings', $data) . 
               view('layout/footer');
    }

    public function updatePassword()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $validation = \Config\Services::validation();

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $user = $this->userModel->find($userId);
        
        if (!password_verify($this->request->getPost('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Password lama tidak benar.');
        }

        $newPassword = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);
        
        if ($this->userModel->update($userId, ['password' => $newPassword])) {
            return redirect()->back()->with('success', 'Password berhasil diubah!');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah password.');
        }
    }

    public function deleteAccount()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $password = $this->request->getPost('password');

        $user = $this->userModel->find($userId);
        
        if (!password_verify($password, $user->password)) {
            return redirect()->back()->with('error', 'Password tidak benar.');
        }

        // Delete user data
        $this->historyModel->where('user_id', $userId)->delete();
        $this->bookmarkModel->where('user_id', $userId)->delete();
        
        // Delete profile image
        if ($user->profile) {
            $profilePath = ROOTPATH . 'public/uploads/profile/' . $user->profile;
            if (file_exists($profilePath)) {
                unlink($profilePath);
            }
        }

        // Delete user account
        $this->userModel->delete($userId);

        // Destroy session
        session()->destroy();

        return redirect()->to('/')->with('success', 'Akun berhasil dihapus.');
    }

    private function getReaderStats($userId)
    {
        $bookmarkStats = $this->bookmarkModel->getBookmarkStats($userId);
        $readingStats = $this->historyModel->getReadingStats($userId);
        
        return [
            'total_bookmarks' => $bookmarkStats['total'],
            'total_read' => $readingStats['unique_novels'],
            'total_chapters' => $readingStats['total_chapters'],
            'favorite_genre' => $this->historyModel->getUserFavoriteGenre($userId),
            'reading_streak' => $this->historyModel->getUserReadingStreak($userId),
            'recent_activity' => $readingStats['recent_activity']
        ];
    }
}
