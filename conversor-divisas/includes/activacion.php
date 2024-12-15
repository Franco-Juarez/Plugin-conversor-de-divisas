<?php
// Función que se ejecuta cuando el plugin es activado
function mi_plugin_activacion()
{
  // Aquí puedes agregar lógica como crear tablas en la base de datos o agregar opciones por defecto
  if (!get_option('mi_plugin_opcion')) {
    update_option('mi_plugin_opcion', 'valor_inicial');
  }
}
