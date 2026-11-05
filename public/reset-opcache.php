<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo 'OPCache reseteado correctamente.';
} else {
    echo 'OPCache no está habilitado.';
}
