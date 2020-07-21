<?php

use App\Comment;
use App\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = factory(Post::class)->create();

        $comments = factory(Comment::class, 100)->create()->each(function (Comment $comment) use ($post) {
            $comment->replies()->saveMany($this->createComments($comment, $post, 3));
        });

        $post->comments()->saveMany($comments);
    }

    protected function createComments(Comment $comment, Post $post, $depth = 3, $currentDepth = 0) {
        if ($currentDepth < $depth) {

            return $comment->replies()->saveMany(
                factory(Comment::class, 3)->create()->each(function ($reply) use ($depth, $currentDepth, $post) {
                    $post->comments()->save($reply);

                    $this->createComments($reply, $post, $depth, ++$currentDepth);
                })
            );
        }
    }
}
