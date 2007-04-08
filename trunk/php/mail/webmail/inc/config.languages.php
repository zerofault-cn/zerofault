<?
########################################################################
# Language & themes settings
########################################################################

$allow_user_change_theme			= no; //allow users select theme
$default_theme					= 0; //index of theme, starting with zero
$allow_user_change_language			= yes; //allow users select language
$default_language				= 0; //index of language, starting with zero

// themes /////////////////////////////////////
$themes[] = Array(
	"name" 		=> "Default",
	"path" 		=> "default"
);

// languages /////////////////////////////////////////////
$languages[] = Array(
	"name" 		=> "English",
	"path" 		=> "en"
);
$languages[] = Array(
	"name" 		=> "German",
	"path" 		=> "de"
);
$languages[] = Array(
	"name" 		=> "Swedish",
	"path"	 	=> "se"
);
$languages[] = Array(
	"name" 		=> "Simplified Chinese",
	"path"	 	=> "ch_gb"
);

$languages[] = Array(
	"name" 		=> "Traditional Chinese",
	"path"	 	=> "ch_big5"
);

?>