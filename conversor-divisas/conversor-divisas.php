<?php

/**
 * Plugin Name: Conversor de USD a ARS
 * Description: Un plugin sencillo para convertir de USD a pesos argentinos utilizando la API de Dólar API.
 * Version: 1.1
 * Author: Franco Juárez
 */

// Evitar el acceso directo
if (!defined('ABSPATH')) {
  exit;
}

// Incluir archivos necesarios de la carpeta 'includes'
require_once plugin_dir_path(__FILE__) . 'includes/activacion.php';
require_once plugin_dir_path(__FILE__) . 'includes/desactivacion.php';

// Hook de activación
register_activation_hook(__FILE__, 'mi_plugin_activacion');

// Hook de desactivación
register_deactivation_hook(__FILE__, 'mi_plugin_desactivacion');

// Encolar estilos
function currency_converter_enqueue_scripts()
{
  wp_enqueue_style('currency-converter-style', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'currency_converter_enqueue_scripts');

// Registrar el shortcode para mostrar el formulario en el frontend
add_shortcode('currency_converter', 'mostrar_formulario_conversion');

// Función que mostrará el formulario o el contenido
function mostrar_formulario_conversion()
{
  ob_start(); // Capturar la salida

  // Inicializar el monto si se envió el formulario
  $monto_inicial = isset($_POST['monto']) ? floatval($_POST['monto']) : '';

  // Obtener la comisión desde las opciones de WordPress
  $comision = get_option('currency_converter_comision', 0);

?>
  <div class="currency-converter">
    <h4>Convertí tus dólares ahora</h4>
    <form id="conversion-form" action="" method="post">
      <label for="monto">Monto en USD:</label>
      <input type="number" id="monto" name="monto" step="0.01" placeholder="Ingrese el monto en USD" required value="<?php echo $monto_inicial; ?>">
      <br><br>
      <input id="convert-btn" type="submit" value="Convertir">
    </form>

    <div id="resultado-conversion" style="margin-top: 20px;">
      <label for="resultado">Resultado en ARS:</label>
      <input type="text" id="resultado" value="" readonly>
      <?php
      if (isset($_POST['monto'])) {
        $tasa_cambio = obtener_tasa_cambio_usd_ars();
        if ($tasa_cambio) {
          $conversion = $monto_inicial * $tasa_cambio;
          $conversion_con_comision = $conversion + ($conversion * ($comision / 100)); // Aplicar comisión
          echo "<script>document.getElementById('resultado').value = '" . number_format($conversion_con_comision, 2) . " ARS';</script>";
        } else {
          echo "<p style='color: red;'>Error obteniendo la tasa de cambio. Intente nuevamente.</p>";
        }
      }
      ?>
    </div>
    <script>
      history.replaceState(null, null, location.pathname);
    </script>
  </div>
<?php
  return ob_get_clean(); // Devolver la salida capturada
}

// Función para obtener la tasa de cambio desde Dólar API
function obtener_tasa_cambio_usd_ars()
{
  $url = 'https://dolarapi.com/v1/dolares/oficial';
  $response = wp_remote_get($url);

  if (is_wp_error($response)) {
    return false; // Error en la solicitud
  }

  $body = wp_remote_retrieve_body($response);
  $data = json_decode($body, true);

  if (isset($data['compra'])) { // Usamos el valor de compra del dólar oficial
    return floatval($data['compra']);
  }

  return false; // Si no se encuentra la tasa de cambio
}

// === Aquí comienza la funcionalidad de la página de configuración ===

// Agregar la opción de menú en el backend
function currency_converter_add_admin_menu()
{
  add_menu_page(
    'Conversor de USD a ARS', // Título de la página
    'Conversor Divisas', // Título del menú
    'manage_options', // Capacidad
    'currency_converter', // Slug
    'currency_converter_settings_page', // Función que mostrará la página
    'dashicons-money-alt', // Icono del menú
    100 // Posición
  );
}
add_action('admin_menu', 'currency_converter_add_admin_menu');

// Página de configuración
function currency_converter_settings_page()
{
?>
  <div class="wrap">
    <h1>Configuración del Conversor de Divisas</h1>
    <form method="post" action="options.php">
      <?php
      settings_fields('currency_converter_settings_group'); // Nombre del grupo de ajustes
      do_settings_sections('currency_converter'); // Nombre de la página
      submit_button(); // Botón para guardar
      ?>
    </form>
  </div>
<?php
}

// Registrar el ajuste de comisión
function currency_converter_register_settings()
{
  register_setting('currency_converter_settings_group', 'currency_converter_comision');

  add_settings_section(
    'currency_converter_settings_section',
    'Ajustes de Comisión',
    'currency_converter_settings_section_callback',
    'currency_converter'
  );

  add_settings_field(
    'currency_converter_comision',
    'Comisión (%)',
    'currency_converter_comision_render',
    'currency_converter',
    'currency_converter_settings_section'
  );
}
add_action('admin_init', 'currency_converter_register_settings');

function currency_converter_settings_section_callback()
{
  echo 'Configure el porcentaje de comisión a aplicar en cada conversión.';
}

function currency_converter_comision_render()
{
  $comision = get_option('currency_converter_comision', 0); // Obtener el valor actual o 0 por defecto
  echo '<input type="number" name="currency_converter_comision" value="' . esc_attr($comision) . '" step="0.01" min="0" /> %';
}
