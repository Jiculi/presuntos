export function mostrarVentana(pagina) {
    $('#ventana-overlay').fadeIn();
    $('#ventana-overlay').height($(window).height());

    $("#altaOficio").css("width", "80%");
    $("#altaOficio").css("top", "3%");
    $("#altaOficio").css("height", "auto");

    $("#altaOficio").fadeIn();
    $("#altaOficio").load(pagina);
}