<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private function nodeRecurse(&$nodes, $parentId = null, $maxDepth = 3)
    {
        $fakerSeedId = 44 * ($parentId + 1);
        $faker = Faker\Factory::create();
        $childrenCount = $faker->numberBetween(0, 2);

        if (is_null($parentId)) {
            $childrenCount = $faker->numberBetween(0, 4);
        }

        for ($a = 1; $a <= $childrenCount; $a++) {
            $node = new \App\Node();
            $faker->seed($fakerSeedId + $a);
            $node->name = $faker->word;
            $node->parent_id = $parentId;
            $node->save();
            $nodes[] = $node->id;

            if ($maxDepth > 0) {
                static::nodeRecurse($nodes, $node->id, $maxDepth - 1);
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $tag_ids = [];
        $users = [];
        $nodes = [];

        static::nodeRecurse($nodes);

        for ($a = 1; $a <= 5; $a++) {
            $tag = new \App\Tag();
            $faker->seed($a + 10);
            $tag->name = $faker->word;
            $tag->save();
            $tag_ids[] = $tag->id;
        }

        $faker->unique(true);
        for ($b = 1; $b <= 20; $b++) {
            $user = new \App\User();
            $faker->seed($a);
            $user->name = $faker->unique()->userName;
            $user->email = $faker->unique()->email;
            $user->password = $faker->password;
            $user->save();
            $users[] = $user;
        }

        foreach ($users as $user) {
            $faker->seed($user->id);
            if ($faker->boolean(40)) { // Author
                $author = new \App\Author();
                $author->user()->associate($user);
                $author->name = $faker->name;
                $author->save();
                if ($faker->boolean(50)) {
                    $number_of_likes = $faker->numberBetween(1, count($users));
                    $faker->unique(true);
                    for ($c = 1; $c <= $number_of_likes; $c++) {
                        $like = new \App\Like();
                        $user_key = $faker->unique()->randomElement(array_keys($users));
                        $like->user()->associate($users[$user_key]);
                        $like->likeable()->associate($author);
                        $like->save();
                    }
                }

                if ($faker->boolean(20)) {
                    $number_of_reports = $faker->numberBetween(1, round(count($users) / 3));
                    $faker->unique(true);
                    for ($d = 1; $d <= $number_of_reports; $d++) {
                        $report = new \App\Report();
                        $user_key = $faker->unique()->randomElement(array_keys($users));
                        $report->user()->associate($users[$user_key]);
                        $report->save();
                        $report->authors()->attach($author);
                    }
                }

                if ($faker->boolean(75)) { // At leat 1 article
                    $article_count = $faker->numberBetween(1, 15);
                    for ($e = 1; $e < $article_count; $e++) {
                        $article = new \App\Article();
                        $article->author()->associate($author);
                        $article->title = $faker->sentence($faker->numberBetween(3, 10));
                        $article->body = $faker->paragraphs($faker->numberBetween(2, 8), true);
                        $article->node()->associate($faker->randomElement($nodes));
                        $article->save();
                        $article->tags()->sync($faker->randomElements($tag_ids, $faker->numberBetween(0, min(3, count($tag_ids)))));
                        if ($faker->boolean(10)) {
                            $number_of_reports = $faker->numberBetween(1, round(count($users) / 3));
                            $faker->unique(true);
                            for ($f = 1; $f <= $number_of_reports; $f++) {
                                $report = new \App\Report();
                                $user_key = $faker->unique()->randomElement(array_keys($users));
                                $report->user()->associate($users[$user_key]);
                                $report->save();
                                $report->articles()->attach($article);
                            }
                        }

                        if ($faker->boolean(90)) {
                            $review = new \App\Review();
                            $user_key = $faker->randomElement(array_keys($users));
                            $review->user()->associate($users[$user_key]);
                            $review->reviewable()->associate($article);
                            $review->save();
                        }

                        if ($faker->boolean(69)) {
                            $number_of_likes = $faker->numberBetween(1, count($users));
                            $faker->unique(true);
                            for ($g = 1; $g <= $number_of_likes; $g++) {
                                $like = new \App\Like();
                                $user_key = $faker->unique()->randomElement(array_keys($users));
                                $like->user()->associate($users[$user_key]);
                                $like->likeable()->associate($article);
                                $like->save();
                            }
                        }
                    }

                    if ($faker->boolean(70)) { // At leat 1 comment
                        $comment_count = $faker->numberBetween(1, 20);
                        for ($h = 1; $h < $comment_count; $h++) {
                            $comment = new \App\Comment();
                            $comment->article()->associate($article);
                            $comment->user()->associate($user);
                            $comment->body = $faker->paragraph(4, true);
                            $comment->save();
                            if ($faker->boolean(15)) {
                                $number_of_reports = $faker->numberBetween(1, round(count($users) / 3));
                                $faker->unique(true);
                                for ($i = 1; $i <= $number_of_reports; $i++) {
                                    $report = new \App\Report();
                                    $user_key = $faker->unique()->randomElement(array_keys($users));
                                    $report->user()->associate($users[$user_key]);
                                    $report->save();
                                    $report->comments()->attach($comment);
                                }
                            }

                            if ($faker->boolean(90)) {
                                $review = new \App\Review();
                                $user_key = $faker->randomElement(array_keys($users));
                                $review->user()->associate($users[$user_key]);
                                $review->reviewable()->associate($comment);
                                $review->save();
                            }

                            if ($faker->boolean(60)) {
                                $number_of_likes = $faker->numberBetween(1, count($users));
                                $faker->unique(true);
                                for ($j = 1; $j <= $number_of_likes; $j++) {
                                    $like = new \App\Like();
                                    $user_key = $faker->unique()->randomElement(array_keys($users));
                                    $like->user()->associate($users[$user_key]);
                                    $like->likeable()->associate($comment);
                                    $like->save();
                                }
                            }
                        }

                    }

                }
            }
        }
    }
}
