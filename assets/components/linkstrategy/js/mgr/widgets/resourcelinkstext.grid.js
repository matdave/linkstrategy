linkstrategy.grid.ResourceLinksText = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        url: linkstrategy.config.modx3 ? MODx.config.connector_url : linkstrategy.config.connectorUrl,
        baseParams: {
            action: linkstrategy.config.modx3 ? "LinkStrategy\\Processors\\ResourceLinksText\\GetList" : "mgr/resourcelinkstext/getlist",
            sort: "text",
        },
        autosave: false,
        preventSaveRefresh: true,
        fields: ["id", "link_count", "resource_count", "text"],
        paging: true,
        remoteSort: true,
        emptyText: _("linkstrategy.global.no_records"),
        columns: [
        {
            header: _("id"),
            dataIndex: "id",
            sortable: true,
            hidden: true,
        },
        {
            header: _("linkstrategy.resourcelinkstext.link"),
            dataIndex: "link",
            sortable: true,
            hidden: true,
            width: 40,
        },
        {
            header: _("linkstrategy.resourcelinkstext.text"),
            dataIndex: "text",
            sortable: true,
            width: 80,
        },
        {
            header: _("linkstrategy.global.linkedon"),
            dataIndex: "resource_count",
            sortable: true,
            width: 40,
            renderer: function (value) {
                if (value > 1) {
                    return value + " " + _("linkstrategy.global.resources");
                } else if (value === 1) {
                    return value + " " + _("linkstrategy.global.resource");
                } else {
                    return _("linkstrategy.global.not_applicable");
                }
            }
        },
        {
            header: _("linkstrategy.resourcelinkstext.variants"),
            dataIndex: "link_count",
            sortable: true,
            width: 40,
            renderer: function (value) {
                if (value > 1) {
                    return value + " " + _("linkstrategy.resourcelinkstext.variants");
                } else if (value === 1) {
                    return value + " " + _("linkstrategy.resourcelinkstext.variant");
                } else {
                    return _("linkstrategy.global.not_applicable");
                }
            }
        },
        ],
        tbar: this.getTbar(config),
    });
    linkstrategy.grid.ResourceLinksText.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.grid.ResourceLinksText, MODx.grid.Grid, {
    getTbar: function (config) {
        return [
        {
            text: _("linkstrategy.global.export"),
            handler: this.exportFilters,
        },
        "->",
        {
            xtype: "textfield",
            blankText: _("linkstrategy.global.search"),
            filterName: "query",
            listeners: {
                change: this.filterSearch,
                scope: this,
                render: {
                    fn: function (cmp) {
                        new Ext.KeyMap(cmp.getEl(), {
                            key: Ext.EventObject.ENTER,
                            fn: this.blur,
                            scope: cmp,
                        });
                    },
                    scope: this,
                },
            },
        },
        {
            xtype: "button",
            text: _("linkstrategy.global.clear"),
            handler: this.clearFilters,
            scope: this,
        },
        ];
    },

    getMenu: function () {
        var m = [];
        m.push({
            text: _("linkstrategy.global.explore"),
            handler: this.exploreText,
        });
        return m;
    },
    exploreText: function (btn, e) {
        var record = this.menu.record;
        var win = MODx.load({
            xtype: "linkstrategy-window-resourcelinkstext-explore",
            record: record,
        });
        win.show(e.target);
    },

    exportFilters: function (comp, search) {
        var s = this.getStore();
        var filters = "export=true&HTTP_MODAUTH=" + MODx.siteId;
        Object.keys(s.baseParams).forEach((key) => {
            filters += "&" + key + "=" + s.baseParams[key];
        });
        window.location = this.config.url + "?" + filters;
    },

    filterSearch: function (comp, search) {
        var s = this.getStore();
        s.baseParams[comp.filterName] = search;
        this.getBottomToolbar().changePage(1);
    },

    clearFilters: function (btn, e) {
        this.getTopToolbar().items.items.forEach(function (item) {
            if (item.filterName) {
                item.reset();
            }
        });
        var s = this.getStore();
        s.baseParams = {
            action: s.baseParams.action,
        };
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg("linkstrategy-grid-resourcelinkstext", linkstrategy.grid.ResourceLinksText);
