<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Domain\Services\ProposalService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class ProposalJob implements ShouldQueue
{
    use Dispatchable,InteractsWithQueue,Queueable, SerializesModels;

    protected int $id;
    public $tries = 0;
    private ProposalService $proposalService;
    /**
     * Create a new job instance.
     */
    public function __construct(int $id, ProposalService $proposalService){
        $this->id = $id;
        $this->proposalService = $proposalService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {    
        if(!$this->proposalService->validateVerify($this->id)){
            $response = Http::get('https://util.devi.tools/api/v2/authorize');

            $res = $response->json();
               
            if($res['data']['authorization']){

                $this->proposalService->updateVerify($this->id);

                Log::info("Autenticado com sucesso");


            }
            else{
                Log::info("Erro ao autenticar");
                $this->release(10);
            }   
        }
        else{
            Log::info("Ja Autenticado");
        }

        if(!$this->proposalService->validateNotify($this->id)){                        
            $response = Http::post('https://util.devi.tools/api/v1/notify');
            
            $res = $response->json();

            if(!isset($res['status'])){
                    $this->proposalService->updateNotify($this->id);

                    Log::info("Notificado com sucesso");
            }
            else{
                Log::info("Erro ao Notificar");
                $this->release(10);
            }
        
        }
        else{
            Log::info("Ja Notificado");
        }
    }
}
