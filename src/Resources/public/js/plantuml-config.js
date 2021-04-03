PlantUml.Config = Class.create({

    initialize: function(panelId, name) {
        this.panelId = panelId;
        this.name = name;

        this.initStores();
        this.buildPanels();
        this.loadConfig();
    },

    initStores: function() {
        this.classTreeStore = Ext.create('Ext.data.TreeStore', {
            fields: [
                'id',
                'text',
                {
                    name: 'seed',
                    type: 'boolean',
                    convert: function(v,rec) {
                        return !rec.get('seedable') ? null : v;
                    }
                },
                'mode',
                'seedable'
            ],
            proxy: {
                type: 'memory'
            }
        });
        this.templateStore = Ext.create('Ext.data.Store', {
            fields: ['name', 'value'],
            proxy: {
                type: 'ajax',
                url: 'plantuml/templates_list',
                reader: {
                    type: 'json',
                    rootProperty: 'templates'
                }
            },
            autoLoad: true
        });
        this.fieldModeStore = Ext.create('Ext.data.Store', {
            fields: ['text', 'value'],
            data: [
                { text: 'Auto', value: 'auto' },
                { text: 'Display all', value: 'all' },
                { text: 'Display none', value: 'none' },
            ]
        });
        var data = [
            { text: 'No translation', value: 'none' }
        ]
        for (var i = 0; i < pimcore.settings.websiteLanguages.length; i++) {
            data.push({ text: pimcore.available_languages[pimcore.settings.websiteLanguages[i]], value: pimcore.settings.websiteLanguages[i] });
        }
        this.translationStore = Ext.create('Ext.data.Store', {
            fields: ['text', 'value'],
            data: data
        });
    },

    loadConfig: function() {
        Ext.Ajax.request({
            url: 'plantuml/config_get?name=' + this.name,
            success: function(response) {
                var resp = Ext.decode(response.responseText);
                if (!resp || !resp.success) {
                    Ext.Msg.alert('Error', resp.message ? resp.message : 'Failed to load configuration');
                } else {
                    this.classTreeStore.setRootNode({
                        expanded: true,
                        children: resp.classTree
                    });
                    this.formPanel.getForm().setValues(resp.settings);
                }
            }.bind(this),
        });
    },

    buildPanels: function() {

        var classMode = Ext.create('Ext.form.ComboBox', {
            store: Ext.create('Ext.data.Store', {
                fields: ['text', 'value'],
                data: [
                    { text:'auto', value: 'auto' },
                    { text:'skip', value: 'skip' },
                    { text:'force', value: 'force' },
                ]
            }),
            forceSelection: true,
            editable: false,
            queryMode: 'local',
            displayField: 'text',
            valueField: 'value',
        });

        this.classFieldPanel = Ext.create('Ext.tree.Panel', {
            title: 'Scope',
            region: 'west',
            store: this.classTreeStore,
            rootVisible: false,
            disableSelection: true,
            autoScroll: true,
            containerScroll: true,
            animate: true,
            split: true,
            width: '50%',
            padding: "0 5",
            plugins : [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 1
                })
            ],
            viewConfig: {
                markDirty: false
            },
            columns: [
                {
                    xtype: 'treecolumn',
                    text: 'Name',
                    dataIndex: 'text',
                    flex: 1,
                    menuDisabled: true,
                    sortable: false
                },
                {
                    xtype: 'checkcolumn',
                    text: 'Seed',
                    width: 60,
                    dataIndex: 'seed',
                    menuDisabled: true,
                    sortable: false,
                    renderer: function (value, meta, record) {
                        if (record.get('seedable')) {
                            return new Ext.ux.CheckColumn().renderer(value);
                        }
                    }
                },
                {
                    text: 'Mode',
                    width: 90,
                    dataIndex: 'mode',
                    menuDisabled: true,
                    sortable: false,
                    editor: classMode,
                    renderer: function (value, meta, record) {
                        return value === 'auto' ? '<span style="color:#c0c0c0;">auto</span>' : value;
                    }
                },
            ]
        });
        this.formPanel = Ext.create('Ext.form.Panel', {
            title: 'Settings',
            padding: "0 5",
            bodyPadding: 10,
            region: 'center',
            autoScroll: true,
            containerScroll: true,
            items: [
                {
                    xtype: 'textfield',
                    fieldLabel: 'Title',
                    labelWidth: 100,
                    name: 'title',
                    allowBlank: false,
                    width: '100%'
                },
                {
                    xtype: 'combo',
                    fieldLabel: 'Template',
                    labelWidth: 100,
                    name: 'template',
                    store: this.templateStore,
                    displayField: 'name',
                    valueField: 'value',
                    allowBlank: false,
                    forceSelection: true,
                    editable: false,
                    width: '100%'
                },
                {
                    xtype: 'textfield',
                    fieldLabel: 'Output path' + ' <span class="pimcore_object_label_icon pimcore_icon_gray_info"></span>',
                    autoEl: {
                        tag: 'div',
                        'data-qtip': '<i>Absolute or relative (without leading slash) path where to save generated puml. '
                            + 'Leave empty for frontend output only.</i>'
                    },
                    name: 'outputPath',
                    width: '100%',
                },
                {
                    xtype: 'combo',
                    fieldLabel: 'Field mode' + ' <span class="pimcore_object_label_icon pimcore_icon_gray_info"></span>',
                    labelWidth: 100,
                    name: 'fieldMode',
                    store: this.fieldModeStore,
                    displayField: 'text',
                    valueField: 'value',
                    allowBlank: false,
                    forceSelection: true,
                    editable: false,
                    width: '100%',
                    autoEl: {
                        tag: 'div',
                        'data-qtip': '<i>Relation fields won\'t be listed as class properties if the relation is visualized by an association (Auto mode). '
                            + 'You can choose to always list relation fields or list no fields at all.</i>'
                    },
                },
                {
                    xtype: 'combo',
                    fieldLabel: 'Translation' + ' <span class="pimcore_object_label_icon pimcore_icon_gray_info"></span>',
                    labelWidth: 100,
                    name: 'translation',
                    store: this.translationStore,
                    displayField: 'text',
                    valueField: 'value',
                    allowBlank: false,
                    forceSelection: true,
                    editable: false,
                    width: '100%',
                    autoEl: {
                        tag: 'div',
                        'data-qtip': '<i>Translate class names and field labels via admin translations.</i>'
                    },
                },
                {
                    xtype: 'checkboxfield',
                    fieldLabel: 'Hidden fields',
                    boxLabel: 'Do not list hidden fields as class attribute',
                    name: 'ignoreHiddenFields',
                    inputValue: true,
                },
            ],
        });

        this.previewPanel = Ext.create('Ext.Panel', {
            title: 'Generated PUML',
            bodyPadding: 5,
            height: 200,
            region: 'south',
            collapsible: true,
            autoScroll: true,
            style: 'border-top: 1px solid #d0d0d0;',
            items: [
                {
                    xtype: 'textareafield',
                    width: '100%',
                    height: '100%',
                    readOnly: true,
                    id: this.panelId + '_preview',
                    border: false,
                    value: 'Hint: Select one or more classes from the "Object" namespace as seed. '
                        + 'These seeds along with all related classes become part of your class diagram.'
                }
            ],
        });

        this.panel = new Ext.Panel({
            itemId: this.panelId,
            title: this.name,
            layout: 'border',
            closable: true,
            items: [this.classFieldPanel, this.formPanel, this.previewPanel],
            fbar: [
                {
                    type: 'button',
                    text: 'Copy to Clipboard',
                    iconCls: 'pimcore_icon_text',
                    handler: function() {
                        try {
                            var el = Ext.getCmp(this.panelId + '_preview')
                                .getEl().dom.getElementsByTagName('textarea')[0];
                            el.select();
                            var puml = el.value;
                            el = document.createElement('textarea');
                            el.value = puml;
                            document.body.appendChild(el);
                            el.select();
                            document.execCommand('copy');
                            document.body.removeChild(el);
                        } catch (e) {
                            // sorry...
                        }
                    }.bind(this)
                },
                {
                    xtype: 'tbfill'
                },
                {
                    type: 'button',
                    text: 'Delete',
                    iconCls: 'pimcore_icon_delete',
                    handler: function() {
                        this.delete();
                    }.bind(this)
                },
                {
                    type: 'button',
                    text: 'Save',
                    iconCls: 'pimcore_icon_save',
                    handler: function() {
                        this.save().then(function() {
                            pimcore.helpers.showNotification('Success', 'Configuration saved', 'success');
                        }).catch(function() {
                            // nothing to do here
                        });
                    }.bind(this)
                },
                {
                    type: 'button',
                    text: 'Save and Generate',
                    iconCls: 'pimcore_icon_save',
                    handler: function() {
                        this.save()
                        .then(function() {
                            this.generate();
                        }.bind(this))
                        .catch(function() {
                            // nothing to do here
                        });
                    }.bind(this)
                }
            ]
        });
    },

    getPanel: function() {
        return this.panel;
    },

    save: function() {
        return new Promise(function(resolve, reject) {
            var form = this.formPanel.getForm();
            if (!form.isValid()) {
                reject();
            }
            var data = form.getValues();
            var classSeed = {};
            var classMode = {};
            this.classTreeStore.getRootNode().cascadeBy(function (node) {
                if (!node.isRoot()) {
                    classSeed[node.get('id')] = node.get('seed');
                    classMode[node.get('id')] = node.get('mode');
                }
            });
            data.classSeed = classSeed;
            data.classMode = classMode;

            Ext.Ajax.request({
                url: 'plantuml/config_save?name=' + this.name,
                method: 'POST',
                jsonData: data,
                headers: { 'Content-Type' : 'application/json' },
                success: function(response) {
                    var resp = Ext.decode(response.responseText);
                    if (resp && resp.success) {
                        resolve();
                    } else {
                        Ext.Msg.alert('Error', resp.message ? resp.message : 'Failed to save configuration');
                        reject();
                    }
                }.bind(this),
            });
        }.bind(this));
    },

    generate: function() {
        Ext.Ajax.request({
            url: 'plantuml/generate?name=' + this.name,
            success: function(response) {
                var resp = Ext.decode(response.responseText);
                if (resp && resp.success) {
                    pimcore.helpers.showNotification('Success', 'PUML Generated', 'success');
                    Ext.getCmp(this.panelId + '_preview').setValue(resp.puml);
                } else {
                    Ext.Msg.alert('Error', resp.message ? resp.message : 'Generation failed');
                }
            }.bind(this),
        });
    },

    delete: function() {
        var form = Ext.create('Ext.form.Panel', {
            bodyPadding: 10,
            url: 'plantuml/config_delete',
            items: [
                {
                    xtype: 'hidden',
                    name: 'name',
                    value: this.name
                },
                {
                    html: 'Do you really want to delete the configuration "' + this.name + '"?'
                }
            ],
        });

        var dialog = Ext.create("Ext.Window",{
            title: 'Delete Configuration',
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
                    }.bind(this)
                },
                {
                    type: 'button',
                    text: 'Delete',
                    iconCls: 'pimcore_icon_delete',
                    handler: function() {
                        form.submit({
                            success: function(form, action) {
                                var tabPanel = Ext.getCmp('plugin_plantuml_editpanel');
                                tabPanel.remove(this.panel);
                                pimcore.globalmanager.get('plugin_plantuml').reloadConfigs();
                                dialog.close();
                            }.bind(this),
                            failure: function(form, action) {
                                dialog.close();
                                Ext.Msg.alert('Error', action.result.message
                                    ? action.result.message
                                    : 'Failed to delete configuration'
                                );
                            }
                        });
                    }.bind(this)
                },
            ]
        }).show();
    },

});
