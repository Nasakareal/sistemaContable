require('./bootstrap');
import Instascan from 'instascan';

document.addEventListener('DOMContentLoaded', () => {
    const videoElement = document.getElementById('preview');
    if (!videoElement) {
        console.warn("No existe el elemento con id='preview' en la vista.");
        return;
    }

    let scanner = new Instascan.Scanner({ video: videoElement });

    scanner.addListener('scan', (content) => {
        console.log("Contenido escaneado:", content);
        if (content.includes('codigo prod-')) {
            const codigo = content.split('codigo prod-')[1].trim();
            window.location.href = `/productos/${codigo}`;
        } else {
            alert("El código QR no tiene un formato válido (falta 'codigo prod-').");
        }
    });

    Instascan.Camera.getCameras()
        .then((cameras) => {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                alert("No se encontraron cámaras disponibles.");
            }
        })
        .catch((err) => {
            console.error("Error al acceder a las cámaras:", err);
            alert("Hubo un problema al intentar acceder a la(s) cámara(s).");
        });

    const stopButton = document.getElementById('stopScan');
    if (stopButton) {
        stopButton.addEventListener('click', () => {
            scanner.stop();
            alert("Escaneo detenido.");
        });
    }
});
