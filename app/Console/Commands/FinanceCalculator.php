<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Card;
use App\Api\V1\Services\CardService;

class FinanceCalculator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finance:calculator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will calculate the finance of users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $cardService;
    public function __construct(CardService $cardService)
    {
        parent::__construct();
        $this->cardService = $cardService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $users = User::all();
        foreach($users as $user){
           $this->cardService->currentGoal($user->id);
        }
    }
}
