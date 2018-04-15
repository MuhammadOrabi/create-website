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
        
        $this->createMovies($site);
    }

    public function createMovies($site)
    {
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

        ItemsHelper::create([
            'title' => 'Skyfall',
            'paragraph' => 'When Bond s latest assignment goes gravely wrong and agents around the world are exposed, MI6 is attacked forcing M to relocate the agency . These events cause her authority and position to be challenged by Gareth Mallory(Ralph Fiennes), the new Chairman of the Intelligence and Security Committee . With MI6 now compromised from both inside and out, M is left with one ally she can trust : Bond . 007 takes to the shadows - aided only by field agent, Eve(Naomie Harris) - following a trail to the mysterious Silva(Javier Bardem), whose lethal and hidden motives have yet to reveal themselves.',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fmedia-reviews%2FSKYFALL%20-%20Official%20Trailer-6kw1UVovByw.mkv?alt=media&token=d2e10b7d-7138-4302-93c6-f53ac5107e83', 
            'img' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fmedia-reviews%2FMV5BNDVhZmJiYWMtNmIzMC00ZWNiLTkzZDYtNGNlZmViMGM4OGExXkEyXkFqcGdeQXVyNTIzOTk5ODM%40._V1_UX182_CR0%2C0%2C182%2C268_AL_.jpg?alt=media&token=841e1e05-b18b-47ab-98d9-6e56d741ea3a'
        ], $movies);

        ItemsHelper::create([
            'title' => 'Spectre',
            'paragraph' => 'A cryptic message from the past sends James Bond on a rogue mission to Mexico City and eventually Rome, where he meets Lucia, the beautiful and forbidden widow of an infamous criminal. Bond infiltrates a secret meeting and uncovers the existence of the sinister organisation known as SPECTRE. Meanwhile back in London, Max Denbigh, the new head of the Centre of National Security, questions Bond s actions and challenges the relevance of MI6 led by M . Bond covertly enlists Moneypenny and Q to help him seek out Madeleine Swann, the daughter of his old nemesis Mr White, who may hold the clue to untangling the web of SPECTRE . as the daughter of the assassin, she understands Bond in a way most others cannot . as Bond ventures towards the heart of SPECTRE, he learns a chilling connection between himself and the enemy he seeks . ',
            'img' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fmedia-reviews%2FMV5BOWQ1MDE1NzgtNTQ4OC00ZjliLTllZDAtN2IyOTVmMTc5YjUxXkEyXkFqcGdeQXVyNzkwMjQ5NzM%40._V1_UX182_CR0%2C0%2C182%2C268_AL_.jpg?alt=media&token=34471844-fff8-4cee-82d3-a8a0a8a53b14',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fmedia-reviews%2FSPECTRE%20-%20Final%20Trailer%20(Official)-z4UDNzXD3qA.mp4?alt=media&token=2d62cfc5-e829-4c85-8a9e-e55a92c86b7e'
        ], $movies);

        ItemsHelper::create([
            'title' => 'Casino Royale',
            'paragraph' => 'James Bond goes on his first ever mission as a 00. Le Chiffre is a banker to the world s terrorists . He is participating in a poker game at Montenegro, where he must win back his money, in order to stay safe among the terrorist market . The boss of MI6, known simply as M sends Bond, along with Vesper Lynd to attend this game and prevent Le Chiffre from winning . Bond, using help from Felix Leiter, Mathis and having Vesper pose as his partner, enters the most important poker game in his already dangerous career . But if Bond defeats Le Chiffre, will he and Vesper Lynd remain safe ? ',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fmedia-reviews%2FCasino%20Royale%20Official%20Trailer%20(2006)%20James%20Bond%20Movie%20HD-36mnx8dBbGE.mkv?alt=media&token=1c279372-c1ad-462e-a892-d75f5b1e2532',
            'img' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fmedia-reviews%2FMV5BMDI5ZWJhOWItYTlhOC00YWNhLTlkNzctNDU5YTI1M2E1MWZhXkEyXkFqcGdeQXVyNTIzOTk5ODM%40._V1_UX182_CR0%2C0%2C182%2C268_AL_.jpg?alt=media&token=ccc4a9e1-7074-41f5-9294-af189a40c0a4'
        ], $movies);
    }
}
