<?php
echo '<h2>PHP Version: ' . PHP_VERSION . '</h2>';
echo '<h2>mbstring: ' . (function_exists('mb_strimwidth') ? '<span style="color:green">OK</span>' : '<span style="color:red">MANQUANT</span>') . '</h2>';
echo '<h2>Extensions chargées:</h2><pre>';
print_r(get_loaded_extensions());
echo '</pre>';
echo '<h2>php.ini utilisé:</h2><pre>' . php_ini_loaded_file() . '</pre>';
echo '<h2>Fichiers ini additionnels:</h2><pre>' . php_ini_scanned_files() . '</pre>';
