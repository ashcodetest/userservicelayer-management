<?php
namespace App\Services;

use App\DAO\UserDAO;
use App\BO\UserBO;
use Illuminate\Support\Facades\Cache;

class UserService
{
    protected $userDAO;
    protected $userBO;

    public function __construct(UserDAO $userDAO, UserBO $userBO)
    {
        $this->userDAO = $userDAO;
        $this->userBO = $userBO;
    }

    public function createUser(array $data)
    {
        $prepared = $this->userBO->prepareUserData($data);
        $user = $this->userDAO->create($prepared);

        Cache::put("user_{$user->id}", $user, now()->addMinutes(10));
        return $user;
    }

    public function getUser(int $id)
    {
        return Cache::remember("user_$id", now()->addMinutes(10), function () use ($id) {
            return $this->userDAO->getById($id);
        });
    }

    public function getAllUsers()
    {
        return Cache::remember('all_users', now()->addMinutes(10), function () {
            return $this->userDAO->getAll();
        });
    }

    public function updateUser(int $id, array $data)
    {
        $user = $this->userBO->updateUser($id, $data);

        // Invalidate cache
        Cache::forget('users_all');
        Cache::forget("user_{$id}");

        return $user;
    }
}
