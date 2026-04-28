<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div style="border:1px solid #999;background:#fff;color:#000;padding:8px;margin:6px 0;font-family:monospace;font-size:12px">
    <h4 style="margin:0 0 4px 0">A PHP Error was encountered</h4>
    <p style="margin:2px 0">Severity: <?php echo $severity; ?></p>
    <p style="margin:2px 0">Message:  <?php echo $message; ?></p>
    <p style="margin:2px 0">Filename: <?php echo $filepath; ?></p>
    <p style="margin:2px 0">Line Number: <?php echo $line; ?></p>
    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
        <p>Backtrace:</p>
        <?php foreach (debug_backtrace() as $error): ?>
            <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
                <p style="margin-left:10px">
                    File: <?php echo $error['file']; ?><br>
                    Line: <?php echo $error['line']; ?><br>
                    Function: <?php echo $error['function']; ?>
                </p>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
</div>
