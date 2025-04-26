OsiReverse-shell.php 
=====================

Es una reverse shell escrita en PHP diseñada para ser utilizada en entornos de pruebas de penetración. Este script establece una conexión con un servidor remoto (IP y puerto configurables) y ejecuta un shell interactivo.

Caracteristicas:
----------------
▶️Conexión remota interactiva mediante sockets TCP.

▶️Auto-discovery del entorno de ejecución:

* Usuario actual.

* UID / GID del proceso.

* Sistema operativo detectado.

* Shell por defecto.

▶️Uso de stream\_select para comunicación eficiente y no bloqueante.

▶️Configuración sencilla de IP, puerto y shell remoto.

▶️Manejo de errores básico y mensajes de depuración opcionales.

⚠️ Advertencia
===============================
Este script está destinado exclusivamente para fines educativos, pruebas de penetración autorizadas y auditorías de seguridad. El uso no autorizado puede ser ilegal. Al utilizar este proyecto, aceptas hacerlo bajo tu propio riesgo y responsabilidad.