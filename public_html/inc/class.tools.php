<?php

// Ensure environment is loaded
if (!function_exists('env')) {
    require_once __DIR__ . '/env_loader.php';
}

// Backup Class
class tools{

    private function writeUTF8filename($filenamename,$content){
        $f=fopen($filenamename,"w+");
        fwrite($f, pack("CCC",0xef,0xbb,0xbf));
        fwrite($f,$content);
        fclose($f);
    }

    // Backup MySQL DATABASE - returns true/false, no message output
    function backup_database($tables){
        $b = new DBBackup(array(
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'user' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'database' => env('DB_NAME_PUBLIC', 'ydiedu_ydi')
        ));
        $backup = $b->backup();

        if(!$backup['error']){
            $timestamp = date('Y-m-d_H-i-s');
            $filename = '../content/backup/ydi_db_' . $timestamp . '.sql';
            $this->writeUTF8filename($filename, $backup['msg']);
            return true;
        } else {
            return false;
        }
    }

    // Delete SQL File From Server - returns true/false
    function delete_sql($file){
        // Validate filename
        $file = basename($file);
        $sql = $file.".sql";
        $path = "../content/backup/".$sql;

        if(file_exists($path) && unlink($path)){
            if(function_exists('adminAlert')) {
                adminAlert("success", "Database backup deleted successfully");
            }
            return true;
        }else{
            if(function_exists('adminAlert')) {
                adminAlert("error", "Error deleting file");
            }
            return false;
        }
    }

    // Backup website files - returns true/false
    function backup_files(){
        $timestamp = date('Y-m-d_H-i-s');
        $archive = new PclZip("../content/backup/ydi_files_" . $timestamp . ".zip");

        $v_dir = dirname(getcwd());
        $v_remove = $v_dir;

        $v_list = $archive->create($v_dir, PCLZIP_OPT_REMOVE_PATH, $v_remove);

        if ($v_list == 0) {
            if(function_exists('adminAlert')) {
                adminAlert("error", $archive->errorInfo(true));
            }
            return false;
        }else{
            if(function_exists('adminAlert')) {
                adminAlert("success", "Website backup created successfully!");
            }
            return true;
        }
    }

    // Delete Files backup From Server - returns true/false
    function delete_files($file){
        // Validate filename
        $file = basename($file);
        $zip = $file.".zip";
        $path = "../content/backup/".$zip;

        if(file_exists($path) && unlink($path)){
            if(function_exists('adminAlert')) {
                adminAlert("success", "Backup file deleted successfully");
            }
            return true;
        }else{
            if(function_exists('adminAlert')) {
                adminAlert("error", "Error deleting file");
            }
            return false;
        }
    }

    // Legacy methods for backwards compatibility
    function db_backups(){ /* Deprecated - handled by tools.php */ }
    function files_backups(){ /* Deprecated - handled by tools.php */ }
}
?>
