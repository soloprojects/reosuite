

    function exportDoc(divId){
        $("#"+divId).wordExport();
    }

    $('.tbl_order').on('scroll', function () {
        $(".tbl_order > *").width($(".tbl_order").width() + $(".tbl_order").scrollLeft());
    });

    $(document).ready(function(){
        $('#quick_calculator').jsRapCalculator({name:'ERP Calculator'});
    });

    var li_class = document.getElementsByClassName("myUL");
    $(window).click(function() {
        for (var i = 0; i < li_class.length; i++){
            li_class[i].style.display = 'none';
        }

    });
