pimcore.registerNS('pimcore.plugin.PlantUml');
pimcore.registerNS('PlantUml');
pimcore.registerNS('PlantUml.Config');

pimcore.plugin.PlantUml = Class.create(pimcore.plugin.admin, {

    config : {},

    getClassName: function () {
        return 'pimcore.plugin.PlantUml';
    },

    initialize: function() {
        pimcore.plugin.broker.registerPlugin(this);
    },

    uninstall: function() {

    },

    pimcoreReady: function (params,broker)
    {
        var user = pimcore.globalmanager.get('user');
        if (!user.admin) {
            return;
        }

        var menu = new Ext.Action({
            text: 'PLantUML',
            iconCls: 'pimcore_icon_plantuml',
            handler: this.openPlantUml.bind(this)
        });

        if (layoutToolbar.settingsMenu) {
            layoutToolbar.settingsMenu.add(menu);
        }
    },

    openPlantUml : function()
    {
        try {
            pimcore.globalmanager.get('plugin_plantuml').activate();
        }
        catch (e) {
            pimcore.globalmanager.add('plugin_plantuml', new PlantUml());
        }
    }

});

new pimcore.plugin.PlantUml();
