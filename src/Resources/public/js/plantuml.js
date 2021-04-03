PlantUml = Class.create(function() {

    var tabPanel;
    var panel;
    var listPanel;
    var editPanel;
    var configStore;

    var self = {

        initialize: function () {
            self.initStores();
            self.createPanel();
        },

        reloadConfigs: function() {
            configStore.reload();
        },

        initStores: function () {
            if (configStore) {
                configStore.reload();
            } else {
                configStore = Ext.create('Ext.data.Store', {
                    fields: {
                        'name': 'string'
                    },
                    proxy: {
                        type: 'ajax',
                        url: 'plantuml/config_list',
                        reader: {
                            type: 'json',
                            root: 'config'
                        }
                    },
                    autoLoad: true,
                });
            }
        },

        createPanel: function () {
            editPanel = new Ext.TabPanel({
                id: 'plugin_plantuml_editpanel',
                activeTab: 0,
                items: [],
                region: 'center',
            });

            listPanel = Ext.create('Ext.grid.Panel', {
                title: 'Configurations',
                region: 'west',
                split: true,
                width: 200,
                store: configStore,
                columns: [
                    {
                        dataIndex: 'name',
                        text: 'Name',
                        flex: 1
                    }
                ],
                listeners: {
                    'rowclick': function (grid, record) {
                        self.openSchemaConfig(record.data);
                    }
                },
                tbar: [
                    {
                        type: 'button',
                        text: 'Create',
                        iconCls: 'pimcore_icon_add',
                        handler: self.createConfig
                    }
                ]
            });

            panel = new Ext.Panel({
                id: 'plugin_plantuml_panel',
                iconCls: 'pimcore_icon_plantuml',
                title: 'PLantUML',
                border: false,
                layout: 'border',
                closable: true,
                items: [listPanel, editPanel]
            });

            tabPanel = Ext.getCmp('pimcore_panel_tabs');
            tabPanel.add(panel);
            tabPanel.setActiveItem('plugin_plantuml_panel');

            tabPanel.on('destroy', function () {
                pimcore.globalmanager.remove('plugin_plantuml_panel');
            });
            panel.on('destroy', function () {
                tabPanel = panel = listPanel = editPanel = null;
            });

            pimcore.layout.refresh();
        },

        activate: function () {
            if (panel) {
                Ext.getCmp('pimcore_panel_tabs').setActiveItem('plugin_plantuml_panel');
            } else {
                self.initialize();
            }
        },

        openSchemaConfig: function (data) {
            var panelId = 'plugin_plantuml_panel_config_' + data.name;
            var configPanel = editPanel.getComponent(panelId);
            if (configPanel) {
                editPanel.getComponent(panelId).show();
            } else {
                var config = new PlantUml.Config(panelId, data.name);
                configPanel = config.getPanel();
                editPanel.add(configPanel);
            }
            configPanel.show();
        },

        getGlobalSettingsPanel: function () {
            return new Ext.Panel({
                title: 'PlantUML',
                border: false,
                layout: 'fit',
                closable: false,
                fbar: {
                    items: [
                        {
                            text: ''
                        }
                    ]
                },
                items: []
            });
        },

        createConfig: function () {
            var form = Ext.create('Ext.form.Panel', {
                bodyPadding: 10,
                url: 'plantuml/config_create',
                items: [
                    {
                        xtype: 'textfield',
                        name: 'name',
                        fieldLabel: 'Name',
                        allowBlank: false,
                        maskRe: /[0-9a-zA-Z_\-]/
                    }
                ],
            });

            var dialog = Ext.create("Ext.Window",{
                title: 'Create Configuration',
                width: 300,
                height: 150,
                closable: false,
                items: [ form ],
                fbar: [
                    {
                        type: 'button',
                        text: 'Cancel',
                        iconCls: 'pimcore_icon_cancel',
                        handler: function() {
                            dialog.close();
                        }
                    },
                    {
                        type: 'button',
                        text: 'Save',
                        iconCls: 'pimcore_icon_save',
                        handler: function() {
                            if (form.isValid()) {
                                form.submit({
                                    success: function (form, action) {
                                        configStore.reload();
                                        dialog.close();
                                    },
                                    failure: function (form, action) {
                                        Ext.Msg.alert('Error', action.result.message
                                            ? action.result.message
                                            : 'Failed to create configuration'
                                        );
                                    }
                                });
                            }
                        }
                    },
                ]
            }).show();
        },
    }

    return {
        initialize: self.initialize,
        activate: self.activate,
        reloadConfigs: self.reloadConfigs
    }

}());