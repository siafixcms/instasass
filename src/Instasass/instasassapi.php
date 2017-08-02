<?php

// Set the namespace
namespace Instasass;

// Use the RPC client
use JsonRPC\Client;

/**
 * Instasass service class
 *
 * @package Instasass
 * @author  Valdis Licis
 */
Class instasassapi {

	/**
	* Some variables
	*/
	private $rClient = null;
	private $aUrls = array();


	function __construct( $sApiKey ) {
		$this->rClient = new Client('https://instasass.lc.lv/api/?api_key=' . $sApiKey);
	}

	/**
	* Does the calls to the API
	*/
	public function __call($sName, $aArgs) {
		return $this->rClient->execute($sName, $aArgs);	
	}

	/**
	* This is a function that allows you to save calls to the API
	* @param string
	* @param bool
	* @param bool
	* @return string
	* @author Valdis Licis
	*/
	public function sass2cssSaved( $sSrc, $bReturnSource = false, $bRecreate = false, $sCompilingMode = 'compressed', $bGoAroundCDN = false ) {
		global $_SESSION;
		if( !isset($_SESSION['rawSCSS'][$sSrc]) || $bRecreate ) {
			$_SESSION['rawSCSS'][$sSrc] = file_get_contents($sSrc);
		}
		if( $bReturnSource ) {
			if( !isset($_SESSION['cssSources'][md5($_SESSION['rawSCSS'][$sSrc])]) ) {
				$_SESSION['cssSources'][md5($_SESSION['rawSCSS'][$sSrc])] = $this->sass2css($_SESSION['rawSCSS'][$sSrc], $bReturnSource, $sCompilingMode, $bGoAroundCDN);
			}
			return $_SESSION['cssSources'][md5($_SESSION['rawSCSS'][$sSrc])];
		} else {
			if( !isset($_SESSION['cssURLs'][md5($_SESSION['rawSCSS'][$sSrc])]) ) {
				$_SESSION['cssURLs'][md5($_SESSION['rawSCSS'][$sSrc])] = $this->sass2css($_SESSION['rawSCSS'][$sSrc], $bReturnSource, $sCompilingMode, $bGoAroundCDN);
			}
			return $_SESSION['cssURLs'][md5($_SESSION['rawSCSS'][$sSrc])];
		}
	}
}
