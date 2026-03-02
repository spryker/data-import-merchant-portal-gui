<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\DataImportMerchantPortalGui\Communication\GuiTable\Mapper;

use Generated\Shared\Transfer\DataImportMerchantFileCollectionTransfer;
use Generated\Shared\Transfer\DataImportMerchantFileCriteriaTransfer;
use Generated\Shared\Transfer\DataImportMerchantFileTableCriteriaTransfer;
use Generated\Shared\Transfer\GuiTableDataResponseTransfer;

interface DataImportMerchantFileGuiTableMapperInterface
{
    public function mapDataImportMerchantFileTableCriteriaTransferToDataImportMerchantFileCriteriaTransfer(
        DataImportMerchantFileTableCriteriaTransfer $dataImportMerchantFileTableCriteriaTransfer,
        DataImportMerchantFileCriteriaTransfer $dataImportMerchantFileCriteriaTransfer
    ): DataImportMerchantFileCriteriaTransfer;

    public function mapDataImportMerchantFileCollectionTransferToGuiTableDataResponseTransfer(
        DataImportMerchantFileCollectionTransfer $dataImportMerchantFileCollectionTransfer,
        GuiTableDataResponseTransfer $guiTableDataResponseTransfer
    ): GuiTableDataResponseTransfer;
}
