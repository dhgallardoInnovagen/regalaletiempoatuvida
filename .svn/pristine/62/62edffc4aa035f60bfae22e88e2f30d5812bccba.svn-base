

function open_new_tab(data, label) {
    var label = label || myLayout.tabCounter;
    id = "tabs-" + myLayout.tabCounter;
    var li = $($("#tabs").attr('template').replace(/#\{href\}/g, "#" + id).replace(/#\{label\}/g, label));
    tabContentHtml = data || "Tab " + myLayout.tabCounter + " content.";

    $("#tabs.tabs-bottom ul.buttom").append(li);
    $("#tabs").append("<div id='" + id + "'><p>" + data + "</p></div>");
    $("#tabs").tabs("refresh");


    myLayout.tabCounter++;

    $('ul.buttom, ul.buttom li', "#tabs")
            .removeClass("ui-corner-all ui-corner-top")
            .addClass("ui-corner-bottom");
    $("ul.buttom", "#tabs").appendTo(".tabs-bottom");

    $(window).trigger('resize');
    setTimeout(function() {
        $(".ui-tabs-anchor:last", "#tabs").trigger("click");
    }, 500);

    init_contend_loaded(id);
    /* 
     $(".tabs-bottom .ui-tabs-nav, .tabs-bottom .ui-tabs-nav > *")
     .removeClass("ui-corner-all ui-corner-top")
     .addClass("ui-corner-bottom");
     
     $(".tabs-bottom .ui-tabs-nav").appendTo(".tabs-bottom");
     */
}

function init_contend_loaded(context) {

    $("fieldset,input[class!='ui-spinner-input'], select, textarea", "#" + context)
            .addClass("ui-widget-content ui-corner-all")
            .focus(function() {
        $(this).removeClass("ui-state-error").addClass("ui-state-hover");
    })
            .blur(function() {
        $(this).removeClass("ui-state-hover");

    });


    $("[dtype='number']", "#" + context).bind("keypress", function(e) {
        return (e.which !== 8 && e.which !== 0 && (e.which < 48 || e.which > 57)) ? false : true;
    });

    $("button,input[type='button']", "#" + context).button();
    $("button:contains(Guardar)")
            .button("option", "icons", {primary: "ui-icon-disk"});
    $("button:contains(Agregar)")
            .button("option", "icons", {primary: "ui-icon-circle-plus"});
     $("button:contains(Quitar)")
            .button("option", "icons", {primary: "ui-icon-circle-minus"});
    

}
function split(val) {
    return val.split(/,\s*/);
}
function extractLast(term) {
    return split(term).pop();
}
var setting = {
    view: {
        selectedMulti: false
    },
    async: {
        enable: true,
        url: base_url + "frame/get_menu/"+  id_modulo + url_sufix,
        autoParam: ["id", "name=n", "level=lv"],
        otherParam: {"otherParam": "zTreeAsyncTest"},
        dataFilter: filter
    },
    callback: {
        beforeClick: beforeClick,
        beforeAsync: beforeAsync,
        onAsyncError: onAsyncError,
        onAsyncSuccess: onAsyncSuccess
    }
};

function filter(treeId, parentNode, childNodes) {
    if (!childNodes)
        return null;

    for (var i = 0, l = childNodes.length; i < l; i++) {

        childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
    }
    return childNodes;
}
function beforeClick(treeId, node) {
    if (node.isParent) {
        return false;
    } else {

        if (!node.isMultiple && $(".ui-tabs-anchor:contains('" + node.label + "')", "#tabs").get().length) {
            $(".ui-tabs-anchor:contains('" + node.label + "')", "#tabs").trigger("click");
            return true;
        }

        $.ajax({
            url: base_url + node.control + url_sufix,
            type: 'POST',
            node: node,
            success: function(data) {
                open_new_tab(data, this.node.label);

            }});

        return true;
    }
}
var log, className = "dark";
function beforeAsync(treeId, treeNode) {
    className = (className === "dark" ? "" : "dark");
    showLog("[ " + getTime() + " beforeAsync ]&nbsp;&nbsp;&nbsp;&nbsp;" + ((!!treeNode && !!treeNode.name) ? treeNode.name : "root"));
    return true;
}
function onAsyncError(event, treeId, treeNode, XMLHttpRequest, textStatus, errorThrown) {
    showLog("[ " + getTime() + " onAsyncError ]&nbsp;&nbsp;&nbsp;&nbsp;" + ((!!treeNode && !!treeNode.name) ? treeNode.name : "root"));
}
function onAsyncSuccess(event, treeId, treeNode, msg) {
    showLog("[ " + getTime() + " onAsyncSuccess ]&nbsp;&nbsp;&nbsp;&nbsp;" + ((!!treeNode && !!treeNode.name) ? treeNode.name : "root"));
}

function showLog(str) {
    if (!log)
        log = $("#log");
    log.append("<li class='" + className + "'>" + str + "</li>");
    if (log.children("li").length > 8) {
        log.get(0).removeChild(log.children("li")[0]);
    }
}
function getTime() {
    var now = new Date(),
            h = now.getHours(),
            m = now.getMinutes(),
            s = now.getSeconds(),
            ms = now.getMilliseconds();
    return (h + ":" + m + ":" + s + " " + ms);
}

function refreshNode(e) {
    var zTree = $.fn.zTree.getZTreeObj("menuOpciones"),
            type = e.data.type,
            silent = e.data.silent,
            nodes = zTree.getSelectedNodes();
    if (nodes.length === 0) {
        alert("Please select one parent node at first...");
    }
    for (var i = 0, l = nodes.length; i < l; i++) {
        zTree.reAsyncChildNodes(nodes[i], type, silent);
        if (!silent)
            zTree.selectNode(nodes[i]);
    }
}

function dato_salvado() {

}