/**
 * Función global para realizar peticiones AJAX al servidor.
 * 
 * @param {string} url - La URL del endpoint a consultar.
 * @param {object} datos - Objeto clave-valor con los datos a enviar.
 * @param {string} metodo - Método HTTP (GET, POST, PUT, DELETE). Por defecto POST.
 * @returns {Promise<any>} Promesa que resuelve en el JSON devuelto por el servidor.
 */
async function hacerPeticion(url, datos = null, metodo = 'POST') {
    try {
        const opciones = {
            method: metodo.toUpperCase(),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        if (datos) {
            const params = new URLSearchParams();
            for (const key in datos) {
                params.append(key, datos[key]);
            }

            if (opciones.method === 'GET' || opciones.method === 'HEAD') {
                url += (url.includes('?') ? '&' : '?') + params.toString();
            } else {
                opciones.body = params.toString();
            }
        }

        const respuesta = await fetch(url, opciones);
        
        if (!respuesta.ok) {
            throw new Error(`Error HTTP: ${respuesta.status}`);
        }
        
        return await respuesta.json();
    } catch (error) {
        console.error("Error en la petición AJAX:", error);
        throw error;
    }
}
