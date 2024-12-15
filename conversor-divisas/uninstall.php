<?php
// Evitar el acceso directo
if (!defined('WP_UNINSTALL_PLUGIN')) {
  exit;
}

// Lógica para limpiar la base de datos al desinstalar el plugin
delete_option('mi_plugin_opcion');
