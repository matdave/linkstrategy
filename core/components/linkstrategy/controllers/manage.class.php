<?php
require_once dirname(dirname(__FILE__)) . '/index.class.php';

class LinkStrategyManageManagerController extends LinkStrategyBaseManagerController
{

    public function process(array $scriptProperties = []): void
    {
    }

    public function getPageTitle(): string
    {
        return $this->modx->lexicon('linkstrategy');
    }

    public function loadCustomCssJs(): void
    {
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/utils/combos.js');
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/widgets/resourcelinkstext/explore.grid.js');
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/widgets/resourcelinkstext/explore.window.js');
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/widgets/resourcelinkstext.grid.js');
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/widgets/links/explore.grid.js');
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/widgets/links/explore.window.js');
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/widgets/links.grid.js');
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/widgets/orphans.grid.js');
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/widgets/manage.panel.js');
        $this->addLastJavascript($this->linkstrategy->getOption('jsUrl') . 'mgr/sections/manage.js');

        $this->addHtml(
            '
            <script type="text/javascript">
                Ext.onReady(function() {
                    MODx.load({ xtype: "linkstrategy-page-manage"});
                });
            </script>
        '
        );
    }

    public function getTemplateFile(): string
    {
        return $this->linkstrategy->getOption('templatesPath') . 'manage.tpl';
    }

}
