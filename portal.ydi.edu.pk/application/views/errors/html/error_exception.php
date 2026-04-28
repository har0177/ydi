<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="border:1px solid #c00;background:#fff;color:#000;padding:8px;margin:6px 0;font-family:monospace;font-size:12px">
    <h4 style="margin:0 0 4px 0;color:#c00">An uncaught Exception was encountered</h4>
    <p>Type: <?php echo get_class($exception); ?></p>
    <p>Message: <?php echo $message; ?></p>
    <p>Filename: <?php echo $exception->getFile(); ?></p>
    <p>Line Number: <?php echo $exception->getLine(); ?></p>
</div>
