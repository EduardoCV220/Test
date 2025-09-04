<?php

namespace App\Domain\Services;

use App\Domain\Entities\Proposal;
use App\Domain\Repositories\ProposalRepositoryInterface;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Nome;
use App\Domain\ValueObjects\Money;

// use App\DTO\UserData;



class ProposalService
{
    private ProposalRepositoryInterface $proposal;

    public function __construct(ProposalRepositoryInterface $proposal)
    {
        $this->proposal = $proposal;
    }

    public function register(string $cpf, string $nome, string $dataNascimento, string $valorEmprestimo, string $chavePix): Proposal
    {
        try {
            $proposal = Proposal::create(
                id: null,
                cpf: new Cpf($cpf),
                nome: new Nome($nome),
                dataNascimento: new \DateTimeImmutable($dataNascimento),
                valorEmprestimo: new Money($valorEmprestimo),
                chavePix: $chavePix
            );

            $this->proposal->save($proposal);

            return $proposal;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateVerify(int $id): bool
    {


        $proposal = $this->proposal->findById($id);

        if (!$proposal) {
            throw new \Exception('Proposta nao Encontrada');
        }

        if (!$proposal->autenticado()) {
            $proposal->setAutenticado(1);
            $this->proposal->update($proposal);
        }

        return true;
    }

    public function validateVerify(int $id): bool
    {

        $proposal = $this->proposal->findById($id);

        if (!$proposal) {
            throw new \Exception('Proposta nao Encontrada');
        }


        return $proposal->autenticado();
    }


    public function updateNotify(int $id): bool
    {

        $proposal = $this->proposal->findById($id);

        if (!$proposal) {
            throw new \Exception('Proposta nao Encontrada');
        }

        if (!$proposal->notificado()) {
            $proposal->setNotificado(1);
            $this->proposal->update($proposal);
        }

        return true;
    }

    public function validateNotify(int $id): bool
    {

        $proposal = $this->proposal->findById($id);

        if (!$proposal) {
            throw new \Exception('Proposta nao Encontrada');
        }

        return $proposal->notificado();
    }
}
