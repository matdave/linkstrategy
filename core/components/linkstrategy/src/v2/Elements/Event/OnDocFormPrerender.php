<?php

namespace LinkStrategy\v2\Elements\Event;

class OnDocFormPrerender extends Event
{

    public function run()
    {
        $mode = $this->getOption('mode');
        $resource =  $this->getOption('resource');
        if (($mode === \modSystemEvent::MODE_NEW) || !$resource) {
            return;
        }
        $this->modx->controller->addLexiconTopic('linkstrategy:default');
        $this->modx->regClientCSS($this->ls->config['cssUrl'] . 'mgr.css');
        $this->modx->regClientStartupScript($this->ls->config['jsUrl'] . 'mgr/linkstrategy.js');
        $this->modx->regClientStartupScript($this->ls->config['jsUrl'] . 'mgr/utils/combos.js');
        $this->modx->regClientStartupScript($this->ls->config['jsUrl'] . 'mgr/widgets/links/explore.grid.js');
        $this->modx->regClientStartupScript($this->ls->config['jsUrl'] . 'mgr/widgets/links/explore.window.js');
        $this->modx->regClientStartupScript($this->ls->config['jsUrl'] . 'mgr/widgets/links.grid.js');

        $corePath = $this->modx->getOption('linkstrategy.core_path', null, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/linkstrategy/');
        $linkstrategy = $this->modx->getService(
            'linkstrategy',
            'LinkStrategy',
            $corePath . 'model/linkstrategy/',
            array(
                'core_path' => $corePath
            )
        );
        $linkstrategy->config['modx3'] = ($this->modx->version['version'] > 3);

        $this->modx->regClientStartupHTMLBlock('
            <script type="text/javascript">
                Ext.onReady(function() {
                    linkstrategy.config = '.$this->modx->toJSON($linkstrategy->config).';
                });
            </script>
        ');

        $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
            Ext.onReady(function() {
                var tab = Ext.getCmp("modx-resource-tabs");
                if (tab) {
                    tab.add({
                        title: _("linkstrategy"),
                        cls: "modx-resource-tab",
                        layout: "form",
                        labelAlign: "top",
                        labelSeparator: "",
                        bodyCssClass: "tab-panel-wrapper main-wrapper",
                        autoHeight: true,
                        defaults: {
                            border: false,
                            msgTarget: "under",
                        },
                        items: [{
                            html: "<p>" + _("linkstrategy.resource.links_desc") + "</p>",
                            cls: "panel-desc ls-panel-desc",
                        }, {
                            xtype: "linkstrategy-grid-links",
                            resource: ' . $resource->get('id') . ',
                            preventRender: true
                        }]
                    })
                }
            });
        </script>');
    }
}
