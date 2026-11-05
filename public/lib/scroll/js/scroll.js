(function () {
    'use strict';

    var win = window; // eslint-disable-line no-undef
    var jq = win.jQuery;
    var appendContent = true;

    function generateContent() {
        jq('.scrollpanel').each(function (idx, el) {
            for (var i = 0; i < 0; i += 1) {
                jq(el).prepend('<div class="foo">' + i + '</div>');
            }
        });
    }

    function updateContent() {
        var $panel = jq('.no5');
        var $panelContent = jq('.no5 > .sp-viewport > .sp-container');
        var length = $panelContent.children().length;

        if (length <= 0) {
            appendContent = true;
        } else if (length >= 10) {
            appendContent = false;
        }

        if (appendContent) {
            $panelContent.prepend('<div class="foo">' + length + '</div>');
        } else {
            $panelContent.children().eq(0).remove();
        }

        $panel.scrollpanel('update');
    }

    function init() {
        generateContent();
        jq('.scrollpanel').scrollpanel();

        win.setInterval(updateContent, 1000);
        $(".no4 .sp-scrollbar").hide();
    }

    jq(init);

}());


$('.xml_content .xmlclose').on('click', function(event){
    $(this).parents('.colxml').remove();
});

$('.xml_content .mdi-chevron-right').on('click', function(event){
    $(this).hide();
    $(this).siblings('.mdi-chevron-down').show();
    $(this).parents('.panel-body').find('.xmlscrollpanel').show();
});

$('.xml_content .mdi-chevron-down').on('click', function(event){
    $(this).hide();
    $(this).siblings('.mdi-chevron-right').show();
    $(this).parents('.panel-body').find('.xmlscrollpanel').hide();
});



$(".xml_content .mdi-chevron-down").hide();
$(".xml_content .xmlscrollpanel").hide();


$(".xml_content .panel").hover(function(){
    $(".no4 .sp-scrollbar").show();
}, function(){
    $(".no4 .sp-scrollbar").hide();
});