<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Services\ProposalService;
use App\Jobs\ProposalJob;

class ProposalController extends Controller
{
    public function __construct(private ProposalService $proposalService){ }

    public function store(Request $request)
    {

        $proposal = $this->proposalService->register($request['cpf'], $request['nome'], $request['data_nascimento'], $request['valor_emprestimo'], $request['chave_pix']);

        ProposalJob::dispatch($proposal->id(), $this->proposalService);
        
        return response()->json([
            'status' => 'Ok',
            'message' => 'Proposta Cadastrada com sucesso'
        ]);
    }

}
