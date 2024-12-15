# Conversor de Divisas para WordPress

Este es un plugin sencillo para WordPress que permite realizar la conversión de divisas utilizando las cotizaciones del dólar en Argentina. El plugin obtiene las tasas de cambio mediante una API externa, proporcionando una herramienta útil para mostrar el valor convertido en tu sitio web.

## Características
- Conversión de divisas basada en la cotización del dólar en Argentina.
- Integración sencilla con WordPress.
- Consulta de una API para obtener datos actualizados de cotización.
- Fácil de instalar y configurar.

## Requisitos
- WordPress 5.0 o superior.
- PHP 7.4 o superior.

## Instalación
1. Descarga el plugin desde este repositorio o clónalo utilizando Git:
   ```bash
   git clone https://github.com/Franco-Juarez/Plugin-conversor-de-divisas.git
   ```

2. Sube la carpeta `conversor-divisas` al directorio `wp-content/plugins` de tu instalación de WordPress.

3. Activa el plugin desde el panel de administración de WordPress en la sección de "Plugins".

4. Configura el plugin desde el menú "Conversor Divisas" en el administrador de WordPress.

## Uso
Una vez activado, el plugin agrega un shortcode que puedes usar en tus entradas o páginas de WordPress. El shortcode tiene la siguiente estructura:

```html
[currency_converter]
```

Esto mostrará un formulario interactivo que permite ingresar un monto en USD y calcular su conversión a ARS utilizando la API de DolarApi: https://dolarapi.com/docs/

Los ajustes, como la comisión a aplicar, se configuran directamente desde el menú de administración de WordPress proporcionado por el plugin.

## Personalización
El plugin está diseñado para ser fácilmente adaptable. Puedes modificar el código en función de tus necesidades específicas o agregar soporte para otras monedas y APIs.

## Contribuciones
¡Las contribuciones son bienvenidas! Si tienes ideas o mejoras para el plugin, no dudes en abrir un issue o enviar un pull request.

## Licencia
Este proyecto está licenciado bajo la [MIT License](https://opensource.org/licenses/MIT). Puedes usarlo y modificarlo libremente, siempre que se mencione al autor original.

## Autor
**Franco Juárez**

Si tienes alguna duda o sugerencia, no dudes en contactarme. ¡Gracias por usar este plugin!

