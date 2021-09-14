<?php

declare(strict_types=1);

namespace TomasNorre\Crawler\Tests\Unit\CrawlStrategy;

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

use TomasNorre\Crawler\Controller\CrawlerController;

/**
 * @codeCoverageIgnore
 * @ignoreAnnotation("noRector")
 */
class CallbackObjectForTesting
{
    /**
     * @noRector Rector\DeadCode\Rector\ClassMethod\RemoveUnusedParameterRector
     */
    public function crawler_execute(array $parameters, CrawlerController $crawlerController): string
    {
        return 'Hi, it works!';
    }
}
