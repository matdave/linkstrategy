linkstrategy.window.LinksExplore = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        title: _("linkstrategy.links.explore", { url: config.record.url }),
        closeAction: "close",
        width: 800,
        autoHeight: true,
        fields: [
        {
            html: _("linkstrategy.links.explore_desc"),
        }, {
            xtype: "linkstrategy-grid-links-explore",
            record: config.record,
        }
        ]
    });
    linkstrategy.window.LinksExplore.superclass.constructor.call(this, config);
}
Ext.extend(linkstrategy.window.LinksExplore, MODx.Window, {

});
Ext.reg("linkstrategy-window-links-explore", linkstrategy.window.LinksExplore);
