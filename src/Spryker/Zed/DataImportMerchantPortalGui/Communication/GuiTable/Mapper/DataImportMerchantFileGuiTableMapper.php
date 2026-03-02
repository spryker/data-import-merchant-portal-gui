<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\DataImportMerchantPortalGui\Communication\GuiTable\Mapper;

use Generated\Shared\Transfer\DataImportMerchantFileCollectionTransfer;
use Generated\Shared\Transfer\DataImportMerchantFileConditionsTransfer;
use Generated\Shared\Transfer\DataImportMerchantFileCriteriaTransfer;
use Generated\Shared\Transfer\DataImportMerchantFileSearchConditionsTransfer;
use Generated\Shared\Transfer\DataImportMerchantFileTableCriteriaTransfer;
use Generated\Shared\Transfer\GuiTableDataResponseTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\SortTransfer;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\DataImportMerchantFileTableConfigurationProvider;

class DataImportMerchantFileGuiTableMapper implements DataImportMerchantFileGuiTableMapperInterface
{
    /**
     * @uses \Orm\Zed\DataImportMerchant\Persistence\Map\SpyDataImportMerchantFileTableMap::COL_ID_DATA_IMPORT_MERCHANT_FILE
     *
     * @var string
     */
    protected const COL_ID_DATA_IMPORT_MERCHANT_FILE = 'spy_data_import_merchant_file.id_data_import_merchant_file';

    /**
     * @uses \Orm\Zed\DataImportMerchant\Persistence\Map\SpyDataImportMerchantFileTableMap::COL_CREATED_AT
     *
     * @var string
     */
    protected const COL_DATA_IMPORT_MERCHANT_FILE_CREATED_AT = 'spy_data_import_merchant_file.created_at';

    /**
     * @var string
     */
    protected const DIRECTION_ASC = 'ASC';

    /**
     * @var array<string, string>
     */
    protected const COLUMN_MAP = [
        DataImportMerchantFileTableConfigurationProvider::COL_KEY_CREATED_AT => self::COL_DATA_IMPORT_MERCHANT_FILE_CREATED_AT,
    ];

    public function mapDataImportMerchantFileTableCriteriaTransferToDataImportMerchantFileCriteriaTransfer(
        DataImportMerchantFileTableCriteriaTransfer $dataImportMerchantFileTableCriteriaTransfer,
        DataImportMerchantFileCriteriaTransfer $dataImportMerchantFileCriteriaTransfer
    ): DataImportMerchantFileCriteriaTransfer {
        $paginationTransfer = (new PaginationTransfer())
            ->setPage($dataImportMerchantFileTableCriteriaTransfer->getPageOrFail())
            ->setMaxPerPage($dataImportMerchantFileTableCriteriaTransfer->getPageSizeOrFail());

        $dataImportMerchantFileCriteriaTransfer
            ->setDataImportMerchantFileConditions(new DataImportMerchantFileConditionsTransfer())
            ->setDataImportMerchantFileSearchConditions(new DataImportMerchantFileSearchConditionsTransfer())
            ->setPagination($paginationTransfer);

        $orderBy = $dataImportMerchantFileTableCriteriaTransfer->getOrderBy();
        if ($orderBy && array_key_exists($orderBy, static::COLUMN_MAP)) {
            $sortField = static::COLUMN_MAP[$orderBy];
            $sortTransfer = (new SortTransfer())
                ->setField($sortField)
                ->setIsAscending($dataImportMerchantFileTableCriteriaTransfer->getOrderDirection() === static::DIRECTION_ASC);

            $dataImportMerchantFileCriteriaTransfer->addSort($sortTransfer);
        }

        $this->applyTableFilters($dataImportMerchantFileTableCriteriaTransfer, $dataImportMerchantFileCriteriaTransfer);

        return $dataImportMerchantFileCriteriaTransfer;
    }

    public function mapDataImportMerchantFileCollectionTransferToGuiTableDataResponseTransfer(
        DataImportMerchantFileCollectionTransfer $dataImportMerchantFileCollectionTransfer,
        GuiTableDataResponseTransfer $guiTableDataResponseTransfer
    ): GuiTableDataResponseTransfer {
        $paginationTransfer = $dataImportMerchantFileCollectionTransfer->getPaginationOrFail();
        $guiTableDataResponseTransfer
            ->setPage($paginationTransfer->getPageOrFail())
            ->setPageSize($paginationTransfer->getMaxPerPageOrFail())
            ->setTotal($paginationTransfer->getNbResultsOrFail());

        return $guiTableDataResponseTransfer;
    }

    protected function applyTableFilters(
        DataImportMerchantFileTableCriteriaTransfer $dataImportMerchantFileTableCriteriaTransfer,
        DataImportMerchantFileCriteriaTransfer $dataImportMerchantFileCriteriaTransfer
    ): DataImportMerchantFileCriteriaTransfer {
        $dataImportMerchantFileConditionsTransfer = $dataImportMerchantFileCriteriaTransfer
            ->getDataImportMerchantFileConditionsOrFail()
            ->setStatuses($dataImportMerchantFileTableCriteriaTransfer->getFilterStatuses())
            ->setImporterTypes($dataImportMerchantFileTableCriteriaTransfer->getFilterImporterTypes());

        if ($dataImportMerchantFileTableCriteriaTransfer->getFilterCreatedAt()) {
            $dataImportMerchantFileConditionsTransfer->setRangeCreatedAt(
                $dataImportMerchantFileTableCriteriaTransfer->getFilterCreatedAt(),
            );
        }

        if ($dataImportMerchantFileTableCriteriaTransfer->getFilterImportedBy()) {
            $dataImportMerchantFileConditionsTransfer->setUserIds(
                $dataImportMerchantFileTableCriteriaTransfer->getFilterImportedBy(),
            );
        }

        if ($dataImportMerchantFileTableCriteriaTransfer->getSearchTerm()) {
            $dataImportMerchantFileCriteriaTransfer
                ->getDataImportMerchantFileSearchConditionsOrFail()
                ->setOriginalFileName($dataImportMerchantFileTableCriteriaTransfer->getSearchTerm());
        }

        return $dataImportMerchantFileCriteriaTransfer;
    }
}
