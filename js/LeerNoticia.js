window.addEventListener("load", function () {
    var urlParams = new URLSearchParams(window.location.search);
    var perfil = urlParams.get('pantalla') || 'todos';

    var divContenido = document.getElementById("contenido");
    var noticias = [];
    var indexNoticiaActual = 0;
    var contenedor;

    comenzar();

    function comenzar() {
        fetch("plantilla/plantillaContenido.html").then(x => x.text()).then(y => {
            contenedor = document.createElement("div");
            contenedor.innerHTML = y;
            divContenido.appendChild(contenedor);

            fetch("http://gestiontelevisiones.com/api/ApiNoticias.php").then(x => x.json()).then(y => {
                // Filtrar noticias según el perfil
                noticias = y.noticias.filter(function (noticia) {
                    return perfil === 'todos' || noticia.perfil === perfil || noticia.perfil === 'todos';
                });

                // Verificar si hay noticias para mostrar
                if (noticias.length > 0) {
                    obtenerYMostrarSiguienteNoticia();
                } else {
                    console.log('No hay noticias para mostrar.');
                }
            });
        });
    }

    function obtenerYMostrarSiguienteNoticia() {
        // Verificar si aún hay noticias para mostrar
        if (indexNoticiaActual >= noticias.length) {
            // Reiniciar el índice cuando llegamos a la última noticia
            indexNoticiaActual = 0;
        }

        // Verificar si hay noticias para mostrar
        if (noticias.length > 0) {
            var tipoContenido = noticias[indexNoticiaActual].tipo.toLowerCase();
            var noticiaAux = contenedor.querySelector(".noticia").cloneNode(true);
            var contenidoAux = noticiaAux.querySelector(".contenido");

            if (tipoContenido === "web") {
                contenidoAux.innerHTML = noticias[indexNoticiaActual].contenido;
            } else if (tipoContenido === "video") {
                contenidoAux.innerHTML = '<video src="' + noticias[indexNoticiaActual].url + '" controls autoplay></video>';
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
        } else {
            console.log('No hay noticias para mostrar.');
        }
    }

    // Entrar en modo pantalla completa en respuesta al clic del usuario
    document.addEventListener('click', function () {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) {
            document.documentElement.msRequestFullscreen();
        }
    });
});
