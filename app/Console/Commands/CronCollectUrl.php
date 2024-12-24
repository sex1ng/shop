<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use QL\QueryList;
use DB;

class CronCollectUrl extends Command
{

    protected $signature = 'cron:template {key1?}';

    protected $description = '模板示例';

    public function handle()
    {
        $rules = [
            'title' => ['li div.p-name em', 'text', '-font'],
            'link'  => ['li div.p-img a', 'href'],
            'img'   => ['li div.p-img a img', 'src'],
            'price' => ['li div.p-price i', 'text'],
        ];

        $category = '家居';
        $html     = file_get_contents(storage_path("$category.html"));
        $data     = QueryList::Query($html, $rules)->data;
        foreach ($data as $key => &$item) {
            if (@ ! $item['link'] || @ ! $item['title'] || @ ! $item['img']) {
                unset($data[$key]);
                continue;
            }
            $item['title'] = str_replace("\r", '', $item['title']);
            $item['title'] = str_replace("\n", '', $item['title']);
            $item['title'] = str_replace("   ", '', $item['title']);
            $item['img'] = str_replace(".avif", '', $item['img']);
            if ( ! str_contains($item['link'], 'https://')) {
                $item['link'] = 'https:' . $item['link'];
            }
            if ( ! str_contains($item['img'], 'https://')) {
                $item['img'] = 'https:' . $item['img'];
            }

            $item['sale']     = rand(1, 99);
            $item['category'] = $category;
            if (str_contains($item['img'], 'data:image')) {
                unset($data[$key]);
            }
            $item['price'] = str_replace('?', rand(0, 9), $item['price']);
        }

//        dd($data);

        DB::table('tao_goods')->insert($data);

        dd($data);
    }

}