// formateador.js - Función global para formatear números
(function() {
  'use strict';
  
  // Función principal global
  window.formatoEuropeo = function(valor, decimales = 2) {
    if (valor === null || valor === undefined || valor === '') return '';
    
    const num = Number(valor);
    if (isNaN(num)) return valor;
    
    return num.toLocaleString('es-ES', {
      minimumFractionDigits: decimales,
      maximumFractionDigits: decimales,
      useGrouping: true
    });
  };
  
  // Función específica para moneda USD
  window.formatoUSD = function(valor) {
    return window.formatoEuropeo(valor, 2) + ' USD';
  };
  
})();