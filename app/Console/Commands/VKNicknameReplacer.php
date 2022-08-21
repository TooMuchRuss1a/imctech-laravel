<?php

namespace App\Console\Commands;

use App\Models\Social;
use App\Services\VkApiService;
use Illuminate\Console\Command;

class VKNicknameReplacer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:VKNicknameReplacer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command replaces VK links with nicknames with VK links with ids';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vkApiService = new VkApiService();
        $vks = Social::where('type', 'vk')->get();
        foreach ($vks as $vk) {
            $this->info($vk->id);
            $response = $vkApiService->getVkDataViaLink($vk->link);
            sleep(1);
            if (!empty($response)) {
                $vk->update(['link' => 'https://vk.com/id'.$response[0]['id']]);
            }
            else {
                $this->error('ERROR: VK link is invalid - ' . $vk->link . ' - ' . $vk->user()->first()->login);
            }
        }
        $this->info('Success');
        return 0;
    }
}
