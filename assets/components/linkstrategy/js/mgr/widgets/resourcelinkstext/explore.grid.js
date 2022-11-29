linkstrategy.grid.ResourceLinksTextExplore = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        url: MODx.config.connector_url,
        baseParams: {
            action: "LinkStrategy\\Processors\\ResourceLinksText\\Explore",
            text: config.record.text,
        },
        autosave: false,
        preventSaveRefresh: true,
        fields: ["id", "link", "link_url", "resource", "resource_menutitle", "resource_pagetitle"],
        paging: true,
        remoteSort: true,
        emptyText: _("linkstrategy.global.no_records"),
        showActionsColumn: false,
        grouping: false,
        groupBy: "link_url",
        sortBy: "link_url",
        singleText: _("linkstrategy.global.resource"),
        pluralText: _("linkstrategy.global.resources"),
        columns: [
        {
            header: _("id"),
            dataIndex: "id",
            sortable: false,
            hidden: true,
        },
        {
            header: _("linkstrategy.resourcelinkstext.link"),
            dataIndex: "link",
            sortable: false,
            hidden: true,
        },
        {
            header: _("linkstrategy.global.url"),
            dataIndex: "link_url",
            sortable: true,
            width: 60,
        },
        {
            header: _("linkstrategy.global.resource"),
            dataIndex: "resource",
            sortable: true,
            width: 60,
            renderer: function (value, metaData, record) {
                if (value > 0) {
                    var linktitle = record.data.resource_menutitle ? record.data.resource_menutitle : record.data.resource_pagetitle;
                    return '<a href="' + MODx.config.manager_url
                        + '?a=resource/update&id=' + value + '">' + linktitle + '</a>';
                }
                return _("linkstrategy.global.not_applicable");
            }
        },
        ],
        tbar: this.getTbar(config),
    });
    linkstrategy.grid.ResourceLinksTextExplore.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.grid.ResourceLinksTextExplore, MODx.grid.Grid, {
    getTbar: function (config) {
        return [
        {
            text: _("linkstrategy.global.export"),
            handler: this.exportFilters,
        },
        "->", {
            xtype: "linkstrategy-combo-link",
            text: config.record.text,
            filterName: "link",
            listeners: {
                change: this.filterSearch,
                scope: this,
            }
        },
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
            text: this.config.record.text,
        };
        this.getBottomToolbar().changePage(1);
    },
});
Ext.reg("linkstrategy-grid-resourcelinkstext-explore", linkstrategy.grid.ResourceLinksTextExplore);
