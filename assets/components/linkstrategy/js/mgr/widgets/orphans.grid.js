linkstrategy.grid.Orphans = function (config) {
  config = config || {};

  Ext.applyIf(config, {
    url: linkstrategy.config.modx3
      ? MODx.config.connector_url
      : linkstrategy.config.connectorUrl,
    baseParams: {
      action: linkstrategy.config.modx3
        ? "LinkStrategy\\Processors\\Orphans\\GetList"
        : "mgr/orphans/getlist",
      sort: "id",
      deleted: 0,
      context: MODx.config.default_context
    },
    autosave: false,
    preventSaveRefresh: true,
    fields: [
      "id",
      "context_key",
      "menutitle",
      "pagetitle",
      "published",
      "deleted",
    ],
    paging: true,
    remoteSort: true,
    showActionsColumn: false,
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
          return value !== "" ? value : _("linkstrategy.global.not_applicable");
        },
      },
      {
        header: _("linkstrategy.global.resource"),
        dataIndex: "pagetitle",
        sortable: true,
        width: 40,
        renderer: function (value, metaData, record) {
          var linktitle = record.data.menutitle
            ? record.data.menutitle
            : record.data.pagetitle;
          return (
            '<a href="' +
            MODx.config.manager_url +
            "?a=resource/update&id=" +
            record.data.id +
            '">' +
            linktitle +
            "</a>"
          );
        },
      },
      {
        header: _("linkstrategy.orphans.published"),
        dataIndex: "published",
        sortable: true,
        width: 40,
        renderer: this.rendYesNo,
      },
      {
        header: _("linkstrategy.orphans.deleted"),
        dataIndex: "deleted",
        sortable: true,
        width: 40,
        renderer: this.rendYesNo,
      },
    ],
    tbar: this.getTbar(config),
  });
  linkstrategy.grid.Orphans.superclass.constructor.call(this, config);
};
Ext.extend(linkstrategy.grid.Orphans, MODx.grid.Grid, {
  getTbar: function (config) {
    return [
      {
        text: _("linkstrategy.global.export"),
        handler: this.exportFilters,
      },
      "->",
      {
        xtype: "checkbox",
        boxLabel: _("linkstrategy.orphans.hide_unpublished"),
        filterName: "published",
        listeners: {
          change: function (comp, checked) {
            var s = this.getStore();
            s.baseParams[comp.filterName] = checked ? 1 : null;
            this.getBottomToolbar().changePage(1);
          },
          scope: this,
        },
      },
      {
        xtype: "checkbox",
        boxLabel: _("linkstrategy.orphans.hide_deleted"),
        filterName: "deleted",
        checked: true,
        listeners: {
          change: function (comp, checked) {
            var s = this.getStore();
            s.baseParams[comp.filterName] = checked ? 0 : null;
            this.getBottomToolbar().changePage(1);
          },
          scope: this,
        },
      },
      {
        xtype: "linkstrategy-combo-context",
        filterName: "context",
        listeners: {
          select: this.filterSearch,
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

  getMenu: function () {
    var m = [];
    return m;
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
    if (this.isObject(search)) {
      search = search.data[comp.valueField];
    }
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
      deleted: 0,
      context: MODx.config.default_context
    };
    this.getBottomToolbar().changePage(1);
  },
  isObject: function(object) {
    return Object.prototype.toString.call(object) === '[object Object]'
  }
});
Ext.reg("linkstrategy-grid-orphans", linkstrategy.grid.Orphans);
