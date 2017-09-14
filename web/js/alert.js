$("#form-ajustes, #cart-view").on("pjax:end", function() {
    $.pjax.reload({container:"#alerta-msg"});  //Reload GridView
});

$("#alerta-msg").on("pjax:end",function() {
    $(this).hide().fadeIn('slow');
});