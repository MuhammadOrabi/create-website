<?php

use Illuminate\Database\Seeder;
use App\Helpers\Blogs\Template1\Template1Helper;
use App\User;
use App\Theme;
use App\Helpers\Blogs\Template1\SectionHelper;
use App\Helpers\Blogs\Template1\ItemsHelper;

class BlogsTemplate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'blog.admin@app.com',
            'password' => bcrypt('password'),
            'address' => 'main'
        ]);

        $theme = Theme::where('location', 'templates.blogs.template1')->first();
        $site = $admin->addSite('media-reviews', $theme->id);
        $site->update(['name' => 'Media Reviews']);
        
        $page = $site->pages()->where('slug', 'page')->firstOrFail();
        SectionHelper::createDashboard($page, [
            'title' => 'Movies',
            'order' => 1,
            'active' => 1,
            'tags' => ['movies']
        ]);

        $movies = $page->sections()->where('title', 'Movies')->firstOrFail();
        ItemsHelper::create([
            'title' => 'Spider Man',
            'paragraph' => 'Storyline: Based on Marvel Comics superhero character, this is a story of Peter Parker who is a nerdy high-schooler. He was orphaned as a child, bullied by jocks, and cant confess his crush for his stunning neighborhood girl Mary Jane Watson. To say his life is "miserable" is an understatement. But one day while on an excursion to a laboratory a runaway radioactive spider bites him... and his life changes in a way no one could have imagined. Peter acquires a muscle-bound physique, clear vision, ability to cling to surfaces and crawl over walls, shooting webs from his wrist ... but the fun isnt going to last. An eccentric millionaire Norman Osborn administers a performance enhancing drug on himself and his maniacal alter ego Green Goblin emerges. Now Peter Parker has to become Spider-Man and take Green Goblin to the task... or else Goblin will kill him. They come face to face and the war begins in which only one of them will survive at the end. Written by Soumitra',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fmedia-reviews%2FSPIDER-MAN%20-%20INTO%20THE%20SPIDER-VERSE%20-%20Official%20Teaser%20Trailer-ii3n7hYQOl4.mp4?alt=media&token=067fda8b-f9d5-4511-8935-a040f949fd98',
            'img' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fmedia-reviews%2FMV5BZDEyN2NhMjgtMjdhNi00MmNlLWE5YTgtZGE4MzNjMTRlMGEwXkEyXkFqcGdeQXVyNDUyOTg3Njg%40._V1_UX182_CR0%2C0%2C182%2C268_AL_.jpg?alt=media&token=0ca8e0ec-8797-4b23-9598-f18445cf33b8'
        ], $movies);
    }
}
