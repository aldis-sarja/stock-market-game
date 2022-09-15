<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_should_be_able_to_create_user()
    {
        $user = new User([
            'name' => 'UserName',
            'email' => 'user@email.com',
            'password' => 'user_password',
            'wallet' => 12345,
        ]);
        $this->assertEquals('UserName', $user->name);
        $this->assertEquals('user@email.com', $user->email);
        $this->assertEquals('user_password', $user->password);
        $this->assertEquals(12345, $user->wallet);
    }
}
