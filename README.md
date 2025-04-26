OsiReverse-shell.php
=====================

OsiReverse-shell.php es una reverse shell escrita en PHP que establece una conexión remota hacia un servidor atacante, permitiendo la ejecución de comandos de forma interactiva. Este script ha sido diseñado para ser ligero, discreto y con características de auto-descubrimiento del entorno, utilizando stream\_select para mejorar la estabilidad de la conexión.

Características
Conexión remota interactiva mediante sockets TCP.

Auto-discovery del entorno de ejecución:

Usuario actual.

UID / GID del proceso.

Sistema operativo detectado.

Shell por defecto.

Uso de stream_select para comunicación eficiente y no bloqueante.

Configuración sencilla de IP, puerto y shell remoto.

Manejo de errores básico y mensajes de depuración opcionales.

Advertencia
Este script está destinado exclusivamente para fines educativos, pruebas de penetración autorizadas y auditorías de seguridad.
El uso no autorizado puede ser ilegal. Úsalo bajo tu propia responsabilidad.
