<?php

function getSig($param,$api_secret){
	if( $api_secret != ""){
                foreach($param as $key=>$value){
                    $sig.=$key."=".$value;
                }
		$sig = $sig.$api_secret;
		$sig = md5($sig);
		return $sig;
	}else{
		return "";
	}
}
?>