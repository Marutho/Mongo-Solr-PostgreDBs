<?php

/* Nombre de dominio del servidor Solr */
define('SOLR_SERVER_HOSTNAME', 'solr.example.com');

/* Si ejecutar en modo seguro */
define('SOLR_SECURE', true);

/* Puerto HTTP para la conexión */
define('SOLR_SERVER_PORT', ((SOLR_SECURE) ? 8443 : 8983));

/* Nomre de Usuario de Autenticación Básica de HTTP */
define('SOLR_SERVER_USERNAME', 'admin');

/* Contraseña de Autenticación Básica de HTTP */
define('SOLR_SERVER_PASSWORD', 'admin');

/* Tiempo límite de conexión de HTTP */
/* Es el tiempo máximo en segundos permitido para la operación de transferencia de datos de http. El valor predeterminado es 30 seg. */
define('SOLR_SERVER_TIMEOUT', 10);

/* Nombre de archivo a una clave + certificado privados con formato PEM (concatenado en ese ornden */
define('SOLR_SSL_CERT', 'certs/combo.pem');

/* Nombre de archivo a un certificado privado con formato PEM */
define('SOLR_SSL_CERT_ONLY', 'certs/solr.crt');

/* Nombre de archivo a una clave privada con formato PEM */
define('SOLR_SSL_KEY', 'certs/solr.key');

/* Contraseña para el archivo de clave privada con formato PEM */
define('SOLR_SSL_KEYPASSWORD', 'StrongAndSecurePassword');

/* Nombre del archivo que mantiene uno o más certificados CA para ser verificados con su par */
define('SOLR_SSL_CAINFO', 'certs/cacert.crt');

/* Nombre del directorio que mantiene múltiples certificados CA para ser verificados con su par */
define('SOLR_SSL_CAPATH', 'certs/');

?>