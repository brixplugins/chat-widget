<?php
/**
 * Chat Widget plugin for Craft CMS 3.x
 *
 * Install an simple and easy to customize chat widget on your website
 *
 * @link      https://brixplugins.com/
 * @copyright Copyright (c) 2021 Brix Plugins
 */

namespace brixplugins\chatwidgettests\unit;

use Codeception\Test\Unit;
use UnitTester;
use Craft;
use brixplugins\chatwidget\ChatWidget;

/**
 * ExampleUnitTest
 *
 *
 * @author    Brix Plugins
 * @package   ChatWidget
 * @since     1.0.0
 */
class ExampleUnitTest extends Unit
{
    // Properties
    // =========================================================================

    /**
     * @var UnitTester
     */
    protected $tester;

    // Public methods
    // =========================================================================

    // Tests
    // =========================================================================

    /**
     *
     */
    public function testPluginInstance()
    {
        $this->assertInstanceOf(
            ChatWidget::class,
            ChatWidget::$plugin
        );
    }

    /**
     *
     */
    public function testCraftEdition()
    {
        Craft::$app->setEdition(Craft::Pro);

        $this->assertSame(
            Craft::Pro,
            Craft::$app->getEdition()
        );
    }
}
