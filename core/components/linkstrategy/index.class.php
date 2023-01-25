<?php

require_once dirname(__FILE__) . '/model/linkstrategy/linkstrategy.class.php';
abstract class LinkStrategyBaseManagerController extends modExtraManagerController
{
    /** @var $linkstrategy */
    public $linkstrategy;

    public function initialize(): void
    {
        if ($this->modx->version['version'] > 3) {
            $this->linkstrategy = $this->modx->services->get('linkstrategy');
        } else {
            $corePath = $this->modx->getOption('linkstrategy.core_path', null, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/linkstrategy/');
            $this->linkstrategy = $this->modx->getService(
                'linkstrategy',
                'LinkStrategy',
                $corePath . 'model/linkstrategy/',
                array(
                    'core_path' => $corePath
                )
            );
        }
        $this->addCss($this->linkstrategy->getOption('cssUrl') . 'mgr.css');
        $this->addJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/linkstrategy.js');
        $this->linkstrategy->config['allowRegenerate'] = (bool) $this->linkstrategy->getOption('allow_regenerate_button');
        $this->linkstrategy->config['modx3'] = ($this->modx->version['version'] >= 3);

        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    linkstrategy.config = ' . $this->modx->toJSON($this->linkstrategy->config) . ';
                });
            </script>
        ');

        parent::initialize();
    }

    public function getLanguageTopics(): array
    {
        return array('linkstrategy:default');
    }

    public function checkPermissions(): bool
    {
        return true;
    }

    public function addLastJavascript($script)
    {
        $this->head['lastjs'][] = $script . '?v=1.1.0';
    }
}
