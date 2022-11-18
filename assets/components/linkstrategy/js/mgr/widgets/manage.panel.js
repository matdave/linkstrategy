linkstrategy.panel.Manage = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        baseCls: 'modx-formpanel',
        cls: 'container',
        items: [
            {
                html: '<h2>' + _('linkstrategy.manage.page_title') + '</h2>',
                border: false,
                cls: 'modx-page-header'
        },
            {
                xtype: 'modx-tabs',
                defaults: {
                    border: false,
                    autoHeight: true
                },
                border: true,
                activeItem: 0,
                hideMode: 'offsets',
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
                }
                ]
        }
        ]
    });
    linkstrategy.panel.Manage.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.panel.Manage, MODx.Panel);
Ext.reg('linkstrategy-panel-manage', linkstrategy.panel.Manage);
