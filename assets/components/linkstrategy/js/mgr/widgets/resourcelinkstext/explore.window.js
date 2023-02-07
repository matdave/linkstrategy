linkstrategy.window.ResourceLinksTextExplore = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        title: _("linkstrategy.resourcelinkstext.explore", { text: config.record.text }),
        closeAction: "close",
        width: 800,
        height: 600,
        autoHeight: false,
        fields: [
        {
            html: _("linkstrategy.resourcelinkstext.explore_desc"),
        }, {
            xtype: "linkstrategy-grid-resourcelinkstext-explore",
            record: config.record,
        }
        ]
    });
    linkstrategy.window.ResourceLinksTextExplore.superclass.constructor.call(this, config);
}
Ext.extend(linkstrategy.window.ResourceLinksTextExplore, MODx.Window, {

});
Ext.reg("linkstrategy-window-resourcelinkstext-explore", linkstrategy.window.ResourceLinksTextExplore);
