<?php
// Función que se ejecuta cuando el plugin es desactivado
function mi_plugin_desactivacion()
{
  // Aquí puedes agregar lógica para limpiar transitorios o registros temporales si es necesario
  delete_option('mi_plugin_opcion'); // Esto eliminará la opción al desactivar el plugin
}
