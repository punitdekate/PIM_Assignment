/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

document.addEventListener(pimcore.events.pimcoreReady, (e) => {
    const perspectiveCfg = pimcore.globalmanager.get("perspective");

    if (perspectiveCfg.inToolbar("datahub") === false) {
        return
    }

    const user = pimcore.globalmanager.get("user");
    if (user.admin || user.isAllowed("plugin_datahub_config")) {

        let navEl = Ext.get('pimcore_menu_search').insertSibling('<li id="pimcore_menu_datahub" data-menu-tooltip="'
            + t('plugin_pimcore_datahub_toolbar') +
            '" class="pimcore_menu_item pimcore_menu_needs_children"><img alt="datahub" src="/bundles/pimcoreadmin/img/flat-white-icons/mind_map.svg"></li>', 'before');

        navEl.on('mousedown', function () {
            try {
                pimcore.globalmanager.get("plugin_pimcore_datahub_config").activate();
            } catch (e) {
                pimcore.globalmanager.add("plugin_pimcore_datahub_config", new pimcore.plugin.datahub.config());
            }
        });

        pimcore.helpers.initMenuTooltips();
    }
});

document.addEventListener("pimcore.perspectiveEditor.permissions.structure.load", (e) => {
    if (e.detail.context === 'toolbar') {
        e.detail.structure['datahub'] = {};
    }
});

document.addEventListener("pimcore.perspectiveEditor.permissions.load", (e) => {
    const context = e.detail.context;
    const menu = e.detail.menu;
    const permissions = e.detail.permissions;

    if (context === 'toolbar' && menu === 'datahub') {
        if (permissions[context][menu] === undefined) {
            permissions[context][menu] = [];
        }
        if (permissions[context][menu].indexOf('hidden') === -1) {
            permissions[context][menu].push('hidden');
        }
    }
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.config");
pimcore.plugin.datahub.config = Class.create({

    initialize: function () {
        this.getTabPanel();
    },

    activate: function () {
        let tabPanel = Ext.getCmp("pimcore_panel_tabs");
        tabPanel.setActiveItem(this.getTabPanel());
    },

    getTabPanel: function () {
        if (!this.panel) {
            this.panel = new Ext.Panel({
                id: "pimcore_plugin_datahub_config_tab",
                title: t("plugin_pimcore_datahub_toolbar"),
                iconCls: "plugin_pimcore_datahub_icon",
                border: false,
                layout: "border",
                closable: true,
                items: [this.getTree(), this.getEditPanel()]
            });

            var tabPanel = Ext.getCmp("pimcore_panel_tabs");
            tabPanel.add(this.panel);
            tabPanel.setActiveItem("pimcore_plugin_datahub_config_tab");

            this.panel.on("destroy", function () {
                pimcore.globalmanager.remove("plugin_pimcore_datahub_config");
            }.bind(this));

            pimcore.layout.refresh();
        }

        return this.panel;
    },

    userIsAllowedToCreate: function(adapter) {
        let user = pimcore.globalmanager.get("user");

        //everything is allowed for admins
        if (user.admin || user.isAllowed('plugin_datahub_admin')) {
            return true;
        }

        return user.isAllowed("plugin_datahub_adapter_" + adapter);
    },

    getTree: function () {
        if (!this.tree) {

            var store = Ext.create('Ext.data.TreeStore', {
                autoLoad: false,
                autoSync: true,
                proxy: {
                    type: 'ajax',
                    url: '/admin/pimcoredatahub/config/list',
                    reader: {
                        type: 'json'
                    }
                }
            });

            let menuItems = [];

            let firstHandler;

            for (let key in pimcore.plugin.datahub.adapter) {
                if( pimcore.plugin.datahub.adapter.hasOwnProperty( key ) && this.userIsAllowedToCreate(key)) {
                    let adapter = new pimcore.plugin.datahub.adapter[key](this);

                    if (!firstHandler) {
                        firstHandler = adapter.addConfiguration.bind(adapter, key);
                    }
                    menuItems.push(
                    {
                        text: t('plugin_pimcore_datahub_type_' + key),
                        iconCls: "plugin_pimcore_datahub_icon_" + key,
                        handler: adapter.addConfiguration.bind(adapter, key)
                    });
                }
            }

            var addConfigButton = new Ext.SplitButton({
                text: t("plugin_pimcore_datahub_configpanel_add"),
                iconCls: "pimcore_icon_add",
                handler: firstHandler,
                disabled:  !pimcore.settings['data-hub-writeable'] || !firstHandler,
                menu: menuItems,
            });


            this.tree = new Ext.tree.TreePanel({
                store: store,
                region: "west",
                autoScroll: true,
                animate: true,
                containerScroll: true,
                border: true,
                width: 200,
                split: true,
                root: {
                    id: '0',
                    expanded: true,
                    iconCls: "pimcore_icon_thumbnails"
                },
                rootVisible: false,
                tbar: {
                    items: [
                        addConfigButton
                    ]
                },
                listeners: {
                    itemclick: this.onTreeNodeClick.bind(this),
                    itemcontextmenu: this.onTreeNodeContextmenu.bind(this),
                    render: function () {
                        this.getRootNode().expand()
                    }
                }
            });
        }

        return this.tree;
    },

    getEditPanel: function () {
        if (!this.editPanel) {
            this.editPanel = new Ext.TabPanel({
                region: "center"
            });
        }

        return this.editPanel;
    },


    onTreeNodeClick: function (tree, record, item, index, e, eOpts) {
        if (!record.isLeaf()) {
            return;
        }

        let adapterType = record.data.adapter;
        let adapterImpl = new pimcore.plugin.datahub.adapter[adapterType](this);
        adapterImpl.openConfiguration(record.id);
    },


    onTreeNodeContextmenu: function (tree, record, item, index, e, eOpts) {
        if (!record.isLeaf()) {
            return;
        }

        e.stopEvent();

        tree.select();

        var menu = new Ext.menu.Menu();
        menu.add(new Ext.menu.Item({
            text: t('delete'),
            iconCls: "pimcore_icon_delete",
            disabled: !record.data['writeable'] || (!record.data.permissions.delete),
            handler: this.deleteConfiguration.bind(this, tree, record)
        }));

        menu.add(new Ext.menu.Item({
            text: t('clone'),
            iconCls: "pimcore_icon_clone",
            disabled: !record.data['writeable'] || !this.userIsAllowedToCreate(record.data.adapter),
            handler: this.cloneConfiguration.bind(this, tree, record)
        }));

        menu.showAt(e.pageX, e.pageY);
    },

    cloneConfiguration: function (tree, record) {
        let adapterType = record.data.adapter;
        let adapterImpl = new pimcore.plugin.datahub.adapter[adapterType](this);
        adapterImpl.cloneConfiguration(tree, record);
    },

    deleteConfiguration: function (tree, record) {
        let adapterType = record.data.adapter;
        let adapterImpl = new pimcore.plugin.datahub.adapter[adapterType](this);
        adapterImpl.deleteConfiguration(tree, record);
    },

    refreshTree: function() {
        this.tree.getStore().load({
            node: this.tree.getRootNode()
        });
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.adapter.graphql");
pimcore.plugin.datahub.adapter.graphql = Class.create({

    initialize: function (configPanel) {
        this.configPanel = configPanel;
    },

    addConfiguration: function (type) {
        Ext.MessageBox.prompt(t('plugin_pimcore_datahub_configpanel_enterkey_title'), t('plugin_pimcore_datahub_configpanel_enterkey_prompt'), this.addConfigurationComplete.bind(this, type), null, null, "");
    },

    addConfigurationComplete: function (type, button, value, object) {
        var regresult = value.match(/[a-zA-Z0-9_\-]+/);
        if (button == "ok" && value.length > 2 && value.length <= 80 && regresult == value) {
            Ext.Ajax.request({
                url: "/admin/pimcoredatahub/config/add",
                params: {
                    name: value,
                    type: type
                },
                success: function (response) {
                    var data = Ext.decode(response.responseText);
                    this.configPanel.refreshTree();

                    if (!data || !data.success) {
                        pimcore.helpers.showNotification(t("error"), t("plugin_pimcore_datahub_configpanel_error_adding_config") + ': <br/>' + data.message, "error");
                    } else {
                        this.openConfiguration(data.name);
                    }

                }.bind(this)
            });
        }
        else if (button == "cancel") {
            return;
        }
        else {
            Ext.Msg.alert(t("plugin_pimcore_datahub_configpanel"), value.length <= 80 ? t("plugin_pimcore_datahub_configpanel_invalid_name") : t("plugin_pimcore_datahub_configpanel_invalid_length"));
        }
    },

    openConfiguration: function (id) {
        var existingPanel = Ext.getCmp("plugin_pimcore_datahub_configpanel_panel_" + id);
        if(existingPanel) {
            this.configPanel.editPanel.setActiveTab(existingPanel);
            return;
        }

        Ext.Ajax.request({
            url: "/admin/pimcoredatahub/config/get",
            params: {
                name: id
            },
            success: function (response) {
                var data = Ext.decode(response.responseText);

                pimcore.plugin.datahub.graphql = pimcore.plugin.datahub.graphql || {};
                pimcore.plugin.datahub.graphql.supportedQueryDataTypes = data.supportedGraphQLQueryDataTypes;
                pimcore.plugin.datahub.graphql.supportedMutationDataTypes = data.supportedGraphQLMutationDataTypes;

                let fieldPanel = new pimcore.plugin.datahub.configuration.graphql.configItem(data, this);
                pimcore.layout.refresh();
            }.bind(this)
        });
    },

    cloneConfiguration: function (tree, record) {
        Ext.MessageBox.prompt(t('plugin_pimcore_datahub_configpanel_enterclonekey_title'), t('plugin_pimcore_datahub_configpanel_enterclonekey_enterclonekey_prompt'),
            this.cloneConfigurationComplete.bind(this, tree, record), null, null, "");
    },

    cloneConfigurationComplete: function (tree, record, button, value, object) {

        var regresult = value.match(/[a-zA-Z0-9_\-]+/);
        if (button == "ok" && value.length > 2 && value.length <= 80 && regresult == value) {
            Ext.Ajax.request({
                url: "/admin/pimcoredatahub/config/clone",
                params: {
                    name: value,
                    originalName: record.data.id
                },
                success: function (response) {
                    var data = Ext.decode(response.responseText);

                    this.configPanel.refreshTree();

                    if (!data || !data.success) {
                        pimcore.helpers.showNotification(t("error"), t("plugin_pimcore_datahub_configpanel_error_cloning_config") + ': <br/>' + data.message, "error");
                    } else {
                        this.openConfiguration(data.name, tree, record);
                    }

                }.bind(this)
            });
        }
        else if (button == "cancel") {
            return;
        }
        else {
            Ext.Msg.alert(t("plugin_pimcore_datahub_configpanel"), value.length <= 80 ? t("plugin_pimcore_datahub_configpanel_invalid_name") : t("plugin_pimcore_datahub_configpanel_invalid_length"));
        }
    },

    deleteConfiguration: function (tree, record) {
        Ext.Msg.confirm(t('delete'), t('delete_message'), function (btn) {
            if (btn == 'yes') {
                Ext.Ajax.request({
                    url: "/admin/pimcoredatahub/config/delete",
                    params: {
                        name: record.data.id
                    }
                });

                this.configPanel.getEditPanel().removeAll();
                record.remove();
            }
        }.bind(this));
    },

});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.configuration.graphql.configItem");
pimcore.plugin.datahub.configuration.graphql.configItem = Class.create(pimcore.element.abstract, {

    saveUrl: "/admin/pimcoredatahub/config/save",

    initialize: function (data, parent) {
        this.parent = parent;
        this.data = data.configuration;
        this.userPermissions = data.userPermissions;
        this.modificationDate = data.modificationDate;

        this.tab = new Ext.TabPanel({
            activeTab: 0,
            title: this.data.general.name,
            closable: true,
            deferredRender: false,
            forceLayout: true,
            iconCls: "plugin_pimcore_datahub_icon_" + this.data.general.type,
            id: "plugin_pimcore_datahub_configpanel_panel_" + data.name,
            buttons: {
                componentCls: 'plugin_pimcore_datahub_statusbar',
                itemId: 'footer'
            },
            defaults: {
                renderer: Ext.util.Format.htmlEncode
            },
        });

        //create sub panels after main panel is generated - to be able to reference it in sub panels
        this.tab.add(this.getItems());
        this.tab.setActiveTab(0);

        this.tab.on("activate", this.tabactivated.bind(this));
        this.tab.on("destroy", this.tabdestroy.bind(this));

        this.parent.configPanel.editPanel.add(this.tab);
        this.parent.configPanel.editPanel.setActiveTab(this.tab);
        this.parent.configPanel.editPanel.updateLayout();

        this.setupChangeDetector();

        this.showInfo();
    },

    getItems: function() {
        return [this.getGeneral(), this.getSchema(), this.getSecurity(), this.getPermissions()];
    },

    openExplorer: function (callbackFn) {
        Ext.Ajax.request({
            url: '/admin/pimcoredatahub/config/get-explorer-url?name=' + this.data.general.name,

            success: function (callbackFn, response, opts) {

                var data = Ext.decode(response.responseText);
                var securityValues = this.securityForm.getForm().getFieldValues();
                var explorerUrl = window.location.origin + data.explorerUrl;
                if (securityValues && securityValues["method"] == "datahub_apikey") {
                    explorerUrl = explorerUrl + "?apikey=" + securityValues["apikey"];
                }
                callbackFn(explorerUrl);
            }.bind(this, callbackFn)
        });

    },

    showInfo: function () {

        var footer = this.tab.getDockedComponent('footer');

        footer.removeAll();

        footer.add({
            xtype: 'button',
            text: t('plugin_pimcore_datahub_graphql_open_explorer_in_iframe'),
            iconCls: 'pimcore_icon_iframe',
            handler: function () {
                this.openExplorer(function (explorerUrl) {
                    pimcore.helpers.openGenericIframeWindow("plugin_datahub_iframe_" + this.data.general.name, explorerUrl, "plugin_pimcore_datahub_icon_graphql",
                        t("plugin_pimcore_datahub_graphql_iexplorer") + " - " + this.data.general.name
                    );
                }.bind(this));
            }.bind(this)
        });

        footer.add({
            xtype: 'button',
            text: t('plugin_pimcore_datahub_graphql_open_explorer_in_tab'),
            iconCls: 'pimcore_icon_open_window',
            handler: function () {
                this.openExplorer(function (explorerUrl) {
                    window.open(explorerUrl, '_blank');
                }.bind(this));
            }.bind(this)
        });

        let saveButtonConfig = {
            text: t("save"),
            iconCls: "pimcore_icon_apply",
            disabled: !this.data.general.writeable || !this.userPermissions.update,
            handler: this.save.bind(this)
        };
        if(!this.data.general.writeable) {
            saveButtonConfig.tooltip = t("config_not_writeable");
        }
        footer.add(saveButtonConfig);
    },

    tabactivated: function () {
        this.tabdestroyed = false;
    },

    tabdestroy: function () {
        this.tabdestroyed = true;
    },

    getGeneral: function () {


        this.generalForm = new Ext.form.FormPanel({
            bodyStyle: "padding:10px;",
            autoScroll: true,
            defaults: {
                labelWidth: 200,
                width: 600
            },
            border: false,
            title: t("plugin_pimcore_datahub_configpanel_item_general"),
            items: [
                {
                    xtype: "checkbox",
                    fieldLabel: t("active"),
                    name: "active",
                    value: this.data.general && this.data.general.hasOwnProperty("active") ? this.data.general.active : true
                },
                {
                    xtype: "textfield",
                    fieldLabel: t("type"),
                    name: "type",
                    value: t("plugin_pimcore_datahub_type_" + this.data.general.type),
                    readOnly: true
                },
                {
                    xtype: "textfield",
                    fieldLabel: t("name"),
                    name: "name",
                    value: this.data.general.name,
                    readOnly: true
                },
                {
                    name: "description",
                    fieldLabel: t("description"),
                    xtype: "textarea",
                    height: 100,
                    value: this.data.general.description
                },
                {
                    xtype: "textfield",
                    fieldLabel: t("group"),
                    name: "group",
                    value: this.data.general.group
                },
                {
                    xtype: "displayfield",
                    hideLabel: true,
                    value: t("plugin_pimcore_datahub_configpanel_condition_hint"),
                    readOnly: true,
                    disabled: true
                },
                {
                    name: "sqlObjectCondition",
                    fieldLabel: t("plugin_pimcore_datahub_configpanel_sqlObjectCondition"),
                    xtype: "textarea",
                    height: 100,
                    value: this.data.general.sqlObjectCondition
                }
            ]
        });

        return this.generalForm;
    },

    getSecurity: function () {

        var methodsStore = Ext.create('Ext.data.Store', {
            fields: ['method', 'translatedMethod'],
            data: [{
                'method': 'datahub_apikey',
                "translatedMethod": t("plugin_pimcore_datahub_configpanel_security_method_apikey"),
                'allowBlank': false
            }]
        });


        this.documentWorkspace = new pimcore.plugin.datahub.workspace.document(this);
        this.assetWorkspace = new pimcore.plugin.datahub.workspace.asset(this);
        this.objectWorkspace = new pimcore.plugin.datahub.workspace.object(this);

        var apikeyField = new Ext.form.field.TextArea({
            xtype: "textareafield",
            labelWidth: 200,
            width: 600,
            height: 100,
            fieldLabel: t("plugin_pimcore_datahub_security_datahub_apikey"),
            name: "apikey",
            value: this.data.security ? Array.isArray(this.data.security.apikey) ? this.data.security.apikey.join("\n") : this.data.security.apikey : "",
            minLength: 16
        });

        var skipPermissionCheck = new Ext.form.Checkbox({
            fieldLabel: t('plugin_pimcore_datahub_skip_permission_check'),
            labelWidth: 200,
            name: "skipPermissionCheck",
            value: this.data.security ? this.data.security.skipPermissionCheck : ""
        });

        var disableIntrospection = new Ext.form.Checkbox({
            fieldLabel: t('plugin_pimcore_datahub_disable_introspection'),
            labelWidth: 200,
            name: "disableIntrospection",
            value: this.data.security ? this.data.security.disableIntrospection : ""
        });

        this.securityForm = new Ext.form.FormPanel({
            bodyStyle: "padding:10px;",
            autoScroll: true,
            defaults: {
                labelWidth: 200
            },
            border: false,
            title: t("plugin_pimcore_datahub_configpanel_security"),
            items: [
                {
                    xtype: "combobox",
                    fieldLabel: t("plugin_pimcore_datahub_configpanel_security_method"),
                    name: "method",
                    store: methodsStore,
                    value: this.data.security && this.data.security.method ? this.data.security.method : "datahub_apikey",
                    valueField: 'method',
                    displayField: 'translatedMethod',
                    width: 600
                },
                {
                    xtype: "fieldcontainer",
                    layout: 'hbox',

                    items: [
                        apikeyField,
                        {
                            xtype: "button",
                            width: 32,
                            style: "margin-left: 8px",
                            iconCls: "pimcore_icon_clear_cache",
                            handler: function () {
                                let val = apikeyField.getValue();
                                let newKey = md5(uniqid());
                                apikeyField.setValue(val ? val + "\n" + newKey : newKey);
                            }.bind(this)
                        }
                    ]
                },
                {
                    xtype: 'displayfield',
                    hideLabel: true,
                    value: t("plugin_pimcore_datahub_security_apikey_description"),
                    cls: "pimcore_extra_label_bottom",
                    style: "padding-bottom: 0px",
                    readOnly: true,
                    disabled: true
                },
                skipPermissionCheck,
                disableIntrospection,
                {
                    xtype: 'displayfield',
                    hideLabel: true,
                    value: t("plugin_pimcore_datahub_security_introspection_description"),
                    cls: "pimcore_extra_label_bottom",
                    style: "padding-bottom: 0px",
                    readOnly: true,
                    disabled: true
                },
                {
                    xtype: 'fieldset',
                    width: 800,
                    title: t("workspaces"),
                    items: [
                        this.documentWorkspace.getPanel(),
                        this.assetWorkspace.getPanel(),
                        this.objectWorkspace.getPanel()
                    ]
                }
            ]
        });

        return this.securityForm;
    },

    getSchema: function () {

        this.createSchemaStoreAndGrid("query");
        this.createSchemaStoreAndGrid("mutation");
        this.createSpecialSettingsGrid();

        this.schemaForm = new Ext.form.FormPanel({
            bodyStyle: "padding:10px;",
            autoScroll: true,
            defaults: {
                labelWidth: 200,
                width: 800
            },
            border: false,
            title: t("plugin_pimcore_datahub_configpanel_schema"),
            items: [
                {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_graphql_query_schema'),
                    items: [
                        this.querySchemaGrid
                    ]
                }, {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_graphql_mutation_schema'),
                    items: [
                        this.mutationSchemaGrid
                    ]
                },
                {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_graphql_special_schema'),
                    items: [
                        this.specialSchemaGrid
                    ]
                }
            ]
        });

        return this.schemaForm;
    },

    onAdd: function (type) {
        this.showEntitySelectionDialog(type);
    },

    updateData: function (data, grid) {
    },

    createSchemaStoreAndGrid: function (type) {
        var schemaToolbar = Ext.create('Ext.Toolbar', {
            cls: 'main-toolbar',
            items: [
                {
                    text: t('add'),
                    handler: this.onAdd.bind(this, type),
                    iconCls: "pimcore_icon_add"
                }
            ]
        });

        var fields = ['id', 'columnConfig'];
        if (type == "mutation") {
            fields.push("create");
            fields.push("update");
            fields.push("delete");
        }
        this[type + "SchemaStore"] = Ext.create('Ext.data.Store', {
            reader: {
                type: 'memory'
            },
            fields: fields,
            data: this.data.schema[type + "Entities"]
        });

        var columns = [
            {
                text: t("plugin_pimcore_datahub_configpanel_entity"),
                sortable: true,
                dataIndex: 'id',
                editable: false,
                filter: 'string',
                flex: 1
            }
        ];

        var additionalColumns = ["create", "update", "delete"];
        if (type == "mutation") {
            for (var i = 0; i < additionalColumns.length; i++) {
                var checkColumn = Ext.create('Ext.grid.column.Check', {
                    text: t(additionalColumns[i]),
                    dataIndex: additionalColumns[i]
                });
                columns.push(checkColumn);
            }
        }

        columns.push({
            xtype: 'actioncolumn',
            text: t('settings'),
            menuText: t('settings'),
            width: 60,
            items: [
                {
                    tooltip: t('settings'),
                    icon: "/bundles/pimcoreadmin/img/flat-color-icons/settings.svg",
                    handler: function (grid, rowIndex) {
                        var record = grid.getStore().getAt(rowIndex);

                        var classStore = pimcore.globalmanager.get("object_types_store");
                        var classIdx = classStore.findExact("text", record.data.id);
                        if (classIdx >= 0) {
                            var classRecord = classStore.getAt(classIdx);
                            classId = classRecord.data.id;
                            var columnConfig = record.get("columnConfig");

                            var dialog = new pimcore.plugin.datahub.fieldConfigDialog(type, {
                                    className: classRecord.data.text,
                                    classId: classId
                                },
                                columnConfig,
                                function (data, settings) {
                                    record.set('columnConfig', data);
                                }, null);
                        }
                    }.bind(this)
                }]
        });

        columns.push({
            xtype: 'actioncolumn',
            text: t('delete'),
            menuText: t('delete'),
            width: 60,
            items: [{
                tooltip: t('delete'),
                icon: "/bundles/pimcoreadmin/img/flat-color-icons/delete.svg",
                handler: function (grid, rowIndex) {
                    grid.getStore().removeAt(rowIndex);
                }.bind(this)
            }
            ]
        });

        var prop = type + "SchemaGrid";
        this[prop] = Ext.create('Ext.grid.Panel', {
            frame: false,
            bodyCls: "pimcore_editable_grid",
            autoScroll: true,
            store: this[type + "SchemaStore"],
            columnLines: true,
            stripeRows: true,
            columns: {
                items: columns
            },
            trackMouseOver: true,
            selModel: Ext.create('Ext.selection.RowModel', {}),
            tbar: schemaToolbar,
            viewConfig: {
                forceFit: true,
                enableTextSelection: true
            }
        });

    },

    createSpecialSettingsGrid: function () {
        var schemaToolbar = Ext.create('Ext.Toolbar', {
            cls: 'main-toolbar'
        });

        var fields = ['id', 'create', 'read', 'update', 'delete'];

        this.specialSchemaStore = Ext.create('Ext.data.Store', {
            reader: {
                type: 'memory'
            },
            fields: fields,
            data: this.data.schema.specialEntities
        });

        var columns = [
            {
                sortable: true,
                dataIndex: 'name',
                editable: false,
                filter: 'string',
                renderer: function (v) {
                    return t("plugin_pimcore_datahub_graphql_special_" + v);
                },
                flex: 1
            }
        ];

        var additionalColumns = ["create", "read", "update", "delete"];

        for (var i = 0; i < additionalColumns.length; i++) {
            var checkColumn = Ext.create('Ext.grid.column.Check', {
                text: t(additionalColumns[i]),
                dataIndex: additionalColumns[i] + 'Allowed',
                operationIndex: additionalColumns[i],
                listeners: {
                    beforecheckchange: function (checkCol, rowIndex, checked) {
                        var store = this.specialSchemaGrid.getStore();
                        var record = store.getAt(rowIndex);
                        var possibleValue = checkCol.operationIndex + 'Possible';

                        if (!record.get(possibleValue)) {
                            pimcore.helpers.showNotification(t("info"), "Operation is not implemented.");
                            return false;
                        }

                        return true;
                    }.bind(this)}
            });
            columns.push(checkColumn);
        }

        this.specialSchemaGrid = Ext.create('Ext.grid.Panel', {
            frame: false,
            bodyCls: "pimcore_editable_grid",
            autoScroll: true,
            store: this.specialSchemaStore,
            columnLines: true,
            stripeRows: true,
            columns: {
                items: columns
            },
            trackMouseOver: true,
            tbar: schemaToolbar,
            viewConfig: {
                forceFit: true,
                enableTextSelection: true
            }
        });
    },

    createPermissionsGrid: function (type) {
        let fields = ['id', 'read', 'update', 'delete'];

        let permissions = [];
        if (this.data.permissions && this.data.permissions[type]) {
            permissions = this.data.permissions[type];
        }

        this[type + "PermissionsStore"] = Ext.create('Ext.data.Store', {
            reader: {
                type: 'memory'
            },
            fields: fields,
            data: permissions
        });

        let columns = [
            {
                dataIndex: 'id',
                hidden: true
            },
            {
                sortable: true,
                dataIndex: 'name',
                editable: false,
                filter: 'string',
                flex: 1
            }
        ];

        let additionalColumns = ["read", "update", "delete"];

        for (let i = 0; i < additionalColumns.length; i++) {
            let checkColumn = Ext.create('Ext.grid.column.Check', {
                text: t(additionalColumns[i]),
                dataIndex: additionalColumns[i],
                operationIndex: additionalColumns[i],
            });
            columns.push(checkColumn);
        }

        columns.push({
            xtype: 'actioncolumn',
            menuText: t('delete'),
            width: 30,
            items: [{
                tooltip: t('delete'),
                icon: "/bundles/pimcoreadmin/img/flat-color-icons/delete.svg",
                handler: function (grid, rowIndex) {
                    grid.getStore().removeAt(rowIndex);
                }.bind(this)
            }
            ]
        });

        let permissionsToolbar = Ext.create('Ext.Toolbar', {
            cls: 'main-toolbar',
            items: [
                {
                    text: t('add'),
                    handler: this.showPermissionDialog.bind(this, type),
                    iconCls: "pimcore_icon_add"
                }
            ]
        });

        this[type + "PermissionsGrid"] = Ext.create('Ext.grid.Panel', {
            frame: false,
            bodyCls: "pimcore_editable_grid",
            autoScroll: true,
            store: this[type + "PermissionsStore"],
            columnLines: true,
            stripeRows: true,
            columns: {
                items: columns
            },
            trackMouseOver: true,
            tbar: permissionsToolbar,
            viewConfig: {
                forceFit: true,
                enableTextSelection: true
            }
        });
    },

    getPermissions: function () {
        if (!this.userPermissions.update) {
            return;
        }

        this.createPermissionsGrid("user");
        this.createPermissionsGrid("role");

        this.permissionsForm = new Ext.form.FormPanel({
            bodyStyle: "padding:10px;",
            autoScroll: true,
            defaults: {
                labelWidth: 200,
                width: 800
            },
            border: false,
            title: t("plugin_pimcore_datahub_configpanel_permissions"),
            items: [
                {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_graphql_permissions_roles'),
                    items: [
                        this.rolePermissionsGrid
                    ]
                }, {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_graphql_permissions_users'),
                    items: [
                        this.userPermissionsGrid
                    ]
                }
            ]
        });

        return this.permissionsForm;
    },

    getSaveDataArray: function () {
        var saveData = {};
        saveData["general"] = this.generalForm.getForm().getFieldValues(false, false);
        saveData["schema"] = this.schemaForm.getForm().getFieldValues();
        saveData["security"] = this.securityForm.getForm().getFieldValues(false, false);
        saveData["schema"]["queryEntities"] = this.getSchemaData("query");
        saveData["schema"]["mutationEntities"] = this.getSchemaData("mutation");
        saveData["schema"]["specialEntities"] = this.getSchemaData("special");
        saveData["workspaces"] = {};
        saveData["workspaces"]["asset"] = this.assetWorkspace.getValues();
        saveData["workspaces"]["document"] = this.documentWorkspace.getValues();
        saveData["workspaces"]["object"] = this.objectWorkspace.getValues();
        saveData["permissions"] = this.getPermissionsSaveData();
        return saveData;
    },

    getSaveData: function () {
        return Ext.encode(this.getSaveDataArray());
    },

    getPermissionsSaveData: function () {
        if (this.userPermissionsStore) {
            let data = {};
            data["user"] = this.getPermissionsData("user");
            data["role"] = this.getPermissionsData("role");

            return data;
        }

        return this.data.permissions;
    },

    getSchemaData: function (type) {
        var tmData = [];

        var store = this[type + "SchemaStore"];
        var data = store.queryBy(function (record, id) {
            return true;
        });

        for (var i = 0; i < data.items.length; i++) {
            tmData.push(data.items[i].data);
        }

        return tmData;
    },

    getPermissionsData: function (type) {
        var tmData = [];

        var store = this[type + "PermissionsStore"];
        var data = store.queryBy(function (record, id) {
            return true;
        });

        for (var i = 0; i < data.items.length; i++) {
            tmData.push(data.items[i].data);
        }

        return tmData;
    },

    save: function () {
        const saveData = this.getSaveData();
        Ext.Ajax.request({
            url: this.saveUrl,
            params: {
                data: saveData,
                modificationDate: this.modificationDate
            },
            method: "post",
            success: function (response) {
                const rdata = Ext.decode(response.responseText);
                if (rdata && rdata.success) {
                    this.modificationDate = rdata.modificationDate;
                    this.saveOnComplete();
                } else if(rdata && rdata.permissionError) {
                    pimcore.helpers.showNotification(t("error"), t("plugin_pimcore_datahub_configpanel_item_saveerror_permissions"), "error");
                    this.tab.setActiveTab(this.tab.items.length-1);
                } else {
                    pimcore.helpers.showNotification(t("error"), t("plugin_pimcore_datahub_configpanel_item_saveerror"), "error", t(rdata.message));
                }
            }.bind(this)
        });
    },

    saveOnComplete: function () {
        this.parent.configPanel.tree.getStore().load({
            node: this.parent.configPanel.tree.getRootNode()
        });

        pimcore.helpers.showNotification(t("success"), t("plugin_pimcore_datahub_configpanel_item_save_success"), "success");

        this.resetChanges();
    },

    showEntitySelectionDialog: function (type) {

        var store = this[type + "SchemaStore"];
        this.entitySelectionDialog = new Ext.Window({
            autoHeight: true,
            title: t('plugin_pimcore_datahub_operator_select_entity'),
            closeAction: 'close',
            width: 500,
            modal: true
        });

        var entityStore = new Ext.data.JsonStore({
            proxy: {
                url: '/admin/class/get-tree',
                type: 'ajax',
                reader: {
                    type: 'json',
                    idProperty: 'text'
                }
            },
            fields: ['id'],
            autoDestroy: true,
            autoLoad: true,
            sortInfo: {field: 'id', direction: "ASC"}
        });

        var entityCombo = new Ext.form.ComboBox(
            {
                xtype: "combo",
                fieldLabel: t("plugin_pimcore_datahub_configpanel_entity"),
                store: entityStore,
                triggerAction: 'all',
                editable: false,
                width: 450
            }
        );

        var form = new Ext.form.FormPanel({
            bodyStyle: 'padding: 10px;',
            items: [entityCombo],
            bbar: [
                "->",
                {
                    xtype: "button",
                    text: t("OK"),
                    iconCls: "pimcore_icon_bool",
                    handler: function () {
                        var entity = entityCombo.getValue();
                        if (entity) {
                            var record = store.getById(entity);
                            if (!record) {
                                var newData = {
                                    id: entity,
                                    name: entity
                                };
                                if (type == "mutation") {
                                    newData["update"] = true;
                                }
                                var addedRecord = store.addSorted(newData);
                                addedRecord = addedRecord[0];
                                this[type + "SchemaGrid"].getSelectionModel().select([addedRecord]);
                            }
                        }

                        this.entitySelectionDialog.close();

                    }.bind(this)
                },
                {
                    xtype: "button",
                    text: t("cancel"),
                    iconCls: "pimcore_icon_cancel",
                    handler: function () {
                        this.entitySelectionDialog.close();
                    }.bind(this)
                }]
        });

        this.entitySelectionDialog.add(form);
        this.entitySelectionDialog.show();
    },

    showPermissionDialog: function (type) {
        let store = this[type + "PermissionsStore"];
        this.permissionDialog = new Ext.Window({
            autoHeight: true,
            title: t('plugin_pimcore_datahub_operator_select_' + type),
            closeAction: 'close',
            width: 500,
            modal: true
        });

        let permissionStore = new Ext.data.JsonStore({
            proxy: {
                url: '/admin/pimcoredatahub/config/permissions-users',
                extraParams: {
                    type: type,
                },
                type: 'ajax',
                reader: {
                    type: 'json',
                    idProperty: 'id',
                }
            },
            fields: ['id', 'text'],
            autoDestroy: true,
            autoLoad: true,
            sortInfo: {field: 'id', direction: "ASC"}
        });

        let permissionCombo = new Ext.form.field.Tag({
            fieldLabel: t("plugin_pimcore_datahub_configpanel_" + type),
            store: permissionStore,
            triggerAction: 'all',
            editable: true,
            width: 450,
            queryMode: 'local',
            filterPickList: true,
            valueField: "id",
            displayField: "text"
        });

        let form = new Ext.form.FormPanel({
            bodyStyle: 'padding: 10px;',
            items: [permissionCombo],
            bbar: [
                "->",
                {
                    xtype: "button",
                    text: t("OK"),
                    iconCls: "pimcore_icon_bool",
                    handler: function () {
                        var userIds = permissionCombo.getValue();
                        Ext.each(userIds, function (userId) {
                            var record = store.getById(userId);
                            var selected = permissionStore.getById(userId);
                            if (!record) {
                                let newUser = {
                                    id: selected.get('id'),
                                    name: selected.get('text')
                                };
                                let addedRecord = store.addSorted(newUser);
                                addedRecord = addedRecord[0];
                                this[type + "PermissionsGrid"].getSelectionModel().select([addedRecord]);
                            }
                        }.bind(this));

                        this.permissionDialog.close();

                    }.bind(this)
                },
                {
                    xtype: "button",
                    text: t("cancel"),
                    iconCls: "pimcore_icon_cancel",
                    handler: function () {
                        this.permissionDialog.close();
                    }.bind(this)
                }]
        });

        this.permissionDialog.add(form);
        this.permissionDialog.show();
    },

    _confirmDirtyClose: function () {
        Ext.MessageBox.confirm(
            t("element_has_unsaved_changes"),
            t("element_unsaved_changes_message"),
            function (buttonValue) {
                if (buttonValue === "yes") {
                    this._confirmedDirtyClose = true;

                    this.tab.fireEventedAction("close", [this.tab, {}]);
                    this.parent.configPanel.editPanel.remove(this.tab);
                }
            }.bind(this)
        );
    }

});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.fieldConfigDialog");
pimcore.plugin.datahub.fieldConfigDialog = Class.create({

    showFieldname: true,
    data: {},
    brickKeys: [],

    initialize: function (type, generalConfig, columnConfig, callback, settings) {

        this.type = type;
        this.generalConfig = generalConfig || {};
        this.columnConfig = columnConfig || {};
        this.columnConfig.columns = this.columnConfig.columns || [];
        this.callback = callback;

        this.settings = settings || {};

        if (!this.callback) {
            this.callback = function () {
            };
        }

        this.configPanel = new Ext.Panel({
            layout: "border",
            iconCls: "pimcore_icon_table",
            title: t("plugin_pimcore_datahub_configpanel_fields"),
            items: [
                this.getSelectionPanel(), this.getLeftPanel()]

        });


        var tabs = [this.configPanel];

        this.tabPanel = new Ext.TabPanel({
            activeTab: 0,
            forceLayout: true,
            items: tabs
        });

        buttons = [];

        buttons.push({
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData();
                }.bind(this)
            }
        );

        this.window = new Ext.Window({
            width: 950,
            height: '95%',
            modal: true,
            title: t("plugin_pimcore_datahub_" + this.type) + " " + t('plugin_pimcore_datahub_configpanel_schema_fields') + ' - ' + this.generalConfig.className,
            layout: "fit",
            items: [this.tabPanel],
            buttons: buttons
        });

        this.window.show();
    },

    doBuildChannelConfigTree: function (configuration) {

        var elements = [];
        if (configuration) {
            for (var i = 0; i < configuration.length; i++) {
                var configElement = this.getConfigElement(configuration[i]);
                if (configElement) {
                    var treenode = configElement.getConfigTreeNode(configuration[i].attributes);

                    if (configuration[i].attributes && configuration[i].attributes.childs) {
                        var childs = this.doBuildChannelConfigTree(configuration[i].attributes.childs);
                        treenode.children = childs;
                        if (childs.length > 0) {
                            treenode.expandable = true;
                        }
                    }
                    elements.push(treenode);
                } else {
                    console.log("config element not found");
                }
            }
        }
        return elements;
    },

    getLeftPanel: function () {
        if (!this.leftPanel) {

            var items = this.getOperatorTrees();
            items.unshift(this.getClassDefinitionTreePanel());

            this.brickKeys = [];
            this.leftPanel = new Ext.Panel({
                cls: "pimcore_panel_tree pimcore_gridconfig_leftpanel",
                region: "center",
                split: true,
                width: 300,
                minSize: 175,
                collapsible: true,
                collapseMode: 'header',
                collapsed: false,
                animCollapse: false,
                layout: 'accordion',
                hideCollapseTool: true,
                header: false,
                layoutConfig: {
                    animate: false
                },
                hideMode: "offsets",
                items: items
            });
        }

        return this.leftPanel;
    },


    doGetRecursiveData: function (node) {
        var childs = [];
        node.eachChild(function (child) {
            var attributes = child.data.configAttributes;
            attributes.childs = this.doGetRecursiveData(child);
            var childConfig = {
                "isOperator": child.data.isOperator ? true : false,
                "attributes": attributes
            };

            childs.push(childConfig);
        }.bind(this));

        return childs;
    },


    commitData: function () {

        this.data = {};


        var operatorFound = false;

        if (this.selectionPanel) {
            this.data.columns = [];
            this.selectionPanel.getRootNode().eachChild(function (child) {
                var obj = {};

                if (child.data.isOperator) {
                    var attributes = child.data.configAttributes;
                    var operatorChilds = this.doGetRecursiveData(child);
                    attributes.childs = operatorChilds;
                    operatorFound = true;

                    obj.isOperator = true;
                    obj.attributes = attributes;

                } else {
                    var attributes = {};
                    attributes.attribute = child.data.key;
                    attributes.label = child.data.layout ? child.data.layout.title : child.data.text;
                    attributes.dataType = child.data.dataType;
                    if (child.data.width) {
                        attributes.width = child.data.width;
                    }
                    obj.attributes = attributes;
                    obj.isOperator = false;
                }

                this.data.columns.push(obj);
            }.bind(this));
        }

        var user = pimcore.globalmanager.get("user");


        if (!operatorFound) {
            this.callback(this.data, this.settings);
            this.window.close();
        } else {
            var columnsPostData = Ext.encode(this.data.columns);
            Ext.Ajax.request({
                //TODO what to do with this stuff ?

                url: "/admin/object-helper/prepare-helper-column-configs",
                method: 'POST',
                params: {
                    columns: columnsPostData
                },
                success: function (response) {
                    var responseData = Ext.decode(response.responseText);
                    this.data.columns = responseData.columns;

                    this.callback(this.data, this.settings);
                    this.window.close();


                }.bind(this)
            });
        }
    },

    openConfigDialog: function (element, copy) {
        var window = element.getConfigDialog(copy, null);

        if (window) {
            //this is needed because of new focus management of extjs6
            setTimeout(function () {
                window.focus();
            }, 250);
        }
    },


    getSelectionPanel: function () {
        if (!this.selectionPanel) {

            var childs = [];
            for (var i = 0; i < this.columnConfig.columns.length; i++) {
                var nodeConf = this.columnConfig.columns[i];

                if (nodeConf.isOperator) {
                    var child = this.doBuildChannelConfigTree([nodeConf]);
                    if (!child || !child[0]) {
                        continue;
                    }
                    child = child[0];
                } else {
                    var attributes = nodeConf.attributes;
                    let text = attributes.label ? t(attributes.label) : `(${attributes.attribute})`;

                    if (attributes.dataType !== "system" && this.showFieldname && attributes.key) {
                        text = text + " (" + attributes.key.replace("~", ".") + ")";
                    }

                    var child = {
                        text: text,
                        key: attributes.attribute,
                        type: "data",
                        dataType: attributes.dataType,
                        leaf: true,
                        layout: attributes.layout,
                        iconCls: "pimcore_icon_" + attributes.dataType
                    };
                    if (attributes.width) {
                        child.width = attributes.width;
                    }
                }
                childs.push(child);
            }

            this.cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
                clicksToEdit: 1
            });

            var store = new Ext.data.TreeStore({
                fields: [{
                    name: "text"
                }
                ],
                root: {
                    id: "0",
                    root: true,
                    text: t("plugin_pimcore_datahub_configpanel_root"),
                    leaf: false,
                    isTarget: true,
                    expanded: true,
                    children: childs
                }
            });

            this.selectionPanel = new Ext.tree.TreePanel({
                store: store,
                plugins: [this.cellEditing],
                rootVisible: true,
                viewConfig: {
                    plugins: {
                        ptype: 'treeviewdragdrop',
                        ddGroup: "columnconfigelement"
                    },
                    listeners: {
                        beforedrop: function (node, data, overModel, dropPosition, dropHandlers, eOpts) {
                            var target = overModel.getOwnerTree().getView();
                            var source = data.view;

                            if (target != source) {
                                var record = data.records[0];
                                var isOperator = record.data.isOperator;
                                var realOverModel = overModel;
                                if (dropPosition == "before" || dropPosition == "after") {
                                    realOverModel = overModel.parentNode;
                                }

                                if (isOperator || this.parentIsOperator(realOverModel)) {
                                    var attr = record.data;
                                    if (record.data.configAttributes) {
                                        attr = record.data.configAttributes;
                                    }
                                    var elementConfig = {
                                        "isOperator": true,
                                        "attributes": attr
                                    }

                                    var element = this.getConfigElement(elementConfig);
                                    var copy = element.getCopyNode(record);
                                    data.records = [copy]; // assign the copy as the new dropNode
                                    this.openConfigDialog(element, copy);
                                } else {

                                    if (!this.checkSupported(record)) {
                                        dropHandlers.cancelDrop();
                                        return false;
                                    }


                                    if (this.selectionPanel.getRootNode().findChild("key", record.data.key)) {
                                        dropHandlers.cancelDrop();
                                    } else {
                                        var copy = Ext.apply({}, record.data);
                                        delete copy.id;
                                        copy = record.createNode(copy);

                                        var ownerTree = this.selectionPanel;


                                        //TODO in case this ever get's reintegrated in to the core,
                                        // we don't support this on key level !
                                        // if (record.data.dataType == "classificationstore") {
                                        //     setTimeout(function () {
                                        //         var ccd = new pimcore.object.classificationstore.columnConfigDialog();
                                        //         ccd.getConfigDialog(ownerTree, copy, this.selectionPanel);
                                        //     }.bind(this), 100);
                                        // }
                                        data.records = [copy]; // assign the copy as the new dropNode
                                    }
                                }
                            } else {
                                // node has been moved inside right selection panel
                                var record = data.records[0];
                                var isOperator = record.data.isOperator;
                                var realOverModel = overModel;
                                if (dropPosition == "before" || dropPosition == "after") {
                                    realOverModel = overModel.parentNode;
                                }

                                if (isOperator || this.parentIsOperator(realOverModel)) {
                                    var attr = record.data;
                                    if (record.data.configAttributes) {
                                        // there is nothing to do, this guy has been configured already
                                        return;
                                        // attr = record.data.configAttributes;
                                    }
                                    var element = this.getConfigElement(attr);

                                    var copy = element.getCopyNode(record);
                                    data.records = [copy]; // assign the copy as the new dropNode

                                    this.openConfigDialog(element, copy);

                                    record.parentNode.removeChild(record);
                                }
                            }
                        }.bind(this),
                        drop: function (node, data, overModel) {
                            overModel.set('expandable', true);

                        }.bind(this),
                        nodedragover: function (targetNode, dropPosition, dragData, e, eOpts) {
                            var sourceNode = dragData.records[0];

                            if (sourceNode.data.isOperator) {
                                var realOverModel = targetNode;
                                if (dropPosition == "before" || dropPosition == "after") {
                                    realOverModel = realOverModel.parentNode;
                                }

                                var sourceType = this.getNodeTypeAndClass(sourceNode);
                                var targetType = this.getNodeTypeAndClass(realOverModel);
                                var allowed = true;


                                if (typeof realOverModel.data.isChildAllowed == "function") {
                                    allowed = allowed && realOverModel.data.isChildAllowed(realOverModel, sourceNode);
                                }

                                if (typeof sourceNode.data.isParentAllowed == "function") {
                                    allowed = allowed && sourceNode.data.isParentAllowed(realOverModel, sourceNode);
                                }


                                return allowed;
                            } else {
                                var targetNode = targetNode;

                                var allowed = true;
                                if (this.parentIsOperator(targetNode)) {
                                    if (dropPosition == "before" || dropPosition == "after") {
                                        targetNode = targetNode.parentNode;
                                    }

                                    if (typeof targetNode.data.isChildAllowed == "function") {
                                        allowed = allowed && targetNode.data.isChildAllowed(targetNode, sourceNode);
                                    }

                                    if (typeof sourceNode.data.isParentAllowed == "function") {
                                        allowed = allowed && sourceNode.data.isParentAllowed(targetNode, sourceNode);
                                    }

                                }

                                return allowed;
                            }
                        }.bind(this),
                        options: {
                            target: this.selectionPanel
                        }
                    }
                },
                id: 'tree',
                region: 'east',
                title: t('plugin_pimcore_datahub_configpanel_available_fields'),
                layout: 'fit',
                width: 640,
                split: true,
                autoScroll: true,
                rowLines: true,
                columnLines: true,
                listeners: {
                    itemcontextmenu: this.onTreeNodeContextmenu.bind(this)
                },
                columns: [
                    {
                        xtype: 'treecolumn',                    //this is so we know which column will show the tree
                        text: t('configuration'),
                        dataIndex: 'text',
                        flex: 90
                    }
                ]
            });

            var model = store.getModel();
            model.setProxy({
                type: 'memory'
            });
        }

        return this.selectionPanel;
    },

    parentIsOperator: function (record) {
        while (record) {
            if (record.data.isOperator) {
                return true;
            }
            record = record.parentNode;
        }
        return false;
    },

    getNodeTypeAndClass: function (node) {
        var type = "value";
        var className = "";
        if (node.data.configAttributes) {
            type = node.data.configAttributes.type;
            className = node.data.configAttributes['class'];
        } else if (node.data.dataType) {
            className = node.data.dataType.toLowerCase();
        }
        return {type: type, className: className};
    },

    onTreeNodeContextmenu: function (tree, record, item, index, e, eOpts) {
        e.stopEvent();

        tree.select();

        var menu = new Ext.menu.Menu();

        if (this.id != 0) {
            menu.add(new Ext.menu.Item({
                text: t('delete'),
                iconCls: "pimcore_icon_delete",
                handler: function (node) {
                    record.parentNode.removeChild(record, true);
                }.bind(this, record)
            }));

            if (record.data.children && record.data.children.length > 0) {
                menu.add(new Ext.menu.Item({
                    text: t('collapse_children'),
                    iconCls: "pimcore_icon_collapse_children",
                    handler: function (node) {
                        record.collapseChildren();
                    }.bind(this, record)
                }));

                menu.add(new Ext.menu.Item({
                    text: t('expand_children'),
                    iconCls: "pimcore_icon_expand_children",
                    handler: function (node) {
                        record.expandChildren();
                    }.bind(this, record)
                }));
            }

            if (record.data.isOperator) {
                menu.add(new Ext.menu.Item({
                    text: t('edit'),
                    iconCls: "pimcore_icon_edit",
                    handler: function (node) {
                        var nodeConfig = {
                            "isOperator": node.data.isOperator,
                            "attributes": node.data.configAttributes
                        }
                        this.getConfigElement(nodeConfig).getConfigDialog(node,
                            {
                                callback: function () {
                                    console.log("callback not needed for now");
                                }.bind(this)
                            });
                    }.bind(this, record)
                }));
            }
        }

        menu.showAt(e.pageX, e.pageY);
    },


    getClassDefinitionTreePanel: function () {
        if (!this.classDefinitionTreePanel) {

            var items = [];

            this.brickKeys = [];
            this.classDefinitionTreePanel = this.getClassTree("/admin/class/get-class-definition-for-column-config",
                this.generalConfig.classId, this.generalConfig.objectId);
        }

        return this.classDefinitionTreePanel;
    },

    getClassTree: function (url, classId, objectId) {

        var classTreeHelper = new pimcore.object.helpers.classTree(this.showFieldname, {
            showInvisible: true
        });
        var tree = classTreeHelper.getClassTree(url, classId, objectId);

        tree.addListener("itemdblclick", function (tree, record, item, index, e, eOpts) {
            if (!record.data.root && record.data.type != "layout" && record.data.dataType != 'localizedfields') {

                if (!this.checkSupported(record)) {
                    return;
                }

                var copy = Ext.apply({}, record.data);

                if (this.selectionPanel && !this.selectionPanel.getRootNode().findChild("key", record.data.key)) {
                    delete copy.id;
                    copy = this.selectionPanel.getRootNode().appendChild(copy);

                    var ownerTree = this.selectionPanel;

                    // TODO same as above regarding the core
                    // classificaton is stored on field level but on key level
                    // if (record.data.dataType == "classificationstore") {
                    //     var ccd = new pimcore.object.classificationstore.columnConfigDialog();
                    //     ccd.getConfigDialog(ownerTree, copy, this.selectionPanel);
                    // }
                }
            }
        }.bind(this));

        return tree;
    },

    getOperatorTrees: function () {
        var operators = pimcore.plugin.datahub[this.type + "operator"] ? Object.keys(pimcore.plugin.datahub[this.type + "operator"]) : [];
        var operatorGroups = [];

        for (var i = 0; i < operators.length; i++) {
            var operator = operators[i];

            if (operator == this.type + "operator") {
                continue;
            }

            if (!operator) {
                console.error("could not resolve operator");
                continue;
            }
            if (!this.availableOperators || this.availableOperators.indexOf(operator) >= 0) {
                var nodeConfig = pimcore.plugin.datahub[this.type + "operator"][operator].prototype;
                var configTreeNode = nodeConfig.getConfigTreeNode();

                var operatorGroup = nodeConfig.operatorGroup ? nodeConfig.operatorGroup : "other";

                if (!operatorGroups[operatorGroup]) {
                    operatorGroups[operatorGroup] = [];
                }

                var groupName = nodeConfig.group || "other";
                if (!operatorGroups[operatorGroup][groupName]) {
                    operatorGroups[operatorGroup][groupName] = [];
                }
                operatorGroups[operatorGroup][groupName].push(configTreeNode);
            }
        }

        var operatorGroupKeys = [];
        for (k in operatorGroups) {
            if (operatorGroups.hasOwnProperty(k)) {
                operatorGroupKeys.push(k);
            }
        }
        operatorGroupKeys.sort();
        var result = [];
        var len = operatorGroupKeys.length;
        for (i = 0; i < len; i++) {
            var operatorGroupName = operatorGroupKeys[i];
            var groupNodes = operatorGroups[operatorGroupName];
            result.push(this.getOperatorTree(operatorGroupName, groupNodes));

        }
        return result;
    },

    getOperatorTree: function (operatorGroupName, groups) {
        var groupKeys = [];
        for (k in groups) {
            if (groups.hasOwnProperty(k)) {
                groupKeys.push(k);
            }
        }

        groupKeys.sort();

        var len = groupKeys.length;

        var groupNodes = [];

        for (i = 0; i < len; i++) {
            var k = groupKeys[i];
            var childs = groups[k];
            childs.sort(
                function (x, y) {
                    return x.text < y.text ? -1 : 1;
                }
            );

            var groupNode = {
                iconCls: 'pimcore_icon_folder',
                text: t(k),
                allowDrag: false,
                allowDrop: false,
                leaf: false,
                expanded: true,
                children: childs
            };

            groupNodes.push(groupNode);
        }

        var tree = new Ext.tree.TreePanel({
            title: t('operator_group_' + operatorGroupName),
            iconCls: 'pimcore_icon_gridconfig_operator_' + operatorGroupName,
            xtype: "treepanel",
            region: "south",
            autoScroll: true,
            layout: 'fit',
            rootVisible: false,
            resizeable: true,
            split: true,
            viewConfig: {
                plugins: {
                    ptype: 'treeviewdragdrop',
                    ddGroup: "columnconfigelement",
                    enableDrag: true,
                    enableDrop: false
                }
            },
            root: {
                id: "0",
                root: true,
                text: t("base"),
                draggable: false,
                leaf: false,
                isTarget: false,
                children: groupNodes
            }
        });

        tree.addListener("itemdblclick", function (tree, record, item, index, e, eOpts) {
            var attr = record.data;
            if (record.data.configAttributes) {
                attr = record.data.configAttributes;
            }
            var elementConfig = {
                "isOperator": true,
                "attributes": attr
            }

            var element = this.getConfigElement(elementConfig);
            var copy = element.getCopyNode(record);
            var addedNode = this.selectionPanel.getRootNode().appendChild(copy);
            this.openConfigDialog(element, addedNode);
        }.bind(this));

        return tree;
    },

    getConfigElement: function (configAttributes) {
        var element = null;
        var attributes = configAttributes.attributes;
        if (attributes && attributes.class && attributes.type) {
            var jsClass = attributes.class.toLowerCase();
            if (pimcore.plugin.datahub[this.type + attributes.type] && pimcore.plugin.datahub[this.type + attributes.type][jsClass]) {
                element = new pimcore.plugin.datahub[this.type + attributes.type][jsClass](this.generalConfig.classId);
            }
        } else {
            var dataType = configAttributes.dataType ? configAttributes.dataType.toLowerCase() : null;
            if (pimcore.plugin.datahub[this.type + "value"] && pimcore.plugin.datahub[this.type + "value"][dataType]) {
                element = new pimcore.plugin.datahub[this.type + "value"][dataType](this.generalConfig.classId);
            } else {
                element = new pimcore.plugin.datahub[this.type + "value"]["defaultvalue"](this.generalConfig.classId);
            }
        }
        return element;
    },

    checkSupported: function (record) {
        if (record.data.type == "data") {
            var dataType = record.data.dataType;
            if (dataType != "system" && !in_array(dataType, pimcore.plugin.datahub.graphql["supported" + ucfirst(this.type) + "DataTypes"])) {
                Ext.MessageBox.alert(t("error"), sprintf(t("plugin_pimcore_datahub_" + this.type) + " " + t('plugin_pimcore_datahub_datatype_not_supported_yet'), dataType));
                return false;
            }
        }
        return true;
    }
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.Abstract");

pimcore.plugin.datahub.Abstract = Class.create({
    type: null,
    class: null,
    objectClassId: null,
    allowedTypes: null,
    allowedParents: null,
    maxChildCount: null,

    initialize: function(classId) {
        this.objectClassId = classId;
    },

    getBaseTranslationKey: function () {
        var prefix = 'operator';

        if (this.mode == "mutation") {
            prefix = "mutation" + prefix;
        }

        return (
            this.type + "_" + this.defaultText.toLowerCase().replace(' ', '_'),
            prefix + "_" + this.defaultText.toLowerCase().replace(' ', '_')
        );
    },

    getDefaultText: function () {
        return t(this.getBaseTranslationKey());
    },

    getConfigTreeNode: function(configAttributes) {
        return {};
    },


    getCopyNode: function(source) {
        var copy = new Ext.tree.TreeNode({
            text: source.data.text,
            isTarget: true,
            leaf: true,
            configAttributes: {
                label: null,
                type: this.type,
                class: this.class
            }
        });
        return copy;
    },


    getConfigDialog: function(node, params) {
    },

    commitData: function() {
        this.window.close();
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.mutationvalue.defaultvalue");

pimcore.plugin.datahub.mutationvalue.defaultvalue = Class.create(pimcore.plugin.datahub.Abstract, {

    type: "value",
    class: "DefaultValue",

    getConfigTreeNode: function(configAttributes) {
        var node = {
            draggable: true,
            iconCls: "pimcore_icon_" + configAttributes.dataType,
            text: configAttributes.label,
            configAttributes: configAttributes,
            isTarget: true,
            leaf: true
        };

        return node;
    },

    getCopyNode: function(source) {

        var copy = source.createNode({
            iconCls: source.data.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: true,
            dataType: source.data.dataType,
            qtip: source.data.key,
            configAttributes: {
                label: source.data.text,
                type: this.type,
                class: this.class,
                attribute: source.data.key,
                dataType: source.data.dataType
            }
        });
        return copy;
    },

    getConfigDialog: function(node, params) {
        return null;
    },

    commitData: function(params) {
        if(this.radiogroup.getValue().rb == "custom") {
            this.node.data.configAttributes.label = this.textfield.getValue();
            this.node.set('text', this.textfield.getValue());
        } else {
            this.node.data.configAttributes.label = this.node.get('text');
        }
        this.window.close();
        if (params && params.callback) {
            params.callback();
        }
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.queryvalue.defaultvalue");

pimcore.plugin.datahub.queryvalue.defaultvalue = Class.create(pimcore.plugin.datahub.Abstract, {

    type: "value",
    class: "DefaultValue",

    getConfigTreeNode: function(configAttributes) {
        var node = {
            draggable: true,
            iconCls: "pimcore_icon_" + configAttributes.dataType,
            text: configAttributes.label,
            configAttributes: configAttributes,
            isTarget: true,
            leaf: true
        };

        return node;
    },

    getCopyNode: function(source) {

        var copy = source.createNode({
            iconCls: source.data.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: true,
            dataType: source.data.dataType,
            qtip: source.data.key,
            configAttributes: {
                label: source.data.text,
                type: this.type,
                class: this.class,
                attribute: source.data.key,
                dataType: source.data.dataType
            }
        });
        return copy;
    },

    getConfigDialog: function(node, params) {
        return null;
    },

    commitData: function(params) {
        if(this.radiogroup.getValue().rb == "custom") {
            this.node.data.configAttributes.label = this.textfield.getValue();
            this.node.set('text', this.textfield.getValue());
        } else {
            this.node.data.configAttributes.label = this.node.get('text');
        }
        this.window.close();
        if (params && params.callback) {
            params.callback();
        }
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.queryoperator.alias");

pimcore.plugin.datahub.queryoperator.alias = Class.create(pimcore.plugin.datahub.Abstract, {
    operatorGroup: "other",
    type: "operator",
    class: "Alias",
    iconCls: "plugin_pimcore_datahub_icon_alias",
    defaultText: "Alias",

    getConfigTreeNode: function(configAttributes) {
        if(configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.label ? configAttributes.label : this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                expanded: true,
                leaf: false,
                expandable: false,
                allowChildren: true,
                isChildAllowed: this.allowChild
            };
        } else {

            //For building up operator list
            var configAttributes = { type: this.type, class: this.class, label: this.getDefaultText()};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true,
                isChildAllowed: this.allowChild
            };
        }
        node.isOperator = true;
        return node;
    },


    getCopyNode: function(source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: false,
            expanded: true,
            isOperator: true,
            isChildAllowed: this.allowChild,
            configAttributes: {
                label: source.data.configAttributes.label,
                type: this.type,
                class: this.class
            }
        });
        return copy;
    },


    getConfigDialog: function(node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('attribute'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 350,
            modal: true,
            title: t('settings'),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function(params) {
        this.node.set('isOperator', true);
        this.node.data.configAttributes.label = this.textField.getValue();
        this.node.set('text', this.textField.getValue());
        this.window.close();

        if (params && params.callback) {
            params.callback();
        }
    },

    allowChild: function (targetNode, dropNode) {
        if (targetNode.childNodes.length > 0) {
            return false;
        }
        return true;
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.queryoperator.concatenator");

pimcore.plugin.datahub.queryoperator.concatenator = Class.create(pimcore.plugin.datahub.Abstract, {
    operatorGroup: "transformer",
    type: "operator",
    class: "Concatenator",
    iconCls: "pimcore_icon_operator_concatenator",
    defaultText: "Concatenator",

    getConfigTreeNode: function(configAttributes) {
        if(configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.label,
                configAttributes: configAttributes,
                isTarget: true,
                allowChildren: true,
                expanded: true,
                leaf: false,
                expandable: false
            };
        } else {

            //For building up operator list
            var configAttributes = { type: this.type, class: this.class};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true
            };
        }
        node.isOperator = true;
        return node;
    },


    getCopyNode: function(source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: false,
            expandable: false,
            isOperator: true,
            configAttributes: {
                label: source.data.text,
                type: this.type,
                class: this.class
            }
        });

        return copy;
    },


    getConfigDialog: function(node, params) {
        this.node = node;

        this.textfield = new Ext.form.TextField({
            fieldLabel: t('label'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        this.glue = new Ext.form.TextField({
            fieldLabel: t('glue'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.glue
        });


        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textfield, this.glue],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 200,
            modal: true,
            title: this.getDefaultText(),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function(params) {
        this.node.data.configAttributes.label = this.textfield.getValue();
        this.node.set('text', this.textfield.getValue());
        this.node.set('isOperator', true);
        this.node.data.configAttributes.glue = this.glue.getValue();
        this.window.close();

        if (params && params.callback) {
            params.callback();
        }
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.queryoperator.dateformatter");

pimcore.plugin.datahub.queryoperator.dateformatter = Class.create(pimcore.plugin.datahub.Abstract, {

    operatorGroup: "formatter",
    type: "operator",
    class: "DateFormatter",
    iconCls: "pimcore_icon_datetime",
    defaultText: "DateFormatter",
    group: "other",

    getConfigTreeNode: function (configAttributes) {
        if (configAttributes) {
            var nodeLabel = this.getNodeLabel(configAttributes);
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: nodeLabel,
                configAttributes: configAttributes,
                isTarget: true,
                maxChildCount: 1,
                expanded: true,
                leaf: false,
                expandable: false,
                isChildAllowed: this.allowChild
            };
        } else {

            //For building up operator list
            var configAttributes = {type: this.type, class: this.class, label: this.getDefaultText()};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                maxChildCount: 1,
                leaf: true,
                isChildAllowed: this.allowChild
            };
        }
        node.isOperator = true;
        return node;
    },

    getCopyNode: function (source) {

        var copy = source.createNode({
            iconCls: source.data.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: false,
            expandable: false,
            dataType: source.data.dataType,
            qtip: source.data.key,
            configAttributes: {
                label: source.data.text,
                type: this.type,
                class: this.class,
                attribute: source.data.key,
                dataType: source.data.dataType
            }
        });
        return copy;
    },

    getConfigDialog: function (node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('label'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        this.formatField = new Ext.form.TextField({
            label_width: 200,
            fieldLabel: t('date_format'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.format
        });

        var helpButton = new Ext.Button({
            text: t("help"),
            handler: function () {
                window.open("http://php.net/manual/en/function.date.php");
            },
            iconCls: "pimcore_icon_help"
        });


        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField, this.formatField, helpButton],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 500,
            height: 250,
            modal: true,
            title: t('settings'),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function (params) {
        this.node.data.configAttributes.label = this.textField.getValue();
        this.node.data.configAttributes.format = this.formatField.getValue();
        this.node.set('isOperator', true);
        this.window.close();

        if (params && params.callback) {
            params.callback();
        }
    },

    getNodeLabel: function (configAttributes) {
        var nodeLabel = configAttributes.label ? configAttributes.label : this.getDefaultText();
        if (configAttributes.format) {
            nodeLabel += '<span class="pimcore_gridnode_hint"> (' + configAttributes.format + ')</span>';
        }

        return nodeLabel;
    },

    allowChild: function (targetNode, dropNode) {
        if (targetNode.childNodes.length > 0) {
            return false;
        }
        return true;
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.queryoperator.elementcounter");

pimcore.plugin.datahub.queryoperator.elementcounter = Class.create(pimcore.plugin.datahub.Abstract, {
    operatorGroup: "transformer",
    type: "operator",
    class: "ElementCounter",
    iconCls: "pimcore_icon_operator_elementcounter",
    defaultText: "Element Counter",

    getConfigTreeNode: function(configAttributes) {
        if(configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.label,
                configAttributes: configAttributes,
                isTarget: true,
                allowChildren: true,
                expanded: true,
                leaf: false,
                expandable: false
            };
        } else {

            //For building up operator list
            var configAttributes = { type: this.type, class: this.class};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true
            };
        }
        node.isOperator = true;
        return node;
    },


    getCopyNode: function(source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: false,
            expandable: false,
            isOperator: true,
            configAttributes: {
                label: source.data.text,
                type: this.type,
                class: this.class
            }
        });

        return copy;
    },


    getConfigDialog: function(node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('label'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        this.countEmptyField = new Ext.form.Checkbox({
            fieldLabel: t('count_empty'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.countEmpty
        });


        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField, this.countEmptyField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 200,
            modal: true,
            title: t('settings'),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function(params) {
        this.node.data.configAttributes.label = this.textField.getValue();
        this.node.data.configAttributes.countEmpty = this.countEmptyField.getValue();
        this.node.set('text', this.textField.getValue());
        this.node.set('isOperator', true);
        this.window.close();

        if (params && params.callback) {
            params.callback();
        }
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.queryoperator.text");

pimcore.plugin.datahub.queryoperator.text = Class.create(pimcore.plugin.datahub.Abstract, {
    operatorGroup: "formatter",
    type: "operator",
    class: "Text",
    iconCls: "pimcore_icon_operator_text",
    defaultText: "Text",
    group: "string",


    getConfigTreeNode: function(configAttributes) {
        if(configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.textValue,
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true
            };
        } else {

            //For building up operator list
            var configAttributes = { type: this.type, class: this.class};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true
            };
        }
        node.isOperator = true;
        return node;
    },


    getCopyNode: function(source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: true,
            isOperator: true,
            configAttributes: {
                label: null,
                type: this.type,
                class: this.class
            }
        });

        return copy;
    },


    getConfigDialog: function(node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('text'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.textValue
        });

        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 160,
            modal: true,
            title: this.getDefaultText(),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function(params) {
        this.node.data.configAttributes.textValue = this.textField.getValue();
        this.node.data.configAttributes.label = this.textField.getValue();
        this.node.set('text', this.textField.getValue());
        this.node.set('isOperator', true);
        this.window.close();
        if (params && params.callback) {
            params.callback();
        }
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.queryoperator.merge");

pimcore.plugin.datahub.queryoperator.merge = Class.create(pimcore.plugin.datahub.Abstract, {
    type: "operator",
    class: "Merge",
    iconCls: "pimcore_icon_operator_merge",
    defaultText: "Merge",
    group: "other",

    getConfigTreeNode: function(configAttributes) {
        if(configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.label ? configAttributes.label : this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                expanded: true,
                leaf: false,
                expandable: false,
                allowChildren: true,
            };
        } else {

            //For building up operator list
            var configAttributes = { type: this.type, class: this.class, label: this.getDefaultText()};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true
            };
        }
        node.isOperator = true;
        return node;
    },


    getCopyNode: function(source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.cssClass,
            isTarget: true,
            leaf: false,
            expanded: true,
            isOperator: true,
            configAttributes: {
                label: source.data.configAttributes.label,
                type: this.type,
                class: this.class
            }
        });
        return copy;
    },


    getConfigDialog: function(node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('label'),
            labelWidth: 200,
            value: this.node.data.configAttributes.label
        });

        this.flattenField = new Ext.form.Checkbox({
            fieldLabel: t('flatten'),
            labelWidth: 200,
            value: this.node.data.configAttributes.flatten,
            hidden: true
        });

        this.uniqueField = new Ext.form.Checkbox({
            fieldLabel: t('unique'),
            labelWidth: 200,
            value: this.node.data.configAttributes.unique
        });


        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField, this.flattenField, this.uniqueField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 350,
            modal: true,
            title: this.getDefaultText(),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function(params) {
        this.node.set('isOperator', true);
        this.node.data.configAttributes.label = this.textField.getValue();
        this.node.data.configAttributes.flatten = this.flattenField.getValue();
        this.node.data.configAttributes.unique = this.uniqueField.getValue();
        this.node.set('text', this.textField.getValue());
        this.window.close();

        if (params && params.callback) {
            params.callback();
        }
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.queryoperator.substring");

pimcore.plugin.datahub.queryoperator.substring = Class.create(pimcore.plugin.datahub.Abstract, {
    operatorGroup: "transformer",
    type: "operator",
    class: "Substring",
    iconCls: "pimcore_icon_operator_substring",
    defaultText: "Substring",
    group: "string",

    getConfigTreeNode: function(configAttributes) {
        if(configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.label ? configAttributes.label : this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                expanded: true,
                leaf: false,
                expandable: false,
                allowChildren: true,
                isChildAllowed: this.allowChild
            };
        } else {

            //For building up operator list
            var configAttributes = { type: this.type, class: this.class, label: this.getDefaultText()};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true,
                isChildAllowed: this.allowChild
            };
        }
        node.isOperator = true;
        return node;
    },


    getCopyNode: function(source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: false,
            expanded: true,
            isOperator: true,
            isChildAllowed: this.allowChild,
            configAttributes: {
                label: source.data.configAttributes.label,
                type: this.type,
                class: this.class
            }
        });
        return copy;
    },


    getConfigDialog: function(node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('plugin_pimcore_datahub_fieldName'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        this.startField = new Ext.form.NumberField({
            fieldLabel: t('start'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.start,
            minValue: 0
        });

        this.lengthField = new Ext.form.NumberField({
            fieldLabel: t('length'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.length
        });


        this.ellipsesField = new Ext.form.Checkbox({
            fieldLabel: t('ellipses'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.ellipses
        });


        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField, this.startField, this.lengthField, this.ellipsesField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 350,
            modal: true,
            title: t('operator_substring_settings'),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function(params) {
        this.node.set('isOperator', true);
        this.node.data.configAttributes.start = this.startField.getValue();
        this.node.data.configAttributes.length = this.lengthField.getValue();
        this.node.data.configAttributes.ellipses = this.ellipsesField.getValue();
        this.node.data.configAttributes.label = this.textField.getValue().replace(/ /g,"_");
        this.node.set('text', this.textField.getValue());
        this.window.close();
        if (params && params.callback) {
            params.callback();
        }
    },

    allowChild: function (targetNode, dropNode) {
        if (targetNode.childNodes.length > 0) {
            return false;
        }
        return true;
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.queryoperator.thumbnail");

pimcore.plugin.datahub.queryoperator.thumbnail = Class.create(pimcore.plugin.datahub.Abstract, {
    operatorGroup: "transformer",
    type: "operator",
    class: "Thumbnail",
    iconCls: "pimcore_icon_thumbnails",
    defaultText: "Thumbnail",

    getConfigTreeNode: function(configAttributes) {
        if(configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.label ? configAttributes.label : this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                expanded: true,
                leaf: false,
                expandable: false,
                allowChildren: true,
                isChildAllowed: this.allowChild
            };
        } else {

            //For building up operator list
            var configAttributes = { type: this.type, class: this.class, label: this.getDefaultText()};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true,
                isChildAllowed: this.allowChild
            };
        }
        node.isOperator = true;
        return node;
    },


    getCopyNode: function(source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: false,
            expanded: true,
            isOperator: true,
            isChildAllowed: this.allowChild,
            configAttributes: {
                label: source.data.configAttributes.label,
                type: this.type,
                class: this.class
            }
        });
        return copy;
    },


    getConfigDialog: function(node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('attribute'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });


        this.thumbnailConfigField = new Ext.form.ComboBox({
            width: 500,
            autoSelect: true,
            valueField: "id",
            displayField: "id",
            value: this.node.data.configAttributes.thumbnailConfig,
            fieldLabel: t("thumbnail"),
            store: new Ext.data.Store({
                autoDestroy: true,
                autoLoad: true,
                proxy: {
                    type: 'ajax',
                    url: '/admin/pimcoredatahub/config/thumbnail-tree',
                    reader: {
                        type: 'json'
                    }
                },
                listeners: {
                    load: function() {
                        this.thumbnailConfigField.setValue(this.node.data.configAttributes.thumbnailConfig);
                    }.bind(this)
                },
                fields: ['id']
            }),
            triggerAction: "all"
        });

        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField, this.thumbnailConfigField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 350,
            modal: true,
            title: t('settings'),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function(params) {
        this.node.set('isOperator', true);
        this.node.data.configAttributes.label = this.textField.getValue();
        this.node.data.configAttributes.thumbnailConfig = this.thumbnailConfigField.getValue();
        this.window.close();

        if (params && params.callback) {
            params.callback();
        }
    },

    allowChild: function (targetNode, dropNode) {
        if (targetNode.childNodes.length > 0) {
            return false;
        }
        return true;
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.queryoperator.thumbnailhtml");

pimcore.plugin.datahub.queryoperator.thumbnailhtml = Class.create(pimcore.plugin.datahub.Abstract, {
    operatorGroup: "transformer",
    type: "operator",
    class: "ThumbnailHtml",
    iconCls: "pimcore_icon_thumbnails",
    defaultText: "Thumbnail HTML",
    group: "other",

    getConfigTreeNode: function(configAttributes) {
        if (configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.label ? configAttributes.label : this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                expanded: true,
                leaf: false,
                expandable: false,
                allowChildren: true,
                isChildAllowed: this.allowChild
            };
        } else {
            //For building up operator list
            var configAttributes = { type: this.type, class: this.class, label: this.getDefaultText() };

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true,
                isChildAllowed: this.allowChild
            };
        }
        node.isOperator = true;

        return node;
    },

    getCopyNode: function(source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: false,
            expanded: true,
            isOperator: true,
            isChildAllowed: this.allowChild,
            configAttributes: {
                label: source.data.configAttributes.label,
                type: this.type,
                class: this.class
            }
        });

        return copy;
    },

    getConfigDialog: function(node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('attribute'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        this.thumbnailHtmlConfigField = new Ext.form.ComboBox({
            width: 500,
            autoSelect: true,
            valueField: "id",
            displayField: "id",
            value: this.node.data.configAttributes.thumbnailHtmlConfig,
            fieldLabel: t("thumbnail"),
            store: new Ext.data.Store({
                autoDestroy: true,
                autoLoad: true,
                proxy: {
                    type: 'ajax',
                    url: '/admin/settings/thumbnail-tree',
                    reader: {
                        type: 'json'
                    }
                },
                listeners: {
                    load: function() {
                        this.thumbnailHtmlConfigField.setValue(this.node.data.configAttributes.thumbnailHtmlConfig);
                    }.bind(this)
                },
                fields: ['id']
            }),
            triggerAction: "all"
        });

        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField, this.thumbnailHtmlConfigField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 350,
            modal: true,
            title: t('settings'),
            layout: "fit",
            items: [this.configPanel]
        });
        this.window.show();

        return this.window;
    },

    commitData: function(params) {
        this.node.set('isOperator', true);
        this.node.data.configAttributes.label = this.textField.getValue();
        this.node.data.configAttributes.thumbnailHtmlConfig = this.thumbnailHtmlConfigField.getValue();
        this.window.close();

        if (params && params.callback) {
            params.callback();
        }
    },

    allowChild: function (targetNode, dropNode) {
        if (targetNode.childNodes.length > 0) {
            return false;
        }

        return true;
    }
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.queryoperator.translatevalue");

pimcore.plugin.datahub.queryoperator.translatevalue = Class.create(pimcore.plugin.datahub.Abstract, {
    operatorGroup: "transformer",
    type: "operator",
    class: "TranslateValue",
    iconCls: "pimcore_icon_localizedfields",
    defaultText: "Translate Value",
    group: "string",


    getConfigTreeNode: function(configAttributes) {
        if(configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.label ? configAttributes.label : this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                maxChildCount: 1,
                expanded: true,
                leaf: false,
                expandable: false
            };
        } else {
            //For building up operator list
            var configAttributes = { type: this.type, class: this.class, label: this.getDefaultText()};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                maxChildCount: 1,
                leaf: true
            };
        }
        node.isOperator = true;
        return node;
    },


    getCopyNode: function(source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.cssClass,
            isTarget: true,
            leaf: false,
            maxChildCount: 1,
            expanded: true,
            expandable: false,
            isOperator: true,
            configAttributes: {
                label: source.data.configAttributes.label,
                type: this.type,
                class: this.class
            }
        });
        return copy;
    },


    getConfigDialog: function(node, params) {
        this.node = node;

        this.textfield = new Ext.form.TextField({
            fieldLabel: t('label'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        this.prefix = new Ext.form.TextField({
            fieldLabel: t('prefix'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.prefix
        });



        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textfield, this.prefix],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 350,
            modal: true,
            title: t('settings'),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function(params) {
        this.node.data.configAttributes.label = this.textfield.getValue();
        this.node.data.configAttributes.prefix = this.prefix.getValue();
        this.node.set('text', this.textfield.getValue());
        this.node.set('isOperator', true);
        this.window.close();
        if (params && params.callback) {
            params.callback();
        }
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.queryoperator.trimmer");

pimcore.plugin.datahub.queryoperator.trimmer = Class.create(pimcore.plugin.datahub.Abstract, {
    operatorGroup: "transformer",
    type: "operator",
    class: "Trimmer",
    iconCls: "pimcore_icon_operator_trimmer",
    defaultText: "Trimmer",
    group: "string",

    getConfigTreeNode: function (configAttributes) {
        if (configAttributes) {
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: configAttributes.label,
                configAttributes: configAttributes,
                isTarget: true,
                allowChildren: true,
                expanded: true,
                leaf: false,
                expandable: false,
                isChildAllowed: this.allowChild
            };
        } else {

            //For building up operator list
            var configAttributes = {type: this.type, class: this.class, trim: 0};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true,
                isChildAllowed: this.allowChild
            };
        }
        node.isOperator = true;
        return node;
    },


    getCopyNode: function (source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: false,
            expandable: false,
            isOperator: true,
            configAttributes: {
                label: source.data.text,
                type: this.type,
                class: this.class

            },
            isChildAllowed: this.allowChild
        });

        return copy;
    },


    getConfigDialog: function (node, params) {
        this.node = node;

        this.textfield = new Ext.form.TextField({
            fieldLabel: t('label'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        var trim = this.node.data.configAttributes.trim;

        this.trimField = new Ext.form.RadioGroup({
            xtype: 'radiogroup',
            fieldLabel: t('trim'),
            border: true,
            columns: 1,
            vertical: true,
            items: [
                {boxLabel: t('left'), name: 'rb', inputValue: '1', checked: trim == 1},
                {boxLabel: t('right'), name: 'rb', inputValue: '2', checked: trim == 2},
                {boxLabel: t('both'), name: 'rb', inputValue: '2', checked: trim == 3},
                {boxLabel: t('disabled'), name: 'rb', inputValue: '0', checked: isNaN(trim) || trim == 0}
            ]
        });

        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textfield, this.trimField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 300,
            modal: true,
            title: t('settings'),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();
        return this.window;
    },

    commitData: function (params) {
        this.node.data.configAttributes.label = this.textfield.getValue();
        this.node.set('text', this.textfield.getValue());
        this.node.set('isOperator', true);

        this.node.data.configAttributes.trim = parseInt(this.trimField.getValue().rb);
        this.window.close();
        if (params && params.callback) {
            params.callback();
        }
    },

    allowChild: function (targetNode, dropNode) {
        if (targetNode.childNodes.length > 0) {
            return false;
        }
        return true;
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.mutationoperator.mutationoperator");

pimcore.plugin.datahub.mutationoperator.mutationoperator = Class.create(pimcore.plugin.datahub.Abstract, {
    type: "operator",
    class: null,
    iconCls: null,
    defaultText: null,
    hasTooltip: false,
    group: null,
    mode: "mutation",

    getConfigTreeNode: function (configAttributes) {
        if (configAttributes) {
            var nodeLabel = this.getNodeLabel(configAttributes);
            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: nodeLabel,
                configAttributes: configAttributes,
                isTarget: true,
                isChildAllowed: this.allowChild,
                expanded: true,
                leaf: false,
                expandable: false
            };
        } else {
            // For building up operator list in left-panel
            var configAttributes = {type: this.type, class: this.class};

            var node = {
                draggable: true,
                iconCls: this.iconCls,
                text: this.getDefaultText(),
                configAttributes: configAttributes,
                isTarget: true,
                leaf: true,
                isChildAllowed: this.allowChild
            };

            if (this.hasTooltip) {
                node.qtip = t(this.getBaseTranslationKey() + '_description');
            }
        }

        node.isOperator = true;

        return node;
    },

    getCopyNode: function (source) {
        var copy = source.createNode({
            iconCls: this.iconCls,
            text: source.data.text,
            isTarget: true,
            leaf: false,
            expandable: false,
            isOperator: true,
            isChildAllowed: this.allowChild,
            configAttributes: {
                label: source.data.text,
                type: this.type,
                class: this.class
            }
        });

        return copy;
    },

    getConfigDialog: function (node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('label'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 200,
            modal: true,
            title: this.getDefaultText(),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();

        return this.window;
    },

    commitData: function (params) {
        this.node.data.configAttributes.label = this.textField.getValue();

        var nodeLabel = this.getNodeLabel(this.node.data.configAttributes);
        this.node.set('text', nodeLabel);
        this.node.set('isOperator', true);
        this.window.close();

        if (params && params.callback) {
            params.callback();
        }
    },

    allowChild: function (targetNode, dropNode) {
        return !targetNode.childNodes.length > 0;
    },

    getNodeLabel: function (configAttributes) {
        return configAttributes.label;
    }
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.mutationoperator.ifempty");

pimcore.plugin.datahub.mutationoperator.ifempty = Class.create(pimcore.plugin.datahub.mutationoperator.mutationoperator, {
    class: "IfEmpty",
    iconCls: "plugin_pimcore_datahub_icon_ifempty",
    defaultText: "IfEmpty",
    group: "other",
    hasTooltip: true
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.mutationoperator.localeswitcher");

pimcore.plugin.datahub.mutationoperator.localeswitcher = Class.create(pimcore.plugin.datahub.mutationoperator.mutationoperator, {
    class: "LocaleSwitcher",
    iconCls: "pimcore_icon_operator_localeswitcher",
    defaultText: "Locale Switcher",
    group: "other",
    hasTooltip: true,

    getConfigDialog: function (node, params) {
        this.node = node;

        this.textField = new Ext.form.TextField({
            fieldLabel: t('label'),
            length: 255,
            width: 200,
            value: this.node.data.configAttributes.label
        });

        var data = [];
        for (var i = 0; i < pimcore.settings.websiteLanguages.length; i++) {
            var language = pimcore.settings.websiteLanguages[i];
            data.push([language, t(pimcore.available_languages[language])]);
        }

        var store = new Ext.data.ArrayStore({
                fields: ["key", "value"],
                data: data
            }
        );

        var options = {
            fieldLabel: t('locale'),
            triggerAction: "all",
            editable: true,
            selectOnFocus: true,
            queryMode: 'local',
            typeAhead: true,
            forceSelection: true,
            store: store,
            componentCls: "object_field",
            mode: "local",
            width: 200,
            padding: 10,
            displayField: "value",
            valueField: "key",
            value: this.node.data.configAttributes.locale
        };

        this.localeField = new Ext.form.ComboBox(options);

        this.configPanel = new Ext.Panel({
            layout: "form",
            bodyStyle: "padding: 10px;",
            items: [this.textField, this.localeField],
            buttons: [{
                text: t("apply"),
                iconCls: "pimcore_icon_apply",
                handler: function () {
                    this.commitData(params);
                }.bind(this)
            }]
        });

        this.window = new Ext.Window({
            width: 400,
            height: 200,
            modal: true,
            title: this.getDefaultText(),
            layout: "fit",
            items: [this.configPanel]
        });

        this.window.show();

        return this.window;
    },

    commitData: function ($super, params) {
        this.node.data.configAttributes.locale = this.localeField.getValue();

        $super(params);
    },

    getNodeLabel: function(configAttributes) {
        var nodeLabel = configAttributes.label;

        if (configAttributes.locale) {
            nodeLabel += '<span class="pimcore_gridnode_hint"> (' + configAttributes.locale + ')</span>';
        }

        return nodeLabel;
    }
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Object
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.mutationoperator.localecollector");

pimcore.plugin.datahub.mutationoperator.localecollector = Class.create(pimcore.plugin.datahub.mutationoperator.mutationoperator, {
    class: "LocaleCollector",
    iconCls: "plugin_pimcore_datahub_icon_localecollector",
    defaultText: "Locale Collector",
    group: "other",
    hasTooltip: true,

    allowChild: function (targetNode, dropNode) {
        return (
            !targetNode.childNodes.length > 0
            && in_array(dropNode.data.dataType, [
                "booleanSelect",
                "checkbox",
                "country",
                "countrymultiselect",
                "date",
                "datetime",
                "email",
                "externalImage",
                "geopoint",
                "firstname",
                "gender",
                "input",
                "image",
                "language",
                "lastname",
                "newsletterActive",
                "manyToOneRelation",
                "multiselect",
                "newsletterConfirmed",
                "numeric",
                "select",
                "slider",
                "textarea",
                "time",
                "wysiwyg"
            ])
        );
    }
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.workspace.abstract");
pimcore.plugin.datahub.workspace.abstract = Class.create({

    availableRights : ["create", "read","update", "delete"],

    initialize: function (parent) {
        this.parent = parent;
        this.workspaces = this.parent.data.workspaces;
    },

    getPanel: function () {

        var gridPlugins = [];
        var storeFields = ["cpath"];

        var typesColumns = [
            {text: t("path"), flex: 1, sortable: false, dataIndex: 'cpath',
                editor: new Ext.form.TextField({}),
                tdCls: "pimcore_property_droptarget",
                renderer: Ext.util.Format.htmlEncode
            }
        ];

        var check;
        for (var i=0; i<this.availableRights.length; i++) {

            var checkConfig = {
                text: t("plugin_pimcore_datahub_workspace_permission_" + this.availableRights[i]),
                dataIndex: this.availableRights[i],
                width: 70,
                hidden: this.rightCheckboxHidden || false,
                disabled: this. rightCheckboxDisabled || false
            };

            check = new Ext.grid.column.Check(checkConfig);

            typesColumns.push(check);
            gridPlugins.push(check);

            // store fields
            storeFields.push({name:this.availableRights[i], type: 'bool'});
        }

        typesColumns.push({
            xtype: 'actioncolumn',
            menuText: t('delete'),
            width: 40,
            items: [{
                tooltip: t('delete'),
                icon: "/bundles/pimcoreadmin/img/flat-color-icons/delete.svg",
                handler: function (grid, rowIndex) {
                    grid.getStore().removeAt(rowIndex);
                    this.updateRows();
                }.bind(this)
            }]
        });

        this.store = new Ext.data.JsonStore({
            autoDestroy: true,
            proxy: {
                type: 'memory',
                reader: {
                    rootProperty: this.type
                }
            },
            fields: storeFields,
            data: this.workspaces
        });

        this.cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
            clicksToEdit: 1
        });

        this.grid = Ext.create('Ext.grid.Panel', {
            frame: false,
            autoScroll: true,
            store: this.store,
            columns : typesColumns,
            trackMouseOver: true,
            columnLines: true,
            stripeRows: true,
            autoExpandColumn: "cpath",
            autoHeight: true,
            style: "margin-bottom:20px;",
            plugins: [
                this.cellEditing
            ],
            tbar: [
                {
                    xtype: "tbtext",
                    text: "<b>" + t(this.type + "s") + "</b>"
                },
                "-","-",
                {
                    iconCls: "pimcore_icon_add",
                    text: t("add"),
                    handler: this.onAdd.bind(this)
                }
            ],
            viewConfig: {
                forceFit: true,
                listeners: {
                    rowupdated: this.updateRows.bind(this),
                    refresh: this.updateRows.bind(this)
                }
            }
        });

        this.store.on("update", this.updateRows.bind(this));
        this.grid.on("viewready", this.updateRows.bind(this));


        return this.grid;
    },

    updateRows: function () {

        var rows = Ext.get(this.grid.getEl().dom).query(".x-grid-row");

        for (var i = 0; i < rows.length; i++) {

            var dd = new Ext.dd.DropZone(rows[i], {
                ddGroup: "element",

                getTargetFromEvent: function(e) {
                    return this.getEl();
                },

                onNodeOver : function(target, dd, e, data) {
                    if (data.records.length == 1 && data.records[0].data.elementType == this.type) {
                        return Ext.dd.DropZone.prototype.dropAllowed;
                    }
                }.bind(this),

                onNodeDrop : function(myRowIndex, target, dd, e, data) {
                    if (pimcore.helpers.dragAndDropValidateSingleItem(data)) {
                        try {
                            var record = data.records[0];
                            var data = record.data;

                            // check for duplicate records
                            var index = this.grid.getStore().findExact("cpath", data.path);
                            if (index >= 0) {
                                return false;
                            }

                            if (data.elementType != this.type) {
                                return false;
                            }

                            var rec = this.grid.getStore().getAt(myRowIndex);
                            rec.set("cpath", data.path);

                            this.updateRows();

                            return true;
                        } catch (e) {
                            console.log(e);
                        }
                    }
                }.bind(this, i)
            });
        }

    },

    onAdd: function (btn, ev) {
        this.grid.store.add({
            read: true,
            cpath: ""
        });

        this.updateRows();
    },

    getValues: function () {

        var values = [];
        this.store.commitChanges();

        var records = this.store.getRange();
        for (var i = 0; i < records.length; i++) {
            var currentData = records[i];
            if (currentData) {
                values.push(currentData.data);
            }
        }

        return values;
    }
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.workspace.document");
pimcore.plugin.datahub.workspace.document = Class.create(pimcore.plugin.datahub.workspace.abstract, {


    type: "document"

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.workspace.asset");
pimcore.plugin.datahub.workspace.asset = Class.create(pimcore.plugin.datahub.workspace.abstract, {


    type: "asset"

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


pimcore.registerNS("pimcore.plugin.datahub.workspace.object");
pimcore.plugin.datahub.workspace.object = Class.create(pimcore.plugin.datahub.workspace.abstract, {

    type: "object"
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.PimcoreDataImporterBundle");

pimcore.plugin.PimcoreDataImporterBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return 'pimcore.plugin.PimcoreDataImporterBundle';
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    }

});

var PimcoreDataImporterBundlePlugin = new pimcore.plugin.PimcoreDataImporterBundle();



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */


Ext.define('DataHub.DataImporter.SubSettingsComboBox', {
    extend: 'Ext.form.field.ComboBox',

    alias: ['widget.subsettingscombo'],

    mode: "local",
    editable: false,
    triggerAction: "all",

    // define namespace from with options should be loaded
    optionsNamespace: {},

    // define blacklist of types that should be ignored
    optionsBlackList: [],

    // panel where settings fields should be loaded into
    settingsPanel: {},

    // values for init settings fields
    settingsValues: {},

    // prefix for names of settings fields
    settingsNamePrefix: 'settings',

    // root container of config - can be used to fire and listen for events
    configItemRootContainer: null,

    // context for initializing sub settings - e.g. passing additional init values, etc.
    initContext: null,

    initComponent: function() {
        var me = this;

        var dataTypesStore = [];
        for(let optionType in me.optionsNamespace) {

            if(!this.optionsBlackList.includes(optionType)) {
                dataTypesStore.push([
                    optionType,
                    t('plugin_pimcore_datahub_data_importer_configpanel_' + this.name + '_' + optionType)
                ]);
            }

        }

        me.store = dataTypesStore;

        me.callParent();

        me.on('added', function(combo) {
            this.updateSettingsPanel(combo.getValue());
        }.bind(this));

        me.on('change', function(combo, newValue, oldValue) {
            this.updateSettingsPanel(newValue);
        }.bind(this));

    },

    updateSettingsPanel: function(optionType) {
        this.settingsPanel.removeAll();
        if(optionType) {
            const typeInstance = new this.optionsNamespace[optionType](
                this.settingsValues || {},
                this.settingsNamePrefix,
                this.configItemRootContainer,
                this.initContext
            );
            const subPanel = typeInstance.buildSettingsForm();
            if(subPanel) {
                this.settingsPanel.add(subPanel);
                subPanel.isValid();
            }
        }
    }

});


Ext.define('DataHub.DataImporter.StructuredValueForm', {
    extend: 'Ext.form.FormPanel',
    alias: ['widget.structuredvalueform'],
    getValues: function() {
        const me = this;
        const values = me.callParent();
        let nestedValues = {};

        for(let key in values) {

            //ignore all fields with name starting __ignore
            if(!key.startsWith('__ignore')) {
                let parts = key.split('.');

                let subLevel = nestedValues;
                let currentPath = '';

                parts.forEach(function(item) {

                    currentPath = currentPath + item;
                    if(values[currentPath] === undefined) {
                        subLevel[item] = subLevel[item] || {};
                    } else {
                        subLevel[item] = values[currentPath];
                    }
                    subLevel = subLevel[item];
                    currentPath = currentPath + '.';
                });
            }
        }

        return nestedValues;
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType = Class.create({

    type: 'abstract',
    data: {},
    dataNamePrefix: '',
    configItemRootContainer: null,
    initContext: null,

    initialize: function (data, dataNamePrefix, configItemRootContainer, initContext) {

        this.data = data;
        this.dataNamePrefix = dataNamePrefix + '.';
        this.configItemRootContainer = configItemRootContainer;
        this.initContext = initContext;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.datahub.adapter.dataImporterDataObject");
pimcore.plugin.datahub.adapter.dataImporterDataObject = Class.create(pimcore.plugin.datahub.adapter.graphql, {

    createConfigPanel: function(data) {
        let fieldPanel = new pimcore.plugin.pimcoreDataImporterBundle.configuration.configItemDataObject(data, this);
    },

    openConfiguration: function (id) {
        var existingPanel = Ext.getCmp("plugin_pimcore_datahub_configpanel_panel_" + id);
        if (existingPanel) {
            this.configPanel.editPanel.setActiveTab(existingPanel);
            return;
        }

        Ext.Ajax.request({
            url: Routing.generate('pimcore_dataimporter_configdataobject_get'),
            params: {
                name: id
            },
            success: function (response) {
                let data = Ext.decode(response.responseText);
                this.createConfigPanel(data);
                pimcore.layout.refresh();
            }.bind(this)
        });
    }
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.plugin.pimcoreDataImporterBundle.configuration.events = {

    /**
     * Fired when data object class changed
     *
     * arguments
     *  - combo
     *  - newValue
     *  - oldValue
     */
    classChanged: 'class_changed',

    /**
     * Fired when data object class combo is initialized
     *
     * arguments
     *  - combo
     *  - newValue
     *  - oldValue
     */
    classInit: 'class_init',

    /**
     * Fired when transformation result preview is updated
     *
     * arguments
     *  - transformationResultHandler (to load data from)
     *
     */
    transformationResultPreviewUpdated: 'transformation_result_preview_updated',


    /**
     * Fired when transformation result type changed
     *
     * arguments
     *   - newType
     */
    transformationResultTypeChanged: 'transformation_result_type_changed',

    /**
     * Fired when loader type changed
     *
     * arguments
     *   - newType
     */
    loaderTypeChanged: 'loader_type_changed',


    /**
     * Fired when dirty state of config changed
     *
     * arguments
     *   - dirty
     */
    configDirtyChanged: 'config_dirty_changed',

};


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.configItemDataObject');
pimcore.plugin.pimcoreDataImporterBundle.configuration.configItemDataObject = Class.create(pimcore.plugin.datahub.configuration.graphql.configItem, {

    urlSave: Routing.generate('pimcore_dataimporter_configdataobject_save'),

    getPanels: function () {
        return [
            this.buildGeneralTab(),
            this.buildDataSourceTab(),
            this.buildImportSettingsTab(),
            this.buildExecutionTab(),
            this.buildLoggerTab(),
            this.getPermissions()
        ];
    },

    initialize: function (data, parent) {
        //TODO make that more generic in datahub
        this.parent = parent;
        this.configName = data.name;
        this.data = data.configuration;
        this.userPermissions = data.userPermissions;
        this.modificationDate = data.modificationDate;

        /**
         * Set writeable to true, if it is undefined.
         * This is done because of backwards compatability to version 6.9-
         * Otherwise the save button would be disabled.
         */
        if (typeof this.data.general.writeable === 'undefined') {
            this.data.general.writeable = true;
        }

        this.tab = Ext.create('Ext.TabPanel', {
            title: this.data.general.name,
            closable: true,
            deferredRender: true,
            forceLayout: true,
            iconCls: "plugin_pimcore_datahub_icon_" + this.data.general.type,
            id: "plugin_pimcore_datahub_configpanel_panel_" + data.name,
            buttons: {
                componentCls: 'plugin_pimcore_datahub_statusbar',
                itemId: 'footer'
            },
            // items: this.getPanels()
        });

        this.tab.columnHeaderStore = Ext.create('Ext.data.Store', {
            fields: ['id', 'dataIndex', 'label'],
            data: data.columnHeaders,
            autoDestroy: false
        });

        this.tab.add(this.getPanels());
        this.tab.setActiveTab(0);

        this.tab.on("activate", this.tabactivated.bind(this));
        this.tab.on("destroy", this.tabdestroy.bind(this));
        this.tab.on('render', this.isValid.bind(this, false));
        this.setupChangeDetector();

        this.parent.configPanel.editPanel.add(this.tab);
        this.parent.configPanel.editPanel.setActiveTab(this.tab);
        this.parent.configPanel.editPanel.updateLayout();

        this.showInfo();
    },

    showInfo: function () {

        var footer = this.tab.getDockedComponent('footer');

        footer.removeAll();

        // this.queueCountInfo = Ext.create('Ext.form.field.Display', {
        //     labelWidth: 300,
        //     readOnly: false,
        //     disabled: false
        // });
        //
        // footer.add(this.queueCountInfo);
        footer.add('->');

        let saveButtonConfig = {
            text: t("save"),
            iconCls: "pimcore_icon_apply",
            disabled: !this.data.general.writeable || !this.userPermissions.update,
            handler: this.save.bind(this)
        };
        if(!this.data.general.writeable) {
            saveButtonConfig.tooltip = t("config_not_writeable");
        }
        footer.add(saveButtonConfig);

    },

    save: function () {
        //TODO make that more generic in datahub
        if (!this.isValid(true)) {
            pimcore.helpers.showNotification(t('error'), t('plugin_pimcore_datahub_data_importer_configpanel_invalid_config'), 'error');
            return;
        }

        var saveData = this.getSaveData();

        Ext.Ajax.request({
            url: this.urlSave,
            params: {
                data: saveData,
                modificationDate: this.modificationDate
            },
            method: "post",
            success: function (response) {
                var rdata = Ext.decode(response.responseText);
                if (rdata && rdata.success) {
                    this.modificationDate = rdata.modificationDate;
                    this.saveOnComplete();
                }
                else if(rdata && rdata.permissionError) {
                        pimcore.helpers.showNotification(t("error"), t("plugin_pimcore_datahub_configpanel_item_saveerror_permissions"), "error");
                        this.tab.setActiveTab(this.tab.items.length-1);
                } else {
                    pimcore.helpers.showNotification(t("error"), t("plugin_pimcore_datahub_configpanel_item_saveerror"), "error", t(rdata.message));
                }
            }.bind(this)
        });
    },


    buildGeneralTab: function () {
        this.generalForm = Ext.create('Ext.form.FormPanel', {
            bodyStyle: "padding:10px;",
            autoScroll: true,
            defaults: {
                labelWidth: 200,
                width: 600
            },
            border: false,
            title: t('plugin_pimcore_datahub_configpanel_item_general'),
            items: [
                {
                    xtype: "checkbox",
                    fieldLabel: t("active"),
                    name: "active",
                    inputValue: true,
                    value: this.data.general && this.data.general.hasOwnProperty("active") ? this.data.general.active : false
                },
                {
                    xtype: "textfield",
                    fieldLabel: t("type"),
                    name: "type",
                    value: t("plugin_pimcore_datahub_type_" + this.data.general.type),
                    readOnly: true
                },
                {
                    xtype: "textfield",
                    fieldLabel: t("name"),
                    name: "name",
                    value: this.data.general.name,
                    readOnly: true
                },
                {
                    name: "description",
                    fieldLabel: t("description"),
                    xtype: "textarea",
                    height: 100,
                    value: this.data.general.description
                },
                {
                    xtype: "textfield",
                    fieldLabel: t("group"),
                    name: "group",
                    value: this.data.general.group
                },
            ]
        });

        return this.generalForm;
    },

    buildDataSourceTab: function () {

        let loaderSettingsPanel = Ext.create('Ext.Panel', {
            width: 900
        });

        const defaults = {
            labelWidth: 200,
            width: 600,
            allowBlank: false,
            msgTarget: 'under'
        };

        this.loaderForm = Ext.create('DataHub.DataImporter.StructuredValueForm', {
            items: [
                {
                    xtype: "fieldset",
                    title: t('plugin_pimcore_datahub_data_importer_configpanel_datasource'),
                    defaults: defaults,
                    items: [
                        {
                            fieldLabel: t("plugin_pimcore_datahub_data_importer_configpanel_datasource_type"),
                            xtype: "subsettingscombo",
                            name: "type",
                            optionsNamespace: pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader,
                            settingsPanel: loaderSettingsPanel,
                            value: this.data.loaderConfig.type,
                            settingsValues: this.data.loaderConfig.settings,
                            initContext: {
                                configName: this.configName
                            },
                            listeners: {
                                change: function(combo, newValue, oldValue) {
                                    this.tab.fireEvent(
                                        pimcore.plugin.pimcoreDataImporterBundle.configuration.events.loaderTypeChanged,
                                        newValue
                                    );
                                }.bind(this)
                            }
                        },
                        loaderSettingsPanel
                    ]
                }
            ]
        });

        const interpreterSettingsPanel = Ext.create('Ext.Panel', {width: 900});


        this.interpreterForm = Ext.create('DataHub.DataImporter.StructuredValueForm', {
            items: [
                {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_data_importer_configpanel_file_format'),
                    defaults: defaults,
                    items: [
                        {
                            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_file_formats_type'),
                            xtype: 'subsettingscombo',
                            name: 'type',
                            optionsNamespace: pimcore.plugin.pimcoreDataImporterBundle.configuration.components.interpreter,
                            settingsPanel: interpreterSettingsPanel,
                            value: this.data.interpreterConfig.type,
                            settingsValues: this.data.interpreterConfig.settings
                        },
                        interpreterSettingsPanel,
                    ]
                }
            ]
        });


        return Ext.create('Ext.Panel', {
            bodyStyle: 'padding:10px;',
            autoScroll: true,
            border: false,
            title: t('plugin_pimcore_datahub_data_importer_configpanel_datasource'),
            items: [
                this.loaderForm,
                this.interpreterForm
            ]
        });

    },

    buildImportSettingsTab: function() {

        const transformationResultHandler = new pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.transformationResultHandler(this.configName, this, null);
        const importPreview = new pimcore.plugin.pimcoreDataImporterBundle.configuration.components.importPreview(this.configName, this, transformationResultHandler);
        this.importSettings = new pimcore.plugin.pimcoreDataImporterBundle.configuration.components.importSettings(this.data, this.tab, transformationResultHandler);


        return Ext.create('Ext.Panel', {
            title: t('plugin_pimcore_datahub_data_importer_configpanel_import_settings'),
            bodyStyle: 'padding:10px;',
            layout: 'border',
            items: [
                importPreview.buildImportPreviewPanel(),
                this.importSettings.buildImportSettingsPanel()
            ]
        });

    },

    buildExecutionTab: function() {
        const execution = new pimcore.plugin.pimcoreDataImporterBundle.configuration.components.execution(this.configName, this.data.executionConfig, this.tab, this.data.loaderConfig.type);
        this.executionForm = execution.buildPanel();
        return this.executionForm;
    },

    buildLoggerTab: function() {
        const loggerTab = new pimcore.plugin.pimcoreDataImporterBundle.configuration.components.logTab(this.configName);
        return loggerTab.getTabPanel();
    },

    updateColumnHeaders: function() {
        Ext.Ajax.request({
            url: Routing.generate('pimcore_dataimporter_configdataobject_loadavailablecolumnheaders'),
            method: 'POST',
            params: {
                config_name: this.configName,
                current_config: this.getSaveData()
            },
            success: function (response) {
                let data = Ext.decode(response.responseText);
                this.tab.columnHeaderStore.loadData(data.columnHeaders);
            }.bind(this)
        });
    },

    getSaveData: function () {
        let saveData = {};

        saveData['general'] = this.generalForm.getValues();
        saveData['loaderConfig'] = this.loaderForm.getValues();
        saveData['interpreterConfig'] = this.interpreterForm.getValues();
        saveData['resolverConfig'] = this.importSettings.getResolverConfig();
        saveData['processingConfig'] = this.importSettings.getProcessingConfig();
        saveData['mappingConfig'] = this.importSettings.getMappingConfig();
        saveData['executionConfig'] = this.executionForm.getValues();
        saveData['permissions'] = this.getPermissionsSaveData();

        return Ext.encode(saveData);
    },

    detectedChange: function ($super) {
        $super();
        if(this.tab) {
            this.tab.fireEvent(
                pimcore.plugin.pimcoreDataImporterBundle.configuration.events.configDirtyChanged,
                this.dirty
            );
        }
    },

    saveOnComplete: function () {
        this.parent.configPanel.tree.getStore().load({
            node: this.parent.configPanel.tree.getRootNode()
        });

        pimcore.helpers.showNotification(t("success"), t("plugin_pimcore_datahub_configpanel_item_save_success"), "success");

        this.resetChanges();
    },

    resetChanges: function ($super) {
        $super();

        if(this.tab && !this.dirty) {
            this.tab.fireEvent(
                pimcore.plugin.pimcoreDataImporterBundle.configuration.events.configDirtyChanged,
                this.dirty
            );
        }
    },

    isValid: function(expandPanels) {
        let isValid = this.generalForm.isValid();
        isValid = this.loaderForm.isValid() && isValid;
        if(!isValid) {
            console.log('Loader Form not valid.');
        }
        isValid = this.interpreterForm.isValid() && isValid;
        if(!isValid) {
            console.log('Interpreter Form not valid.');
        }
        isValid = this.executionForm.isValid() && isValid;
        if(!isValid) {
            console.log('Execution Form not valid.');
        }

        isValid = this.importSettings.isValid(expandPanels) && isValid;

        return isValid;
    }

});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.sftp");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.sftp = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'sftp',

    buildSettingsForm: function() {

        if(!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600
                },
                border: false,
                items: [
                    {
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_sftp_host'),
                        name: this.dataNamePrefix + 'host',
                        value: this.data.host,
                        allowBlank: false,
                        msgTarget: 'under'
                    },
                    {
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_sftp_port'),
                        name: this.dataNamePrefix + 'port',
                        value: this.data.port || 22,
                        allowBlank: false,
                        msgTarget: 'under',
                        width: 350
                    },
                    {
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_sftp_username'),
                        name: this.dataNamePrefix + 'username',
                        value: this.data.username,
                        allowBlank: false,
                        msgTarget: 'under'
                    },
                    {
                        xtype: 'textfield',
                        inputType: 'password',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_sftp_password'),
                        name: this.dataNamePrefix + 'password',
                        value: this.data.password,
                        allowBlank: false,
                        msgTarget: 'under'
                    },
                    {
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_sftp_remotePath'),
                        name: this.dataNamePrefix + 'remotePath',
                        value: this.data.remotePath || '/path/to/file/import.json',
                        allowBlank: false,
                        msgTarget: 'under',
                        width: 900
                    }
                ]
            });
        }

        return this.form;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.http");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.http = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'http',

    buildSettingsForm: function() {

        if(!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600
                },
                border: false,
                items: [
                    {
                        xtype: 'combo',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_http_schema'),
                        name: this.dataNamePrefix + 'schema',
                        store: ['https://', 'http://'],
                        forceSelection: true,
                        value: this.data.schema,
                        allowBlank: false,
                        msgTarget: 'under',
                        width: 330
                    },{
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_http_url'),
                        name: this.dataNamePrefix + 'url',
                        value: this.data.url,
                        allowBlank: false,
                        msgTarget: 'under',
                        width: 900

                    }
                ]
            });
        }

        return this.form;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.asset");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.asset = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'asset',

    buildSettingsForm: function() {
        if(!this.form) {

            this.component = Ext.create('Ext.form.TextField', {
                name: this.dataNamePrefix + 'assetPath',
                value: this.data.assetPath,
                fieldCls: 'pimcore_droptarget_input',
                width: 500,
                enableKeyEvents: true,
                allowBlank: false,
                msgTarget: 'under',
                listeners: {
                    render: function (el) {
                        // add drop zone
                        new Ext.dd.DropZone(el.getEl(), {
                            reference: this,
                            ddGroup: "element",
                            getTargetFromEvent: function (e) {
                                return this.reference.component.getEl();
                            },

                            onNodeOver: function (target, dd, e, data) {
                                if (data.records.length === 1 && this.dndAllowed(data.records[0].data)) {
                                    return Ext.dd.DropZone.prototype.dropAllowed;
                                }
                            }.bind(this),

                            onNodeDrop: this.onNodeDrop.bind(this)
                        });

                        el.getEl().on("contextmenu", this.onContextMenu.bind(this));

                    }.bind(this)
                }
            });

            let composite = Ext.create('Ext.form.FieldContainer', {
                fieldLabel: t('asset'),
                layout: 'hbox',
                items: [
                    this.component,
                    {
                        xtype: "button",
                        iconCls: "pimcore_icon_delete",
                        style: "margin-left: 5px",
                        handler: this.empty.bind(this)
                    },{
                        xtype: "button",
                        iconCls: "pimcore_icon_search",
                        style: "margin-left: 5px",
                        handler: this.openSearchEditor.bind(this)
                    }
                ],
                width: 900,
                componentCls: "object_field object_field_type_manyToOneRelation",
                border: false,
                style: {
                    padding: 0
                },
                listeners: {
                    afterrender: function () {
                    }.bind(this)
                }
            });

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600,
                },
                border: false,
                width: 900,
                items: [
                    composite
                ]
            });
        }

        return this.form;
    },

    onNodeDrop: function (target, dd, e, data) {

        if(!pimcore.helpers.dragAndDropValidateSingleItem(data)) {
            return false;
        }

        data = data.records[0].data;

        if (this.dndAllowed(data)) {
            this.component.setValue(data.path);
            return true;
        } else {
            return false;
        }
    },

    onContextMenu: function (e) {

        var menu = new Ext.menu.Menu();
        menu.add(new Ext.menu.Item({
            text: t('empty'),
            iconCls: "pimcore_icon_delete",
            handler: function (item) {
                item.parentMenu.destroy();
                this.empty();
            }.bind(this)
        }));

        menu.add(new Ext.menu.Item({
            text: t('search'),
            iconCls: "pimcore_icon_search",
            handler: function (item) {
                item.parentMenu.destroy();
                this.openSearchEditor();
            }.bind(this)
        }));

        menu.showAt(e.getXY());

        e.stopEvent();
    },

    openSearchEditor: function () {
        pimcore.helpers.itemselector(false, this.addDataFromSelector.bind(this), {
            type: ['asset'],
            subtype: {
                asset: ['text', 'document']
            },
            specific: {}
        }, {});
    },

    addDataFromSelector: function (data) {
        this.component.setValue(data.fullpath);
    },

    empty: function () {
        this.component.setValue("");
    },

    dndAllowed: function (data) {
        if (data.elementType === 'asset') {
            return data.type === 'document' || data.type === 'text' || data.type === 'unknown';
        }
        return false;
    }


});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.upload");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.upload = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'upload',

    buildSettingsForm: function() {
        if(!this.form) {

            let items = [];
            const url = Routing.generate('pimcore_dataimporter_configdataobject_uploadimportfile', {'config_name': this.initContext.configName});

            items.push({
                xtype: 'fileuploadfield',
                emptyText: t('select_a_file'),
                fieldLabel: t('file'),
                readOnly: false,
                width: 470,
                name: 'Filedata',
                buttonText: "",
                buttonConfig: {
                    iconCls: 'pimcore_icon_upload'
                },
                listeners: {
                    change: function () {
                        this.form.getForm().submit({
                            url: url,
                            params: {
                                csrfToken: pimcore.settings['csrfToken']
                            },
                            waitMsg: t("please_wait"),
                            success: function (el, res) {
                                this.updateUploadStatusInformation();
                            }.bind(this),

                            failure: function (el, res) {
                                const response = res.response;

                                let jsonData = null;
                                try {
                                    jsonData = Ext.decode(response.responseText);
                                } catch (e) {

                                }

                                const date = new Date();
                                let errorMessage = "Timestamp: " + date.toString() + "\n";
                                let errorDetailMessage = "\n" + response.responseText;

                                try {
                                    errorMessage += "Status: " + response.status + " | " + response.statusText + "\n";
                                    errorMessage += "URL: " + options.url + "\n";

                                    if(jsonData) {
                                        if (jsonData['message']) {
                                            errorDetailMessage = jsonData['message'];
                                        }

                                        if(jsonData['traceString']) {
                                            errorDetailMessage += "\nTrace: \n" + jsonData['traceString'];
                                        }
                                    }

                                    errorMessage += "Message: " + errorDetailMessage;
                                } catch (e) {
                                    errorMessage += "\n\n";
                                    errorMessage += response.responseText;
                                }

                                var message = t("error_general");
                                if(jsonData && jsonData['message']) {
                                    message = jsonData['message'] + "<br><br>" + t("error_general");
                                }
                                pimcore.helpers.showNotification(t("error"), message, "error", errorMessage);
                            }
                        });
                    }.bind(this)
                }
            });

            this.uploadStatus = Ext.create('Ext.form.field.Display', {
                hideLabel: false,
                style: 'margin-left:205px;margin-top:-10px'
            });
            items.push(this.uploadStatus);

            this.uploadFilePath = Ext.create('Ext.form.TextField', {
                name: this.dataNamePrefix + 'uploadFilePath',
                value: this.data.uploadFilePath,
                hidden: true
            });
            items.push(this.uploadFilePath);

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                fileUpload: true,
                defaults: {
                    labelWidth: 200,
                    width: 600
                },
                border: false,
                width: 900,
                items: items
            });
        }

        this.updateUploadStatusInformation();

        return this.form;
    },

    updateUploadStatusInformation: function() {

        Ext.Ajax.request({
            url: Routing.generate('pimcore_dataimporter_configdataobject_hasimportfileuploaded'),
            method: 'GET',
            params: {
                config_name: this.initContext.configName,
            },
            success: function (response) {
                let data = Ext.decode(response.responseText);

                if(data.message) {
                    this.uploadStatus.setValue(data.message);
                } else {
                    this.uploadStatus.setValue('');
                }

                if(data.success) {
                    this.uploadStatus.setFieldStyle('color: green');
                } else {
                    this.uploadStatus.setFieldStyle('color: red');
                }

                this.uploadFilePath.setValue(data.filePath);

            }.bind(this)
        });
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.push');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.loader.push = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'push',

    buildSettingsForm: function() {

        if(!this.form) {
            var apikeyField = new Ext.form.field.Text({
                name: this.dataNamePrefix + 'apiKey',
                value: this.data.apiKey,
                width: 400,
                minLength: 16,
                allowBlank: false,
                msgTarget: 'under'
            });

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600
                },
                border: false,
                items: [
                    {
                        xtype: 'fieldcontainer',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_push_apikey'),
                        layout: 'hbox',
                        width: 700,
                        items: [
                            apikeyField,
                            {
                                xtype: 'button',
                                width: 32,
                                style: 'margin-left: 8px',
                                iconCls: 'pimcore_icon_clear_cache',
                                handler: function () {
                                    apikeyField.setValue(md5(uniqid()));
                                }.bind(this)
                            }
                        ]
                    },{
                        xtype: 'checkbox',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_push_ignore_not_empty_queue'),
                        name: this.dataNamePrefix + 'ignoreNotEmptyQueue',
                        value: this.data.ignoreNotEmptyQueue,
                    },{
                        xtype: 'fieldcontainer',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_push_endpoint'),
                        layout: 'hbox',
                        width: 1450,
                        items: [
                            {
                                xtype: 'label',
                                text: location.protocol + '//' + location.host + '/pimcore-datahub-import/' + this.initContext.configName + '/push'
                            }
                        ]
                    }

                ]
            });
        }

        return this.form;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.interpreter.csv');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.interpreter.csv = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'csv',

    buildSettingsForm: function() {

        if(!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600,
                    allowBlank: false,
                    msgTarget: 'under'
                },
                border: false,
                items: [
                    {
                        xtype: 'checkbox',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_csv_skip_first_row'),
                        name: this.dataNamePrefix + 'skipFirstRow',
                        value: this.data.hasOwnProperty('skipFirstRow') ? this.data.skipFirstRow : false,
                        inputValue: true
                    },{
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_csv_delimiter'),
                        name: this.dataNamePrefix + 'delimiter',
                        value: this.data.delimiter || ',',
                        width: 250
                    },{
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_csv_enclosure'),
                        name: this.dataNamePrefix + 'enclosure',
                        value: this.data.enclosure || '"',
                        width: 250
                    },{
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_csv_escape'),
                        name: this.dataNamePrefix + 'escape',
                        value: this.data.escape || '\\',
                        width: 250
                    },
                ]
            });
        }

        return this.form;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.interpreter.json");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.interpreter.json = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'json',

    buildSettingsForm: function() {

        if(!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600
                },
                border: false,
                items: [
                ]
            });
        }

        return this.form;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.interpreter.xlsx");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.interpreter.xlsx = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'xlsx',

    buildSettingsForm: function() {

        if(!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600,
                },
                border: false,
                items: [
                    {
                        xtype: 'checkbox',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_csv_skip_first_row'),
                        name: this.dataNamePrefix + 'skipFirstRow',
                        value: this.data.hasOwnProperty('skipFirstRow') ? this.data.skipFirstRow : false,
                        inputValue: true
                    },{
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_xlsx_sheet'),
                        name: this.dataNamePrefix + 'sheetName',
                        value: this.data.sheetName || 'Sheet1'
                    }
                ]
            });
        }

        return this.form;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.interpreter.xml');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.interpreter.xml = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'xml',

    buildSettingsForm: function() {

        if(!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600
                },
                border: false,
                items: [
                    {
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_xml_xpath'),
                        name: this.dataNamePrefix + 'xpath',
                        value: this.data.xpath || '/root/item',
                        allowBlank: false,
                        msgTarget: 'under'
                    },{
                        xtype: 'textarea',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_xml_schema'),
                        name: this.dataNamePrefix + 'schema',
                        value: this.data.schema || '',
                        grow: true,
                        width: 900,
                        scrollable: true
                    }

                ]
            });
        }

        return this.form;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.cleanup.unpublish");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.cleanup.unpublish = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'unpublish',

    buildSettingsForm: function() {
        return null;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.cleanup.delete');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.cleanup.delete = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'delete',

    buildSettingsForm: function() {
        return null;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.importSettings');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.importSettings = Class.create({

    configItemRootContainer: null,
    transformationResultHandler: null,

    initialize: function(data, configItemRootContainer, transformationResultHandler) {
        this.resolverConfigData = data.resolverConfig;
        this.processingConfigData = data.processingConfig;
        this.mappingConfigData = data.mappingConfig;

        this.configItemRootContainer = configItemRootContainer;
        this.transformationResultHandler = transformationResultHandler;
    },

    buildImportSettingsPanel: function() {

        if(!this.panel) {
            this.panel = Ext.create('Ext.TabPanel', {
                region: 'center',
                title: t('plugin_pimcore_datahub_data_importer_configpanel_import_settings'),
                items: [
                    this.buildResolverTab(),
                    this.buildProcessingTab(),
                    this.buildMappingsTab()
                ]
            });
        }

        return this.panel;

    },

    buildResolverTab: function() {

        const panelDefaults = {
            labelWidth: 200,
            width: 600,
            allowBlank: false,
            msgTarget: 'under'
        };

        const loadingStrategySettingsPanel = Ext.create('Ext.Panel', {width: 800});
        const createLocationStrategySettingsPanel = Ext.create('Ext.Panel', {width: 800});
        const updateLocationStrategySettingsPanel = Ext.create('Ext.Panel', {width: 800});
        const publishingStrategySettingsPanel = Ext.create('Ext.Panel', {width: 800});

        this.configItemRootContainer.currentDataValues = this.configItemRootContainer.currentDataValues || {};
        this.configItemRootContainer.currentDataValues.dataObjectClassId = this.resolverConfigData.dataObjectClassId;

        this.resolverForm = Ext.create('DataHub.DataImporter.StructuredValueForm', {
            bodyStyle: 'padding:10px;',
            defaults: panelDefaults,
            scrollable: true,
            title: t('plugin_pimcore_datahub_data_importer_configpanel_resolver'),
            items: [
                {
                    xtype: 'textfield',
                    name: 'elementType',
                    value: 'dataObject',
                    hidden: true
                },{
                    xtype: 'combo',
                    typeAhead: true,
                    triggerAction: 'all',
                    store: pimcore.globalmanager.get('object_types_store'),
                    valueField: 'id',
                    displayField: 'text',
                    listWidth: 'auto',
                    fieldLabel: t('class'),
                    name: 'dataObjectClassId',
                    value: this.resolverConfigData.dataObjectClassId,
                    forceSelection: true,
                    listeners: {
                        change: function(combo, newValue, oldValue) {
                            this.configItemRootContainer.currentDataValues.dataObjectClassId = newValue;
                            this.configItemRootContainer.fireEvent(
                                pimcore.plugin.pimcoreDataImporterBundle.configuration.events.classChanged,
                                combo,
                                newValue,
                                oldValue
                            );
                        }.bind(this),
                        added: function(combo) {
                            this.configItemRootContainer.fireEvent(
                                pimcore.plugin.pimcoreDataImporterBundle.configuration.events.classInit,
                                combo,
                                combo.getValue(),
                            );
                        }.bind(this)
                    }
                },
                {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_data_importer_configpanel_element_loading'),
                    defaults: panelDefaults,
                    width: 850,
                    items: [
                        {
                            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_loading_strategy'),
                            xtype: 'subsettingscombo',
                            name: 'loadingStrategy.type',
                            settingsNamePrefix: 'loadingStrategy.settings',
                            optionsNamespace: pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load,
                            settingsPanel: loadingStrategySettingsPanel,
                            value: this.resolverConfigData.loadingStrategy.type || 'notLoad',
                            settingsValues: this.resolverConfigData.loadingStrategy ? this.resolverConfigData.loadingStrategy.settings : {},
                            configItemRootContainer: this.configItemRootContainer
                        },
                        loadingStrategySettingsPanel,
                    ]
                },
                {
                    xtype: 'fieldset',
                    width: 850,
                    title: t('plugin_pimcore_datahub_data_importer_configpanel_element_creation'),
                    defaults: panelDefaults,
                    items: [
                        {
                            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_create_location_strategy'),
                            xtype: 'subsettingscombo',
                            name: 'createLocationStrategy.type',
                            settingsNamePrefix: 'createLocationStrategy.settings',
                            optionsNamespace: pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location,
                            optionsBlackList: ['noChange'],
                            settingsPanel: createLocationStrategySettingsPanel,
                            value: this.resolverConfigData.createLocationStrategy.type || 'staticPath',
                            settingsValues: this.resolverConfigData.createLocationStrategy ? this.resolverConfigData.createLocationStrategy.settings : {},
                            configItemRootContainer: this.configItemRootContainer
                        },
                        createLocationStrategySettingsPanel
                    ]
                },
                {
                    xtype: 'fieldset',
                    width: 850,
                    title: t('plugin_pimcore_datahub_data_importer_configpanel_element_location_update'),
                    defaults: panelDefaults,
                    items: [
                        {
                            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_update_location_strategy'),
                            xtype: 'subsettingscombo',
                            name: 'locationUpdateStrategy.type',
                            settingsNamePrefix: 'locationUpdateStrategy.settings',
                            optionsNamespace: pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location,
                            optionsBlackList: ['doNotCreate'],
                            settingsPanel: updateLocationStrategySettingsPanel,
                            value: this.resolverConfigData.locationUpdateStrategy.type || 'noChange',
                            settingsValues: this.resolverConfigData.locationUpdateStrategy ? this.resolverConfigData.locationUpdateStrategy.settings : {},
                            configItemRootContainer: this.configItemRootContainer
                        },
                        updateLocationStrategySettingsPanel
                    ]
                },
                {
                    xtype: 'fieldset',
                    width: 850,
                    title: t('plugin_pimcore_datahub_data_importer_configpanel_element_publishing'),
                    defaults: panelDefaults,
                    items: [
                        {
                            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_publish_strategy'),
                            xtype: 'subsettingscombo',
                            name: 'publishingStrategy.type',
                            settingsNamePrefix: 'publishingStrategy.settings',
                            optionsNamespace: pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.publish,
                            settingsPanel: publishingStrategySettingsPanel,
                            value: this.resolverConfigData.publishingStrategy.type || 'noChangeUnpublishNew',
                            settingsValues: this.resolverConfigData.publishingStrategy ? this.resolverConfigData.publishingStrategy.settings : {},
                            configItemRootContainer: this.configItemRootContainer
                        },
                        publishingStrategySettingsPanel
                    ]
                },

            ]
        });

        return this.resolverForm;
    },

    getResolverConfig: function() {

        if(this.resolverForm) {
            return this.resolverForm.getValues();
        }
        return this.resolverConfigData;

    },

    buildProcessingTab: function() {

        const panelDefaults = {
            labelWidth: 200,
            width: 600,
            allowBlank: false,
            msgTarget: 'under'
        };

        const doDeltaCheckCheckbox = Ext.create('Ext.form.field.Checkbox', {
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_delta_check'),
            name: 'doDeltaCheck',
            disabled: !this.processingConfigData.idDataIndex || 0 === this.processingConfigData.idDataIndex.length,
            inputValue: true,
            value: this.processingConfigData.hasOwnProperty('doDeltaCheck') ? this.processingConfigData.doDeltaCheck : false
        });
        const doCleanup = Ext.create('Ext.form.field.Checkbox', {
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_do_cleanup'),
            name: 'cleanup.doCleanup',
            disabled: !this.processingConfigData.idDataIndex || 0 === this.processingConfigData.idDataIndex.length,
            inputValue: true,
            value: this.processingConfigData.cleanup && this.processingConfigData.cleanup.hasOwnProperty('doCleanup') ? this.processingConfigData.cleanup.doCleanup : false
        });
        const cleanupSettingsPanel = Ext.create('Ext.Panel', {width: 900});
        const cleanupStrategy = Ext.create('DataHub.DataImporter.SubSettingsComboBox', {
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_cleanup_strategy'),
            name: 'cleanup.strategy',
            disabled: !this.processingConfigData.idDataIndex || 0 === this.processingConfigData.idDataIndex.length,
            optionsNamespace: pimcore.plugin.pimcoreDataImporterBundle.configuration.components.cleanup,
            settingsPanel: cleanupSettingsPanel,
            value: this.processingConfigData.cleanup ? this.processingConfigData.cleanup.strategy : ''
        });


        this.processingForm = Ext.create('DataHub.DataImporter.StructuredValueForm', {
            bodyStyle: 'padding:10px;',
            defaults: panelDefaults,
            scrollable: true,
            title: t('plugin_pimcore_datahub_data_importer_configpanel_processing_settings'),
            items: [
                {
                    xtype: 'combo',
                    name: 'executionType',
                    fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_execution_type'),
                    store: [
                        ['sequential', t('plugin_pimcore_datahub_data_importer_configpanel_execution_type_sequential')],
                        ['parallel', t('plugin_pimcore_datahub_data_importer_configpanel_execution_type_parallel')]
                    ],
                    value: this.processingConfigData.executionType || 'parallel',
                    mode: 'local',
                    editable: false,
                    triggerAction: 'all'
                },
                {
                    xtype: 'checkbox',
                    fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_archive_import_file'),
                    name: 'doArchiveImportFile',
                    inputValue: true,
                    value: this.processingConfigData.hasOwnProperty('doArchiveImportFile') ? this.processingConfigData.doArchiveImportFile : false
                },
                {
                    xtype: 'combo',
                    fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_id_data_index'),
                    name: 'idDataIndex',
                    value: this.processingConfigData.idDataIndex,
                    store: this.configItemRootContainer.columnHeaderStore,
                    displayField: 'label',
                    valueField: 'dataIndex',
                    forceSelection: false,
                    queryMode: 'local',
                    triggerOnClick: false,
                    allowBlank: true,
                    listeners: {
                        change: function(textfield, newValue, oldValue) {
                            const hasNoIdField = (!newValue || 0 === newValue.length);
                            doDeltaCheckCheckbox.setDisabled(hasNoIdField);
                            doCleanup.setDisabled(hasNoIdField);
                            cleanupStrategy.setDisabled(hasNoIdField);
                            if(hasNoIdField) {
                                doDeltaCheckCheckbox.setValue(false);
                                doCleanup.setValue(false);
                                cleanupStrategy.setValue('');
                            }
                        }
                    }
                },
                doDeltaCheckCheckbox,
                doCleanup,
                cleanupStrategy
            ]
        });

        return this.processingForm;
    },


    getProcessingConfig: function() {

        if(this.processingForm) {
            return this.processingForm.getValues();
        }
        return this.processingConfigData;

    },

    buildMappingsTab: function() {

        this.mappingConfiguration = new pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.mappingConfiguration(
            this.mappingConfigData,
            this.configItemRootContainer,
            this.transformationResultHandler
        );

        const panel = Ext.create('Ext.Panel', {
            title: t('plugin_pimcore_datahub_data_importer_configpanel_mappings'),
            scrollable: false,
            layout: 'fit',
            items: [
                this.mappingConfiguration.buildMappingsPanel()
            ]
        });
        // panel.updateLayout();
        // pimcore.layout.refresh();
        return panel;
    },

    getMappingConfig: function() {

        if(this.mappingConfiguration) {
            return this.mappingConfiguration.getValues();
        }
        return this.mappingConfigData;

    },


    isValid: function(expandPanels) {

        let isValid = true;
        if(this.resolverForm && !this.resolverForm.isValid()) {
            isValid = false;
            const fields = this.resolverForm.form.getFields();
            fields.each(function(field) {
                if(!field.isValid()) {
                    console.log(field.getName());
                    console.log(field.getErrors());
                }
            });
        }

        if(this.processingForm && !this.processingForm.isValid()) {
            isValid = false;
            const fields = this.processingForm.form.getFields();
            fields.each(function(field) {
                if(!field.isValid()) {
                    console.log(field.getName());
                    console.log(field.getErrors());
                }
            });
        }

        if(this.mappingConfiguration) {
            isValid = this.mappingConfiguration.isValid(expandPanels) && isValid;
            if(!isValid) {
                console.log('Mapping Config not valid.');
            }
        }

        return isValid;
    }

});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.importPreview');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.importPreview = Class.create({

    configName: '',
    configItemInstance: null,
    previewRecordIndex: 0,
    transformationResultHandler: null,

    initialize: function(configName, configItemInstance, transformationResultHandler) {
        this.configName = configName;
        this.configItemInstance = configItemInstance;
        this.transformationResultHandler = transformationResultHandler;
    },

    buildImportPreviewPanel: function() {

        if(!this.panel) {
            this.panel = Ext.create('Ext.Panel', {
                title: t('plugin_pimcore_datahub_data_importer_configpanel_import_preview'),
                region: 'west',
                autoScroll: true,
                animate: false,
                containerScroll: true,
                width: 400,
                split: true,
                items: [
                    this.buildUploadPanel(),
                    this.buildPreviewGrid()
                ]
            });
        }
        return this.panel;

    },

    buildUploadPanel: function() {
        this.errorField = Ext.create('Ext.form.field.Display', {});
        this.uploadPanel = Ext.create('Ext.Panel', {
            bodyStyle: 'padding: 0 8px',
            tbar: {
                items: [
                    {
                        xtype: 'button',
                        iconCls: 'pimcore_icon_upload',
                        tooltip: t('plugin_pimcore_datahub_data_importer_configpanel_preview_data_upload'),
                        handler: this.uploadDialog.bind(this)
                    },{
                        xtype: 'button',
                        iconCls: 'pimcore_icon_clone',
                        tooltip: t('plugin_pimcore_datahub_data_importer_configpanel_preview_data_clone'),
                        handler: this.copyPreviewFromDataSource.bind(this)
                    },
                    '->',
                    {
                        xtype: 'button',
                        iconCls: 'pimcore_icon_refresh',
                        handler: this.updatePreview.bind(this, null, false)
                    }
                ]
            },
            items: [
                this.errorField
            ]
        });

        return this.uploadPanel;
    },

    buildPreviewGrid: function() {
        var columns = [
            {
                text: t('plugin_pimcore_datahub_data_importer_configpanel_preview_dataindex'),
                flex: 200,
                sortable: false,
                hidden: true,
                dataIndex: 'dataindex'
            },
            {
                text: t('plugin_pimcore_datahub_data_importer_configpanel_preview_label'),
                flex: 130,
                sortable: false,
                dataIndex: 'label'
            },
            {
                text: t('plugin_pimcore_datahub_data_importer_configpanel_preview_data'),
                flex: 150,
                sortable: false,
                dataIndex: 'data',
                tdCls: 'whitespace-pre'
            }
        ];
        this.previewStore = Ext.create('Ext.data.JsonStore', {
            data: [],
            fields: ['dataIndex', 'label', 'data', 'mapped']
        });

        Ext.util.CSS.createStyleSheet(
            '.whitespace-pre .x-grid-cell-inner { white-space:pre }'
        );

        this.gridPanel = Ext.create('Ext.grid.Panel', {
            hidden: true,
            autoScroll: true,
            store: this.previewStore,
            columns: {
                items: columns,
                defaults: {
                    renderer: Ext.util.Format.htmlEncode,
                },
            },
            emptyText: t('plugin_pimcore_datahub_data_importer_configpanel_preview_empty'),
            tbar: {
                items: [
                    {
                        xtype: 'button',
                        iconCls: 'pimcore_icon_upload',
                        tooltip: t('plugin_pimcore_datahub_data_importer_configpanel_preview_data_upload'),
                        handler: this.uploadDialog.bind(this)
                    },{
                        xtype: 'button',
                        iconCls: 'pimcore_icon_clone',
                        tooltip: t('plugin_pimcore_datahub_data_importer_configpanel_preview_data_clone'),
                        handler: this.copyPreviewFromDataSource.bind(this)
                    },
                    '->',
                    {
                        xtype: 'button',
                        iconCls: 'pimcore_icon_refresh',
                        handler: this.updatePreview.bind(this, null, false)
                    },{
                        xtype: 'button',
                        iconCls: 'plugin_pimcore_datahub_icon_previous',
                        handler: this.updatePreview.bind(this, 'previous', false)
                    },
                    {
                        xtype: 'button',
                        iconCls: 'plugin_pimcore_datahub_icon_next',
                        handler: this.updatePreview.bind(this, 'next', false)
                    }
                ]
            },
            trackMouseOver: true,
            columnLines: true,
            stripeRows: true,
            viewConfig: {
                forceFit: true,
                markDirty: false,
                getRowClass: function(record) {
                    if(record.get('mapped')) {
                        return 'data_hub_preview_panel_column_mapped';
                    } else {
                        return '';
                    }
                }
            },
            listeners: {
                afterrender: this.updatePreview.bind(this, null, true)
            }
        });

        return this.gridPanel;
    },

    checkValidConfiguration: function(suppressInvalidError) {
        let isValid = this.configItemInstance.loaderForm.isValid();
        isValid = this.configItemInstance.interpreterForm.isValid() && isValid;
        // isValid = this.configItemInstance.importSettings.resolverForm.isValid() && isValid;

        if(!isValid) {
            if(!suppressInvalidError) {
                pimcore.helpers.showNotification(t('error'), t('plugin_pimcore_datahub_data_importer_configpanel_invalid_config_for_preview'), 'error');
            }
            return false;
        }
        return true;

    },

    uploadDialog: function() {

        if(!this.checkValidConfiguration(false)) {
            return;
        }

        const url = Routing.generate('pimcore_dataimporter_configdataobject_uploadpreviewdata', {'config_name': this.configName});

        pimcore.helpers.uploadDialog(url, 'Filedata', function() {
            this.updatePreview();
        }.bind(this), function(res) {
            console.log('failure');
            console.log(res);

            const response = res.response;

            let jsonData = null;
            try {
                jsonData = Ext.decode(response.responseText);
            } catch (e) {

            }

            const errorMessage = this.buildErrorMessage(response, jsonData);

            let message = t("error_general");
            if(jsonData && jsonData['message']) {
                message = jsonData['message'] + "<br><br>" + t("error_general");
            }
            pimcore.helpers.showNotification(t("error"), message, "error", errorMessage);
        });
    },

    buildErrorMessage: function(response, jsonData) {
        const date = new Date();
        let errorMessage = "Timestamp: " + date.toString() + "\n";
        let errorDetailMessage = "\n" + response.responseText;

        try {
            errorMessage += "Status: " + response.status + " | " + response.statusText + "\n";
            errorMessage += "URL: " + options.url + "\n";

            if(jsonData) {
                if (jsonData['message']) {
                    errorDetailMessage = jsonData['message'];
                }

                if(jsonData['traceString']) {
                    errorDetailMessage += "\nTrace: \n" + jsonData['traceString'];
                }
            }

            errorMessage += "Message: " + errorDetailMessage;
        } catch (e) {
            errorMessage += "\n\n";
            errorMessage += response.responseText;
        }

        return errorMessage;
    },

    updatePreview: function(direction, suppressInvalidError) {

        if(!this.checkValidConfiguration(suppressInvalidError)) {
            return;
        }

        if(direction === 'next') {
            this.previewRecordIndex = this.previewRecordIndex + 1;
        } else if(direction === 'previous') {
            this.previewRecordIndex = (this.previewRecordIndex - 1 > 0) ? this.previewRecordIndex - 1 : 0;
        }

        const currentConfig = this.configItemInstance.getSaveData();

        Ext.Ajax.request({
            url: Routing.generate('pimcore_dataimporter_configdataobject_loaddatapreview'),
            method: 'POST',
            params: {
                config_name: this.configName,
                record_number: this.previewRecordIndex,
                current_config: currentConfig
            },
            success: function (response) {
                let data = Ext.decode(response.responseText);

                if(data.hasData) {
                    this.gridPanel.show();
                    this.uploadPanel.hide();
                    this.previewRecordIndex = data.previewRecordIndex;
                    this.previewStore.loadData(data.dataPreview);
                    this.transformationResultHandler.setCurrentPreviewRecord(data.previewRecordIndex);
                    this.transformationResultHandler.updateData(true);
                } else {
                    this.gridPanel.hide();
                    this.uploadPanel.show();
                    if(data.errorMessage) {
                        this.errorField.setValue(data.errorMessage);
                    } else {
                        this.errorField.setValue('');
                    }
                }


            }.bind(this)
        });


        this.configItemInstance.updateColumnHeaders();

    },

    copyPreviewFromDataSource: function() {

        if(!this.checkValidConfiguration(false)) {
            return;
        }

        const currentConfig = this.configItemInstance.getSaveData();

        Ext.Ajax.request({
            url: Routing.generate('pimcore_dataimporter_configdataobject_copypreviewdata'),
            method: 'POST',
            params: {
                config_name: this.configName,
                current_config: currentConfig
            },
            success: function (response) {
                let data = Ext.decode(response.responseText);

                if(data.success) {
                    this.updatePreview()
                } else {
                    let message = t("error_general");
                    if(data && data['message']) {
                        message = data['message'] + "<br><br>" + t("error_general");
                    }

                    const errorMessage = this.buildErrorMessage(response, data);
                    pimcore.helpers.showNotification(t("error"), message, "error", errorMessage);
                }

            }.bind(this)
        });
    }

});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load.id');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load.id = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'id',

    buildSettingsForm: function() {

        if(!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600,
                    allowBlank: false,
                    msgTarget: 'under'
                },
                border: false,
                items: [
                    {
                        xtype: 'combo',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_data_source_index'),
                        name: this.dataNamePrefix + 'dataSourceIndex',
                        value: this.data.dataSourceIndex,
                        store: this.configItemRootContainer.columnHeaderStore,
                        displayField: 'label',
                        valueField: 'dataIndex',
                        forceSelection: false,
                        queryMode: 'local',
                        triggerOnClick: false
                    }
                ]
            });
        }

        return this.form;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load.path');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load.path = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load.id, {

    type: 'path'

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load.attribute');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load.attribute = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'attribute',
    dataApplied: false,

    buildSettingsForm: function() {

        if(!this.form) {
            const languageSelection = Ext.create('Ext.form.ComboBox', {
                store: pimcore.settings.websiteLanguages,
                forceSelection: true,
                fieldLabel: t('language'),
                name: this.dataNamePrefix + 'language',
                value: this.data.language,
                allowBlank: true,
                hidden: true
            });

            const attributeSelection = Ext.create('Ext.form.ComboBox', {
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_attribute_name'),
                name: this.dataNamePrefix + 'attributeName',
                value: this.data.attributeName,
                displayField: 'title',
                valueField: 'key',
                forceSelection: true,
                queryMode: 'local'
            });

            const attributeStore = Ext.create('Ext.data.JsonStore', {
                fields: ['key', 'name', 'localized'],
                autoLoad: true,
                proxy: {
                    type: 'ajax',
                    extraParams: {
                        class_id: this.configItemRootContainer.currentDataValues.dataObjectClassId
                    },
                    url: Routing.generate('pimcore_dataimporter_configdataobject_loaddataobjectattributes'),
                    reader: {
                        type: 'json',
                        rootProperty: 'attributes'
                    }
                },

                listeners: {
                    dataChanged: function(store) {
                        if(!this.dataApplied) {
                            attributeSelection.setValue(this.data.attributeName);
                            this.form.isValid();
                            this.dataApplied = true;
                            this.setLanguageVisibility(attributeStore, attributeSelection, languageSelection);
                        }
                    }.bind(this)
                }
            });


            attributeSelection.setStore(attributeStore);
            attributeSelection.on('change', this.setLanguageVisibility.bind(this, attributeStore, attributeSelection, languageSelection));

            this.configItemRootContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.classChanged,
                function(combo, newValue, oldValue) {
                    attributeStore.proxy.setExtraParam('class_id', newValue);
                    attributeStore.load();
                }
            );

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600,
                    allowBlank: false,
                    msgTarget: 'under',
                },
                border: false,
                items: [
                    {
                        xtype: 'combo',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_data_source_index'),
                        name: this.dataNamePrefix + 'dataSourceIndex',
                        value: this.data.dataSourceIndex,
                        store: this.configItemRootContainer.columnHeaderStore,
                        displayField: 'label',
                        valueField: 'dataIndex',
                        forceSelection: false,
                        queryMode: 'local',
                        triggerOnClick: false
                    },
                    attributeSelection,
                    languageSelection,
                    {
                        xtype: 'checkbox',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_include_unpublished'),
                        name: this.dataNamePrefix + 'includeUnpublished',
                        value: this.data.hasOwnProperty('includeUnpublished') ? this.data.includeUnpublished : false,
                        inputValue: true
                    }
                ]
            });
        }

        return this.form;
    },

    setLanguageVisibility: function(attributeStore, attributeSelection, languageSelection) {
        const record = attributeStore.findRecord('key', attributeSelection.getValue());
        if(record) {
            languageSelection.setHidden(!record.data.localized);
            if(!record.data.localized) {
                languageSelection.setValue(null);
            }
        }
    }


});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load.notLoad');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.load.notLoad = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'notLoad',

    buildSettingsForm: function() {

        return null;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.staticPath');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.staticPath = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'staticPath',

    buildSettingsForm: function() {

        if(!this.form) {

            this.parentFolder = new Ext.form.TextField({
                name: this.dataNamePrefix + 'path',
                value: this.data.path || '/',
                fieldCls: 'pimcore_droptarget_input',
                width: 500,
                enableKeyEvents: true,
                allowBlank: false,
                msgTarget: 'under',
                listeners: {
                    render: function (el) {
                        // add drop zone
                        new Ext.dd.DropZone(el.getEl(), {
                            reference: this,
                            ddGroup: "element",
                            getTargetFromEvent: function (e) {
                                return this.reference.parentFolder.getEl();
                            },

                            onNodeOver: function (target, dd, e, data) {
                                if (data.records.length === 1 && this.dndAllowed(data.records[0].data)) {
                                    return Ext.dd.DropZone.prototype.dropAllowed;
                                }
                            }.bind(this),

                            onNodeDrop: this.onNodeDrop.bind(this)
                        });

                        el.getEl().on("contextmenu", this.onContextMenu.bind(this));

                    }.bind(this)
                }
            });

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600,
                    allowBlank: false,
                    msgTarget: 'under'
                },
                border: false,
                items: [
                    // {
                    //     xtype: 'textfield',
                    //     fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_path'),
                    //     name: this.dataNamePrefix + 'path',
                    //     value: this.data.path || '/'
                    // }
                    {
                        xtype: 'fieldcontainer',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_path'),
                        layout: 'hbox',
                        items: [
                            this.parentFolder,
                            {
                                xtype: "button",
                                iconCls: "pimcore_icon_delete",
                                style: "margin-left: 5px",
                                handler: this.empty.bind(this)
                            },{
                                xtype: "button",
                                iconCls: "pimcore_icon_search",
                                style: "margin-left: 5px",
                                handler: this.openSearchEditor.bind(this)
                            }
                        ],
                        width: 900,
                        componentCls: "object_field object_field_type_manyToOneRelation",
                        border: false,
                        style: {
                            padding: 0
                        }
                    }
                ]
            });
        }

        return this.form;
    },

    onNodeDrop: function (target, dd, e, data) {

        if(!pimcore.helpers.dragAndDropValidateSingleItem(data)) {
            return false;
        }

        data = data.records[0].data;

        if (this.dndAllowed(data)) {
            this.parentFolder.setValue(data.path);
            return true;
        } else {
            return false;
        }
    },

    onContextMenu: function (e) {

        var menu = new Ext.menu.Menu();
        menu.add(new Ext.menu.Item({
            text: t('empty'),
            iconCls: "pimcore_icon_delete",
            handler: function (item) {
                item.parentMenu.destroy();
                this.empty();
            }.bind(this)
        }));

        menu.add(new Ext.menu.Item({
            text: t('search'),
            iconCls: "pimcore_icon_search",
            handler: function (item) {
                item.parentMenu.destroy();
                this.openSearchEditor();
            }.bind(this)
        }));

        menu.showAt(e.getXY());

        e.stopEvent();
    },

    openSearchEditor: function () {
        pimcore.helpers.itemselector(false, this.addDataFromSelector.bind(this), {
            type: ['object'],
            subtype: {
                object: ['folder']
            },
            specific: {}
        }, {});
    },

    addDataFromSelector: function (data) {
        this.parentFolder.setValue(data.fullpath);
    },

    empty: function () {
        this.parentFolder.setValue("");
    },

    dndAllowed: function (data) {
        if (data.elementType === 'object') {
            return data.type === 'folder';
        }
        return false;
    }



});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.findParent');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.findParent = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'findParent',
    dataApplied: false,

    buildSettingsForm: function() {

        if(!this.form) {

            const languageSelection = Ext.create('Ext.form.ComboBox', {
                store: pimcore.settings.websiteLanguages,
                forceSelection: true,
                fieldLabel: t('language'),
                name: this.dataNamePrefix + 'attributeLanguage',
                value: this.data.attributeLanguage,
                allowBlank: true,
                hidden: true
            });

            const attributeName = Ext.create('Ext.form.ComboBox', {
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_attribute_name'),
                name: this.dataNamePrefix + 'attributeName',
                hidden: this.data.findStrategy !== 'attribute',
                allowBlank: true, // this.data.findStrategy !== 'attribute',
                value: this.data.attributeName,
                displayField: 'title',
                valueField: 'key',
                forceSelection: true,
                queryMode: 'local'
            });


            const attributeStore = Ext.create('Ext.data.JsonStore', {
                fields: ['key', 'name', 'localized'],
                autoLoad: true,
                proxy: {
                    type: 'ajax',
                    extraParams: {
                        class_id: this.data.attributeDataObjectClassId,
                        system_read: 1
                    },
                    url: Routing.generate('pimcore_dataimporter_configdataobject_loaddataobjectattributes'),
                    reader: {
                        type: 'json',
                        rootProperty: 'attributes'
                    }
                },

                listeners: {
                    dataChanged: function(store) {
                        if(!this.dataApplied) {
                            attributeName.setValue(this.data.attributeName);
                            this.form.isValid();
                            this.dataApplied = true;
                            this.setLanguageVisibility(attributeStore, attributeName, languageSelection);
                        }
                    }.bind(this)
                }
            });

            attributeName.setStore(attributeStore);
            attributeName.on('change', this.setLanguageVisibility.bind(this, attributeStore, attributeName, languageSelection));


            const attributeDataObjectClassId = Ext.create('Ext.form.field.ComboBox', {
                typeAhead: true,
                triggerAction: 'all',
                store: pimcore.globalmanager.get('object_types_store'),
                valueField: 'id',
                displayField: 'text',
                listWidth: 'auto',
                fieldLabel: t('class'),
                name: this.dataNamePrefix + 'attributeDataObjectClassId',
                value:  this.data.attributeDataObjectClassId,
                hidden: this.data.findStrategy !== 'attribute',
                allowBlank: true, // this.data.findStrategy !== 'attribute',
                forceSelection: true,
                listeners: {
                    change: function(combo, newValue, oldValue) {
                        attributeStore.proxy.setExtraParam('class_id', newValue);
                        attributeStore.load();
                    }
                }
            });




            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600,
                    allowBlank: false,
                    msgTarget: 'under'
                },
                border: false,
                items: [
                    {
                        xtype: 'combo',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_find_strategy'),
                        name: this.dataNamePrefix + 'findStrategy',
                        value: this.data.findStrategy,
                        store: [
                            ['id', t('plugin_pimcore_datahub_data_importer_configpanel_find_strategy_id')],
                            ['path', t('plugin_pimcore_datahub_data_importer_configpanel_find_strategy_path')],
                            ['attribute', t('plugin_pimcore_datahub_data_importer_configpanel_find_strategy_attribute')]
                        ],
                        listeners: {
                            change: function(combo, strategy) {
                                const attributeFields = [attributeDataObjectClassId, attributeName];
                                if(strategy === 'attribute') {
                                    attributeFields.forEach(function(item) {
                                        item.setHidden(false);
                                    });
                                } else {
                                    attributeFields.forEach(function(item) {
                                        item.setValue('');
                                        item.setHidden(true);
                                    });
                                }
                            }
                        }
                    },
                    attributeDataObjectClassId,
                    attributeName,
                    languageSelection,
                    {
                        xtype: 'combo',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_data_source_index'),
                        name: this.dataNamePrefix + 'dataSourceIndex',
                        value: this.data.dataSourceIndex,
                        store: this.configItemRootContainer.columnHeaderStore,
                        displayField: 'label',
                        valueField: 'dataIndex',
                        forceSelection: false,
                        queryMode: 'local',
                        triggerOnClick: false
                    },{
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_fallback_path'),
                        name: this.dataNamePrefix + 'fallbackPath',
                        value: this.data.fallbackPath
                    }
                ]
            });
        }

        return this.form;
    },


    setLanguageVisibility: function(attributeStore, attributeSelection, languageSelection) {
        const record = attributeStore.findRecord('key', attributeSelection.getValue());
        if(record) {
            languageSelection.setHidden(!record.data.localized);
            if(!record.data.localized) {
                languageSelection.setValue(null);
            }
        }
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.findOrCreateFolder');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.findOrCreateFolder = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'findOrCreateFolder',

    buildSettingsForm: function() {

        if(!this.form) {

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600,
                    allowBlank: false,
                    msgTarget: 'under'
                },
                border: false,
                items: [
                    {
                        xtype: 'combo',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_data_source_index'),
                        name: this.dataNamePrefix + 'dataSourceIndex',
                        value: this.data.dataSourceIndex,
                        store: this.configItemRootContainer.columnHeaderStore,
                        displayField: 'label',
                        valueField: 'dataIndex',
                        forceSelection: false,
                        queryMode: 'local',
                        triggerOnClick: false
                    },{
                        xtype: 'textfield',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_fallback_path'),
                        name: this.dataNamePrefix + 'fallbackPath',
                        value: this.data.fallbackPath
                    }
                ]
            });
        }

        return this.form;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.noChange');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.noChange = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'noChange',

    buildSettingsForm: function() {
        return null;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.doNotCreate');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.location.doNotCreate = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'doNotCreate',

    buildSettingsForm: function() {
        return null;
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.publish.alwaysPublish');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.publish.alwaysPublish = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'alwaysPublish',

    buildSettingsForm: function() {

        return null;

    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.publish.attributeBased');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.publish.attributeBased = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'attributeBased',

    buildSettingsForm: function() {

        if(!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 200,
                    width: 600,
                    allowBlank: false,
                    msgTarget: 'under'
                },
                border: false,
                items: [
                    {
                        xtype: 'combo',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_data_source_index'),
                        name: this.dataNamePrefix + 'dataSourceIndex',
                        value: this.data.dataSourceIndex,
                        store: this.configItemRootContainer.columnHeaderStore,
                        displayField: 'label',
                        valueField: 'dataIndex',
                        forceSelection: false,
                        queryMode: 'local',
                        triggerOnClick: false
                    }
                ]
            });
        }

        return this.form;

    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.publish.noChangePublishNew');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.publish.noChangePublishNew = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'noChangePublishNew',

    buildSettingsForm: function() {

        return null;

    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.publish.noChangeUnpublishNew');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.resolver.publish.noChangeUnpublishNew = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'noChangeUnpublishNew',

    buildSettingsForm: function() {

        return null;

    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.mappingConfiguration');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.mappingConfiguration = Class.create({


    configItemRootContainer: null,

    initialize: function(data, configItemRootContainer, transformationResultHandler) {
        this.mappingConfigData = data || [];

        this.configItemRootContainer = configItemRootContainer;
        this.transformationResultHandler = transformationResultHandler;
    },

    buildMappingsPanel: function() {

        if(!this.panel) {

            this.panel = Ext.create('Ext.Panel', {
                scrollable: true,
                tbar: {
                    items: [
                        {
                            text: t('add'),
                            iconCls: 'pimcore_icon_add',
                            handler: function() {
                                this.collapseAll();
                                this.addItem({label: 'new column'}, false, true);
                            }.bind(this)
                        }, '->', {
                            text: t('plugin_pimcore_datahub_data_importer_configpanel_mapping_collapse_all'),
                            iconCls: 'plugin_pimcore_datahub_icon_collapse',
                            handler: this.collapseAll.bind(this)
                        }, {
                            text: t('plugin_pimcore_datahub_data_importer_configpanel_mapping_autofill'),
                            iconCls: 'plugin_pimcore_datahub_icon_wizard',
                            handler: function() {
                                //get all fields from preview
                                let allDataIndices = [];
                                this.configItemRootContainer.columnHeaderStore.each(item => allDataIndices.push(item.data.dataIndex));

                                //get all fields from mappings
                                let usedDataIndices = [];
                                const values = this.getValues();
                                values.forEach(item => usedDataIndices = usedDataIndices.concat(item.dataSourceIndex));

                                //calculate missing fields and add them to panel
                                let missingDataIndices = allDataIndices.filter(item => !usedDataIndices.includes(item));
                                missingDataIndices.forEach(function(item) {
                                    const storeItem = this.configItemRootContainer.columnHeaderStore.getById(item);
                                    const itemLabel = storeItem ? storeItem.data.label : item;
                                    let data = {
                                        label: itemLabel,
                                        dataSourceIndex: [item],
                                        transformationResultType: 'default',
                                        dataTarget: {
                                            type: 'direct',
                                            settings: {
                                                fieldName: itemLabel
                                            }
                                        }
                                    };

                                    let mappingConfigurationItem = this.addItem(data, false);
                                    mappingConfigurationItem.updateTransformationResultPreview();

                                }.bind(this));

                            }.bind(this)
                        }
                    ]
                },
            });

            this.mappingConfigData.forEach(function(mappingItemData, index) {
                this.addItem(mappingItemData, true);
            }.bind(this));

        }

        return this.panel;

    },

    collapseAll: function() {
        this.panel.items.items.forEach(function(item) {
            item.collapse();
        });
    },

    addItem: function(mappingItemData, collapsed, scrollToBottom) {
        const mappingConfigurationItem = new pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.mappingConfigurationItem(mappingItemData, this.configItemRootContainer, this.transformationResultHandler);

        const item = mappingConfigurationItem.buildMappingConfigurationItem(collapsed);
        this.panel.add(item);

        if(collapsed) {
            item.collapse();
        } else {
            item.expand();
        }

        mappingConfigurationItem.recalculateTransformationResultType();
        if(scrollToBottom) {
            this.panel.getScrollable().scrollTo(0, 9999, false);
        }
        return mappingConfigurationItem;
    },

    getValues: function() {

        let mappingConfigData = [];
        this.panel.items.items.forEach(function(item) {
            mappingConfigData.push(item.itemImplementation.getValues());
        });

        return mappingConfigData;
    },

    isValid: function(expandPanels) {
        let isValid = true;
        this.panel.items.items.forEach(function(item) {
            isValid = item.isValid() && isValid;

            if(!item.isValid()) {
                item.setIconCls('pimcore_icon_warning');
                if(expandPanels) {
                    item.expand();
                }
                const fields = item.form.getFields();
                fields.each(function(field) {
                    if(!field.isValid()) {
                        console.log(field.getName());
                        console.log(field.getErrors());
                    }
                });                
            } else {
                item.setIconCls('');
            }

        });

        return isValid;
    }

});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.mappingConfigurationItem');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.mappingConfigurationItem = Class.create({

    configItemRootContainer: null,
    transformationPipelineItems: [],

    initialize: function (data, configItemRootContainer, transformationResultHandler) {
        this.data = data || [];

        this.configItemRootContainer = configItemRootContainer;
        this.transformationResultHandler = transformationResultHandler;
    },

    buildMappingConfigurationItem: function () {

        let data = this.data;

        if (!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                bodyStyle: 'padding:10px;',
                title: data.label,
                collapsed: true,
                collapsible: true,
                titleCollapse: true,
                hideCollapseTool: true,
                headerOverCls: 'data_hub_cursor_pointer',
                cls: 'data_hub_mapping_panel',
                collapsedCls: 'data_hub_collapsed',
                defaults: {
                    labelWidth: 150
                },
                tools: [{
                    type: 'close',
                    cls: 'plugin_pimcore_datahub_icon_mapping_remove',
                    handler: function (owner, tool, event) {
                        const ownerContainer = event.container.component.ownerCt;
                        ownerContainer.remove(event.container.component, true);
                        ownerContainer.updateLayout();
                    }.bind(this)
                }]
            });
            this.form.currentDataValues = {
                transformationResultType: data.transformationResultType
            };


            const transformationResultTypeLabel = Ext.create('Ext.form.Label', {
                html: data.transformationResultType
            });
            this.transformationResultType = Ext.create('Ext.form.TextField', {
                value: data.transformationResultType,
                name: 'transformationResultType',
                hidden: true,
                listeners: {
                    change: function (field, newValue, oldValue) {
                        transformationResultTypeLabel.setHtml(newValue);
                        this.form.currentDataValues.transformationResultType = newValue;
                        this.form.fireEvent(
                            pimcore.plugin.pimcoreDataImporterBundle.configuration.events.transformationResultTypeChanged,
                            newValue
                        );
                    }.bind(this)
                }
            });

            this.transformationResultPreviewLabel = Ext.create('Ext.form.Label', {});

            this.configItemRootContainer.on(
                pimcore.plugin.pimcoreDataImporterBundle.configuration.events.transformationResultPreviewUpdated,
                this.doUpdateTransformationResultPreview.bind(this)
            );

            this.transformationPipeline = this.buildTransformationPipeline(data.transformationPipeline);

            const dataTargetSettingsPanel = Ext.create('Ext.Panel', {});
            this.form.add([
                {
                    xtype: 'textfield',
                    fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_mapping_label'),
                    name: 'label',
                    value: data.label,
                    listeners: {
                        change: function (field, newValue, oldValue) {
                            this.form.setTitle(newValue);
                        }.bind(this)
                    }
                }, {
                    xtype: 'tagfield',
                    name: 'dataSourceIndex',
                    value: data.dataSourceIndex,
                    fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_mapping_source'),
                    store: this.configItemRootContainer.columnHeaderStore,
                    displayField: 'label',
                    valueField: 'dataIndex',
                    filterPickList: false,
                    queryMode: 'local',
                    forceSelection: false,
                    triggerOnClick: false,
                    createNewOnEnter: true,
                    allowBlank: false,
                    msgTarget: 'under',
                    listeners: {
                        change: function () {
                            this.recalculateTransformationResultType();
                            this.updateTransformationResultPreview();
                        }.bind(this),
                        errorchange: this.updateValidationState.bind(this)
                    }
                },
                {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline'),
                    collapsible: true,
                    collapsed: true,
                    items: [
                        this.transformationPipeline
                    ]
                },
                this.transformationResultType,
                {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_result'),
                    items: [{
                        xtype: 'fieldcontainer',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_result_type'),
                        layout: 'hbox',
                        items: [
                            transformationResultTypeLabel
                        ]
                    }, {
                        xtype: 'fieldcontainer',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_result_preview'),
                        layout: 'hbox',
                        items: [
                            this.transformationResultPreviewLabel
                        ]
                    }]
                },
                {
                    xtype: 'fieldset',
                    title: t('plugin_pimcore_datahub_data_importer_configpanel_data_target'),
                    defaults: {
                        labelWidth: 120,
                        width: 500
                    },
                    items: [
                        {
                            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_data_target_type'),
                            xtype: 'subsettingscombo',
                            name: 'dataTarget.type',
                            settingsNamePrefix: 'dataTarget.settings',
                            optionsNamespace: pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget,
                            settingsPanel: dataTargetSettingsPanel,
                            value: data.dataTarget ? data.dataTarget.type : '',
                            settingsValues: data.dataTarget ? data.dataTarget.settings : {},
                            configItemRootContainer: this.configItemRootContainer,
                            initContext: {
                                mappingConfigItemContainer: this.form,
                                updateValidationStateCallback: this.updateValidationState.bind(this)
                            },
                            allowBlank: false,
                            msgTarget: 'under'
                        },
                        dataTargetSettingsPanel
                    ]
                }

            ]);

            this.form.itemImplementation = this;
        }

        this.form.isValid();
        return this.form;
    },

    buildTransformationPipeline: function (data) {
        data = data || [];

        var transformationPipelineContainer = Ext.create('Ext.Panel', {});

        //TODO make that once globally, and not per mapping item?
        let addMenu = new Ext.menu.Menu();

        let subMenus = {};
        let menuItemsWithoutGroup = [];
        const itemTypes = Object.keys(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator);
        itemTypes.sort((item1, item2) => {
            const str1 = t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_' + item1);
            const str2 = t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_' + item2);
            return str1.localeCompare(str2);
        });

        for (let i = 0; i < itemTypes.length; i++) {
            const menuGroup = pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator[itemTypes[i]].prototype.getMenuGroup();
            const iconClass = pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator[itemTypes[i]].prototype.getIconClass();
            if (menuGroup) {
                if (!subMenus[menuGroup.text]) {
                    subMenus[menuGroup.text] = [];
                    subMenus[menuGroup.text]['icon'] = menuGroup.icon;
                }

                subMenus[menuGroup.text].push({
                    iconCls: iconClass,
                    handler: function () {
                        this.addTransformationPipelineItem(itemTypes[i], {}, transformationPipelineContainer);
                        this.recalculateTransformationResultType();
                        this.updateTransformationResultPreview();
                    }.bind(this),
                    text: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_' + itemTypes[i])
                });
            } else {
                menuItemsWithoutGroup.push(new Ext.menu.Item({
                    iconCls: iconClass,
                    handler: function () {
                        this.addTransformationPipelineItem(itemTypes[i], {}, transformationPipelineContainer);
                        this.recalculateTransformationResultType();
                        this.updateTransformationResultPreview();
                    }.bind(this),
                    text: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_' + itemTypes[i])
                }));
            }
        }

        for (let menuText in subMenus) {
            addMenu.add(new Ext.menu.Item({
                text: menuText,
                iconCls: subMenus[menuText]['icon'],
                menu: subMenus[menuText],
                hideOnClick: false
            }));
        }

        for (let menuIndex in menuItemsWithoutGroup) {
            addMenu.add(menuItemsWithoutGroup[menuIndex]);
        }

        transformationPipelineContainer.addDocked({
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    text: t('add'),
                    iconCls: 'pimcore_icon_add',
                    menu: addMenu
                }
            ]
        });

        data.forEach(function (item) {
            this.addTransformationPipelineItem(item.type, item, transformationPipelineContainer);
        }.bind(this));

        return transformationPipelineContainer;

    },

    addTransformationPipelineItem: function (type, data, container) {
        const item = new pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator[type](
            data, container, this.recalculateTransformationResultType.bind(this), this.updateTransformationResultPreview.bind(this)
        );
        container.add(item.buildTransformationPipelineItem());
    },

    recalculateTransformationResultType: function () {
        const currentConfig = Ext.encode(this.getValues());
        Ext.Ajax.request({
            url: Routing.generate('pimcore_dataimporter_configdataobject_calculatetransformationresulttype'),
            method: 'POST',
            params: {
                config_name: this.configItemRootContainer.configName,
                current_config: currentConfig
            },
            success: function (response) {
                let data = Ext.decode(response.responseText);
                this.transformationResultType.setValue(data);

            }.bind(this)
        });
    },

    updateTransformationResultPreview: function () {
        this.transformationResultHandler.updateData(false, this.doUpdateTransformationResultPreview.bind(this));
    },

    doUpdateTransformationResultPreview: function () {
        if (this.form.ownerCt && this.form.ownerCt.items) {
            const mappingIndex = this.form.ownerCt.items.items.indexOf(this.form);
            const transformationResultPreview = this.transformationResultHandler.getTransformationResultPreview(mappingIndex);
            this.transformationResultPreviewLabel.setHtml(transformationResultPreview);
        }
    },

    updateValidationState: function () {
        try {
            if (this.form.isValid()) {
                this.form.setIconCls('');
            } else {
                this.form.setIconCls('pimcore_icon_warning');
            }
        } catch (e) {
            console.log('Could not update validation state: ' + e);
        }
    },

    getValues: function () {
        let values = this.form.getValues();

        let transformationPipelineData = [];
        this.transformationPipeline.items.items.forEach(function (pipelineItem) {
            transformationPipelineData.push(pipelineItem.operatorImplementation.getValues());
        });
        values.transformationPipeline = transformationPipelineData;

        return values;
    }

});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.transformationResultHandler');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.transformationResultHandler = Class.create({

    currentPreviewRecord: 0,
    configItemRootContainer: null,
    configItemInstance: null,
    configName: '',
    transformationResultPreviews: [],

    initialize: function(configName, configItemInstance) {
        this.configName = configName;
        this.configItemRootContainer = configItemInstance.tab;
        this.configItemInstance = configItemInstance;
    },

    setCurrentPreviewRecord: function(currentPreviewRecord) {
        this.currentPreviewRecord = currentPreviewRecord;
    },

    updateData: function(fireUpdateEvent, callback) {

        //loads transformation results (data type & preview) for all mappings and stores it in class variable
        Ext.Ajax.request({
            url: Routing.generate('pimcore_dataimporter_configdataobject_loadtransformationresultpreviews'),
            method: 'POST',
            params: {
                config_name: this.configName,
                current_preview_record: this.currentPreviewRecord,
                current_config: this.configItemInstance.getSaveData()
            },
            success: function (response) {
                let data = Ext.decode(response.responseText);

                this.transformationResultPreviews = data.transformationResultPreviews;

                if(fireUpdateEvent) {
                    //fire event so that elements can update themselves
                    this.configItemRootContainer.fireEvent(
                        pimcore.plugin.pimcoreDataImporterBundle.configuration.events.transformationResultPreviewUpdated,
                        this
                    );
                }

                //call callback after update is finished
                if(callback) {
                    callback();
                }

            }.bind(this)
        });

    },

    getTransformationResultPreview: function(mappingIndex) {

        return this.transformationResultPreviews[mappingIndex];

        //TODO load data
        //load from class variable and return transformation result for given mapping index
        return {
            'transformationResultType': 'default',
            'transformationResultPreview': 'some data'
        };

    }


});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget.direct");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget.direct = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'direct',
    dataApplied: false,
    dataObjectClassId: null,
    transformationResultType: null,

    buildSettingsForm: function () {

        if (!this.form) {
            this.dataObjectClassId = this.configItemRootContainer.currentDataValues.dataObjectClassId;
            this.transformationResultType = this.initContext.mappingConfigItemContainer.currentDataValues.transformationResultType;

            const languageSelection = Ext.create('Ext.form.ComboBox', {
                store: pimcore.settings.websiteLanguages,
                forceSelection: true,
                fieldLabel: t('language'),
                name: this.dataNamePrefix + 'language',
                value: this.data.language,
                allowBlank: true,
                hidden: true
            });

            const attributeSelection = Ext.create('Ext.form.ComboBox', {
                displayField: 'title',
                valueField: 'key',
                queryMode: 'local',
                forceSelection: true,
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_fieldName'),
                name: this.dataNamePrefix + 'fieldName',
                value: this.data.fieldName,
                allowBlank: false,
                msgTarget: 'under'
            });

            const attributeStore = Ext.create('Ext.data.JsonStore', {
                fields: ['key', 'name', 'localized'],
                listeners: {
                    dataChanged: function (store) {
                        if (!this.dataApplied) {
                            attributeSelection.setValue(this.data.fieldName);
                            if (this.form) {
                                this.form.isValid();
                            }
                            this.dataApplied = true;
                            this.setLanguageVisibility(attributeStore, attributeSelection, languageSelection);
                        }

                        if (!store.findRecord('key', attributeSelection.getValue())) {
                            attributeSelection.setValue(null);
                            this.form.isValid();
                        }
                    }.bind(this)
                }
            });

            attributeSelection.setStore(attributeStore);
            attributeSelection.on('change', this.setLanguageVisibility.bind(this, attributeStore, attributeSelection, languageSelection));

            //register listeners for class and type changes
            this.initContext.mappingConfigItemContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.transformationResultTypeChanged, function (newType) {
                this.transformationResultType = newType;
                this.initAttributeStore(attributeStore);
            }.bind(this));
            this.configItemRootContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.classChanged,
                function (combo, newValue, oldValue) {
                    this.dataObjectClassId = newValue;
                    this.initAttributeStore(attributeStore);
                }.bind(this)
            );

            const writeIfTargetIsNotEmpty = Ext.create('Ext.form.Checkbox', {
                boxLabel: t('plugin_pimcore_datahub_data_importer_configpanel_dataTarget.type_direct_write_settings_ifTargetIsNotEmpty'),
                name: this.dataNamePrefix + 'writeIfTargetIsNotEmpty',
                value: this.data.hasOwnProperty('writeIfTargetIsNotEmpty') ? this.data.writeIfTargetIsNotEmpty : true,
                inputValue: true,
                uncheckedValue: false,
                listeners: {
                    change: function (checkbox, value) {
                        if (value) {
                            writeIfSourceIsEmpty.setReadOnly(false);
                            writeIfSourceIsEmpty.setValue(true);
                        } else {
                            writeIfSourceIsEmpty.setValue(false);
                            writeIfSourceIsEmpty.setReadOnly(true);
                        }
                    }
                }
            });

            const writeIfSourceIsEmpty = Ext.create('Ext.form.Checkbox', {
                boxLabel: t('plugin_pimcore_datahub_data_importer_configpanel_dataTarget.type_direct_write_settings_ifSourceIsEmpty'),
                name: this.dataNamePrefix + 'writeIfSourceIsEmpty',
                value: this.data.hasOwnProperty('writeIfSourceIsEmpty') ? this.data.writeIfSourceIsEmpty : true,
                uncheckedValue: false,
                readOnly: this.data.hasOwnProperty('writeIfTargetIsNotEmpty') ? !this.data.writeIfTargetIsNotEmpty : false,
                inputValue: true
            });
            
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 120,
                    width: 500,
                    listeners: {
                        errorchange: this.initContext.updateValidationStateCallback
                    }
                },
                border: false,
                items: [
                    attributeSelection,
                    languageSelection,
                    {
                        xtype: 'fieldcontainer',
                        fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_dataTarget.type_direct_write_settings_label'),
                        defaultType: 'checkboxfield',
                        items: [writeIfTargetIsNotEmpty, writeIfSourceIsEmpty]
                    }
                ]
            });

            //special loading strategy to prevent hundreds of requests when loading configurations
            this.initAttributeStore(attributeStore);
        }

        return this.form;
    },

    initAttributeStore: function (attributeStore) {
        const classId = this.dataObjectClassId;
        const transformationResultType = this.transformationResultType;

        let targetFieldCache = this.configItemRootContainer.targetFieldCache || {};

        if (targetFieldCache[classId] && targetFieldCache[classId][transformationResultType]) {

            if (targetFieldCache[classId][transformationResultType].loading) {
                setTimeout(this.initAttributeStore.bind(this, attributeStore), 400);
            } else {
                attributeStore.loadData(targetFieldCache[classId][transformationResultType].data);
            }


        } else {
            targetFieldCache = targetFieldCache || {};
            targetFieldCache[classId] = targetFieldCache[classId] || {};
            targetFieldCache[classId][transformationResultType] = {
                loading: true,
                data: null
            };
            this.configItemRootContainer.targetFieldCache = targetFieldCache;

            Ext.Ajax.request({
                url: Routing.generate('pimcore_dataimporter_configdataobject_loaddataobjectattributes'),
                method: 'GET',
                params: {
                    'class_id': classId,
                    'transformation_result_type': transformationResultType,
                    'system_write': 1
                },
                success: function (response) {
                    let data = Ext.decode(response.responseText);

                    targetFieldCache[classId][transformationResultType].loading = false;
                    targetFieldCache[classId][transformationResultType].data = data.attributes;

                    attributeStore.loadData(targetFieldCache[classId][transformationResultType].data);

                }.bind(this)
            });
        }
    },

    setLanguageVisibility: function (attributeStore, attributeSelection, languageSelection) {
        const record = attributeStore.findRecord('key', attributeSelection.getValue());
        if (record) {
            languageSelection.setHidden(!record.data.localized);
        }
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget.manyToManyRelation");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget.manyToManyRelation = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'manyToManyRelation',
    dataApplied: false,
    dataObjectClassId: null,
    transformationResultType: null,

    isTransformationResultTypeValid: function(transformationResultType) {
        const validTypes = ['advancedDataObject', 'dataObjectArray', 'assetArray', 'advancedAssetArray'];
        return validTypes.includes(transformationResultType);
    },

    buildSettingsForm: function () {

        if (!this.form) {
            this.dataObjectClassId = this.configItemRootContainer.currentDataValues.dataObjectClassId;
            this.transformationResultType = this.initContext.mappingConfigItemContainer.currentDataValues.transformationResultType;
            this.validTransformationResultType = this.isTransformationResultTypeValid(this.initContext.mappingConfigItemContainer.currentDataValues.transformationResultType);

            const errorField = Ext.create('Ext.form.Label', {
                html: '<p>' + t('plugin_pimcore_datahub_data_importer_configpanel_mtm_relation_type_error') + '</p>',
                style: 'color: #cf4c35'
            });

            const errorFieldExtMessage = Ext.create('Ext.form.Label', {
                html: t('plugin_pimcore_datahub_data_importer_configpanel_mtm_relation_type'),
                style: 'padding-bottom: 5px',
            });

            const fieldContainerError = Ext.create('Ext.form.FieldContainer',{
                hidden: this.validTransformationResultType,
                items: [errorField, errorFieldExtMessage]
            });

            const languageSelection = Ext.create('Ext.form.ComboBox', {
                store: pimcore.settings.websiteLanguages,
                forceSelection: true,
                fieldLabel: t('language'),
                name: this.dataNamePrefix + 'language',
                value: this.data.language,
                allowBlank: true,
                hidden: true
            });

            const overwriteMode = Ext.create('Ext.form.ComboBox', {
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_dataTarget.type_manyToManyRelation_write_settings_overwriteMode'),
                name: this.dataNamePrefix + 'overwriteMode',
                value: this.data.overwriteMode || 'replace',
                store: [
                    ['replace', t('plugin_pimcore_datahub_data_importer_configpanel_dataTarget.type_manyToManyRelation_write_settings_overwriteMode_replace')],
                    ['merge', t('plugin_pimcore_datahub_data_importer_configpanel_dataTarget.type_manyToManyRelation_write_settings_overwriteMode_merge')],
                ],
                hidden: !this.validTransformationResultType || (this.data.hasOwnProperty('writeIfTargetIsNotEmpty') ? !this.data.writeIfTargetIsNotEmpty : false)
            });

            const attributeSelection = Ext.create('Ext.form.ComboBox', {
                displayField: 'title',
                valueField: 'key',
                queryMode: 'local',
                forceSelection: true,
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_fieldName'),
                name: this.dataNamePrefix + 'fieldName',
                value: this.data.fieldName,
                allowBlank: false,
                msgTarget: 'under',
                hidden: !this.validTransformationResultType
            });

            const attributeStore = Ext.create('Ext.data.JsonStore', {
                fields: ['key', 'name', 'localized'],
                listeners: {
                    dataChanged: function (store) {
                        if (!this.dataApplied) {
                            attributeSelection.setValue(this.data.fieldName);
                            if (this.form) {
                                this.form.isValid();
                            }
                            this.dataApplied = true;
                            this.setOptionsVisibility(attributeStore, attributeSelection, languageSelection, overwriteMode);
                        }

                        if (!store || !store.findRecord('key', attributeSelection.getValue())) {
                            attributeSelection.setValue(null);
                            this.form.isValid();
                        }
                    }.bind(this)
                }
            });

            attributeSelection.setStore(attributeStore);
            attributeSelection.on('change', this.setOptionsVisibility.bind(this, attributeStore, attributeSelection, languageSelection, overwriteMode));

            //register listeners for class and type changes
            this.initContext.mappingConfigItemContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.transformationResultTypeChanged, function (newType) {

                this.validTransformationResultType = this.isTransformationResultTypeValid(newType);
                this.transformationResultType = newType;

                if(this.validTransformationResultType) {
                    attributeSelection.show();
                    languageSelection.show();
                    overwriteMode.show();
                    fieldContainerCB.show();
                    fieldContainerError.hide()
                    this.initAttributeStore(attributeStore);
                } else {
                    attributeSelection.setValue('');
                    attributeSelection.hide();
                    languageSelection.hide();
                    overwriteMode.hide();
                    fieldContainerCB.hide();
                    fieldContainerError.show();
                }
            }.bind(this));
            this.configItemRootContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.classChanged,
                function (combo, newValue, oldValue) {
                    this.dataObjectClassId = newValue;
                    this.initAttributeStore(attributeStore);
                }.bind(this)
            );

            const writeIfTargetIsNotEmpty = Ext.create('Ext.form.Checkbox', {
                boxLabel: t('plugin_pimcore_datahub_data_importer_configpanel_dataTarget.type_manyToManyRelation_write_settings_ifTargetIsNotEmpty'),
                name: this.dataNamePrefix + 'writeIfTargetIsNotEmpty',
                value: this.data.hasOwnProperty('writeIfTargetIsNotEmpty') ? this.data.writeIfTargetIsNotEmpty : true,
                inputValue: true,
                uncheckedValue: false,
                listeners: {
                    change: function (checkbox, value) {
                        if (value) {
                            writeIfSourceIsEmpty.setReadOnly(false);
                            writeIfSourceIsEmpty.setValue(true);
                            overwriteMode.setHidden(false);
                        } else {
                            writeIfSourceIsEmpty.setReadOnly(true);
                            writeIfSourceIsEmpty.setValue(false);
                            overwriteMode.setHidden(true);
                        }
                    }
                }
            });

            const writeIfSourceIsEmpty = Ext.create('Ext.form.Checkbox', {
                boxLabel: t('plugin_pimcore_datahub_data_importer_configpanel_dataTarget.type_manyToManyRelation_write_settings_ifSourceIsEmpty'),
                name: this.dataNamePrefix + 'writeIfSourceIsEmpty',
                value: this.data.hasOwnProperty('writeIfSourceIsEmpty') ? this.data.writeIfSourceIsEmpty : true,
                readOnly: this.data.hasOwnProperty('writeIfTargetIsNotEmpty') ? !this.data.writeIfTargetIsNotEmpty : false,
                inputValue: true,
                uncheckedValue: false
            });

            const fieldContainerCB = Ext.create('Ext.form.FieldContainer',{
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_dataTarget.type_manyToManyRelation_write_settings_label'),
                defaultType: 'checkboxfield',
                hidden: !this.validTransformationResultType,
                items: [writeIfTargetIsNotEmpty, writeIfSourceIsEmpty]
            });

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 120,
                    width: 500,
                    listeners: {
                        errorchange: this.initContext.updateValidationStateCallback
                    }
                },
                border: false,
                items: [
                    fieldContainerError,
                    attributeSelection,
                    languageSelection,
                    fieldContainerCB,
                    overwriteMode
                ]
            });

            //special loading strategy to prevent hundreds of requests when loading configurations
            this.initAttributeStore(attributeStore);
        }

        return this.form;
    },

    initAttributeStore: function (attributeStore) {
        const classId = this.dataObjectClassId;

        const transformationResultType = this.transformationResultType;

        let targetFieldCache = this.configItemRootContainer.targetFieldCacheRelations || {};

        if (targetFieldCache[classId] && targetFieldCache[classId][transformationResultType]) {

            if (targetFieldCache[classId][transformationResultType].loading) {
                setTimeout(this.initAttributeStore.bind(this, attributeStore), 400);
            } else {
                attributeStore.loadData(targetFieldCache[classId][transformationResultType].data);
            }


        } else {
            targetFieldCache = targetFieldCache || {};
            targetFieldCache[classId] = targetFieldCache[classId] || {};
            targetFieldCache[classId][transformationResultType] = {
                loading: true,
                data: null
            };
            this.configItemRootContainer.targetFieldCacheRelations = targetFieldCache;

            Ext.Ajax.request({
                url: Routing.generate('pimcore_dataimporter_configdataobject_loaddataobjectattributes'),
                method: 'GET',
                params: {
                    'class_id': classId,
                    'transformation_result_type': transformationResultType,
                    'system_read': 0,
                    'system_write': 0,
                    'load_advanced_relations': 1
                },
                success: function (response) {
                    let data = Ext.decode(response.responseText);

                    targetFieldCache[classId][transformationResultType].loading = false;
                    targetFieldCache[classId][transformationResultType].data = data.attributes;

                    attributeStore.loadData(targetFieldCache[classId][transformationResultType].data);

                }.bind(this)
            });
        }
    },
    setOptionsVisibility: function (attributeStore, attributeSelection, languageSelection) {
        const record = attributeStore.findRecord('key', attributeSelection.getValue());
        if (record) {
            languageSelection.setHidden(!record.data.localized);
        }
    }
});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget.classificationstore');

pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget.classificationstore = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.abstractOptionType, {

    type: 'classificationstore',
    dataApplied: false,
    keyNameLoaded: false,
    dataObjectClassId: null,
    transformationResultType: null,

    buildSettingsForm: function() {

        if(!this.form) {
            this.dataObjectClassId = this.configItemRootContainer.currentDataValues.dataObjectClassId;
            this.transformationResultType = this.initContext.mappingConfigItemContainer.currentDataValues.transformationResultType;

            let languages = [''];
            languages = languages.concat(pimcore.settings.websiteLanguages);

            const languageSelection = Ext.create('Ext.form.ComboBox', {
                store: languages,
                forceSelection: true,
                fieldLabel: t('language'),
                name: this.dataNamePrefix + 'language',
                value: this.data.language,
                allowBlank: true,
                hidden: true
            });

            const clsKeySelectionValue = Ext.create('Ext.form.TextField', {
                name: this.dataNamePrefix + 'keyId',
                value: this.data.keyId,
                hidden: true
            });
            this.clsKeySelectionLabel = Ext.create('Ext.form.TextField', {
                name: '__ignore.' + this.dataNamePrefix + 'keyLabel',
                value: this.data.keyId,
                editable: false,
                width: 340,
                allowBlank: false,
                msgTarget: 'under'
            });

            const clsKeySelection = Ext.create('Ext.form.FieldContainer', {
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_classification_store_key'),
                layout: 'hbox',
                items: [
                    this.clsKeySelectionLabel,
                    {
                        xtype: "button",
                        iconCls: "pimcore_icon_search",
                        style: "margin-left: 5px",
                        handler: function() {

                            let searchWindow = new pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.tools.classificationStoreKeySearchWindow(
                                this.dataObjectClassId,
                                attributeSelection.getValue(),
                                this.transformationResultType,
                                function(id, groupName, keyName) {
                                    clsKeySelectionValue.setValue(id);
                                    this.updateDataKeyLabel(groupName, keyName);
                                }.bind(this)
                            );
                            searchWindow.show();
                        }.bind(this)
                    }
                ],
                width: 600,
                border: false,
                hidden: true,
                style: {
                    padding: 0
                },
                listeners: {
                    afterlayout: function() {
                        if(!this.keyNameLoaded) {

                            if(this.data.keyId) {
                                Ext.Ajax.request({
                                    url: Routing.generate('pimcore_dataimporter_configdataobject_loaddataobjectclassificationstorekeyname'),
                                    method: 'GET',
                                    params: {
                                        'key_id': this.data.keyId
                                    },
                                    success: function (response) {
                                        const data = Ext.decode(response.responseText);

                                        if(data.groupName && data.keyName) {
                                            this.updateDataKeyLabel(data.groupName, data.keyName);
                                        }

                                    }.bind(this)
                                });

                            }

                            this.keyNameLoaded = true;
                        }
                    }.bind(this)
                }
            });

            const attributeSelection = Ext.create('Ext.form.ComboBox', {
                displayField: 'title',
                valueField: 'key',
                queryMode: 'local',
                forceSelection: true,
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_fieldName'),
                name: this.dataNamePrefix + 'fieldName',
                value: this.data.fieldName,
                allowBlank: false,
                msgTarget: 'under'
            });

            const attributeStore = Ext.create('Ext.data.JsonStore', {
                fields: ['key', 'name', 'localized'],
                listeners: {
                    dataChanged: function(store) {
                        if(!this.dataApplied) {
                            attributeSelection.setValue(this.data.fieldName);
                            if(this.form) {
                                this.form.isValid();
                            }
                            this.dataApplied = true;
                            this.setLanguageVisibility(attributeStore, attributeSelection, languageSelection, clsKeySelection);
                        }

                        if(!store.findRecord('key', attributeSelection.getValue())) {
                            attributeSelection.setValue(null);
                            this.form.isValid();
                        }
                    }.bind(this)
                }
            });

            attributeSelection.setStore(attributeStore);
            attributeSelection.on('change', this.setLanguageVisibility.bind(this, attributeStore, attributeSelection, languageSelection, clsKeySelection));

            //register listeners for class and type changes
            this.initContext.mappingConfigItemContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.transformationResultTypeChanged, function(newType) {
                this.transformationResultType = newType;
                this.clsKeySelectionLabel.setValue('');
                clsKeySelectionValue.setValue('');
            }.bind(this));
            this.configItemRootContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.classChanged,
               function(combo, newValue, oldValue) {
                    this.dataObjectClassId = newValue;
                    this.initAttributeStore(attributeStore);
                }.bind(this)
            );

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 120,
                    width: 500,
                    listeners: {
                        errorchange: this.initContext.updateValidationStateCallback
                    }
                },
                border: false,
                items: [
                    attributeSelection,
                    clsKeySelection,
                    clsKeySelectionValue,
                    languageSelection
                ]
            });

            //special loading strategy to prevent hundreds of requests when loading configurations
            this.initAttributeStore(attributeStore);
        }

        return this.form;
    },

    initAttributeStore: function(attributeStore) {

        const classId = this.dataObjectClassId;
        // const transformationResultType = this.transformationResultType;

        let classificationStoreFieldCache = this.configItemRootContainer.classificationStoreFieldCache || {};

        if(classificationStoreFieldCache[classId]) {

            if(classificationStoreFieldCache[classId].loading) {
                setTimeout(this.initAttributeStore.bind(this, attributeStore), 400);
            } else {
                attributeStore.loadData(classificationStoreFieldCache[classId].data);
            }


        } else {
            classificationStoreFieldCache = classificationStoreFieldCache || {};
            classificationStoreFieldCache[classId] = {
                loading: true,
                data: null
            };
            this.configItemRootContainer.classificationStoreFieldCache = classificationStoreFieldCache;

            Ext.Ajax.request({
                url: Routing.generate('pimcore_dataimporter_configdataobject_loaddataobjectclassificationstoreattributes'),
                method: 'GET',
                params: {
                    'class_id': classId
                },
                success: function (response) {
                    let data = Ext.decode(response.responseText);

                    classificationStoreFieldCache[classId].loading = false;
                    classificationStoreFieldCache[classId].data = data.attributes;

                    attributeStore.loadData(classificationStoreFieldCache[classId].data);

                }.bind(this)
            });
        }
    },

    setLanguageVisibility: function(attributeStore, attributeSelection, languageSelection, clsKeySelection) {
        const record = attributeStore.findRecord('key', attributeSelection.getValue());
        if(record) {
            languageSelection.setHidden(!record.data.localized);

            if(clsKeySelection) {
                clsKeySelection.show();
            }

        } else if(clsKeySelection) {
            clsKeySelection.hide();
        }
    },

    updateDataKeyLabel: function(groupName, keyName) {
        this.clsKeySelectionLabel.setValue(keyName + ' ' + t('plugin_pimcore_datahub_data_importer_configpanel_classification_key_in_group') + ' ' + groupName);
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget.classificationstoreBatch');

pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget.classificationstoreBatch = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.datatarget.classificationstore, {

    type: 'classificationstoreBatch',
    dataApplied: false,
    dataObjectClassId: null,
    validTransformationResultType: null,

    isTransformationResultTypeValid: function(transformationResultType) {
        const validTypes = ['array', 'quantityValueArray', 'inputQuantityValueArray', 'dateArray'];
        return validTypes.includes(transformationResultType);
    },

    buildSettingsForm: function() {

        if(!this.form) {
            this.dataObjectClassId = this.configItemRootContainer.currentDataValues.dataObjectClassId;
            this.validTransformationResultType = this.isTransformationResultTypeValid(this.initContext.mappingConfigItemContainer.currentDataValues.transformationResultType);

            const errorField = Ext.create('Ext.form.Label', {
                html: t('plugin_pimcore_datahub_data_importer_configpanel_classification_store_batch_type_error'),
                hidden: this.validTransformationResultType,
                style: 'color: #cf4c35'
            });

            let languages = [''];
            languages = languages.concat(pimcore.settings.websiteLanguages);
            const languageSelection = Ext.create('Ext.form.ComboBox', {
                store: languages,
                forceSelection: true,
                fieldLabel: t('language'),
                name: this.dataNamePrefix + 'language',
                value: this.data.language,
                allowBlank: true,
                hidden: true
            });

            const attributeSelection = Ext.create('Ext.form.ComboBox', {
                displayField: 'title',
                valueField: 'key',
                queryMode: 'local',
                forceSelection: true,
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_fieldName'),
                name: this.dataNamePrefix + 'fieldName',
                value: this.data.fieldName,
                allowBlank: false,
                msgTarget: 'under',
                hidden: !this.validTransformationResultType
            });

            const attributeStore = Ext.create('Ext.data.JsonStore', {
                fields: ['key', 'name', 'localized'],
                listeners: {
                    dataChanged: function(store) {
                        if(!this.dataApplied) {
                            attributeSelection.setValue(this.data.fieldName);
                            if(this.form) {
                                this.form.isValid();
                            }
                            this.dataApplied = true;
                            this.setLanguageVisibility(attributeStore, attributeSelection, languageSelection);
                        }

                        if(!store.findRecord('key', attributeSelection.getValue())) {
                            attributeSelection.setValue(null);
                            this.form.isValid();
                        }
                    }.bind(this)
                }
            });

            attributeSelection.setStore(attributeStore);
            attributeSelection.on('change', this.setLanguageVisibility.bind(this, attributeStore, attributeSelection, languageSelection));

            //register listeners for class and type changes
            this.initContext.mappingConfigItemContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.transformationResultTypeChanged, function(newType) {
                this.validTransformationResultType = this.isTransformationResultTypeValid(newType);

                if(this.validTransformationResultType) {
                    errorField.hide();
                    attributeSelection.show();
                    this.setLanguageVisibility.bind(this, attributeStore, attributeSelection, languageSelection);
                } else {
                    attributeSelection.setValue('');
                    attributeSelection.hide();
                    languageSelection.hide();
                    errorField.show();
                }

            }.bind(this));
            this.configItemRootContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.classChanged,
               function(combo, newValue, oldValue) {
                    this.dataObjectClassId = newValue;
                    this.initAttributeStore(attributeStore);
                }.bind(this)
            );

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                defaults: {
                    labelWidth: 120,
                    width: 500,
                    listeners: {
                        errorchange: this.initContext.updateValidationStateCallback
                    }
                },
                border: false,
                items: [
                    errorField,
                    {
                        html: t('plugin_pimcore_datahub_data_importer_configpanel_classification_store_batch_type'),
                        style: 'padding-bottom: 5px'
                    },
                    attributeSelection,
                    languageSelection
                ]
            });

            //special loading strategy to prevent hundreds of requests when loading configurations
            this.initAttributeStore(attributeStore);
        }

        return this.form;

    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.tools.classificationStoreKeySearchWindow');

pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.tools.classificationStoreKeySearchWindow = Class.create({

    initialize: function (classId, fieldname, transformationResultType, callback) {

        this.callback = callback;

        this.searchWindow = new Ext.Window({
            title: t('search_for_key'),
            width: 850,
            height: 550,
            modal: true,
            layout: 'fit',
            items: [this.buildPanel(classId, fieldname, transformationResultType)],
            bbar: [
                '->',{
                    xtype: 'button',
                    text: t('cancel'),
                    iconCls: 'pimcore_icon_cancel',
                    handler: function () {
                        this.searchWindow.close();
                    }.bind(this)
                },{
                    xtype: 'button',
                    text: t('apply'),
                    iconCls: 'pimcore_icon_apply',
                    handler: function () {
                        var selectionModel = this.gridPanel.getSelectionModel();
                        var selectedKeys = selectionModel.getSelection();

                        if(selectedKeys.length > 0) {
                            this.callback(selectedKeys[0].data.id, selectedKeys[0].data.groupName, selectedKeys[0].data.keyName);
                        }

                        this.searchWindow.close();
                    }.bind(this)
                }]
        });
    },


    show: function() {
        this.searchWindow.show();
    },

    buildPanel: function (classId, fieldname, transformationResultType) {

        const groupFields = ['id', 'groupName', 'keyName', 'keyDescription', 'keyId', 'groupId'];

        const readerFields = [];
        for (let i = 0; i < groupFields.length; i++) {
            readerFields.push({name: groupFields[i]});
        }

        const gridColumns = [];
        gridColumns.push({
            text: 'ID',
            width: 60,
            sortable: true,
            dataIndex: 'id'
        });

        gridColumns.push({
            text: t('group'),
            flex: 1,
            sortable: true,
            dataIndex: 'groupName',
            filter: 'string',
            renderer: pimcore.helpers.grid.getTranslationColumnRenderer.bind(this)
        });

        gridColumns.push({
            text: t('name'),
            flex: 1,
            sortable: true,
            dataIndex: 'keyName',
            filter: 'string',
            renderer: pimcore.helpers.grid.getTranslationColumnRenderer.bind(this)
        });

        gridColumns.push({
            text: t('description'),
            flex: 1,
            sortable: true,
            dataIndex: 'keyDescription',
            filter: 'string',
            renderer: pimcore.helpers.grid.getTranslationColumnRenderer.bind(this)
        });

        const proxy = {
            type: 'ajax',
            url: Routing.generate('pimcore_dataimporter_configdataobject_loaddataobjectclassificationstorekeys'),
            reader: {
                type: 'json',
                rootProperty: 'data',
            },
            extraParams: {
                class_id: classId,
                field_name: fieldname,
                transformation_result_type: transformationResultType
            }
        };

        this.store = Ext.create('Ext.data.Store', {
            remoteSort: true,
            remoteFilter: true,
            autoLoad: true,
            proxy: proxy,
            fields: readerFields
        });

        const pageSize = pimcore.helpers.grid.getDefaultPageSize(-1);
        const pagingtoolbar = pimcore.helpers.grid.buildDefaultPagingToolbar(this.store, {pageSize: pageSize});

        this.gridPanel = new Ext.grid.GridPanel({
            store: this.store,
            border: false,
            columns: gridColumns,
            loadMask: true,
            columnLines: true,
            bodyCls: 'pimcore_editable_grid',
            stripeRows: true,
            selModel: Ext.create('Ext.selection.RowModel', {
                // mode: 'MULTI'
            }),
            bbar: pagingtoolbar,
            listeners: {
                rowdblclick: function (grid, record, tr, rowIndex, e, eOpts ) {
                    this.callback(record.data.id, record.data.groupName, record.data.keyName);
                    this.searchWindow.close();
                }.bind(this)
            },
            plugins: [
                'gridfilters'
            ],
            viewConfig: {
                forcefit: true
            }
        });

        return Ext.create('Ext.Panel', {
            tbar: this.getToolbar(),
            layout: 'fit',
            items: [
                this.gridPanel
            ]
        });
    },

    getToolbar: function () {

        const searchfield = Ext.create('Ext.form.TextField', {
            width: 300,
            style: 'float: left;',
            fieldLabel: t('search'),
            enableKeyEvents: true,
            listeners: {
                keypress: function(searchField, e, eOpts) {
                    if (e.getKey() === 13) {
                        this.applySearchFilter(searchField);
                    }
                }.bind(this)
            }
        });

        return {
            items: [
                '->',
                searchfield,
                {
                    xtype: 'button',
                    text: t('search'),
                    iconCls: 'pimcore_icon_search',
                    handler: this.applySearchFilter.bind(this, searchfield)
                }
            ]
        };
    },

    applySearchFilter: function (searchfield) {
        this.store.getProxy().setExtraParam('searchfilter', searchfield.getValue());
        this.store.reload();
    }


});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator = Class.create({

    type: 'abstract',
    menuGroup: '',
    menuGroups: {
        dataTypes: {
            text: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_data_types'),
            icon: "pimcore_icon_reload"
        },
        loadImport: {
            text: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_load_import'),
            icon: "pimcore_icon_import"
        },
        dataManipulation: {
            text: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_data_manipulation'),
            icon: "pimcore_icon_log_admin"
        },
    },

    data: {},
    container: null,
    transformationResultTypeChangeCallback: null,
    transformationResultPreviewChangeCallback: null,

    initialize: function(data, container, transformationResultTypeChangeCallback, transformationResultPreviewChangeCallback) {
        this.data = data;
        this.container = container;
        this.transformationResultTypeChangeCallback = transformationResultTypeChangeCallback;
        this.transformationResultPreviewChangeCallback = transformationResultPreviewChangeCallback;
    },

    getTopBar: function (name, index, parent) {
        return [{
            xtype: "tbtext",
            text: "<b>" + name + "</b>"
        }, "-", {
            iconCls: 'pimcore_icon_up',
            handler: function (blockId, parent) {

                const container = parent;
                const blockElement = Ext.getCmp(blockId);

                container.moveBefore(blockElement, blockElement.previousSibling());

                this.executeTransformationResultCallbacks();
            }.bind(this, index, parent)
        }, {
            iconCls: 'pimcore_icon_down',
            handler: function (blockId, parent) {

                const container = parent;
                const blockElement = Ext.getCmp(blockId);

                container.moveAfter(blockElement, blockElement.nextSibling());

                this.executeTransformationResultCallbacks();
            }.bind(this, index, parent)
        }, '->', {
            iconCls: 'pimcore_icon_delete',
            handler: function (index, parent) {
                parent.remove(Ext.getCmp(index));

                this.executeTransformationResultCallbacks();
            }.bind(this, index, parent)
        }];
    },

    buildTransformationPipelineItem: function() {
        var myId = Ext.id();
        if(!this.form) {
            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                operatorImplementation: this,
                id: myId,
                style: "margin-top: 10px",
                border: true,
                bodyStyle: "padding: 10px;",
                tbar: this.getTopBar(t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_' + this.type), myId, this.container),
                items: this.getFormItems()
            });
        }

        return this.form;
    },

    getFormItems: function() {
        return []
    },

    getValues: function() {
        let values = this.form.getValues();
        values.type = this.type;
        return values;
    },

    getMenuGroup: function() {
        return null;
    },

    getIconClass: function() {
        return "pimcore_icon_add";
    },

    executeTransformationResultCallbacks: function() {
        if(this.transformationResultPreviewChangeCallback) {
            this.transformationResultPreviewChangeCallback();
        }
        if(this.transformationResultTypeChangeCallback) {
            this.transformationResultTypeChangeCallback();
        }
    },

    inputChangePreviewUpdate: function() {
        if(this.inputChangePreviewTimeout) {
            clearTimeout(this.inputChangePreviewTimeout);
        }
        this.inputChangePreviewTimeout = setTimeout(function() {
            this.transformationResultPreviewChangeCallback();
        }.bind(this), 1000);
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.trim");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.trim = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'trim',

    getMenuGroup: function() {
        return this.menuGroups.dataManipulation;
    },

    getFormItems: function() {
        return [
            {
                xtype: 'combo',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_mode'),
                value: this.data.settings ? this.data.settings.mode : 'both',
                name: 'settings.mode',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                },
                store: [
                    ['left', t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_left')],
                    ['right', t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_right')],
                    ['both', t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_both')]
                ]

            }
        ];
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.numeric");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.numeric = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'numeric',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_data_group_numeric";
    },

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asArray');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asArray = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'asArray',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asCountries');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asCountries = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'asCountries',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_countrymultiselect";
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asGeopoint');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asGeopoint = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'asGeopoint',
    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_geopoint";
    },

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asGeobounds');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asGeobounds = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'asGeobounds',
    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_geobounds";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asGeopolygon');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asGeopolygon = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'asGeopolygon',
    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_geopolygon";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asGeopolyline');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asGeopolyline = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'asGeopolyline',
    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_geopolyline";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asColor');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.asColor = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'asColor',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_rgbaColor";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.explode");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.explode = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'explode',

    getMenuGroup: function() {
        return this.menuGroups.dataManipulation;
    },

    getIconClass: function() {
        return "pimcore_icon_operator_splitter";
    },

    getFormItems: function() {
        return [
            {
                xtype: 'textfield',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_delimiter'),
                value: this.data.settings ? this.data.settings.delimiter : ' ',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                },
                name: 'settings.delimiter'
            },

            {
                xtype: 'checkbox',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_keep_sub_arrays'),
                value: this.data.settings ? this.data.settings.keepSubArrays : false,
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                },
                name: 'settings.keepSubArrays'
            }
        ];
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.combine");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.combine = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'combine',

    getMenuGroup: function() {
        return this.menuGroups.dataManipulation;
    },

    getFormItems: function() {
        return [
            {
                xtype: 'textfield',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_glue'),
                value: this.data.settings ? this.data.settings.glue : ' ',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                },
                name: 'settings.glue'
            }
        ];
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.htmlDecode");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.htmlDecode = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'htmlDecode',

    getMenuGroup: function() {
        return this.menuGroups.dataManipulation;
    },
    getIconClass: function() {
        return "pimcore_icon_html";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.quantityValue");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.quantityValue = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'quantityValue',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_quantityValue";
    },

    getFormItems: function () {
        this.data.settings = this.data.settings || {};

        const unitStore = Ext.create('Ext.data.JsonStore', {
            fields: ['unitId', 'abbreviation'],
            autoLoad: true,
            proxy: {
                type: 'ajax',
                url: Routing.generate('pimcore_dataimporter_configdataobject_loadunitdata'),
                reader: {
                    type: 'json',
                    rootProperty: 'UnitList'
                }
            }
        });

        const staticUnitSelect = Ext.create('Ext.form.ComboBox', {
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_quantityValue_unit_select_label'),
            name: 'settings.staticUnitSelect',
            value: this.data.settings ? this.data.settings.staticUnitSelect : null,
            displayField: 'abbreviation',
            valueField: 'unitId',
            hidden: this.data.settings.unitSourceSelect !== 'static',
            listeners: {
                change: this.inputChangePreviewUpdate.bind(this)
            },
        });

        staticUnitSelect.setStore(unitStore);

        const unitSourceSelect = Ext.create('Ext.form.ComboBox', {
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_quantityValue_unit_source'),
            name: 'settings.unitSourceSelect',
            value: this.data.settings ? this.data.settings.unitSourceSelect : 'id',
            forceSelection: true,
            store: [
                ['id', t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_quantityValue_unit_source_id')],
                ['abbr', t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_quantityValue_unit_source_abbreviation')],
                ['static', t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_quantityValue_unit_source_static')]
            ],
            listeners: {
                change: function(combo, unitSource) {
                    if(unitSource === 'static') {
                        staticUnitSelect.setHidden(false);
                    } else {
                        staticUnitSelect.setHidden(true);
                    }
                    this.inputChangePreviewUpdate();
                    this.transformationResultTypeChangeCallback();
                }.bind(this)
            }
        });

        const unitNullIfNoValueCheckbox = Ext.create('Ext.form.Checkbox', {
            xtype: "checkbox",
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_quantityValue_unit_null_if_no_value'),
            allowBlank: true,
            value: this.data.settings ? this.data.settings.unitNullIfNoValueCheckbox : false,
            listeners: {
                change: this.inputChangePreviewUpdate.bind(this),
            },
            name: "settings.unitNullIfNoValueCheckbox",
        });

        return [
            unitSourceSelect,
            staticUnitSelect,
            unitNullIfNoValueCheckbox
        ];
    }
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.quantityValueArray");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.quantityValueArray = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'quantityValueArray',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_quantityValue";
    },

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.inputQuantityValue");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.inputQuantityValue = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'inputQuantityValue',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_inputQuantityValue";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.inputQuantityValueArray");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.inputQuantityValueArray = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'inputQuantityValueArray',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_inputQuantityValue";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.boolean");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.boolean = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'boolean',
    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_booleanSelect";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.date");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.date = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'date',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_date";
    },

    getFormItems: function() {
        return [
            {
                xtype: 'textfield',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_format'),
                value: this.data.settings ? this.data.settings.format : 'Y-m-d',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                },
                name: 'settings.format'
            }
        ];
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.importAsset");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.importAsset = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    //TODO
    type: 'importAsset',

    getMenuGroup: function() {
        return this.menuGroups.loadImport;
    },

    getIconClass: function() {
        return "pimcore_icon_asset pimcore_icon_overlay_upload";
    },

    getFormItems: function() {

        this.parentFolder = Ext.create('Ext.form.TextField', {
            name: 'settings.parentFolder',
            value: this.data.settings ? this.data.settings.parentFolder : '/',
            fieldCls: 'pimcore_droptarget_input',
            width: 500,
            enableKeyEvents: true,
            allowBlank: false,
            msgTarget: 'under',
            listeners: {
                render: function (el) {
                    // add drop zone
                    new Ext.dd.DropZone(el.getEl(), {
                        reference: this,
                        ddGroup: "element",
                        getTargetFromEvent: function (e) {
                            return this.reference.parentFolder.getEl();
                        },

                        onNodeOver: function (target, dd, e, data) {
                            if (data.records.length === 1 && this.dndAllowed(data.records[0].data)) {
                                return Ext.dd.DropZone.prototype.dropAllowed;
                            }
                        }.bind(this),

                        onNodeDrop: this.onNodeDrop.bind(this)
                    });

                    el.getEl().on("contextmenu", this.onContextMenu.bind(this));

                }.bind(this),
                change: this.inputChangePreviewUpdate.bind(this)
            }
        });

        let composite = Ext.create('Ext.form.FieldContainer', {
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_target_folder'),
            layout: 'hbox',
            items: [
                this.parentFolder,
                {
                    xtype: "button",
                    iconCls: "pimcore_icon_delete",
                    style: "margin-left: 5px",
                    handler: this.empty.bind(this)
                },{
                    xtype: "button",
                    iconCls: "pimcore_icon_search",
                    style: "margin-left: 5px",
                    handler: this.openSearchEditor.bind(this)
                }
            ],
            width: 900,
            componentCls: "object_field object_field_type_manyToOneRelation",
            border: false,
            style: {
                padding: 0
            }
        });


        return [
            composite,
            {
                xtype: 'checkbox',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_use_existing'),
                value: this.data.settings ? this.data.settings.useExisting : true,
                name: 'settings.useExisting'
            },
            {
                xtype: 'checkbox',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_overwrite_existing'),
                value: this.data.settings ? this.data.settings.overwriteExisting : true,
                name: 'settings.overwriteExisting'
            },
            {
                xtype: 'textfield',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_preg_match'),
                value: this.data.settings ? this.data.settings.pregMatch : '',
                name: 'settings.pregMatch'
            }
        ];
    },


    onNodeDrop: function (target, dd, e, data) {

        if(!pimcore.helpers.dragAndDropValidateSingleItem(data)) {
            return false;
        }

        data = data.records[0].data;

        if (this.dndAllowed(data)) {
            this.parentFolder.setValue(data.path);
            return true;
        } else {
            return false;
        }
    },

    onContextMenu: function (e) {

        var menu = new Ext.menu.Menu();
        menu.add(new Ext.menu.Item({
            text: t('empty'),
            iconCls: "pimcore_icon_delete",
            handler: function (item) {
                item.parentMenu.destroy();
                this.empty();
            }.bind(this)
        }));

        menu.add(new Ext.menu.Item({
            text: t('search'),
            iconCls: "pimcore_icon_search",
            handler: function (item) {
                item.parentMenu.destroy();
                this.openSearchEditor();
            }.bind(this)
        }));

        menu.showAt(e.getXY());

        e.stopEvent();
    },

    openSearchEditor: function () {
        pimcore.helpers.itemselector(false, this.addDataFromSelector.bind(this), {
            type: ['asset'],
            subtype: {
                asset: ['folder']
            },
            specific: {}
        }, {});
    },

    addDataFromSelector: function (data) {
        this.parentFolder.setValue(data.fullpath);
    },

    empty: function () {
        this.parentFolder.setValue("");
    },

    dndAllowed: function (data) {
        if (data.elementType === 'asset') {
            return data.type === 'folder';
        }
        return false;
    }


});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.loadAsset");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.loadAsset = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'loadAsset',

    getMenuGroup: function() {
        return this.menuGroups.loadImport;
    },

    getIconClass: function() {
        return "pimcore_icon_asset pimcore_icon_overlay_add";
    },

    getFormItems: function() {
        return [
            {
                xtype: 'combo',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_asset_load_strategy'),
                value: this.data.settings ? this.data.settings.loadStrategy : 'path',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                },
                name: 'settings.loadStrategy',
                store: [
                    ['path', t('plugin_pimcore_datahub_data_importer_configpanel_find_strategy_path')],
                    ['id', t('plugin_pimcore_datahub_data_importer_configpanel_find_strategy_id')],
                ]
            }
        ];
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.gallery");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.gallery = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'gallery',

    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_imageGallery";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.imageAdvanced");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.imageAdvanced = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'imageAdvanced',
    getMenuGroup: function() {
        return this.menuGroups.dataTypes;
    },

    getIconClass: function() {
        return "pimcore_icon_hotspotimage";
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.loadDataObject");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.loadDataObject = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'loadDataObject',
    dataApplied: false,

    getMenuGroup: function() {
        return this.menuGroups.loadImport;
    },

    getIconClass: function() {
        return "pimcore_nav_icon_object pimcore_icon_overlay_add";
    },

    setLanguageVisibility: function(attributeStore, attributeSelection, languageSelection) {
        const record = attributeStore.findRecord('key', attributeSelection.getValue());
        if(record) {

            languageSelection.setHidden(!record.data.localized);
            if(!record.data.localized) {
                languageSelection.setValue(null);
            }
        }
    },

    getFormItems: function() {

        this.data.settings = this.data.settings || {};

        const languageSelection = Ext.create('Ext.form.ComboBox', {
            store: pimcore.settings.websiteLanguages,
            forceSelection: true,
            fieldLabel: t('language'),
            name: 'settings.attributeLanguage',
            value: this.data.settings.attributeLanguage,
            allowBlank: true,
            width: 400,
            hidden: true,
            listeners: {
                change: this.inputChangePreviewUpdate.bind(this)
            },
        });

        const attributeName = Ext.create('Ext.form.ComboBox', {
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_attribute_name'),
            name: 'settings.attributeName',
            hidden: this.data.settings.loadStrategy !== 'attribute',
            allowBlank: true,
            value: this.data.settings.attributeName,
            displayField: 'title',
            valueField: 'key',
            width: 400,
            forceSelection: true,
            queryMode: 'local',
            listeners: {
                change: this.inputChangePreviewUpdate.bind(this)
            },
        });


        const attributeStore = Ext.create('Ext.data.JsonStore', {
            fields: ['key', 'name', 'localized'],
            autoLoad: true,
            proxy: {
                type: 'ajax',
                extraParams: {
                    class_id: this.data.settings.attributeDataObjectClassId,
                    system_read: 1
                },
                url: Routing.generate('pimcore_dataimporter_configdataobject_loaddataobjectattributes'),
                reader: {
                    type: 'json',
                    rootProperty: 'attributes'
                }
            },

            listeners: {
                dataChanged: function(store) {
                    if(!this.dataApplied) {
                        attributeName.setValue(this.data.settings.attributeName);
                        this.form.isValid();
                        this.dataApplied = true;
                        this.setLanguageVisibility(attributeStore, attributeName, languageSelection);
                    }
                }.bind(this)
            }
        });

        const systemAttributes = ['id', 'path', 'key'];

        const partialMatch = Ext.create('Ext.form.field.Checkbox', {
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_accept_partial_match'),
            name: 'settings.partialMatch',
            allowBlank: true,
            value: this.data.settings ? this.data.settings.partialMatch : false,
            hidden: this.data.settings && this.data.settings.attributeName ? (this.data.settings.attributeName === null || systemAttributes.includes(this.data.settings.attributeName)) : true,
            listeners: {
                change: this.inputChangePreviewUpdate.bind(this)
            },
        });

        const loadUnpublished = Ext.create('Ext.form.field.Checkbox', {
            fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_dataobject_load_unpublished'),
            name: 'settings.loadUnpublished',
            hidden: this.data.settings.loadStrategy !== 'attribute',
            allowBlank: true,
            value: this.data.settings ? this.data.settings.loadUnpublished : false,
            listeners: {
                change: this.inputChangePreviewUpdate.bind(this)
            },
        });

        attributeName.setStore(attributeStore);
        attributeName.on('change', function(combo, newValue, oldValue) {
            this.setLanguageVisibility(attributeStore, attributeName, languageSelection);

            if(newValue === null || systemAttributes.includes(newValue)) {
                partialMatch.setValue(false);
                partialMatch.hide();
            } else {
                partialMatch.show();
            }
        }.bind(this));


        const attributeDataObjectClassId = Ext.create('Ext.form.field.ComboBox', {
            typeAhead: true,
            triggerAction: 'all',
            store: pimcore.globalmanager.get('object_types_store'),
            valueField: 'id',
            displayField: 'text',
            listWidth: 'auto',
            fieldLabel: t('class'),
            width: 400,
            name: 'settings.attributeDataObjectClassId',
            value:  this.data.settings.attributeDataObjectClassId,
            hidden: this.data.settings.loadStrategy !== 'attribute',
            allowBlank: true, // this.data.findStrategy !== 'attribute',
            forceSelection: true,
            listeners: {
                change: function(combo, newValue, oldValue) {
                    attributeStore.proxy.setExtraParam('class_id', newValue);
                    attributeStore.load();
                    attributeName.setValue(null);
                }.bind(this)
            }
        });

        return [
            {
                xtype: 'combo',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_dataobject_load_strategy'),
                name: 'settings.loadStrategy',
                value: this.data.settings.loadStrategy || 'id',
                store: [
                    ['id', t('plugin_pimcore_datahub_data_importer_configpanel_find_strategy_id')],
                    ['path', t('plugin_pimcore_datahub_data_importer_configpanel_find_strategy_path')],
                    ['attribute', t('plugin_pimcore_datahub_data_importer_configpanel_find_strategy_attribute')]
                ],
                listeners: {
                    change: function(combo, strategy) {
                        const attributeFields = [attributeDataObjectClassId, attributeName, loadUnpublished];
                        if(strategy === 'attribute') {
                            attributeFields.forEach(function(item) {
                                item.setHidden(false);
                            });
                        } else {
                            attributeFields.forEach(function(item) {
                                item.setValue('');
                                item.setHidden(true);
                            });
                            this.inputChangePreviewUpdate();
                        }
                    }.bind(this)
                }
            },
            attributeDataObjectClassId,
            attributeName,
            partialMatch,
            languageSelection,
            loadUnpublished
        ];
    }

});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.reduceArrayKeyValuePairs');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.reduceArrayKeyValuePairs = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'reduceArrayKeyValuePairs',

    getMenuGroup: function() {
        return this.menuGroups.dataManipulation;
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.flattenArray');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.flattenArray = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'flattenArray',

    getMenuGroup: function() {
        return this.menuGroups.dataManipulation;
    },
});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.staticText");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.staticText = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'staticText',

    getMenuGroup: function() {
        return this.menuGroups.dataManipulation;
    },

    getFormItems: function() {
        return [
            {
                xtype: 'combo',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_static_text_mode'),
                value: this.data.settings ? this.data.settings.mode : 'append',
                name: 'settings.mode',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                },
                store: [
                    ['append', t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_append')],
                    ['prepend', t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_prepend')]
                ]

            },

            {
                xtype: 'textfield',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_text'),
                value: this.data.settings ? this.data.settings.text : '',
                name: 'settings.text',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                }
            },

            {
                xtype: 'checkbox',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_always_add'),
                value: this.data.settings ? this.data.settings.alwaysAdd : false,
                name: 'settings.alwaysAdd'
            }
        ];
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.conditionalConversion");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.conditionalConversion = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'conditionalConversion',

    getMenuGroup: function() {
        return this.menuGroups.dataManipulation;
    },

    getFormItems: function() {
        return [
            {
                xtype: 'textfield',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_original'),
                value: this.data.settings ? this.data.settings.original : '',
                name: 'settings.original',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                }
            },

            {
                xtype: 'textfield',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_converted'),
                value: this.data.settings ? this.data.settings.converted : '',
                name: 'settings.converted',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                }
            }
        ];
    }

});



/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS("pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.stringReplace");
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.operator.stringReplace = Class.create(pimcore.plugin.pimcoreDataImporterBundle.configuration.components.mapping.abstractOperator, {

    type: 'stringReplace',

    getMenuGroup: function() {
        return this.menuGroups.dataManipulation;
    },

    getIconClass: function() {
        return 'pimcore_icon_operator_stringreplace';
    },

    getFormItems: function() {
        return [
            {
                xtype: 'textfield',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_search'),
                value: this.data.settings ? this.data.settings.search : '',
                name: 'settings.search',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                }
            },

            {
                xtype: 'textfield',
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_transformation_pipeline_replace'),
                value: this.data.settings ? this.data.settings.replace : '',
                name: 'settings.replace',
                listeners: {
                    change: this.inputChangePreviewUpdate.bind(this)
                }
            },
        ];
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.execution');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.execution = Class.create({

    configName: '',
    data: {},
    configItemRootContainer: null,
    currentLoaderType: null,
    currentDirtyState: false,
    updateHandle: null,

    initialize: function(configName, data, configItemRootContainer, loaderType) {
        this.configName = configName;
        this.data = data;
        this.configItemRootContainer = configItemRootContainer;
        this.currentLoaderType = loaderType;
    },

    buildPanel: function() {

        if(!this.form) {

            this.buttonFieldContainer = Ext.create('Ext.form.FieldContainer', {
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_execution_manual_execution'),
                items: [
                    {
                        xtype: 'button',
                        width: 165,
                        text: t('plugin_pimcore_datahub_data_importer_configpanel_execution_start'),
                        handler: this.startImport.bind(this)
                    }
                ],
            });

            this.scheduleTypes = Ext.create('Ext.form.FieldContainer', {
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_execution_schedule_type'),
                items: [{
                    xtype: 'radiogroup',
                    vertical: 'false',
                    columns: 2,
                    width: 400,
                    items: [{
                        boxLabel: t('plugin_pimcore_datahub_data_importer_configpanel_execution_schedule_type_cron_label'),
                        name: 'scheduleType',
                        checked: !this.data || this.data.scheduleType !== 'job',
                        inputValue: 'recurring',
                        listeners: {
                            change:  (obj, value) => {
                                if (value) {
                                    this.cronDefinitionContainer.down('textfield').setValue(this.data.cronDefinition);
                                    this.cronDefinitionContainer.setVisible(true);
                                    this.scheduledAtContainer.setVisible(false);
                                    this.scheduledAtContainer.down('datefield').reset();
                                }
                            },
                            scope: this
                        }

                    }, {
                        boxLabel: t('plugin_pimcore_datahub_data_importer_configpanel_execution_schedule_type_job_label'),
                        name: 'scheduleType',
                        checked: this.data?.scheduleType === 'job',
                        inputValue: 'job',
                        listeners: {
                            change: (obj, value) => {
                                if (value) {
                                    this.scheduledAtContainer.down('datefield').setValue(this.data.scheduledAt);
                                    this.scheduledAtContainer.setVisible(true);
                                    this.cronDefinitionContainer.setVisible(false);
                                    this.cronDefinitionContainer.down('textfield').reset();
                                }
                            },
                            scope: this
                        }
                    }]
                }]
            });

            this.scheduledAtContainer = Ext.create('Ext.form.FieldContainer', {
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_execution_datetime'),
                layout: 'hbox',
                hidden: this.data?.scheduleType !== 'job',
                style: 'margin-bottom: 18px;',
                items: [
                    {
                        xtype: 'datefield',
                        name: 'scheduledAt',
                        width: 300,
                        format: 'd-m-Y H:i',
                        value: this.data ? this.data.scheduledAt : '',
                        activeErrorsTpl: t('plugin_pimcore_datahub_data_importer_configpanel_execution_status_error'),
                        formatText: t('plugin_pimcore_datahub_data_importer_configpanel_execution_date_format'),
                        msgTarget: 'under'
                    }
                ]
            });

            this.cronDefinitionContainer = Ext.create('Ext.form.FieldContainer', {
                fieldLabel: t('plugin_pimcore_datahub_data_importer_configpanel_execution_cron'),
                layout: 'hbox',
                hidden: this.data?.scheduleType === 'job',
                items: [
                    {
                        xtype: 'textfield',
                        name: 'cronDefinition',
                        width: 300,
                        value: this.data.cronDefinition,
                        listeners: {
                            blur: function(field) {
                                if(this.cronTimeout) {
                                    clearTimeout(this.cronTimeout);
                                }
                                this.validateCron(field);
                            }.bind(this),
                            change: function(field) {
                                if(this.cronTimeout) {
                                    clearTimeout(this.cronTimeout);
                                }
                                this.cronTimeout = setTimeout(function(field) {
                                    this.validateCron(field);
                                }.bind(this, field), 500);
                            }.bind(this)
                        },
                        msgTarget: 'under',
                    },
                    {
                        xtype: 'displayfield',
                        style: 'padding-left: 10px',
                        value: '<a target="_blank" href="https://crontab.guru/">' + t('plugin_pimcore_datahub_data_importer_configpanel_execution_cron_generator') + '</a>'
                    }
                ]
            });

            this.progressLabel = Ext.create('Ext.form.Label', {
                style: 'margin-bottom: 5px; display: block'
            });
            this.progressBar = Ext.create('Ext.ProgressBar', {
                hidden: true
            });
            this.cancelButtonContainer = Ext.create('Ext.Panel', {
                layout: 'hbox',
                hidden: true,
                bodyStyle: 'padding-top: 10px',
                border: false,
                items: [
                    {
                        xtype: 'component',
                        flex: 1
                    },
                    {
                        xtype: 'button',
                        iconCls: 'pimcore_icon_cancel',
                        text: t('plugin_pimcore_datahub_data_importer_configpanel_execution_cancel'),
                        handler: function() {
                            Ext.Ajax.request({
                                url: Routing.generate('pimcore_dataimporter_configdataobject_cancelexecution'),
                                method: 'PUT',
                                params: {
                                    config_name: this.configName,
                                },
                                success: function (response) {

                                    pimcore.helpers.showNotification(t('success'), t('plugin_pimcore_datahub_data_importer_configpanel_execution_cancel_successful'), 'success');
                                    this.updateProgress();

                                }.bind(this)
                            });
                        }.bind(this)
                    }
                ]
            });

            this.updateProgress();

            this.form = Ext.create('DataHub.DataImporter.StructuredValueForm', {
                bodyStyle: 'padding:10px;',
                title: t('plugin_pimcore_datahub_data_importer_configpanel_execution'),
                items: [
                    {
                        xtype: 'fieldset',
                        title: t('plugin_pimcore_datahub_data_importer_configpanel_execution_settings'),
                        defaults: {
                            labelWidth: 130
                        },
                        items: [
                            this.scheduleTypes,
                            this.cronDefinitionContainer,
                            this.scheduledAtContainer,
                            this.buttonFieldContainer
                        ]
                    },{
                        xtype: 'fieldset',
                        title: t('plugin_pimcore_datahub_data_importer_configpanel_execution_status'),
                        items: [
                            this.progressLabel,
                            this.progressBar,
                            this.cancelButtonContainer

                        ]
                    }
                ]
            });

            this.updateDisabledState();

            this.configItemRootContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.loaderTypeChanged, function(newType) {
                this.currentLoaderType = newType;
                this.updateDisabledState();
            }.bind(this));

            this.configItemRootContainer.on(pimcore.plugin.pimcoreDataImporterBundle.configuration.events.configDirtyChanged, function(dirty) {
                this.currentDirtyState = dirty;
                this.updateDisabledState();
            }.bind(this));

            this.form.on('destroy', function() {
                clearTimeout(this.updateHandle);
            }.bind(this));

        }

        return this.form;
    },

    updateDisabledState: function() {
        this.cronDefinitionContainer.setDisabled(this.currentLoaderType === 'push');
        this.buttonFieldContainer.setDisabled(this.currentLoaderType === 'push' || this.currentDirtyState);
    },

    startImport: function(button) {

        button.setText(t('plugin_pimcore_datahub_data_importer_configpanel_execution_start_loading'));
        button.setDisabled(true);

        Ext.Ajax.request({
            url: Routing.generate('pimcore_dataimporter_configdataobject_startbatchimport'),
            method: 'PUT',
            params: {
                config_name: this.configName,
            },
            success: function (response) {
                let data = Ext.decode(response.responseText);

                if (data && data.success) {
                    pimcore.helpers.showNotification(t('success'), t('plugin_pimcore_datahub_data_importer_configpanel_execution_start_successful'), 'success');
                } else {
                    pimcore.helpers.showNotification(t("error"), t('plugin_pimcore_datahub_data_importer_configpanel_execution_start_error'), 'error');
                }
                button.setDisabled(false);
                button.setText(t('plugin_pimcore_datahub_data_importer_configpanel_execution_start'));
                this.updateDisabledState();
                this.updateProgress();
            }.bind(this)
        });
    },

    validateCron: function(field) {

        if(field.getValue().length === 0) {
            field.setValidation(true);
        } else {
            Ext.Ajax.request({
                url: Routing.generate('pimcore_dataimporter_configdataobject_iscronexpressionvalid'),
                method: 'GET',
                params: {
                    cron_expression: field.getValue()
                },
                success: function (response) {
                    let data = Ext.decode(response.responseText);
                    if(data.success) {
                        field.setValidation(true);
                    } else {
                        field.setValidation(data.message);
                    }
                    field.isValid();
                }.bind(this)
            });
        }

    },

    updateProgress: function() {
        clearTimeout(this.updateHandle);
        Ext.Ajax.request({
            url: Routing.generate('pimcore_dataimporter_configdataobject_checkimportprogress'),
            method: 'GET',
            params: {
                config_name: this.configName,
            },
            success: function (response) {
                let data = Ext.decode(response.responseText);

                if(data.isRunning) {
                    this.progressBar.show();
                    this.cancelButtonContainer.show();
                    this.progressBar.updateProgress(data.progress, data.processedItems + '/' + data.totalItems + ' ' + t('plugin_pimcore_datahub_data_importer_configpanel_execution_processed'));
                    this.progressLabel.setHtml(t('plugin_pimcore_datahub_data_importer_configpanel_execution_current_progress'));
                } else {
                    this.progressBar.hide();
                    this.cancelButtonContainer.hide();
                    this.progressLabel.setHtml('<b>' + t('plugin_pimcore_datahub_data_importer_configpanel_execution_not_running') + '</b>');
                }

                this.updateHandle = setTimeout(this.updateProgress.bind(this), 5000);

            }.bind(this)
        });
    }

});


/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

pimcore.registerNS('pimcore.plugin.pimcoreDataImporterBundle.configuration.components.logTab');
pimcore.plugin.pimcoreDataImporterBundle.configuration.components.logTab = Class.create(pimcore.log.admin, {

    componentPrefix: 'DATA-IMPORTER ',

    initialize: function($super, configName) {
        $super({
            localMode: true,
            searchParams: {
                component: this.componentPrefix + configName
            }
        });
    },

    getTabPanel: function($super) {
        $super();

        this.panel.setTitle(t('plugin_pimcore_datahub_data_importer_configpanel_logs'));
        this.panel.setIconCls('');

        const fieldset = this.searchpanel.items.items[0];
        const componentCombo = fieldset.child('field[name=component]');
        fieldset.remove(componentCombo, false);
        fieldset.add({
            xtype: 'textfield',
            hidden: true,
            name: 'component',
            value: this.searchParams.component
        });

        const relatedObjectField = fieldset.child('field[name=relatedobject]');
        relatedObjectField.setDisabled(false);

        this.store.getProxy().setExtraParam('component', this.searchParams.component);

        return this.panel;
    },

    clearValues: function(){
        this.searchpanel.getForm().reset();

        this.searchParams.fromDate = null;
        this.searchParams.fromTime = null;
        this.searchParams.toDate = null;
        this.searchParams.toTime = null;
        this.searchParams.priority = null;
        this.searchParams.message = null;
        this.searchParams.relatedobject = null;
        this.searchParams.pid = null;
        this.store.baseParams = this.searchParams;
        this.store.reload({
            params: this.searchParams
        });
    },

    find: function() {
        var formValues = this.searchpanel.getForm().getFieldValues();

        this.searchParams.fromDate = this.fromDate.getValue();
        this.searchParams.fromTime = this.fromTime.getValue();
        this.searchParams.toDate = this.toDate.getValue();
        this.searchParams.toTime = this.toTime.getValue();
        this.searchParams.priority = formValues.priority;
        this.searchParams.component = formValues.component;
        this.searchParams.relatedobject = formValues.relatedobject;
        this.searchParams.message = formValues.message;
        this.searchParams.pid = formValues.pid;

        var proxy = this.store.getProxy();
        proxy.extraParams = this.searchParams;
        this.pagingToolbar.moveFirst();
    }

});



