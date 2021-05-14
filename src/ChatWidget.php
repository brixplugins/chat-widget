<?php
/**
 * Chat Widget plugin for Craft CMS 3.x
 *
 * Chat Widget
 *
 * @link      https://brixplugins.com
 * @copyright Copyright (c) 2021 BRIX Plugins
 */

namespace brixplugins\chatwidget;

use brixplugins\chatwidget\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;
use craft\web\View;

use yii\base\Event;

/**
 * https://docs.craftcms.com/v3/extend/
 *
 * @author    BRIX Plugins
 * @package   ChatWidget
 * @since     1.0.0
 *
 * @property  ChatWidgetServiceService $chatWidgetService
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class ChatWidget extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * ChatWidget::$plugin
     *
     * @var ChatWidget
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * Set to `true` if the plugin should have a settings view in the control panel.
     *
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * Set to `true` if the plugin should have its own section (main nav item) in the control panel.
     *
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================


    public function init()
    {
        parent::init();
        self::$plugin = $this;


        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function(RegisterCpNavItemsEvent $event) {
                $event->navItems[] = [
                    'url' => 'settings/plugins/chat-widget',
                    'label' => \Craft::t('app', 'Chat Widget'),
                    'id' => 'nav-chat-widget',
                    'icon' => '@vendor/brixplugins/chat-widget/src/icon-mask.svg'
                ];
            }
        );


        $site_active = false;        
        
        if( $this->getSettings()->disableAllSites ) {
            
            $sites_array = explode(",", $this->getSettings()->txtActivePages);
           
            if( in_array(Craft::$app->getSites()->getCurrentSite()->id, $sites_array) ) {
                $site_active = true;
            }                     

        } else {
            $site_active = true;
        }

        
        if( $site_active AND $this->getSettings()->enablePlugin AND !strpos($_SERVER['REQUEST_URI'], '/'.craft\helpers\App::env('CP_TRIGGER') ?: 'admin') ) {
            

            \Craft::$app->view->registerAssetBundle('brixplugins\\chatwidget\\assetbundles\\chatwidget\\ChatWidgetAsset');


            \Craft::$app->view->registerCss( '.brix-plugins__chat-widget_button { color: #'.$this->getSettings()->colorTextButton.'; } .brix-plugins__chat-widget_message h5 { color: #'.$this->getSettings()->colorMainHeading.'; }.brix-plugins__chat-widget_message p { color: #'.$this->getSettings()->colorTextMessage.'; }' );

            if( $this->getSettings()->colorBackgroundBtn != '' AND  $this->getSettings()->colorBackgroundBtn != 'default' ) {
                \Craft::$app->view->registerCss( '.brix-plugins__chat-widget_button { background: #'.$this->getSettings()->colorBackgroundBtn.';   }' );
            }

            if( $this->getSettings()->enableCustomCSS ) {            
                \Craft::$app->view->registerCss( $this->getSettings()->txtAreaCustomCSS );
            }

            if( !$this->getSettings()->enableOnMobile ) {            
                \Craft::$app->view->registerCss(' @media (max-width: 992px) { .brix-plugins__chat-widget { display: none !important; } }');
            }

            Event::on(
                View::class,
                View::EVENT_BEGIN_BODY,
                function(Event $event) {

                    $plugin_state = 0;

                    if(isset($_COOKIE['bp-chat-open'])){
                        if($_COOKIE['bp-chat-open'] == 1) {
                            $plugin_state = 1;
                        }
                    }


                    if( $plugin_state == 0 ) {
                                            
                        $active_days = [];

                        if( $this->getSettings()->activeDay1 ) {
                            $active_days[] = 1;
                        }

                        if( $this->getSettings()->activeDay2 ) {
                            $active_days[] = 2;
                        }

                        if( $this->getSettings()->activeDay3 ) {
                            $active_days[] = 3;
                        }

                        if( $this->getSettings()->activeDay4 ) {
                            $active_days[] = 4;
                        }

                        if( $this->getSettings()->activeDay5 ) {
                            $active_days[] = 5;
                        }

                        if( $this->getSettings()->activeDay6 ) {
                            $active_days[] = 6;
                        }

                        if( $this->getSettings()->activeDay0 ) {
                            $active_days[] = 0;
                        }

                        if(in_array(date("w"), $active_days)) {
                            if (time() >= strtotime($this->getSettings()->timeFrom.':00') AND time() <= strtotime($this->getSettings()->timeTo.':00')) {
                            
                            } else {
                                $plugin_state = 1;
                            }
                        } else {
                            $plugin_state = 1;
                        }

                    }


                    $asset_agent = \craft\elements\Asset::find()
                        ->id($this->getSettings()['fileAgentPhotoChat'][0])
                        ->one();

                        if( $asset_agent ) {                            
                            $url_image_agent = $asset_agent->getThumbUrl(144);
                        } else {                        

                            $url_image_agent = \Craft::$app->assetManager->getPublishedUrl(
                                '@brixplugins/chatwidget/assetbundles/settings/dist/img/agent.png',
                                true
                            );
    
                        }

                    if( $this->getSettings()->widgetType  == 'custom' ) {

                        $asset_icon = \craft\elements\Asset::find()
                        ->id($this->getSettings()['fileChatIcon'][0])
                        ->one();

                        if( $asset_icon ) {
                            $url_image_icon = $asset_icon->getThumbUrl(180);
                        } else {

                            $url_image_icon = \Craft::$app->assetManager->getPublishedUrl(
                                '@brixplugins/chatwidget/assetbundles/settings/dist/img/'.$this->getSettings()->widgetType.'.svg',
                                true
                            );
                           
                        }

                    } else {     

                        $url_image_icon = \Craft::$app->assetManager->getPublishedUrl(
                            '@brixplugins/chatwidget/assetbundles/settings/dist/img/'.$this->getSettings()->widgetType.'.svg',
                            true
                        );
                    }
                    

                    echo '
                    <div id="bp-chat-widget" class="brix-plugins__chat-widget" data-delay="'.$this->getSettings()->delayPlugin.'" data-inactive="'.$plugin_state.'"> 

                        <div id="bp-chat-widget-message" class="brix-plugins__chat-widget_message">                    
                            <h5>'.$this->getSettings()->txtMainHading.'</h5>
                            <p>'.$this->getSettings()->txtMessage.'</p>
                        </div>

                        <div id="bp-chat-widget-agent" class="brix-plugins__chat-widget_agent">                    
                            <img src="'.$url_image_agent.'" alt="Chat Widget Agent">
                        </div>
                        <a href="'.$this->getSettings()->txtButtonLink.'" target="_blank" id="bp-chat-widget-button" class="brix-plugins__chat-widget_button brix-plugins__chat-widget_button-'.$this->getSettings()->widgetType.'">
                        '.$this->getSettings()->txtButton.'
                        </a>
                        <div id="bp-chat-widget-icon" class="brix-plugins__chat-widget_icon" data-click-state="0" >
                            <img src="'.$url_image_icon.'" alt="Chat Widget Icon">
                        </div>
                    </div>
                    ';
                }
            );

        }


        Craft::info(
            Craft::t(
                'chat-widget',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */

    public function getSettingsResponse()
    {
        return \Craft::$app
            ->controller
            ->renderTemplate('chat-widget/settings',
            [
                'settings' => $this->getSettings(),
                'fileAgentPhotoChatSelectConfig' => array(
                    'id'                 => 'fileAgentPhotoChat',
                    'name'               => 'settings[fileAgentPhotoChat]',
                    'jsClass'            => 'Craft.AssetSelectInput',
                    'elementType'        => 'craft\\elements\\Asset',
                    'elements'           => $this->getSettings()['fileAgentPhotoChat'] && count($this->getSettings()['fileAgentPhotoChat']) ? [Craft::$app->getElements()->getElementById($this->getSettings()['fileAgentPhotoChat'][0])] : null,
                    'criteria'           => array('kind' => array('image')),
                    'limit'              => 1,
                    'viewMode'           => 'table',
                    'selectionLabel'     => Craft::t('chat-widget','Choose a picture'),
                ),
                'fileCustomIconChatSelectConfig' => array(
                    'id'                 => 'fileChatIcon',
                    'name'               => 'settings[fileChatIcon]',
                    'jsClass'            => 'Craft.AssetSelectInput',
                    'elementType'        => 'craft\\elements\\Asset',
                    'elements'           => $this->getSettings()['fileChatIcon'] && count($this->getSettings()['fileChatIcon']) ? [Craft::$app->getElements()->getElementById($this->getSettings()['fileChatIcon'][0])] : null,
                    'criteria'           => array('kind' => array('image')),
                    'limit'              => 1,
                    'viewMode'           => 'table',
                    'selectionLabel'     => Craft::t('chat-widget','Choose an icon'),
               )
               
            ]
        );
    }
}
