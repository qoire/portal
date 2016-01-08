<?php
/****************************************************
* PHPLENS configuration version number
*/
$PHPCONFIG_PHPLENS=0.01;


/****************************************************
* Web server path (not file path) to phplens directory .eg: /php/phplens
*/
$PHPLENS_PATH='/lens/';


/* PHPLens 1.1 extension -- do not modify until phplens applets released */
if (!defined('APPLETS_DIR'))
        define('APPLETS_DIR',PHPLENS_DIR.'/builder/objs');

/****************************************************
* Define this if you have all phplens images stored in a
* specialized graphics web server.
*
* This is the url to the parent of the "img" directory on the web server.
*
* Eg. if the graphics are in http://graphics.server.com/phplens/img
*     then set this var = 'http://graphics.server.com/phplens'
*/
# WARNING: DO NOT UNCOMMENT UNLESS YOU HAVE SPECIAL NEEDS
#$PHPLENS_GRAPHICS_SERVER='http://localhost/php/phplens';


/****************************************************
* DB settings to store session information for dynamic editing.
* Used by phplens-session.inc.php
*/
if (!isset($PHPLENS_SESSION_DRIVER)) {
        $PHPLENS_SESSION_DRIVER='mysql';        // database driver to use
        $PHPLENS_SESSION_CONNECT='localhost';         // server address
        $PHPLENS_SESSION_USER ='lens';        // userid
        $PHPLENS_SESSION_PWD ='spatula';        // password
        $PHPLENS_SESSION_DB ='phplens'; // database (optional for some databases)
}


/****************************************************
* define language and location
* legal values are:
*         en_us
*         en_uk
*/
define('PHPLENS_LANG_DEFAULT','en_us');


/****************************************************
* List of databases that the querybuilder can access
*/
$PHPLENS_DATABASES =
array(                        //driver, server address, userid, pwd, database
        'phplens' => array($PHPLENS_SESSION_DRIVER, $PHPLENS_SESSION_CONNECT, $PHPLENS_SESSION_USER, $PHPLENS_SESSION_PWD, $PHPLENS_SESSION_DB),
        'wheris' => array('mysql','localhost','whereis','wald0','whereis')
);
?>
