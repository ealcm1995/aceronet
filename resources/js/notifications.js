// Configuración base de Toastr
const toastrConfig = {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-bottom-right",
    preventDuplicates: true,
    showDuration: "200",
    hideDuration: "500",
    timeOut: "500",
    extendedTimeOut: "500",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
};

// Estilos personalizados
const toastrStyles = `
    #toast-container {
        position: fixed !important;
        bottom: 15px !important;
        right: 15px !important;
        top: unset !important;
    }
    #toast-container > .toast-success {
        background-image: none !important;
        padding: 15px 15px 15px 15px;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border-left: 5px solid #047857;
        background-color: #059669 !important;
        width: 400px;
        opacity: 1;
    }
    .toast-message {
        font-size: 1rem;
        font-weight: 500;
        color: white;
        display: flex;
        align-items: center;
        line-height: 1.5;
    }
`;

// Función para inicializar las notificaciones
function initializeNotifications() {
    // Aplicar configuración
    toastr.options = toastrConfig;
    
    // Agregar estilos
    const styleElement = document.createElement('style');
    styleElement.textContent = toastrStyles;
    document.head.appendChild(styleElement);
}

// Función helper para mostrar notificación de éxito
function showSuccessNotification(message, callback = null) {
    toastr.remove();
    toastr.success(message, null, {
        timeOut: 300,
        onHidden: callback
    });
}

// Función helper para mostrar notificación de error
function showErrorNotification(message) {
    toastr.remove();
    toastr.error(message, 'Error');
}

// Exportar funciones
window.initializeNotifications = initializeNotifications;
window.showSuccessNotification = showSuccessNotification;
window.showErrorNotification = showErrorNotification; 