
    // elemento de notificación
    const flashMessage = document.getElementById('flash-message');

    if (flashMessage) {
        // para cerrar el mensaje con una animación
        const closeFlashMessage = () => {
            flashMessage.classList.add('opacity-0', 'translate-y-4');
            // Esperar a que termine la transición para eliminarlo del DOM
            setTimeout(() => {
                if(flashMessage) { // Doble chequeo por si el usuario lo cierra manualmente
                    flashMessage.remove();
                }
            }, 500); // duración de la transición CSS
        };

        // Animar la entrada
        setTimeout(() => {
            flashMessage.classList.remove('opacity-0', 'translate-y-4');
        }, 100); // retraso para que la animación se active

        // Animar la salida y eliminar después de 5 segundos
        setTimeout(() => {
            closeFlashMessage();
        }, 5000);
    }

