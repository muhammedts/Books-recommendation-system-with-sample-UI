<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ManageBooksTest extends TestCase
{
    use RefreshDatabase;

    private function bookData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'A Wizard of Earthsea',
            'authors' => 'Ursula K. Le Guin',
            'isbn' => '055338304X',
            'original_publication_year' => 1968,
            'language_code' => 'eng',
        ], $overrides);
    }

    public function test_guests_are_sent_to_login(): void
    {
        $book = Book::factory()->create();

        $this->get(route('books.create'))->assertRedirect(route('login'));
        $this->post(route('books.store'), $this->bookData())->assertRedirect(route('login'));
        $this->delete(route('books.destroy', $book))->assertRedirect(route('login'));
    }

    public function test_non_admins_cannot_create_update_or_delete_books(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['title' => 'Original title']);

        $this->actingAs($user);

        $this->get(route('books.create'))->assertForbidden();
        $this->post(route('books.store'), $this->bookData())->assertForbidden();
        $this->get(route('books.edit', $book))->assertForbidden();
        $this->put(route('books.update', $book), $this->bookData())->assertForbidden();
        $this->delete(route('books.destroy', $book))->assertForbidden();

        $this->assertDatabaseCount('books', 1);
        $this->assertSame('Original title', $book->fresh()->title);

        $this->get(route('books.show', $book))->assertDontSee('Delete');
    }

    public function test_admin_can_create_a_book_with_an_uploaded_cover(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('books.create'))->assertOk();

        $response = $this->actingAs($admin)->post(route('books.store'), $this->bookData([
            'cover' => UploadedFile::fake()->image('earthsea.jpg', 200, 300),
        ]));

        $book = Book::firstWhere('title', 'A Wizard of Earthsea');
        $this->assertNotNull($book);
        $response->assertRedirect(route('books.show', $book));

        $this->assertSame('055338304X', $book->isbn);
        $this->assertStringStartsWith('covers/', $book->image_url);
        Storage::disk('public')->assertExists($book->image_url);
        $this->assertStringContainsString('/storage/covers/', $book->cover_url);
    }

    public function test_admin_can_update_and_delete_a_book(): void
    {
        $admin = User::factory()->admin()->create();
        $book = Book::factory()->create();

        $this->actingAs($admin)->get(route('books.edit', $book))->assertOk();

        $this->actingAs($admin)
            ->put(route('books.update', $book), $this->bookData([
                'title' => 'The Tombs of Atuan',
                'image_url' => 'https://example.com/atuan.jpg',
            ]))
            ->assertRedirect(route('books.show', $book));

        $book->refresh();
        $this->assertSame('The Tombs of Atuan', $book->title);
        $this->assertSame('https://example.com/atuan.jpg', $book->cover_url);

        $this->actingAs($admin)
            ->delete(route('books.destroy', $book))
            ->assertRedirect(route('books.index'));

        $this->assertModelMissing($book);
    }

    public function test_book_validation(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('books.store'), ['title' => '', 'authors' => '', 'original_publication_year' => 'soon'])
            ->assertSessionHasErrors(['title', 'authors', 'original_publication_year']);

        $this->assertDatabaseCount('books', 0);
    }
}
