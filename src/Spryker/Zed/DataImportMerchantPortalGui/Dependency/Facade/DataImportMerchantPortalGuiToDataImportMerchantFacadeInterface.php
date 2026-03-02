<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types = 1);

namespace Spryker\Zed\DataImportMerchantPortalGui\Dependency\Facade;

use Generated\Shared\Transfer\DataImportMerchantFileCollectionRequestTransfer;
use Generated\Shared\Transfer\DataImportMerchantFileCollectionResponseTransfer;
use Generated\Shared\Transfer\DataImportMerchantFileCollectionTransfer;
use Generated\Shared\Transfer\DataImportMerchantFileCriteriaTransfer;
use Generated\Shared\Transfer\MerchantTransfer;

interface DataImportMerchantPortalGuiToDataImportMerchantFacadeInterface
{
    public function getDataImportMerchantFileCollection(
        DataImportMerchantFileCriteriaTransfer $dataImportMerchantFileCriteriaTransfer
    ): DataImportMerchantFileCollectionTransfer;

    public function createDataImportMerchantFileCollection(
        DataImportMerchantFileCollectionRequestTransfer $dataImportMerchantFileCollectionRequestTransfer
    ): DataImportMerchantFileCollectionResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return array<string, list<string>>
     */
    public function getPossibleCsvHeadersIndexedByImporterType(MerchantTransfer $merchantTransfer): array;
}
