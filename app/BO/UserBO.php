<?php
namespace App\BO;

use Illuminate\Support\Facades\Hash;
use App\DAO\UserDAO;

class UserBO
{

    public function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }
    
    public function prepareUserData(array $data): array
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];
    }

    public function updateUser(int $id, array $data)
    {
        return $this->userDAO->update($id, $data);
    }
}