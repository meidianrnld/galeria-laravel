<?php

namespace Tests\Feature;

use App\Models\Aplikasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_pages(): void
    {
        $this->seed();

        $this->get('/admin/aplikasi')
            ->assertRedirect('/login');
    }

    public function test_admin_provinsi_can_open_admin_pages(): void
    {
        $this->seed();

        $user = User::where('role', 'admin_provinsi')->firstOrFail();

        $this->actingAs($user)
            ->get('/admin/aplikasi')
            ->assertOk()
            ->assertSee('Manajemen Aplikasi');
    }

    public function test_viewer_cannot_open_admin_pages(): void
    {
        $this->seed();

        $user = User::where('role', 'executive_viewer')->firstOrFail();

        $this->actingAs($user)
            ->get('/admin/aplikasi')
            ->assertForbidden();
    }

    public function test_admin_can_manage_application_features(): void
    {
        $this->seed();

        $user = User::where('role', 'admin_provinsi')->firstOrFail();
        $aplikasi = Aplikasi::where('slug', 'galeria')->firstOrFail();

        $this->actingAs($user)
            ->get(route('admin.aplikasi.detail.edit', $aplikasi))
            ->assertOk()
            ->assertSee('Detail Aplikasi');

        $this->actingAs($user)
            ->post(route('admin.aplikasi.detail.fitur.store', $aplikasi), [
                'nama' => 'Audit Trail',
                'kategori' => 'Administrasi',
                'deskripsi' => 'Mencatat aktivitas administratif pengguna.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('aplikasi_fiturs', [
            'aplikasi_id' => $aplikasi->id,
            'nama' => 'Audit Trail',
        ]);
    }
}