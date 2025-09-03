<?php

namespace App\Domain\Services;

use App\Domain\Entities\Proposal;
use App\Domain\Repositories\ProposalRepositoryInterface;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Money;
use DateTime;
// use App\DTO\UserData;


use Illuminate\Support\Str;

class ProposalService
{
    private ProposalRepositoryInterface $proposal;

    public function __construct(ProposalRepositoryInterface $proposal)
    {
        $this->proposal = $proposal;
    }

    public function register($cpf, $nome,$dataNascimento, $valorEmprestimo, $chavePix): Proposal
    {
        try {
            $proposal = Proposal::create(
                id: null,
                cpf: new Cpf($cpf),
                nome: $nome,
                dataNascimento: $dataNascimento,
                valorEmprestimo: new Money($valorEmprestimo),
                chavePix: $chavePix
            );

            $this->proposal->save($proposal);

            return $proposal;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateVerify(int $id){

        $proposal = $this->proposal->findById($id);

        if($proposal->autenticado()){
            if(!$proposal){
                throw new \Exception('Proposta nao Encontrada');
            }

            $proposal->setAutenticado(1);

            $this->proposal->update($proposal);

        }
        return true;
    }

    public function validateVerify(int $id){

        $proposal = $this->proposal->findById($id);

        return $proposal->autenticado();
    }


    public function updateNotify(int $id){

        $proposal = $this->proposal->findById($id);

        if($proposal->notificado()){
            if(!$proposal){
                throw new \Exception('Proposta nao Encontrada');
            }
            $proposal->setNotificado(1);

            $this->proposal->update($proposal);
        }
        return true;
    }

    public function validateNotify(int $id){

        $proposal = $this->proposal->findById($id);

        return $proposal->notificado();
    }


}