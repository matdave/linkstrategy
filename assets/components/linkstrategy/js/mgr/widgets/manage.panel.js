linkstrategy.panel.Manage = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: "linkstrategy-panel-manage",
        border: false,
        cls: "container form-with-labels",
        url: linkstrategy.config.modx3 ? MODx.config.connector_url : linkstrategy.config.connectorUrl,
        bypassValidCheck: true,
        saveMsg: _("linkstrategy.generate.ing"),
        baseParams: {
            action: linkstrategy.config.modx3 ? "LinkStrategy\\v3\\Processors\\Utils\\Generate" : "mgr/utils/generate",
        },
        useLoadingMask: true,
        items: [
            {
                html: '<h2>' + _('linkstrategy.manage.page_title') + '</h2>',
                border: false,
                xtype: "modx-header",
        },
            {
                xtype: 'modx-tabs',
                defaults: {
                    border: false,
                    autoHeight: true
                },
                border: true,
                activeItem: 0,
                collapsible: false,
                animCollapse: false,
                itemId: "tabs",
                items: [
                {
                    title: _('linkstrategy.manage.links'),
                    layout: 'form',
                    items: [
                    {
                        html: '<p>' + _('linkstrategy.manage.links_desc') + '</p>',
                        border: false,
                        cls: 'panel-desc'
                    },
                    {
                        cls: 'main-wrapper',
                        xtype: 'linkstrategy-grid-links',
                    }
                    ]
                },
                {
                    title: _('linkstrategy.manage.resourcelinkstext'),
                    layout: 'form',
                    items: [
                    {
                        html: '<p>' + _('linkstrategy.manage.resourcelinkstext_desc') + '</p>',
                        border: false,
                        cls: 'panel-desc'
                    },
                    {
                        cls: 'main-wrapper',
                        xtype: 'linkstrategy-grid-resourcelinkstext',
                    }
                    ]
                },
                {
                    title: _('linkstrategy.manage.orphans'),
                    layout: 'form',
                    items: [
                    {
                        html: '<p>' + _('linkstrategy.manage.orphans_desc') + '</p>',
                        border: false,
                        cls: 'panel-desc'
                    },
                    {
                        cls: 'main-wrapper',
                        xtype: 'linkstrategy-grid-orphans',
                    }
                    ]
                }
                ]
        }
        ],
    });
    linkstrategy.panel.Manage.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.panel.Manage, MODx.FormPanel);
Ext.reg('linkstrategy-panel-manage', linkstrategy.panel.Manage, {
});
