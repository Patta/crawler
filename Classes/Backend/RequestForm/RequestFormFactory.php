<?php

declare(strict_types=1);

namespace TomasNorre\Crawler\Backend\RequestForm;

/*
 * (c) 2020 AOE GmbH <dev@aoe.com>
 *
 * This file is part of the TYPO3 Crawler Extension.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TomasNorre\Crawler\Value\CrawlAction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Info\Controller\InfoModuleController;

final class RequestFormFactory
{
    public static function create(CrawlAction $selectedAction, StandaloneView $view, InfoModuleController $infoModuleController, array $extensionSettings): RequestFormInterface
    {
        switch ($selectedAction->__toString()) {
            case 'log':
                /** @var RequestFormInterface $requestForm */
                $requestForm = GeneralUtility::makeInstance(LogRequestForm::class, $view, $infoModuleController, $extensionSettings);
                break;
            case 'multiprocess':
                $requestForm = GeneralUtility::makeInstance(MultiProcessRequestForm::class, $view, $infoModuleController, $extensionSettings);
                break;
            case 'start':
            default:
                $requestForm = GeneralUtility::makeInstance(StartRequestForm::class, $view, $infoModuleController, $extensionSettings);
        }

        return $requestForm;
    }
}
