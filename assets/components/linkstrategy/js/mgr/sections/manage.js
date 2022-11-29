linkstrategy.page.Manage = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        formpanel: "linkstrategy-panel-manage",
        buttons: this.getButtons(),
        components: [
        {
            xtype: "linkstrategy-panel-manage",
            renderTo: "linkstrategy-panel-manage-div"
        }
        ]
    });
    linkstrategy.page.Manage.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.page.Manage, MODx.Component, {
    getButtons: function () {
        var buttons = [];
        if (linkstrategy.config.allowRegenerate) {
            buttons.push({
                text: "<i class=\"icon icon-refresh\"></i> " + _("linkstrategy.generate"),
                cls: "secondary-button",
                method: "remote",
                process: "LinkStrategy\\Processors\\Utils\\Generate",
            });
        }
        return buttons;
    }
});
Ext.reg("linkstrategy-page-manage", linkstrategy.page.Manage);
