<head>
<title>Nav Bar</title>
<? // <link rel="stylesheet" href="pagestyle.css">

?>

</head>
<body>

<?

$counter=0;

function show_navbar()
{
$link[0]=array("home","URL1");
$link[1]=array("tracking","URL2");
$link[2]=array("dalies","URL3");
$link[3]=array("photos","URL4");


$section_name="links";

$menu_image["height"]=17;
$menu_image["width"]=130;
$menu_image["vspace"]=3;
$menu_image["regular"]="images/nav-button-regular.png";
$menu_image["over"]="images/nav-button-mouseover.png";
$menu_image["selected"]="images/nav-button-selected.png";

echo "<table cellpadding=0 cellspacing=0 border=0>";


foreach ($link as $section_num => $section_info)
        {
        if ($section_info[0]==$section_name)
             {
             $imx[0]=$menu_image["selected"];
             $imx[1]=$menu_image["over"];
             }
           else
             {
             $imx[1]=$menu_image["over"];
             $imx[0]=$menu_image["regular"];
             }


        echo "\n<tr>";
        echo "\n<td \nalign=center \nheight=".$menu_image["height"]." \nwidth=".$menu_image["width"];
        echo "\nbackground=\"".$imx[0]."\"";
        echo "\nid=\"navmenu_".$section_num."\" ";
        echo "\nonclick=\"self.location='".$section_info[1]."';\"";
        echo "\nonmouseover=\"this.style.cursor='hand'; this.style.backgroundImage='url(".$imx[1].")';\"";
        echo "\nonmouseout=\"this.style.backgroundImage='url(".$imx[0].")';\"";
        echo "\n>\n";
        echo $section_info[0];
        echo "\n</td>";
        echo "\n</tr>";
        echo "\n\n";

        }

echo "</table>";
}

show_navbar();
?>

</body>