<?php
    // A custom set of exceptions and log functions for debugging
    // and reporting info to dev and users alike. 
    //  --Elijah T.he Rose

    class cException extends Exception {
        //Custom Exception
        private static $debugPrepend = '';
        private static $msgPrepend = '';
        private static $msgAppend = '';
        private static $bShowDefault = false;
        private static $modDefault = 'error';
        private $bShow = false;
        private $mod = 'error';

        function __constructor($msg) {
            $argc = func_num_args();
            if($argc >= 2) {
                $this->bShow = func_get_arg(1); }
            if($argc >= 3) {
                $this->mod = func_get_arg(2); }
            parent::__constructor($msg);
            $this->logMsg($msg);
        }
        
        private function logMsg($msg) {
            $debugPrepend = 'ERR '.getClass($this).' ('.$this->getLine().'): ';
            $msgPrep = $msgPrepend.$msg.$msgAppend;
            log::debug( $debugPrepend.$msgPrep );
            if ($bShow) {
                log::info($msgPrep, $mod);
            }
        }

        private function editMsg($pre, $ap) {
            $this->$msgPrepend = $pre;
            $this->$msgAppend = $ap;
        }
    };
    //set_exception_handler('cException');

    // FILE EXCEPTIONS --------------------------------------------------------
    class FileException extends cException {
        // Problems with files; $msg generally represents name of file
    };
    class FileOpenException extends FileException{
        private static $msgPrepend = 'File "';
        private static $msgAppend = '" could not be opened.';
    };
    class FileUploadException extends FileException{
        private static $msgAppend = '" could not be uploaded.';
    };
    class FileUploadTypeException extends FileUploadException{
        private $expectedType = '';
        private $givenType = '';
        // function __constructor($msg, $expectedType, $givenType, $bShow = $this->$bShow, $mod = $this->$mod) {
        //     parent::__constructor($msg);
        //     $this->$expectedType = $expectedType;
        //     $this->$givenType = $givenType;
        //     $msgAppend = '" could not be uploaded due to improper file extension;
        //     expected type "'.$expectedType.'", instead received type "'.$givenType.'.';
        // }
    };
    //Consider simply adding a dataArr parameter to cException that accepts arr
    // of any data and can use that in these scripts, no need to redefine constr.
    // VALIDATION EXCEPTIONS --------------------------------------------------------
        class ValidationException extends cException {};
        class ValidationEmptyException extends ValidationException {};
        class ValidationUnknownMethodException extends ValidationException {};
        
        class ValidationSelectionNonoptionException extends ValidationException{};
        class ValidationSelectionNonmultiException extends ValidationException{};
        
        
        class ValidationNumberException extends ValidationException {};
        class ValidationNumberNotnumericException extends ValidationNumberException {};
        class ValidationNumberOobException extends ValidationNumberException {};
        class ValidationNumberOobMinException extends ValidationNumberOobException {};
        class ValidationNumberOobMaxException extends ValidationNumberOobException {};

        class ValidationDatetimeException extends ValidationException {};
        class ValidationDatetimeCreateException extends ValidationDatetimeException {};
        class ValidationDatetimeNotnumericException extends ValidationDatetimeException {};
        class ValidationDatetimeOobException extends ValidationDatetimeException {};
        class ValidationDatetimeOobMinException extends ValidationDatetimeOobException {};
        class ValidationDatetimeOobMaxException extends ValidationDatetimeOobException {};

        class ValidationAlphanumException extends ValidationException {};
        

        class DatabaseException extends Exception {};
        class DatabaseConnectionException extends DatabaseException {};
        class DatabaseInsertException extends DatabaseException {};
        

    //-------------------------------------------------------------------------
    
    // LOGGER------------------------------------------------------------------
    class log {
        // Define if it is shown on the site, 
        // they are always printed to log though.
        static $bAppend = true; //decides whether to append or overwrite log
        static $bLogger = false;   // General 'show' var; B(oolean: Show) Logger (?), not blogger
        static $bDebug = false;    // Shows dev info
        static $bInfo = true;      // Shows client/users info

        private static function logToFile($msg, $filename='log.txt', $dir = './') {
            $writeType = self::$bAppend ? 'a' : 'w';
            $fo = fopen($dir.$filename, $writeType);
            fwrite($fo, $msg."\n");
            fclose($fo);
        }

        private static function logger ($msg) {
            $argv = func_get_args();
            $bShow = isset($argv[1]) ? $argv[1] : self::$bLogger;
            $modifier = $argv[2] ? $argv[2] : '';
            if(trim($modifier) !== '') {
                // User can still bypass with intermediary whitespace, but
                // preg_match('/\s/', $modifier) is too expensive for each and every log
                // Valid = green; Error = red
                $modClass = ' logLevel_'.$modifier;
                if( !(log::logToFile($msg)) ) { $msg.' ERR COULD NOT LOG MSG.';}
                $msg = '<span class="Log'.$modClass.'">'.$msg.'</span>';
            }
            if ($bShow) { echo($msg); } 
        }

        private static function loggerDump ($var) {
            $argv = func_get_args();
            $bShow = isset($argv[1]) ? $argv[1] : self::$bLogger;
            $modifier = isset($argv[2]) ? $argv[2] : '';
            $modClass = ' logLevel_'.$modifier;

            // Sort of a var_export(), but better.
            ob_start();
            var_dump($var);
            $msg = ob_get_clean();

            self::logToFile($msg);
            if ($bShow) { 
                echo '<span class="Log'.$modClass.'"><br>';
                echo $msg;
                echo '<br></span>';
            } 
        }

        public static function debug($msg) {
            $argv = func_get_args();
            $modifier = isset($argv[1]) ? $argv[1] : 'debug';
            self::logger($msg, self::$bDebug, $modifier);
        }
        
        public static function debugDump($msg) {
            $argv = func_get_args();
            $modifier = isset($argv[1]) ? $argv[1] : 'debug';
            self::loggerDump($msg, self::$bDebug, $modifier);
        }
        
        public static function info($msg) {
            $argv = func_get_args();
            $modifier = isset($argv[1]) ? $argv[1] : '';
            self::logger($msg, self::$bInfo, $modifier);
        }

        public static function displayTable($data, $mod = '', $bHead = true, $bFoot = true) {
            if($bHead) {
                $modClass = ($mod == '') ? '' : ' logLevel_'.$mod;
                echo '<table class="log'.$modClass.'"><tr>';
                foreach(array_keys($data) as $name) {
                    echo '<th>'.$name.'</th>';
                }
                echo '</tr>';
            }

            echo '<tr>';
            foreach($data as $name => $value) {
                if(gettype($value) == 'array') {
                    $value = implode('', $value);
                }
                echo '<td>'.$value.'</td>';
            }
            echo '</tr>';

            if ($bFoot) {
                echo '</table>';
            }
        }

    }
    //-------------------------------------------------------------------------
?>