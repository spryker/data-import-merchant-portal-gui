<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types = 1);

namespace Spryker\Zed\DataImportMerchantPortalGui\Communication;

use Spryker\Shared\GuiTable\DataProvider\GuiTableDataProviderInterface;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;
use Spryker\Shared\GuiTable\Http\GuiTableDataRequestExecutorInterface;
use Spryker\Shared\ZedUi\ZedUiFactoryInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\Form\DataImportMerchantFileForm;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\Form\DataProvider\DataImportMerchantFileFormDataProvider;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\Form\Handler\DataImportMerchantFileHandler;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\DataImportMerchantFileTableConfigurationProvider;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\DataImportMerchantFileTableConfigurationProviderInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\GuiTable\DataProvider\DataImportMerchantFileGuiTableDataProvider;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\GuiTable\Mapper\DataImportMerchantFileGuiTableMapper;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\GuiTable\Mapper\DataImportMerchantFileGuiTableMapperInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\Reader\DataImportMerchantFileReader;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\Reader\DataImportMerchantFileReaderInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\Reader\FileReader;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\Reader\FileReaderInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\Writer\FileWriter;
use Spryker\Zed\DataImportMerchantPortalGui\Communication\Writer\FileWriterInterface;
use Spryker\Zed\DataImportMerchantPortalGui\DataImportMerchantPortalGuiDependencyProvider;
use Spryker\Zed\DataImportMerchantPortalGui\Dependency\Facade\DataImportMerchantPortalGuiToDataImportMerchantFacadeInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Dependency\Facade\DataImportMerchantPortalGuiToGlossaryFacadeInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Dependency\Facade\DataImportMerchantPortalGuiToMerchantUserFacadeInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Dependency\Facade\DataImportMerchantPortalGuiToTranslatorFacadeInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Dependency\Service\DataImportMerchantPortalGuiToFileSystemServiceInterface;
use Spryker\Zed\DataImportMerchantPortalGui\Dependency\Service\DataImportMerchantPortalGuiToUtilEncodingServiceInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Spryker\Zed\DataImportMerchantPortalGui\DataImportMerchantPortalGuiConfig getConfig()
 */
class DataImportMerchantPortalGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createDataImportMerchantFileTableConfigurationProvider(): DataImportMerchantFileTableConfigurationProviderInterface
    {
        return new DataImportMerchantFileTableConfigurationProvider(
            $this->createDataImportMerchantFileReader(),
            $this->getGuiTableFactory(),
        );
    }

    public function createDataImportMerchantFileForm(): FormInterface
    {
        $dataProvider = $this->createDataImportMerchantFileFormDataProvider();
        $dataImportMerchantFileTransfer = $dataProvider->getData();

        return $this->getFormFactory()->create(
            DataImportMerchantFileForm::class,
            $dataImportMerchantFileTransfer,
            $dataProvider->getOptions($dataImportMerchantFileTransfer),
        );
    }

    public function createDataImportMerchantFileFormDataProvider(): DataImportMerchantFileFormDataProvider
    {
        return new DataImportMerchantFileFormDataProvider(
            $this->getConfig(),
            $this->getMerchantUserFacade(),
            $this->getDataImportMerchantFacade(),
        );
    }

    public function createDataImportMerchantFileGuiTableDataProvider(): GuiTableDataProviderInterface
    {
        return new DataImportMerchantFileGuiTableDataProvider(
            $this->createDataImportMerchantFileGuiTableMapper(),
            $this->createDataImportMerchantFileReader(),
            $this->getUtilEncodingService(),
            $this->getTranslatorFacade(),
        );
    }

    public function createDataImportMerchantFileGuiTableMapper(): DataImportMerchantFileGuiTableMapperInterface
    {
        return new DataImportMerchantFileGuiTableMapper();
    }

    public function createDataImportMerchantFileReader(): DataImportMerchantFileReaderInterface
    {
        return new DataImportMerchantFileReader(
            $this->getConfig(),
            $this->getDataImportMerchantFacade(),
            $this->getMerchantUserFacade(),
        );
    }

    public function createFileReader(): FileReaderInterface
    {
        return new FileReader(
            $this->getFileSystemService(),
        );
    }

    public function createFileWriter(): FileWriterInterface
    {
        return new FileWriter(
            $this->getTranslatorFacade(),
        );
    }

    public function createDataImportMerchantFileHandler(): DataImportMerchantFileHandler
    {
        return new DataImportMerchantFileHandler(
            $this->getDataImportMerchantFacade(),
            $this->getTranslatorFacade(),
            $this->getGlossaryFacade(),
        );
    }

    public function getGuiTableFactory(): GuiTableFactoryInterface
    {
        return $this->getProvidedDependency(DataImportMerchantPortalGuiDependencyProvider::SERVICE_GUI_TABLE_FACTORY);
    }

    public function getZedUiFactory(): ZedUiFactoryInterface
    {
        return $this->getProvidedDependency(DataImportMerchantPortalGuiDependencyProvider::SERVICE_ZED_UI_FACTORY);
    }

    public function getGuiTableHttpDataRequestExecutor(): GuiTableDataRequestExecutorInterface
    {
        return $this->getProvidedDependency(DataImportMerchantPortalGuiDependencyProvider::SERVICE_GUI_TABLE_HTTP_DATA_REQUEST_EXECUTOR);
    }

    public function getTranslatorFacade(): DataImportMerchantPortalGuiToTranslatorFacadeInterface
    {
        return $this->getProvidedDependency(DataImportMerchantPortalGuiDependencyProvider::FACADE_TRANSLATOR);
    }

    public function getGlossaryFacade(): DataImportMerchantPortalGuiToGlossaryFacadeInterface
    {
        return $this->getProvidedDependency(DataImportMerchantPortalGuiDependencyProvider::FACADE_GLOSSARY);
    }

    public function getDataImportMerchantFacade(): DataImportMerchantPortalGuiToDataImportMerchantFacadeInterface
    {
        return $this->getProvidedDependency(DataImportMerchantPortalGuiDependencyProvider::FACADE_DATA_IMPORT_MERCHANT);
    }

    public function getMerchantUserFacade(): DataImportMerchantPortalGuiToMerchantUserFacadeInterface
    {
        return $this->getProvidedDependency(DataImportMerchantPortalGuiDependencyProvider::FACADE_MERCHANT_USER);
    }

    public function getUtilEncodingService(): DataImportMerchantPortalGuiToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(DataImportMerchantPortalGuiDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    public function getFileSystemService(): DataImportMerchantPortalGuiToFileSystemServiceInterface
    {
        return $this->getProvidedDependency(DataImportMerchantPortalGuiDependencyProvider::SERVICE_FILE_SYSTEM);
    }
}
