<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Api\V1\Services\ProccessCardRequest;
class CardRequestProccesser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proccess:card_request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will proccess card requests';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $proccessCardRequest;
    public function __construct(ProccessCardRequest $proccessCardRequest)
    {
        parent::__construct();

        $this->proccessCardRequest = $proccessCardRequest;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->proccessCardRequest->proccessRequest();
    }
}
