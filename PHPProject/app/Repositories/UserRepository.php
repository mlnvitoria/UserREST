<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class UserRepository implements IRepository
{
    /**
     * Get user by ID
     *
     * @param integer $id
     * @throws ModelNotFoundException
     * @return User
     */
    public function getByID(int $id) : User
    {
        $user = User::findOrFail($id);
        if ($user['id'] !== Auth::user()['id']) {
            unset($user['api_token']);
        }
        return $user;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByAPIToken(string $token) : User
    {
        return User::where('api_token', $token)->firstOrFail();
    }

    /**
     * @return User
     */
    public function create(array $data) : User
    {
        $user = new User();
        $user->fill($data);
        $user->api_token = bin2hex(random_bytes(32));
        $user->save();

        return $user;
    }

    /**
     * @throws ModelNotFoundException
     * @return User
     */
    public function update(int $id, array $data) : User
    {
        $user = User::findOrFail($id);
        $user->fill($data);
        $user->save();

        return $user;
    }

    public function deleteById(int $id) : void
    {
        User::destroy($id);
    }

    public function getValidatorRules($name) : array
    {
        return User::getValidatorRules($name);
    }
}