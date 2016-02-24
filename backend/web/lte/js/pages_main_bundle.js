$("#pages_box .table-hover tbody").sortable({revert: true,items: "tr", cursor: "move", stop: function(event, ui) {
    $.post("pages/update-pos",{data:$("#pages_box .table-hover tbody").sortable("toArray")});
    $.jGrowl("Порядок изменён успешно!", { header: "Уведомление" });
}});

(function(){
    var childHref = $('#pages_box .child'),
        childBox = $('#child-box');

    //childBox
    childHref.on('click', function(event){
        event.preventDefault();
        var href = $(this).attr('href');
        $.post(href, function(data){
            childBox.html(data);
        });
    });

})();