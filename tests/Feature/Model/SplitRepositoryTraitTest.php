<?php

namespace CaiqueMcz\AsaasPaymentGateway\Tests\Feature\Model;

use CaiqueMcz\AsaasPaymentGateway\Exception\AsaasException;
use CaiqueMcz\AsaasPaymentGateway\Model\Split;
use CaiqueMcz\AsaasPaymentGateway\Response\ListResponse;
use CaiqueMcz\AsaasPaymentGateway\Tests\Traits\GatewayTrait;
use CaiqueMcz\AsaasPaymentGateway\Tests\Traits\SplitTrait;

class SplitRepositoryTraitTest extends BaseRepository
{
    use GatewayTrait;
    use SplitTrait;

    protected string $defaultCol = "paymentExternalReference";
    protected bool $withMock = true;
    protected $mockRepository = null;


    /**
     * @throws AsaasException
     */
    public function testGetAllPaid(): ListResponse
    {
        return $this->processGetAllPaid();
    }

    /**
     * @depends testGetAllPaid
     * @throws AsaasException
     */
    public function testProcessGetPaid(ListResponse $listResponse): void
    {
        $this->processGetPaid($listResponse);
    }

    /**
     * @depends testProcessGetPaid
     * @throws AsaasException
     */
    public function testGetAllReceived(): ListResponse
    {
        return $this->processGetAllReceived();
    }

    /**
     * @depends testGetAllReceived
     * @throws AsaasException
     */
    public function testGetReceived(ListResponse $listResponse): void
    {
        $this->processGetReceived($listResponse);
    }

    public function getRandomData(): array
    {
        return [];
    }

    protected function setUp(): void
    {
        $this->initGateway();
        $injectedRepo = null;
        if ($this->withMock) {
            $injectedRepo = $this->getMockBuilder($this->getRepositoryClass())
                ->setConstructorArgs([Split::class])
                ->getMock();
        }
        $this->mockRepository = $injectedRepo;
        Split::injectRepository(Split::class, $this->mockRepository);
    }
}
