linkstrategy.grid.Links = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        url: linkstrategy.config.modx3 ? MODx.config.connector_url : linkstrategy.config.connectorUrl,
        baseParams: {
            action: linkstrategy.config.modx3 ? "LinkStrategy\\Processors\\Links\\GetList" : "mgr/links/getlist",
            sort: "resourcelinks_count",
            resource: config.resource || null,
        },
        autosave: false,
        preventSaveRefresh: true,
        fields: ["id", "context_key", "internal", "url", "uri", "resource", "resource_menutitle", "resource_pagetitle", "resourcelinks_count", "textvariants_count"],
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
            header: _("linkstrategy.links.context_key"),
            dataIndex: "context_key",
            sortable: true,
            width: 40,
            renderer: function (value) {
                return value !== '' ? value : _("linkstrategy.global.not_applicable");
            }
        },
        {
            header: _("linkstrategy.links.internal"),
            dataIndex: "internal",
            sortable: true,
            width: 40,
            renderer: this.rendYesNo,
        },
        {
            header: _("linkstrategy.global.url"),
            dataIndex: "url",
            sortable: true,
            width: 80,
        },
        {
            header: _("linkstrategy.links.uri"),
            dataIndex: "uri",
            sortable: true,
            hidden: true,
            width: 40,
        },
        {
            header: _("linkstrategy.global.resource"),
            dataIndex: "resource",
            sortable: true,
            width: 40,
            renderer: function (value, metaData, record) {
                if (value > 0) {
                    var linktitle = record.data.resource_menutitle ? record.data.resource_menutitle : record.data.resource_pagetitle;
                    return '<a href="' + MODx.config.manager_url
                        + '?a=resource/update&id=' + value + '">' + linktitle + '</a>';
                }
                return _("linkstrategy.global.not_applicable");
            }
        },
        {
            header: _("linkstrategy.global.linkedon"),
            dataIndex: "resourcelinks_count",
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
            header: _("linkstrategy.links.variants"),
            dataIndex: "textvariants_count",
            sortable: true,
            width: 40,
            renderer: function (value) {
                if (value > 1) {
                    return value + " " + _("linkstrategy.links.variants");
                } else if (value === 1) {
                    return value + " " + _("linkstrategy.links.variant");
                } else {
                    return _("linkstrategy.global.not_applicable");
                }
            }
        },
        ],
        tbar: this.getTbar(config),
    });
    linkstrategy.grid.Links.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.grid.Links, MODx.grid.Grid, {
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
            handler: this.exploreLink,
        });
        return m;
    },
    exploreLink: function (btn, e) {
        var record = this.menu.record;
        var win = MODx.load({
            xtype: "linkstrategy-window-links-explore",
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
            resource: this.config.resource || null,
        };
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg("linkstrategy-grid-links", linkstrategy.grid.Links);
