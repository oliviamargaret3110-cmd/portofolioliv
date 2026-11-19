<?php

namespace Tests\Feature;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengunjung_dapat_mengirim_pesan(): void
    {
        $this->post(route('messages.store'), [
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'impression' => 'Teman',
            'message' => 'Halo, saya ingin berdiskusi mengenai proyek website.',
        ])
            ->assertRedirect(route('contact.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('messages', [
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'is_read' => false,
        ]);
    }

    public function test_pesan_tidak_valid_ditolak(): void
    {
        $this->post(route('messages.store'), [
            'name' => '',
            'email' => 'bukan-email',
            'message' => 'pendek',
        ])->assertSessionHasErrors(['name', 'email', 'message']);

        $this->assertDatabaseCount('messages', 0);
    }

    public function test_pengiriman_pesan_dibatasi_lima_kali_per_menit(): void
    {
        $payload = [
            'name' => 'Pengunjung',
            'email' => 'pengunjung@example.com',
            'message' => 'Pesan pengujian rate limit yang cukup panjang.',
        ];

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->post(route('messages.store'), $payload)->assertRedirect(route('contact.index'));
        }

        $this->post(route('messages.store'), $payload)->assertStatus(429);
        $this->assertSame(5, Message::query()->count());
    }
}
