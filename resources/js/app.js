
    // Busca el componente de notificación en la página
    const flashMessage = document.getElementById('flash-message');

    if (flashMessage) {
        // Función para cerrar el mensaje con una animación
        const closeFlashMessage = () => {
            flashMessage.classList.add('opacity-0', 'translate-y-4');
            // Esperar a que termine la transición para eliminarlo del DOM
            setTimeout(() => {
                if(flashMessage) { // Doble chequeo por si el usuario lo cierra manualmente
                    flashMessage.remove();
                }
            }, 500); // Debe coincidir con la duración de la transición CSS
        };

        // El botón de cerrar ahora solo elimina el elemento directamente (he simplificado esto en el HTML)
        // Pero mantenemos el cierre automático y la animación de entrada

        // 1. Animar la entrada
        setTimeout(() => {
            flashMessage.classList.remove('opacity-0', 'translate-y-4');
        }, 100); // Pequeño retraso para que la animación se active

        // 2. Animar la salida y eliminar después de 5 segundos
        setTimeout(() => {
            closeFlashMessage();
        }, 5000); // 5000ms = 5 segundos
    }

