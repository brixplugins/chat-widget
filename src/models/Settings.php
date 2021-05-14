<?php
/**
 * Chat Widget plugin for Craft CMS 3.x
 *
 * Chat Widget
 *
 * @link      https://brixplugins.com
 * @copyright Copyright (c) 2021 BRIX Plugins
 */

namespace brixplugins\chatwidget\models;

use brixplugins\chatwidget\ChatWidget;

use Craft;
use craft\base\Model;

/**
 * ChatWidget Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    BRIX Plugins
 * @package   ChatWidget
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $enablePlugin = true;
    public $delayPlugin = '5000';
    public $widgetType = 'whatsapp';
    public $txtMainHading = 'Welcome to our website!';
    public $txtMessage = 'Nice to meet you! If you have any question about our services, feel free to contact us.';
    public $txtButton = 'Chat with us!';
    public $txtButtonLink = 'https://api.whatsapp.com/send?phone=11234567890';
    public $colorMainHeading = '3F4D5A';
    public $colorTextMessage = '7B8793';
    public $colorTextButton = 'FFFFFF';
    public $colorBackgroundBtn = 'default';
    public $timeFrom = '8:00';
    public $timeTo = '14:00';
    public $txtActivePages = '';
    public $disableAllSites = false;
    public $enableCustomCSS = false;
    public $enableOnMobile = true;
    public $activeDay1 = true;
    public $activeDay2 = true;
    public $activeDay3 = true;
    public $activeDay4 = true;
    public $activeDay5 = true;
    public $activeDay6 = true;
    public $activeDay0 = true;
    public $fileAgentPhotoChat = [0];
    public $fileChatIcon = [0];
    public $txtAreaCustomCSS = '
    .brix-plugins__chat-widget_message {
        background: #FE742A;
    }
    ';

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['enablePlugin', 'boolean'],
            ['enablePlugin', 'default', 'value' => false ],
            ['delayPlugin', 'string'],
            ['delayPlugin', 'default', 'value' => '5000' ],
            ['widgetType', 'string'],
            ['widgetType', 'default', 'value' => 'whatsapp' ],
            ['txtMainHading', 'string'],
            ['txtMainHading', 'default', 'value' => 'Welcome to our website!' ],
            ['txtMessage', 'string'],
            ['txtMessage', 'default', 'value' => 'Nice to meet you! If you have any question about our services, feel free to contact us.' ],
            ['txtButton', 'string'],
            ['txtButton', 'default', 'value' => 'Chat with us!' ],
            ['txtButtonLink', 'string'],
            ['txtButtonLink', 'default', 'value' => 'https://api.whatsapp.com/send?phone=11234567890' ],
            ['colorMainHeading', 'string'],
            ['colorMainHeading', 'default', 'value' => '3F4D5A' ],
            ['colorTextMessage', 'string'],
            ['colorTextMessage', 'default', 'value' => '7B8793' ],
            ['colorTextButton', 'string'],
            ['colorTextButton', 'default', 'value' => 'FFFFFF' ],
            ['colorBackgroundBtn', 'string'],
            ['colorBackgroundBtn', 'default', 'value' => '' ],
            ['timeFrom', 'string'],
            ['timeFrom', 'default', 'value' => '8:00' ],
            ['timeTo', 'string'],
            ['timeTo', 'default', 'value' => '14:00' ],
            ['disableAllSites', 'boolean'],
            ['disableAllSites', 'default', 'value' => false ],
            ['txtActivePages', 'string'],
            ['enableCustomCSS', 'boolean'],
            ['enableCustomCSS', 'default', 'value' => false ],
            ['activeDay1', 'boolean'],
            ['activeDay1', 'default', 'value' => false ],
            ['activeDay2', 'boolean'],
            ['activeDay2', 'default', 'value' => false ],
            ['activeDay3', 'boolean'],
            ['activeDay3', 'default', 'value' => false ],
            ['activeDay4', 'boolean'],
            ['activeDay4', 'default', 'value' => false ],
            ['activeDay5', 'boolean'],
            ['activeDay5', 'default', 'value' => false ],
            ['activeDay6', 'boolean'],
            ['activeDay6', 'default', 'value' => false ],
            ['activeDay0', 'boolean'],
            ['activeDay0', 'default', 'value' => false ],
            ['txtAreaCustomCSS', 'string'],
            ['txtAreaCustomCSS', 'default', 'value' => '' ],
            ['enableOnMobile', 'boolean'],
            ['enableOnMobile', 'default', 'value' => false ],
            ['fileChatIcon', 'default', 'value' => [] ],
            ['fileAgentPhotoChat', 'default', 'value' => [] ]
        ];
    }
}
 