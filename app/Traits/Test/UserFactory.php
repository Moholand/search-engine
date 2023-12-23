<?php

namespace App\Traits\Test;

use App\Models\User\User;

trait UserFactory
{
    public function createUser(): User
    {
        return User::create([
            'name'     => 'testName',
            'surname'  => 'testSurname',
            'email'    => 'testEmail@test.com',
            'password' => 'testPassword'
        ]);
    }
}
