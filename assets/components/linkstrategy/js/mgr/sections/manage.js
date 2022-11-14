linkstrategy.page.Manage = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [
            {
                xtype: 'linkstrategy-panel-manage',
                renderTo: 'linkstrategy-panel-manage-div'
            }
        ]
    });
    linkstrategy.page.Manage.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.page.Manage, MODx.Component);
Ext.reg('linkstrategy-page-manage', linkstrategy.page.Manage);
