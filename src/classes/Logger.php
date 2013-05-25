<?php

/**
 * Class for error catching and logging.
 */
final class Logger {

	/**
	 *
	 * @var float Start of script processing
	 */
	private static $start = 0;
	private static $debug = false;

	/**
	 * nastartuje sledování chyb
	 */
	public final static function start($debug = false) {
		self::$debug = $debug;
		error_reporting(E_ALL);
		self::$start = self::getMicrotime();
		set_error_handler(array(__CLASS__, 'errorHandler'), E_ALL);
		set_exception_handler(array(__CLASS__, 'exceptionHandler'));
		register_shutdown_function(array(__CLASS__, 'shutdownHandler'));
		error_reporting(0);
	}

	/**
	 * Zachytává PHP chyby
	 * Funkce se volá automaticky PHP interpreterem
	 * Nevolat přímo!!!
	 * @param int $errNo číslo chyby
	 * @param string $errStr popis chyby
	 * @param string $errFile soubor
	 * @param int $errLine řádek
	 * @param array $errcontext kontext proměnných
	 * @return boolean
	 */
	public final static function errorHandler( $errNo, $errStr, $errFile, $errLine, $errContext = null ) {
		if ( $errNo == E_STRICT ) {
			return false;
		}
		if ( self::$debug ) {
			if ( $errNo == E_ERROR || $errNo == E_USER_ERROR ) {
				$errcolor = "ff0000";
				$errlevel = "ERROR";
			} elseif ( $errNo == E_WARNING || $errNo == E_USER_WARNING ) {
				$errcolor = "ff9900";
				$errlevel = "WARNING";
			} elseif ( $errNo == E_NOTICE || $errNo == E_USER_NOTICE ) {
				$errcolor = "ffdd00";
				$errlevel = "NOTICE";
			} else {
				$errcolor = "ffff00";
				$errlevel = "";
			}
			echo '<div style="z-index: 255;margin: .2em;border: 3px solid #'.$errcolor.'; border-radius: 5px; padding: 10px; background-color: rgba(245,245,245,0.5); font-size: 13px; color: #000000;opacity: 0.8">'
				.'<strong>'.$errlevel.' ['.$errNo.'] '.nl2br($errStr).'</strong> <span style="margin-left: 10px;">File: '.$errFile.' (line: '.$errLine.')</span><span style="color: silver;"> PHP ' . PHP_VERSION . ' (' . PHP_OS . ')</span>'
				.'</div>';
			if ( $errNo == E_ERROR || $errNo == E_USER_ERROR ) {
				header("HTTP/1.1 500 Internal Server Error");
				exit();
			}
		} else {
			if ( $errNo != E_NOTICE && $errNo != E_USER_NOTICE ) {
				$msg = "Date:\t".date("r")."\nErrNo:\t".$errNo."\nFile:\t".$errFile."\nLine:\t".$errLine."\nURL:\t".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."\nDesc:\t".$errStr."\nAgent:\t".$_SERVER['HTTP_USER_AGENT']."\nIP:\t".$_SERVER['REMOTE_ADDR'];
				//odeslání do logu
				error_log($msg."\n\n".str_repeat("-", 100)."\n\n", 3, PATH."log/".date("Y-m-d")."-php.txt");
			}
			//v případě fatal error, ukončím provádění
			if ( $errNo == E_ERROR || $errNo == E_USER_ERROR ) {
				header("Location: /error");
				exit();
			}
		}
		return true;
	}

	public final static function exceptionHandler( $ex ) {
		if ( self::$debug ) {
			echo '<div style="z-index: 255; border: 3px solid red; border-radius: 5px; padding: 10px; background-color: rgba(245,245,245,0.5); font-size: 13px; color: #000000;opacity: 0.8">'
				.'<strong>['.$ex->getCode().'] '.$ex->getMessage().'</strong> <span style="margin-left: 10px;">File: '.$ex->getFile().' (line: '.$ex->getLine().')</span><span style="color: silver;"> PHP ' . PHP_VERSION . ' (' . PHP_OS . ')</span>'
				.'</div>';
		}
		return true;
	}

	public final static function shutdownHandler( ) {
		if ( $error = error_get_last() ) {
			if ( preg_match("%^".PATH."%", $error['file']) ) {
				self::errorHandler($error['type'], $error['message'], $error['file'], $error['line']);
			}
		}
		$processTime = self::getMicrotime() - self::$start;
		if ( $processTime > (self::$debug ? 15.0 : 5.0) ) {
			self::errorHandler(E_USER_WARNING, "Long script execution (".$processTime.")", __FILE__, 0);
		}
		if ( self::$debug ) {
			echo "<div style=\"position: absolute; right: 0px; bottom: 0px;text-shadow:3px 3px 3px gray; color: #000000;\">".$processTime."</div>";
		}
	}

	private static function getMicrotime ( ) {
		list($usec, $sec) = explode(' ', microtime());
		return ((float)$usec + (float)$sec);
	}
	
}

?>
