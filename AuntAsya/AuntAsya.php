<?php
/**
 * @name Aunt Asya has arrived =)
 * @author M1zh0rY
 * @category js clear script
 * Infected Script:
 * JS/Agent.* (all, ESET)
 * JS/Kryptik.LP (ESET)
 * Trojan:JS/BlacoleRef.BC (MCE)
 * @license GNU
 * @version 2.1
 * @tutorial Is script clear js infected file of infected script (see up)
 * @date 10082012 0106
 * @update signature 06072012 2043
 * @author Kokurkin German Sergeevich
 *
 * 00000    000000  0     0    00   0
 * 0    0   0       0     0   0 0   0
 * 0    0   0000     0   0      0   0
 * 0    0   0         0 0       0   0
 * 0000     000000     0        0   0000000
 */
namespace DevilOper;
const DEBUG = true; # for view find infected files

Class __auntAsya {
    static $js_files_list = Array();
    static $js_signature = Array(
        "\\x68", "\\x61r", "\\x43o",
        "\\x64", "\\x65At", "\\x43",
        "\\x61rCod", "\\x86", "\\x61",
        "\\x65", "\\x66r", "\\x6fm",
        "\\x43h", "\\x72", "\\x6fd",
        "\\x68a", "\\x43o", "\\x41",
        "\\x74", "\"fr\"+\"omC\"+\"harCode\"",
        "=\"ev\"+\"al\"", "fr\\x6fmChar", "\\x43",
        "\\x6fd", "\\x65","\\x63",
        "\\x68", "\\x61", "\\x72C",
        "\\x6f", "\\x64e", "\\x41t",
        "[((e)?\"s\":\"\")+\"p\"+\"lit\"](\"a$\"[((e)?\"su\":\"\")+\"bstr\"](1));",
        "\\x6dC", "\\x66r", "\\x68arC",
        "\\x72o", "\\x6dCha", "\\x6fde",
        "\\x6fde", "\\x43ode", "\\x72om",
        "\\x43ha", "\\x72Co", "\\x6d",
        "\\x43ode",
        "f='fr'+'om'+'Ch';f+='arC';f+='ode';",
        "f+=(h)?'ode':\"\";",
        "f='f'+'r'+'o'+'m'+'Ch'+'arC'+'ode';",
        "f='fromCh';f+='arC';f+='qgode'[\"substr\"](2);",
    );
    static $js_infected_file_list = Array();
}

/**
 * This function searching files and add to static pool files for checking
 *
 * @param $dir - var for search dir
 */
function find_js_files($dir){
    if (is_dir($dir)){
        $__dir = opendir($dir);
        while ($item = readdir($__dir)){
            if ($item == '.' || $item == '..') continue;
            find_js_files($dir . DIRECTORY_SEPARATOR . $item);
        }
        closedir($__dir);
    } else {
        if(substr($dir, -3) == '.js') __auntAsya::$js_files_list[] = $dir;
    }
}

/**
 * This function checked all files in pool to infected signature
 */
function choice_infected_files(){
    for ($q=0;count(__auntAsya::$js_files_list)>$q;$q++){
        $_code = file_get_contents(__auntAsya::$js_files_list[$q]);
        $_code = str_replace("\r\n", "\n", $_code);
        for($w=0;count(__auntAsya::$js_signature)>$w;$w++){
            if(strpos($_code, __auntAsya::$js_signature[$w])){
                __auntAsya::$js_infected_file_list[] = Array(
                    "finded_sign" => __auntAsya::$js_signature[$w],
                    "code" => $_code,
                    "file" => __auntAsya::$js_files_list[$q]
                );
                break;
            }
        }
    }
}

/**
 * Debugger function for view in window for job script
 */
function view_infected_js_files(){
    for($i=0;count(__auntAsya::$js_infected_file_list)>$i;$i++){
        $html = "<pre>
			&&&&&
			&& File:&nbsp;".__auntAsya::$js_infected_file_list[$i]['file']."
			&& File finded signature:&nbsp;".__auntAsya::$js_infected_file_list[$i]['finded_sign']."
			&&&&&
		</pre>";
        print_r($html);
    }
}

/**
 * This function creat object for work in infected files
 *
 * @param $js_file - full path to file
 * @return object|false - return open Object files
 */
function load_js_code($js_file){
    return file($js_file);
}

/**
 * @param $js_code - string - file infected code
 * @param $infected_code - string - finding infected signature for clear
 * @param $js_file - file for clear infected signature
 * @param $finded_sign  - string - finding infected signature for clear
 * @return string - cleared code from file
 */
function edit_js_code($js_code, $infected_code, $js_file, $finded_sign){
    for($i=0;count($js_code)>$i;$i++){
        if(strpos($js_code[$i], $finded_sign)){
            unset($js_code[$i]);
        }
    }
    return implode("", $js_code);
}

/**
 * Debugger function for save original file
 * @param $js_file - file
 * @return bool -  true or false to copied file
 */
function rename_old_js_file($js_file){
    $pathArr = explode("/", $js_file);
    $file_name_old = explode(".", $pathArr[count($pathArr)-1]);
    $file_name_old = "_".$file_name_old[0];
    unset($pathArr[count($pathArr)-1]);
    if(!is_dir(implode("/", $pathArr)."/infected/")) mkdir(implode("/", $pathArr)."/infected/");
    $path_fileold = implode("/", $pathArr)."/infected/".$file_name_old;
    if (file_exists($path_fileold)) $path_fileold .= time();
    return copy($js_file, $path_fileold);
}

/**
 * Function to saved new file in cleared code
 * @param $js_file - full file path
 * @param $js_code - cleared code
 */
function save_new_js_file($js_file, $js_code){
    $res = fopen($js_file, "w");
    fwrite($res, $js_code);
    fclose($res);
    chmod($js_file, 0644);
}

/*
Functional Started
*/
#------------------------------------------------------------------------------------------------------------
find_js_files(dirname(__FILE__) . DIRECTORY_SEPARATOR);
#------------------------------------------------------------------------------------------------------------
choice_infected_files();
#------------------------------------------------------------------------------------------------------------
if (DEBUG)
    view_infected_js_files();
#------------------------------------------------------------------------------------------------------------
for($i=0;count(__auntAsya::$js_infected_file_list)>$i;$i++){
    $js_code = load_js_code(__auntAsya::$js_infected_file_list[$i]['file']);
    $cleared_js_code = edit_js_code($js_code, __auntAsya::$js_infected_file_list[$i]['code'], __auntAsya::$js_infected_file_list[$i]['file'], __auntAsya::$js_infected_file_list[$i]['finded_sign']);
    $renamed = rename_old_js_file(__auntAsya::$js_infected_file_list[$i]['file']);
    if(!$renamed) print_r ("<pre>!!!!!!!!!!!!!!!!!!!!!!!!!!!\n\r!!! ERROR! Error rename file: ".__auntAsya::$js_infected_file_list[$i]['file']."\n\r!!!!!!!!!!!!!!!!!!!!!!!!!!!</pre>");
    save_new_js_file(__auntAsya::$js_infected_file_list[$i]['file'], $cleared_js_code);
}
#------------------------------------------------------------------------------------------------------------
exit(print_r("script finished the work"));
#EOF - DevilOper
