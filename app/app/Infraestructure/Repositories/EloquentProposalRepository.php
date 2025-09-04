<?php


namespace App\Infraestructure\Repositories;

use App\Domain\Repositories\ProposalRepositoryInterface;
use App\Domain\Entities\Proposal;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Money;

use App\Models\Proposal as EloquentProposalModel;

class EloquentProposalRepository implements ProposalRepositoryInterface
{
    public function findById(int $id): ?Proposal
    {
        $userModel = EloquentProposalModel::find($id);

        return $userModel ? $this->toDomain($userModel) : null;
    }

    public function save(Proposal $proposal): void
    {
        $eloquent = EloquentProposalModel::create(
            [
                'nome' => $proposal->nome()->value(),
                'cpf' => $proposal->cpf()->value(),
                'data_nascimento' => $proposal->data_nascimento(),
                'valor_emprestimo' => $proposal->valor_emprestimo()->value(),
                'chave_pix' => $proposal->chave_pix(),
            ]
        );
        $proposal->setId($eloquent->id);
    }

    public function update(Proposal $proposal): void
    {
        $eloquent = EloquentProposalModel::find($proposal->id());
        if ($eloquent) {
            $eloquent->nome = $proposal->nome();
            $eloquent->cpf = $proposal->cpf()->value();
            $eloquent->data_nascimento = $proposal->data_nascimento();
            $eloquent->valor_emprestimo = $proposal->valor_emprestimo()->value();
            $eloquent->chave_pix = $proposal->chave_pix();
            $eloquent->autenticado = $proposal->autenticado();
            $eloquent->notificado = $proposal->notificado();
            $eloquent->save();
        }
    }

    private function toDomain(EloquentProposalModel $model): Proposal
    {
        return Proposal::create(
            id: $model->id,
            cpf: new Cpf($model->cpf),
            nome: $model->nome,
            dataNascimento: new \DateTimeImmutable($model->data_nascimento),
            valorEmprestimo: new Money($model->valor_emprestimo),
            chavePix: $model->chave_pix,
            autenticado: $model->autenticado,
            notificado: $model->notificado
        );
    }
}
