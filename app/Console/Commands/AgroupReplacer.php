<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AgroupReplacer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:AgroupReplacer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command replaces syntactically incorrect agroups';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $newAgroup = mb_strtoupper(mb_substr(str_replace(' ', '', $user->agroup), 0, 1, 'UTF-8'), 'UTF-8') . mb_strtolower(mb_substr(str_replace(' ', '', $user->agroup), 1, strlen(str_replace(' ', '', $user->agroup)) - 1, 'UTF-8'), 'UTF-8');
            $this->info($user->agroup . ' => ' . $newAgroup);
            $user->update(['agroup' => $newAgroup]);
        }
        $this->info('Success');
        return 0;
    }
}
