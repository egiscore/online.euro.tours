<?php 
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2006 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: fckeditor.php
 * 	This is the integration file for PHP.
 * 	
 * 	It defines the FCKeditor class that can be used to create editor
 * 	instances in PHP pages on server side.
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

class FCKeditor
{
	var $InstanceName ;
	var $BasePath ;
	var $Width ;
	var $Height ;
	var $ToolbarSet ;
	var $Value ;
	var $Config ;

	// PHP 5 Constructor (by Marcus Bointon <coolbru@users.sourceforge.net>)
	function __construct( $instanceName )
 	{
        $this->InstanceName	= $instanceName ;
		$this->BasePath		= WWWROOT.'vendor/fckeditor/' ;
		$this->Width		= '100%' ;
		$this->Height		= '200' ;
		$this->ToolbarSet	= 'Default' ;
		$this->Value		= '' ;

		$this->Config		= array() ;
	}
	
	// PHP 4 Contructor
	function FCKeditor( $instanceName )
	{
		$this->__construct( $instanceName ) ;
	}

	function Create()
	{
		echo $this->CreateHtml() ;
	}
	
	function CreateHtml()
	{
		if (!class_exists('Samo_String',false)) {
            include_once _ROOT.'includes/classes/class.samo_string.php';
        }
        $HtmlValue = Samo_String::set($this->Value)->safehtml(true);

		$Html = '<div>' ;
		
		if ( $this->IsCompatible() )
		{
			if ( isset( $_GET['fcksource'] ) && $_GET['fcksource'] == "true" )
				$File = 'fckeditor.original.html' ;
			else
				$File = 'fckeditor.html' ;

			$Link = "{$this->BasePath}editor/{$File}?InstanceName={$this->InstanceName}" ;
			
			if ( $this->ToolbarSet != '' )
				$Link .= "&amp;Toolbar={$this->ToolbarSet}" ;

			// Render the linked hidden field.
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}\" name=\"{$this->InstanceName}\" value=\"{$HtmlValue}\" style=\"display:none\" />" ;

			// Render the configurations hidden field.
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}___Config\" value=\"" . $this->GetConfigFieldString() . "\" style=\"display:none\" />" ;

			// Render the editor IFRAME.
			$Html .= "<iframe id=\"{$this->InstanceName}___Frame\" src=\"{$Link}\" width=\"{$this->Width}\" height=\"{$this->Height}\" frameborder=\"0\" scrolling=\"no\"></iframe>" ;
		}
		else
		{
			if ( strpos( $this->Width, '%' ) === false )
				$WidthCSS = $this->Width . 'px' ;
			else
				$WidthCSS = $this->Width ;

			if ( strpos( $this->Height, '%' ) === false )
				$HeightCSS = $this->Height . 'px' ;
			else
				$HeightCSS = $this->Height ;

			$Html .= "<textarea name=\"{$this->InstanceName}\" rows=\"4\" cols=\"40\" style=\"width: {$WidthCSS}; height: {$HeightCSS}\">{$HtmlValue}</textarea>" ;
		}

		$Html .= '</div>' ;
		
		return $Html ;
	}

	function IsCompatible() {
		$sAgent = $_SERVER['HTTP_USER_AGENT'] ;
		if ( strpos($sAgent, 'MSIE') !== false && strpos($sAgent, 'mac') === false && strpos($sAgent, 'Opera') === false ) {
			$iVersion = (float)substr($sAgent, strpos($sAgent, 'MSIE') + 5, 3) ;
            return ($iVersion >= 5.5) ;
		} else if ( strpos($sAgent, 'Gecko/') !== false ) {
			$iVersion = (int)substr($sAgent, strpos($sAgent, 'Gecko/') + 6, 8) ;
			return ($iVersion >= 20030210);
		} else if ( strpos($sAgent,'Gecko') !== false && strpos($sAgent,'rv:') !== false) {
            $iVersion = (float)substr($sAgent,strpos($sAgent,'rv:') + 3,3);
            return $iVersion < 11.0;
        } else if ( strpos($sAgent, 'Opera/') !== false ) {
			$fVersion = (float)substr($sAgent, strpos($sAgent, 'Opera/') + 6, 4) ;
			return ($fVersion >= 9.5) ;
		} else if ( preg_match( "|AppleWebKit/(\d+)|i", $sAgent, $matches ) ) {
			$iVersion = $matches[1] ;
			return ( $iVersion >= 522 ) ;
		}
		return false ;
	}

	function GetConfigFieldString()
	{
		$sParams = '' ;
		$bFirst = true ;

		foreach ( $this->Config as $sKey => $sValue )
		{
			if ( $bFirst == false )
				$sParams .= '&amp;' ;
			else
				$bFirst = false ;
			
			if ( $sValue === true )
				$sParams .= $this->EncodeConfig( $sKey ) . '=true' ;
			else if ( $sValue === false )
				$sParams .= $this->EncodeConfig( $sKey ) . '=false' ;
			else
				$sParams .= $this->EncodeConfig( $sKey ) . '=' . $this->EncodeConfig( $sValue ) ;
		}
		
		return $sParams ;
	}

	function EncodeConfig( $valueToEncode )
	{
		$chars = array( 
			'&' => '%26', 
			'=' => '%3D', 
			'"' => '%22' ) ;

		return strtr( $valueToEncode,  $chars ) ;
	}
}

?>