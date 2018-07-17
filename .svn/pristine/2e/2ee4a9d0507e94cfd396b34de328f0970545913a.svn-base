$(document).ready(function() {

    $.datepicker.setDefaults({
        dateFormat: "dd/mm/yy",
        altFormat: "dd/mm/yy",
        changeMonth: true,
        changeYear: true,
        showAnim: 'fold'
    });

    jQuery.extend(jQuery.jgrid.defaults, {
        cmTemplate: {
            search: true
                    //,searchoptions: {clearSearch: false}
        }
    });

    $("#loading").hide()
            .bind("ajaxSend", function() {
        var height = $(window).height();
        var width = $(document).width();
        $(this).css({
            'left': width / 2 - ($(this).width() / 2),
            'top': $(window).scrollTop() + height / 3 - ($(this).height() / 2),
            'z-index': 800000
        }).show();
    })
            .bind("ajaxSuccess", function() {
        $(this).hide('slow');

    })
            .bind("ajaxError", function() {
        $(this).hide('slow');
    });



    myLayout = $('body').layout({
        west__size: 300
                , east__size: 300
                // RESIZE Accordion widget when panes resize
                , west__onresize: $.layout.callbacks.resizePaneAccordions
                , east__onresize: $.layout.callbacks.resizePaneAccordions
                , initClosed: true
                , onresize_end: function() {
            $(window).trigger('resize');
            $('#tabs').tabs().height($(".ui-layout-center").height());
        }
    });

    $(".ui-layout-toggler").button({
        text: false
    });

    $("#logout_button").button();
    $("#logout_button span ").button();
    
    $("#frame_button").button();
    $("#frame_button span ").button();
    

    $(".ui-layout-toggler-west").button("option", {
        icons: {
            primary: 'ui-icon-triangle-1-e'
        }
    });
    $(".ui-layout-toggler-north").button("option", {
        icons: {
            primary: 'ui-icon-triangle-1-s'
        }
    });
    $(".ui-layout-toggler-east").button("option", {
        icons: {
            primary: 'i-icon-triangle-1-w'
        }
    });
    $(".ui-layout-toggler-south").button("option", {
        icons: {
            primary: 'i-icon-triangle-1-n'
        }
    });

    myLayout.tabCounter = 2;

    $("#accordion1").accordion({
        heightStyle: "fill"
    });

    // ACCORDION - in the East pane - in a 'content-div'
    $("#accordion2").accordion({
        heightStyle: "fill"
                , active: 1
    });


    //  $("#tabs").tabs({heightStyle: "fill"});

    $("#tabs").tabs({
        heightStyle: "fill",
        fxAutoHeight: true,
        activate: function(event, ui) {
            $(window).trigger('resize');
        }
    })
            .removeClass("ui-corner-all").addClass("ui-corner-bottom");
    $(".tabs-bottom .ui-tabs-nav, .tabs-bottom .ui-tabs-nav > *")
            .removeClass("ui-corner-all ui-corner-top")
            .addClass("ui-corner-bottom");

    $(".tabs-bottom .ui-tabs-nav").appendTo(".tabs-bottom");

    $("#tabs").delegate("span.ui-icon-close", "click", function() {
        var panelId = $(this).closest("li").remove().attr("aria-controls");
        $("#" + panelId).remove();
        $("#tabs").tabs("refresh");

    });

    // addThemeSwitcher('.ui-layout-north', {top: '12px', right: '5px'});

    $.fn.zTree.init($("#menuOpciones"), setting);
    $("#refreshNode").bind("click", {type: "refresh", silent: false}, refreshNode);
    $("#refreshNodeSilent").bind("click", {type: "refresh", silent: true}, refreshNode);
    $("#addNode").bind("click", {type: "add", silent: false}, refreshNode);
    $("#addNodeSilent").bind("click", {type: "add", silent: true}, refreshNode);

    $('body').keypress(function(e) {
        if (e.which === 27) {
            $("[guardado]").removeAttr("guardado");
        }
    });

    $("#jAlert").dialog({
        draggable: true,
        modal: true,
        resizable: false,
        width: 'auto',
        autoOpen: false,
        buttons: {
            Aceptar: function() {
                $(this).dialog("close");
                $(this).dialog("option", "title", "Mensaje de Alerta");
                $(this).empty();
            }
        }
    });

    window.alert = function(mensaje, titulo) {
        $("#jAlert").html(mensaje);
        if (titulo !== null)
            $("#jAlert").dialog("option", "title", titulo);

        $("#jAlert").dialog("open");
    };


    $(window).resize(function() {

        setTimeout(function() {
            $("[role='grid'].ui-jqgrid-btable", $('#tabs').find("[aria-expanded=true]"))
                    .each(function() {
                $(this).jqGrid('setGridWidth', $("#gbox_" + this.id).parent().width() - 5);
            });

        }, 300);
    });

});