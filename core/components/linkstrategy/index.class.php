<?php
abstract class LinkStrategyBaseManagerController extends modExtraManagerController {
    /** @var \LinkStrategy\LinkStrategy $linkstrategy */
    public $linkstrategy;

    public function initialize(): void
    {
        $this->linkstrategy = $this->modx->services->get('linkstrategy');

        $this->addCss($this->linkstrategy->getOption('cssUrl') . 'mgr.css');
        $this->addJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/linkstrategy.js');

        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    linkstrategy.config = '.$this->modx->toJSON($this->linkstrategy->config).';
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
}
