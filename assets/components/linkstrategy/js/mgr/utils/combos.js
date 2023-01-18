linkstrategy.combo.Text = function (config) {
    config = config || {};

    var baseParams = Ext.applyIf(config.baseParams || {}, {
        action: linkstrategy.config.modx3 ? "LinkStrategy\\Processors\\Utils\\Text" : "mgr/utils/text",
        link: config.link || 0,
    });

    Ext.applyIf(config, {
        name: "text",
        hiddenName: "text",
        displayField: "text",
        editable: true,
        valueField: "text",
        fields: ["text"],
        emptyText: _("linkstrategy.links.variants"),
        pageSize: 20,
        url: linkstrategy.config.modx3 ? MODx.config.connector_url : linkstrategy.config.connectorUrl,
        baseParams: baseParams,
    });
    linkstrategy.combo.Text.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.combo.Text, MODx.combo.ComboBox);
Ext.reg("linkstrategy-combo-text", linkstrategy.combo.Text);

linkstrategy.combo.Link = function (config) {
    config = config || {};

    var baseParams = Ext.applyIf(config.baseParams || {}, {
        action: linkstrategy.config.modx3 ? "LinkStrategy\\Processors\\Utils\\Links" : "mgr/utils/links",
        text: config.text || "",
    });

    Ext.applyIf(config, {
        name: "link",
        hiddenName: "link",
        displayField: "link_url",
        editable: true,
        valueField: "link_id",
        fields: ["link_id","link_url"],
        emptyText: _("linkstrategy.resourcelinkstext.variants"),
        pageSize: 20,
        url: linkstrategy.config.modx3 ? MODx.config.connector_url : linkstrategy.config.connectorUrl,
        baseParams: baseParams,
    });
    linkstrategy.combo.Link.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.combo.Link, MODx.combo.ComboBox);
Ext.reg("linkstrategy-combo-link", linkstrategy.combo.Link);
