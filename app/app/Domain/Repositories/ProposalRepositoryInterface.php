<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Proposal;


interface ProposalRepositoryInterface
{
    public function findById(int $id): ?Proposal;

    public function save(Proposal $proposal): void;

    public function update(Proposal $proposal): void;

    // public function update(Proposal $proposal): void;
}
