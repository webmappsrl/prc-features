<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRolesTest extends TestCase
{

    /**
     * @test
     *  */
    public function no_roles_always_false()
    {
        $u = $this->u(0, 0, 0);
        $this->assertFalse($u->hasRole(UserRole::Admin));
        $this->assertFalse($u->hasRole(UserRole::Editor));
        $this->assertFalse($u->hasRole(UserRole::Contributor));
    }

    /**
     * @test
     *  */
    public function admin_always_true()
    {
        $this->assertTrue($this->u(1, 0, 0)->hasRole(UserRole::Admin));
        $this->assertTrue($this->u(1, 1, 0)->hasRole(UserRole::Admin));
        $this->assertTrue($this->u(1, 0, 1)->hasRole(UserRole::Admin));
        $this->assertTrue($this->u(1, 1, 1)->hasRole(UserRole::Admin));
    }

    /**
     * @test
     *  */
    public function editor_always_true()
    {
        $this->assertTrue($this->u(0, 1, 0)->hasRole(UserRole::Editor));
        $this->assertTrue($this->u(0, 1, 1)->hasRole(UserRole::Editor));
    }

    /**
     * @test
     *  */
    public function contributor_always_true()
    {
        $this->assertTrue($this->u(0, 0, 1)->hasRole(UserRole::Contributor));
    }

    /**
     * @test
     *  */
    public function admin_always_false()
    {
        $this->assertFalse($this->u(0, 0, 0)->hasRole(UserRole::Admin));
        $this->assertFalse($this->u(0, 1, 0)->hasRole(UserRole::Admin));
        $this->assertFalse($this->u(0, 0, 1)->hasRole(UserRole::Admin));
        $this->assertFalse($this->u(0, 1, 1)->hasRole(UserRole::Admin));
    }

    /**
     * @test
     *  */
    public function editor_always_false()
    {
        $this->assertFalse($this->u(0, 0, 0)->hasRole(UserRole::Editor));
        $this->assertFalse($this->u(1, 0, 0)->hasRole(UserRole::Editor));
        $this->assertFalse($this->u(0, 0, 1)->hasRole(UserRole::Editor));
        $this->assertFalse($this->u(1, 0, 1)->hasRole(UserRole::Editor));
    }

    /**
     * @test
     *  */
    public function contributor_always_false()
    {
        $this->assertFalse($this->u(0, 0, 0)->hasRole(UserRole::Contributor));
        $this->assertFalse($this->u(1, 0, 0)->hasRole(UserRole::Contributor));
        $this->assertFalse($this->u(0, 1, 0)->hasRole(UserRole::Contributor));
        $this->assertFalse($this->u(1, 1, 0)->hasRole(UserRole::Contributor));
    }







    /**
     * Simplified user creator with proper roles
     *
     * @param integer $admin Set as 1 do add admin role, 0 otherwise
     * @param integer $editor Set as 1 do add developer role, 0 otherwise
     * @param integer $contributor Set as 1 do add manager role, 0 otherwise
     * @return User
     */
    private function u(int $admin, int $editor, int $contributor): User
    {
        $roles = [];
        if ($admin == 1) $roles[] = UserRole::Admin;
        if ($editor == 1) $roles[] = UserRole::Editor;
        if ($contributor == 1) $roles[] = UserRole::Contributor;
        $user = User::factory()->create(['roles' => $roles]);
        return $user;
    }
}
