<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'generate:sitemap';
    protected $description = 'Generate the sitemap';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Sitemap::create('https://laravel.grayzonebbs.com')
            ->add(Url::create('/'))
            ->add(Url::create('/about'))
            ->add(Url::create('/contact'))
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
