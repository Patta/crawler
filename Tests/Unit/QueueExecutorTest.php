<?php

declare(strict_types=1);

namespace TomasNorre\Crawler\Tests\Unit;

/*
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

use Nimut\TestingFramework\TestCase\UnitTestCase;
use TomasNorre\Crawler\Controller\CrawlerController;
use TomasNorre\Crawler\CrawlStrategy\CrawlStrategyFactory;
use TomasNorre\Crawler\QueueExecutor;
use TomasNorre\Crawler\Tests\Unit\CrawlStrategy\CallbackObjectForTesting;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class QueueExecutorTest extends UnitTestCase
{
    /**
     * @var QueueExecutor
     */
    protected $queueExecutor;

    /**
     * @var CrawlerController
     */
    protected $mockedCrawlerController;

    protected function setUp(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['crawler'] = [];
        $this->mockedCrawlerController = $this->createMock(CrawlerController::class);
        $crawlStrategyFactory = GeneralUtility::makeInstance(CrawlStrategyFactory::class);
        $this->queueExecutor = new QueueExecutor($crawlStrategyFactory);
    }

    /**
     * @test
     * @dataProvider invalidArgumentsReturnErrorInExecuteQueueItemDataProvider
     */
    public function invalidArgumentsReturnErrorInExecuteQueueItem(array $queueItem): void
    {
        $result = $this->queueExecutor->executeQueueItem($queueItem, $this->mockedCrawlerController);
        self::assertEquals('ERROR', $result);
    }

    /**
     * @test
     */
    public function executeQueueItemCallback(): void
    {
        $queueItem = [
            'parameters' => serialize(['_CALLBACKOBJ' => CallbackObjectForTesting::class]),
        ];
        $result = $this->queueExecutor->executeQueueItem($queueItem, $this->mockedCrawlerController);

        self::assertIsArray($result);
        self::assertArrayHasKey('content', $result);
        self::assertStringContainsString('Hi, it works!', $result['content']);
    }

    public function invalidArgumentsReturnErrorInExecuteQueueItemDataProvider(): array
    {
        return [
            'No parameters set' => [
                'queueItem' => [],
            ],
            'Parameters set, but empty' => [
                'queueItem' => [
                    'parameters' => '',
                ],
            ],
            'Parameters set, can be converted' => [
                'queueItem' => [
                    'parameters' => serialize('Simple string'),
                ],
            ],
            'Parameters set, cannot be converted' => [
                'queueItem' => [
                    'parameters' => 'A simple string not encoded',
                ],
            ],
        ];
    }
}
