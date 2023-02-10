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


