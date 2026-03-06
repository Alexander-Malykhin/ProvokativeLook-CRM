<?php

namespace ProvokativeLook\Application\Deal\Stage\Preparation;

use CCrmProductRow;

use ProvokativeLook\Domain\Entity\Deal;
use ProvokativeLook\Application\Deal\Stage\Contracts\StageHandlerInterface;
use ProvokativeLook\Infrastructure\Repository\SmartInvoiceRepository;
use ProvokativeLook\Infrastructure\Crm\Products\ProductRowFactory;

final class CreateInvoicesHandler implements StageHandlerInterface
{
    private const PREPAY_PERCENT = 20;
    private const TYPE_PAY_FIELD = 'TYPE_PAY';
    private const ONE_INVOICE_VALUE_ID = 26;

    public function __construct(
        private SmartInvoiceRepository $invoiceRepository,
         private ProductRowFactory     $productRowFactory,
    ){}
    public function stageId(): string
    {
        return 'PREPARATION';
    }
    public function handle(Deal $deal): void
    {
        $dealId = (int)$deal->getId();
        $stage = (string)$deal->getStageId();

        $fieldValueId = (int)$deal->get(self::TYPE_PAY_FIELD);

        $dealRows = CCrmProductRow::LoadRows('D', $dealId) ?: [];

        if (!$dealRows) return;

        if ($fieldValueId === self::ONE_INVOICE_VALUE_ID)
        {
            $rows = [];

            foreach ($dealRows as $srcRow)
                $rows[] = $this->productRowFactory->fromDealRowWithPercent($srcRow, 100);

            $id = $this->invoiceRepository->createForDeal($deal, "Счет по сделке #{$dealId}", $rows);
            return;
        }

        $prepayRows = [];
        $payRows = [];

        foreach ($dealRows as $srcRow)
        {
            $prepayRows[] = $this->productRowFactory->fromDealRowWithPercent($srcRow, self::PREPAY_PERCENT);
            $payRows[] = $this->productRowFactory->fromDealRowWithPercent($srcRow, 100 - self::PREPAY_PERCENT);
        }

        $prepaymentInvoice = $this->invoiceRepository->createForDeal(
            $deal,
            "Предоплата " . self::PREPAY_PERCENT . "% #{$dealId}",
            $prepayRows
        );

        $additionalPaymentInvoice = $this->invoiceRepository->createForDeal(
            $deal,
            "Доплата " . (100 - self::PREPAY_PERCENT) . "% #{$dealId}",
            $payRows
        );
    }
}