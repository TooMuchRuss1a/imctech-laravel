<?php

namespace App\Console\Commands;

use App\Models\Social;
use App\Services\VkApiService;
use Illuminate\Console\Command;

class VkCacheUpdater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:VkCacheUpdater';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command updates VkCache';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vkApiService = new VkApiService();
        $vks = Social::where('type', 'vk')->get();
        $nicknames = [];
        foreach ($vks as $vk) {
            $array = explode("/", $vk->link);
            $nicknames[] = $array[array_key_last($array)];
            $this->info(end($nicknames));
        }
        $this->info('Total nicknames ' . count($nicknames));
        $this->info(json_encode($nicknames));
        $response = $vkApiService->updateCache($nicknames);
        if (!empty($response)) {
            $array = [];
            foreach ($response as $vk) {
                $array[0] = $vk;
                cache()->put('id' . $vk['id'], $array, now()->addDay()->addHour());
            }
        }
        else {
            $this->error('Response empty');
        }
        $this->info('Total cached ' . count($response));
        $this->info(json_encode(array_column($response, 'id')));

        $this->info('Success');
        return 0;
    }
}
