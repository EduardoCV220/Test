<?php


namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Services\ProposalService;
use App\Domain\Entities\Proposal;
use App\Domain\Repositories\ProposalRepositoryInterface;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Money;

class ProposalServiceTest extends TestCase
{
    private $repository;
    private ProposalService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Criamos um mock do repositório
        $this->repository = $this->createMock(ProposalRepositoryInterface::class);

        // Injetamos o mock no service
        $this->service = new ProposalService($this->repository);
    }

    /** @test */
    public function it_registers_a_new_proposal()
    {
        $cpf = "39325127822";
        $nome = "Eduardo Silva";
        $dataNascimento = "1990-01-01";
        $valorEmprestimo = 2500;
        $chavePix = "chave-pix-teste";

        // Esperamos que o repositório receba o método save()
        $this->repository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Proposal::class));

        $proposal = $this->service->register($cpf, $nome, $dataNascimento, $valorEmprestimo, $chavePix);

        $this->assertInstanceOf(Proposal::class, $proposal);
        $this->assertEquals($nome, $proposal->nome());
    }

    /** @test */
    public function it_updates_verify_status()
    {
        $proposal = $this->createMock(Proposal::class);

        $proposal->method('autenticado')->willReturn(true);
        $proposal->expects($this->once())->method('setAutenticado')->with(1);

        $this->repository
            ->method('findById')
            ->willReturn($proposal);

        $this->repository
            ->expects($this->once())
            ->method('update')
            ->with($proposal);

        $result = $this->service->updateVerify(1);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_validates_notify_status()
    {
        $proposal = $this->createMock(Proposal::class);
        $proposal->method('notificado')->willReturn(true);

        $this->repository
            ->method('findById')
            ->willReturn($proposal);

        $result = $this->service->validateNotify(1);

        $this->assertTrue($result);
    }
}
