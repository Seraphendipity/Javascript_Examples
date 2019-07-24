<?php
    // A custom set of exceptions and log functions for debugging
    // and reporting info to dev and users alike. 
    //  --Elijah T.he Rose

    class cException extends Exception {
        //Custom Exception
        private static $debugPrepend = '';
        private static $msgPrepend = '';
        private static $msgAppend = '';
        private $bShow = false;
        private $mod = 'error';

        function __constructor($msg, $bShow = $this->$bShow, $mod = $this->$mod) {
            parent::__constructor($msg);
            $this->bShow = $bShow;
            $this->mod = $mod;
            $this->logMsg($msg);
        }
        
        private function logMsg($msg) {
            $debugPrepend = 'ERR '.getClass($this).' ('.$this->getLine().'): ';
            $msgPrep = $msgPrepend.$msg.$msgAppend;
            log::debug( $debugPrepend.$msgPrep );
            if ($bShow) {
                log::info($msgPrep, $mod)
            }
        }

        private static function editMsg($pre, $ap) {
            $this->$msgPrepend = $pre;
            $this->$msgAppend = $ap;
        }
    };
    set_exception_handler('cException');

    // FILE EXCEPTIONS --------------------------------------------------------
    class FileException extends cException {
        // Problems with files; $msg generally represents name of file
    };
    class FileOpenException extends FileException{
        $self::editMsg('File "','" could not be opened.');
    };
    class FileUploadException extends FileException{};
        $self::editMsg('File "','" could not be uploaded.');
    class FileUploadTypeException extends FileUploadException{
        $expectedType = '';
        $givenType = '';
        function __constructor($msg, $expectedType, $givenType, $bShow = $this->$bShow, $mod = $this->$mod) {
            parent::__constructor($msg);
            $this->$expectedType = $expectedType;
            $this->$givenType = $givenType;
        }
        $self::editMsg('File "','" could not be uploaded due to improper file extension;
        expected type "'.$expectedType.'", instead received type "'.$givenType.'.');
    };
    //Consider simply adding a dataArr parameter to cException that accepts arr
    // of any data and can use that in these scripts, no need to redefine constr.
    //-------------------------------------------------------------------------
    
    // LOGGER------------------------------------------------------------------
    class log {
        // Define if it is shown on the site, 
        // they are always printed to log though.
        static bool $bAppend = true; //decides whether to append or overwrite log
        static bool $bLogger = false;   // General 'show' var; B(oolean: Show) Logger (?), not blogger
        static bool $bDebug = false;    // Shows dev info
        static bool $bInfo = true;      // Shows client/users info

        private static function logToFile($filename='log.txt', $dir = './') {
            $writeType = $bAppend ? 'a' : 'w';
            $fo = fopen($dir.$filename, $writetype);
            fwrite($fo, $msg."\n");
            fclose($fo);
        }

        private static function logger ($msg, $bShow = $bLogger, $modifier='') {
            if(trim($modifier) !== '') {
                // User can still bypass with intermediary whitespace, but
                // preg_match('/\s/', $modifier) is too expensive for each and every log
                // Valid = green; Error = red
                $modClass = ' logLevel_'.$modifier;
            }
            if( !(log::logToFile($msg)) ) { $msg.' ERR COULD NOT LOG MSG.';}
            $msg = '<span class="Log'.$modClass.'">'.$msg.'</span>';
            if ($bShow) { echo($msg); } 
        }

        private static function loggerDump ($var, $bShow = $bLogger, $modifier='') {
            if(trim($modifier) !== '') {
                // User can still bypass with intermediary whitespace, but
                // preg_match('/\s/', $modifier) is too expensive for each and every log
                $modClass = ' LogLevel_'.$modifier;
            }

            // Sort of a var_export(), but better.
            ob_start();
            var_dump($var);
            $msg = ob_get_clean();

            self::logToFile($msg);
            if ($bShow) { var_dump($var); } 
        }

        public static function debug($msg, $modifier='') {
            self::logger($msg, $bDebug, $modifier);
        }
        
        public static function debugDump($msg, $modifier='') {
            self::loggerDump($msg, $bDebug, $modifier);
        }
        
        public static function info($msg, $modifier='') {
            self::logger($msg, $bInfo, $modifier);
        }

    }
    //-------------------------------------------------------------------------
?>