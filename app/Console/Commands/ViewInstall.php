<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ViewInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'for:views {--U|update} {repository?}';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install the view files from git repository';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->files = $this->laravel->make('files');

        if ($this->option('update')) {
            //只更新
            $this->gitPull();
            $this->build();
            $this->linkPublic();
            return;
        }
        $this->gitClone();
        $this->npmInstall();
        $this->build();
        $this->linkPublic();
    }

    private function gitClone()
    {
        $repo = $this->argument('repository');
        if (!$repo) {
            $repo = $this->ask('please input your views files repository of git');
        }
        if ($this->files->exists('view-src')) {
            $rs = $this->choice('view-src exists , want to overwrite?', ['overwrite', 'use exists src'], '1');
            if ($rs == 'use exists src') return;
            elseif ($rs == 'overwrite') {
                if (!$this->files->deleteDirectory(storage_path('../view-src'))) $this->comment('delete view-src failed,please try again');
                $this->comment('view-src deleted');
            }
        }
        $this->comment('start git clone , waiting...');
        exec("git clone {$repo} view-src");
    }

    private function npmInstall()
    {
        $node_v = exec('node -v');
        if (!$node_v || (int)$node_v[1] < 5) {
            $this->error('require node >= 5.4!');
        }
        $this->comment('start install npm packages,it takes a lot of time.Just wait patiently!');
        exec('npm i view-src --prefix view-src/');//安装npm 包
    }


    public function build()
    {
        $rs = exec('view-src/node_modules/gulp/bin/gulp.js build:php --gulpfile view-src/gulpfile.js --cwd view-src/');
        $this->comment('build view : ' . $rs);
    }

    private function linkPublic()
    {
        $linkDirs = ['css', 'fonts', 'js', 'images', 'views'];
        foreach ($linkDirs as $dir) {
            if (file_exists(public_path($dir))) {
                $this->files->delete(public_path($dir));
            }
            $this->files->link(storage_path("../view-src/{$dir}"), public_path($dir));
        }
    }

    private function gitPull()
    {
        $rs = exec('git --git-dir=view-src/.git pull');
        $this->comment("git pull finish\n$rs");
    }
}
