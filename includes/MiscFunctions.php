<?php

/* $Id: MiscFunctions.php 4761 2011-12-03 03:03:38Z daintree $*/

/*  ******************************************  */
/** STANDARD MESSAGE HANDLING & FORMATTING **/
/*  ******************************************  */

function prnMsg($Msg,$Type='info', $Prefix=''){

	echo getMsg($Msg, $Type, $Prefix);

}//prnMsg

function reverse_escape($str) {
  $search=array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
  $replace=array("\\","\0","\n","\r","\x1a","'",'"');
  return str_replace($search,$replace,$str);
}

//getMsg
function getMsg($Msg,$Type='info',$Prefix=''){
	$Colour='';
	if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>0) {
		$LogFile=fopen($_SESSION['LogPath'].'/webERP-test.log', 'a');
	}
	switch($Type){
		case 'error':
			$Class = 'error';
			$Prefix = $Prefix ? $Prefix : _('ERROR') . ' ' ._('Message Report');
			if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>0) {
				fwrite($LogFile, date('Y-m-d h-m-s').','.$Type.','.$_SESSION['UserID'].','.trim($Msg,',')."\n");
			}
			break;
		case 'warn':
			$Class = 'warn';
			$Prefix = $Prefix ? $Prefix : _('WARNING') . ' ' . _('Message Report');
			if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>1) {
				fwrite($LogFile, date('Y-m-d h-m-s').','.$Type.','.$_SESSION['UserID'].','.trim($Msg,',')."\n");
			}
			break;
		case 'success':
			$Class = 'success';
			$Prefix = $Prefix ? $Prefix : _('SUCCESS') . ' ' . _('Report');
			if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>3) {
				fwrite($LogFile, date('Y-m-d h-m-s').','.$Type.','.$_SESSION['UserID'].','.trim($Msg,',')."\n");
			}
			break;
		case 'info':
		default:
			$Prefix = $Prefix ? $Prefix : _('INFORMATION') . ' ' ._('Message');
			$Class = 'info';
			if (isset($_SESSION['LogSeverity']) and $_SESSION['LogSeverity']>2) {
				fwrite($LogFile, date('Y-m-d h-m-s').','.$Type.','.$_SESSION['UserID'].','.trim($Msg,',')."\n");
			}
	}
	return '<div class="'.$Class.'"><b>' . $Prefix . '</b> : ' .$Msg . '</div>';
}

function IsEmailAddress($Email){

	$AtIndex = strrpos ($Email, "@");
	if ($AtIndex == false) {
	    return  false;	// No @ sign is not acceptable.
	}

	if (preg_match('/\\.\\./', $Email)){
	    return  false;	// > 1 consecutive dot is not allowed.
	}
	//  Check component length limits
	$Domain = mb_substr ($Email, $AtIndex+1);
	$Local= mb_substr ($Email, 0, $AtIndex);
	$LocalLen = mb_strlen ($Local);
	$DomainLen = mb_strlen ($Domain);
	if ($LocalLen < 1 || $LocalLen > 64){
	    // local part length exceeded
	    return  false;
	}
	if ($DomainLen < 1 || $DomainLen > 255){
	    // domain part length exceeded
	    return  false;
	}

	if ($Local[0] == '.' OR $Local[$LocalLen-1] == '.') {
	    // local part starts or ends with '.'
	    return  false;
	}
	if (!preg_match ('/^[A-Za-z0-9\\-\\.]+$/', $Domain )){
	    // character not valid in domain part
	    return  false;
	}
	if (!preg_match ('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace ("\\\\", "" ,$Local) )){
	    // character not valid in local part unless local part is quoted
	    if (!preg_match ('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $Local) ))  {
			return  false;
	    }
	}

	//  Check for a DNS 'MX' or 'A' record.
	//  Windows supported from PHP 5.3.0 on - so check.
	$Ret = true;
	/*  Apparentely causes some problems on some versions - perhaps bleeding edge just yet
	if (version_compare(PHP_VERSION, '5.3.0') >= 0 OR mb_strtoupper(mb_substr(PHP_OS, 0, 3) !== 'WIN')) {
	    $Ret = checkdnsrr( $Domain, 'MX' ) OR checkdnsrr( $Domain, 'A' );
	}
	*/
	return  $Ret;
}

//  Lindsay debug stuff
function LogBackTrace( $dest = 0 ) {
    error_log( "***BEGIN STACK BACKTRACE***", $dest );

    $stack = debug_backtrace();
    //  Leave out our frame and the topmost - huge for xmlrpc!
    for( $ii = 1; $ii < count( $stack ) - 3; $ii++ )
    {
	$frame = $stack[$ii];
	$msg = "FRAME " . $ii . ": ";
	if( isset( $frame['file'] ) ) {
	    $msg .= "; file=" . $frame['file'];
	}
	if( isset( $frame['line'] ) ) {
	    $msg .= "; line=" . $frame['line'];
	}
	if( isset( $frame['function'] ) ) {
	    $msg .= "; function=" . $frame['function'];
	}
	if( isset( $frame['args'] ) ) {
	    // Either function args, or included file name(s)
	    $msg .= ' (';
	    foreach( $frame['args'] as $val ) {

			$typ = gettype( $val );
			switch( $typ ) {
				case 'array':
				    $msg .= '[ ';
				    foreach( $val as $v2 ) {
						if( gettype( $v2 ) == 'array' ) {
						    $msg .= '[ ';
						    foreach( $v2 as $v3 )
							$msg .= $v3;
						    $msg .= ' ]';
						} else {
						    $msg .= $v2 . ', ';
					    }
					    $msg .= ' ]';
					    break;
					}
				case 'string':
				    $msg .= $val . ', ';
				    break;

				case 'integer':
				    $msg .= sprintf( "%d, ", $val );
				    break;

				default:
				    $msg .= '<' . gettype( $val ) . '>, ';
				    break;

		    	}
		    $msg .= ' )';
			}
		}
	error_log( $msg, $dest );
    }

    error_log( '++++END STACK BACKTRACE++++', $dest );

    return;
}

function http_file_exists($url)  {
	$f=@fopen($url,'r');
	if($f) {
		fclose($f);
		return true;
	}
	return false;
}


function english2bangla($input) {
    $bn_digits=array('০','১','২','৩','৪','৫','৬','৭','৮','৯');
    $output = str_replace(range(0, 9),$bn_digits, $input); 
    return $output;
}

function number($inputs)
{
    $digits= array('১ম','২য়','৩য়','৪র্থ','৫ম','৬ষ্ঠ','৭ম','৮ম','৯ম','১০ম','এস.এস.সি','এইচ.এস.সি','অনার্স','মাষ্টার্স','ডিগ্রী','বি.এস.সি','এম.এস.সি','এম.ফিল','পি.এইচ.ডি'); 
    $output =$digits[$inputs];
    return $output;
}
function getProgramType($type)
{
   $arr_type = array('presentation'=>'প্রেজেন্টশন','program'=>'প্রোগ্রাম','training'=>'ট্রেইনিং','travel'=>'ট্র্যাভেল');
   return $arr_type[$type];
}
function getProgramer($type)
{
   $arr_who = array('presentation'=>'প্রেজেন্টার','program'=>'প্রোগ্রামার','training'=>'ট্রেইনার','travel'=>'ট্র্যাভেলার');
   return $arr_who[$type];
}
function getProgramerType($type)
{
   $arr_who_type = array('presentation'=>'presenter','program'=>'programmer','training'=>'trainer','travel'=>'traveler');
   return $arr_who_type[$type];
}
function getAwardType($aType){
    $arr_award_type = array('company'=>'কোম্পানী', 'employee'=>'কর্মচারী', 'customer'=>'কাস্টমার');
    return $arr_award_type[$aType];
}
?>