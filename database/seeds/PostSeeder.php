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

        $comments = factory(Comment::class, 1)->create()->each(function (Comment $comment) use ($post) {
            $comment->replies()->saveMany($this->createComments($comment));
        });

        $post->comments()->saveMany($comments);
    }

    protected function createComments(Comment $comment, $length = 3, $depth = 3, $currentDepth = 0) {
        if ($currentDepth < $depth) {

            return $comment->replies()->saveMany(
                factory(Comment::class, $length)->create()->each(function ($reply) use ($length, $depth, $currentDepth) {
                    $this->createComments($reply, $length, $depth, ++$currentDepth);
                })
            );
        }
    }
}
