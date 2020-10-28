<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Api\V1\Services\CardSummerService;
class TotalCardSummer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'card:summer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sums all cards what you have';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $cardSummerService;
    public function __construct(CardSummerService $cardSummerService)
    {
        parent::__construct();
        $this->cardSummerService = $cardSummerService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->cardSummerService->sumCards();
    }
}
