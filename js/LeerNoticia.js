window.addEventListener("load", function () {
    var btnComenzar = document.getElementById("comenzar");
    var divContenido = document.getElementById("contenido");
    var noticias = [];
    var indexNoticiaActual = 0;
    var contenedor;

    btnComenzar.addEventListener("click", comenzar);

    function comenzar() {
        btnComenzar.style.display = "none";
        fetch("plantilla/plantillaContenido.html").then(x => x.text()).then(y => {
            contenedor = document.createElement("div");
            contenedor.innerHTML = y;
            divContenido.appendChild(contenedor);

            fetch("http://gestionartelevisiones.com/api/ApiNoticias.php").then(x => x.json()).then(y => {
                noticias = y.noticias;
                obtenerYMostrarSiguienteNoticia();
            });
        });
    }

    function obtenerYMostrarSiguienteNoticia() {
        if (indexNoticiaActual < noticias.length) {
            var tipoContenido = noticias[indexNoticiaActual].tipo.toLowerCase();
            var noticiaAux = contenedor.querySelector(".noticia").cloneNode(true);
            var contenidoAux = noticiaAux.querySelector(".contenido");

            if (tipoContenido === "web") {
                contenidoAux.innerHTML = noticias[indexNoticiaActual].contenido;
            } else if (tipoContenido === "video") {
                contenidoAux.innerHTML = '<video src="' + noticias[indexNoticiaActual].url + '" controls></video>';
            } else if (tipoContenido === "imagen") {
                contenidoAux.innerHTML = '<img src="' + noticias[indexNoticiaActual].url + '" alt="Imagen de la noticia">';
            }

            if (indexNoticiaActual !== 0) {
                contenedor.innerHTML = '';  // Limpiar el contenido anterior antes de agregar la nueva noticia
            }

            contenedor.appendChild(noticiaAux);

            // Aumentar el índice para la siguiente noticia
            indexNoticiaActual++;

            // Llamar recursivamente para la siguiente noticia después de la duración
            setTimeout(obtenerYMostrarSiguienteNoticia, noticias[indexNoticiaActual - 1].duracion * 1000);
        }
    }
});
