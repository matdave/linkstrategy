var LinkStrategy = function (config) {
    config = config || {};
    LinkStrategy.superclass.constructor.call(this, config);
};
Ext.extend(LinkStrategy, Ext.Component, {

    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    combo: {},
    field: {},
    config: {},

});
Ext.reg('linkstrategy', LinkStrategy);
linkstrategy = new LinkStrategy();
