window.addEventListener("load", function() {
    document.getElementById("contenidoTextArea").style.display = "block";
});

function mostrarCamposContenido() {
    var tipoContenido = document.getElementById("tipoContenido").value;

    document.getElementById("contenidoTextArea").style.display = tipoContenido === "Web" ? "block" : "none";
    document.getElementById("urlImagen").style.display = tipoContenido === "Imagen" ? "block" : "none";
    document.getElementById("urlVideo").style.display = tipoContenido === "Video" ? "block" : "none";
    document.getElementById("formatoVideo").style.display = tipoContenido === "Video" ? "block" : "none";
}
