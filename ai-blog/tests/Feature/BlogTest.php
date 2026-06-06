<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    private User $alice;

    private User $bob;

    private Category $category;

    private Post $alicePost;

    private Post $bobPost;

    private Comment $aliceComment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->alice = User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
        ]);

        $this->bob = User::factory()->create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
        ]);

        $this->category = Category::create(['name' => 'Technology']);

        $this->alicePost = Post::create([
            'title' => 'Alice Post',
            'body' => 'Alice body content.',
            'feature_image' => 'https://picsum.photos/seed/alice/800/400',
            'category_id' => $this->category->id,
            'user_id' => $this->alice->id,
        ]);

        $this->bobPost = Post::create([
            'title' => 'Bob Post',
            'body' => 'Bob body content.',
            'feature_image' => 'https://picsum.photos/seed/bob/800/400',
            'category_id' => $this->category->id,
            'user_id' => $this->bob->id,
        ]);

        $this->aliceComment = Comment::create([
            'content' => 'Alice comment.',
            'post_id' => $this->bobPost->id,
            'user_id' => $this->alice->id,
        ]);
    }

    public function test_guest_can_view_posts_index(): void
    {
        $response = $this->get(route('posts.index'));

        $response->assertOk();
        $response->assertSee('Alice Post');
        $response->assertSee('Bob Post');
    }

    public function test_guest_can_view_post_detail_with_comments(): void
    {
        $response = $this->get(route('posts.show', $this->bobPost));

        $response->assertOk();
        $response->assertSee('Bob Post');
        $response->assertSee('Alice comment.');
        $response->assertSee('Log in');
    }

    public function test_guest_cannot_create_post(): void
    {
        $this->get(route('posts.create'))->assertRedirect(route('login'));
    }

    public function test_guest_cannot_store_post(): void
    {
        $this->post(route('posts.store'), [
            'title' => 'Guest Post',
            'body' => 'Should fail.',
            'feature_image' => 'https://picsum.photos/seed/guest/800/400',
            'category_id' => $this->category->id,
        ])->assertRedirect(route('login'));
    }

    public function test_guest_cannot_store_comment(): void
    {
        $this->post(route('comments.store', $this->bobPost), [
            'content' => 'Guest comment.',
        ])->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_post(): void
    {
        $response = $this->actingAs($this->alice)->post(route('posts.store'), [
            'title' => 'New Alice Post',
            'body' => 'Fresh content.',
            'feature_image' => 'https://picsum.photos/seed/new/800/400',
            'category_id' => $this->category->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'New Alice Post',
            'user_id' => $this->alice->id,
        ]);
    }

    public function test_authenticated_user_can_create_comment(): void
    {
        $response = $this->actingAs($this->bob)->post(route('comments.store', $this->alicePost), [
            'content' => 'Bob replies to Alice.',
        ]);

        $response->assertRedirect(route('posts.show', $this->alicePost));
        $this->assertDatabaseHas('comments', [
            'content' => 'Bob replies to Alice.',
            'user_id' => $this->bob->id,
            'post_id' => $this->alicePost->id,
        ]);
    }

    public function test_post_owner_can_update_post(): void
    {
        $response = $this->actingAs($this->alice)->patch(route('posts.update', $this->alicePost), [
            'title' => 'Updated Alice Post',
            'body' => 'Updated body.',
            'feature_image' => $this->alicePost->feature_image,
            'category_id' => $this->category->id,
        ]);

        $response->assertRedirect(route('posts.show', $this->alicePost));
        $this->assertDatabaseHas('posts', [
            'id' => $this->alicePost->id,
            'title' => 'Updated Alice Post',
        ]);
    }

    public function test_non_owner_cannot_update_post(): void
    {
        $this->actingAs($this->bob)->patch(route('posts.update', $this->alicePost), [
            'title' => 'Hijacked',
            'body' => 'Nope.',
            'feature_image' => $this->alicePost->feature_image,
            'category_id' => $this->category->id,
        ])->assertForbidden();
    }

    public function test_post_owner_can_delete_post(): void
    {
        $this->actingAs($this->alice)
            ->delete(route('posts.destroy', $this->alicePost))
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', ['id' => $this->alicePost->id]);
    }

    public function test_non_owner_cannot_delete_post(): void
    {
        $this->actingAs($this->bob)
            ->delete(route('posts.destroy', $this->alicePost))
            ->assertForbidden();
    }

    public function test_comment_owner_can_update_comment(): void
    {
        $this->actingAs($this->alice)->patch(route('comments.update', $this->aliceComment), [
            'content' => 'Updated Alice comment.',
        ])->assertRedirect(route('posts.show', $this->bobPost));

        $this->assertDatabaseHas('comments', [
            'id' => $this->aliceComment->id,
            'content' => 'Updated Alice comment.',
        ]);
    }

    public function test_non_owner_cannot_update_comment(): void
    {
        $this->actingAs($this->bob)->patch(route('comments.update', $this->aliceComment), [
            'content' => 'Bob takeover.',
        ])->assertForbidden();
    }

    public function test_comment_owner_can_delete_comment(): void
    {
        $this->actingAs($this->alice)
            ->delete(route('comments.destroy', $this->aliceComment))
            ->assertRedirect(route('posts.show', $this->bobPost));

        $this->assertDatabaseMissing('comments', ['id' => $this->aliceComment->id]);
    }

    public function test_non_owner_cannot_delete_comment(): void
    {
        $this->actingAs($this->bob)
            ->delete(route('comments.destroy', $this->aliceComment))
            ->assertForbidden();
    }
}
