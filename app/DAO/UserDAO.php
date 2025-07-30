<?php
namespace App\DAO;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserDAO
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $data): ?User
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function getAll(): Collection
    {
        return User::query()->get();
    }
}
