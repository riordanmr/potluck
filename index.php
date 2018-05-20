<?php
// index.php - PHP version of potluck signup app.
// Originally written by MRR in ca. 2001 in VBScript and Active Server Pages.
// Converted to PHP on 23 June 2007, with help from asp2php converter:
// asp2php (vbscript) converted on Sat Jun 09 09:47:44 2007
// See http://asp2php.naken.cc/download.php
// Resurrected 20 May 2018 for potlucks in Sedona, AZ.
 ?>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="TextPad">
<meta name="author" content="Mark Riordan">
<style>
<!--
h1 {font-family: "Arial, Helvetica"; font-size: 14pt }
h2 {font-family: "Arial, Helvetica"; font-size: 12pt }
body, p, th, td, li, a {font-family: "Verdana"; }
-->
</style>
<title>Cookout at Mark's place</title>
</head>

<?php

include_once("db.php");

function ShowMsg($MyText)
{
  print $MyText."\r\n";
  flush();
}

function error($msg) {
    ?>
    <html>
    <head>
    <script language="JavaScript">
    <!--
        alert("<?=$msg?>");
        history.back();
    //-->
    </script>
    </head>
    <body>
    </body>
    </html>
    <?
    exit;
}


function mrr_mysql_query($sql) {
	$result = mysql_query($sql);
	if(!$result) {
		error('Unable to perform query: ' . mysql_error());
	}
	return $result;
}


function PerformAction($strCmd)
{
  $EventID=2;
  switch ($strCmd) {
    case "delete":
      $strID=$_GET["ID"];
      $sql="DELETE FROM potluckpersondish WHERE ID=".$strID.";";
      $resultDel = mysql_query($sql);
      if (!$resultDel) {
        ShowMsg("<h2>Sorry, a database error has occurred deleting your dish.</h2>");
      } else {
        ShowMsg("<p><strong><em><font color=\"blue\">The dish has been deleted.</font></em></strong></p>");
      }
      break;
    case "add":
		// $_POST contents are already slash-quoted when magic_quotes_gpc is on in PHP.ini,
		// which is the case for MRRR3000Z and 60bits.net.
      $strPerson=$_POST["person"];
      $strDish=$_POST["dish"];
      $sql = "INSERT INTO potluckpersondish SET Person='$strPerson', Dish='$strDish', LastUpdated=Now(), EventID=$EventID;";
      //ShowMsg("About to ". $sql);
      $result = mysql_query($sql);
      if (!$result) {
        ShowMsg("<h2>Sorry, a database error has occurred during insert.</h2>");
      } else {
        ShowMsg("<p><strong><em><font color=\"blue\">A dish for ".$strPerson." has been added.</font></em></strong></p>");
      }
      break;
    case "":
    	// Empty action is OK.
    	break;
    default:
    	ShowMsg("Unknown action: " . $strCmd);
    	break;
  }
}

function CreateDishForm()
{
	$EventID=2;
	dbConnect();
  $sql="SELECT * FROM potluckevents WHERE EventID=$EventID;";
  $result = mrr_mysql_query($sql);
  $Title=mysql_result($result,0, "Title");
  $Welcome=mysql_result($result,0, "Welcome");
?>
<body>
<h1><?php   echo $Title;?></h1>
<p><?php   echo $Welcome;?>
</p>
<p>If you like, you may sign up for a dish to pass below.
(It's optional; there should be plenty of food.)
If you want to change your entry, delete your entry
and then come back and reenter it.
</p>
<p>A hot grill will be available for those who want
something other than burgers.</p>
<form method="post" action="index.php?action=add">
<?php
  $strCmd="";
  if(isset($_GET["action"])) $strCmd = $_GET["action"];
  PerformAction($strCmd);

  $sql="SELECT * FROM potluckpersondish WHERE EventID=$EventID;";
  $result = mrr_mysql_query($sql);
   $NRecords = mysql_num_rows($result);

// Output the table of people already signed up.

  $strRows = "";

  for ($j=0; $j<$NRecords; $j++)
  {
    $strPerson=mysql_result($result, $j, "Person");
    $strDish=mysql_result($result, $j, "Dish");
    $strID=mysql_result($result, $j, "ID");
    $strRows=$strRows."<tr><td>".$strPerson."</td><td>"
      .$strDish."</td><td>"
      ."<a href=\"index.php?action=delete&ID=".$strID."\">Delete</a>"."</td></tr>"."\r\n";

  }

  if ($strRows=="") {
    ShowMsg("<tr><td>You are the first person to sign up!</td></tr>");
  } else {
    ShowMsg("<caption align=\"left\"><font face=\"Tahoma\" size=\"4\">People already signed up</font></caption>");
    ShowMsg("<table border=\"0\" bgcolor=\"ffffa0\" width=\"90%\">");
    ShowMsg("<tr><th align=\"left\">Person</th><th align=\"left\" width=\"60%\">Dish</th>");
    ShowMsg("<th align=\"left\" width=\"15%\">Delete?</th></tr>");
    ShowMsg($strRows);
    ShowMsg("</table>");
  }

  ShowMsg("<center><a href=\"index.php?time=".time()."\">Refresh this list</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center>");
	// Output the table used to enter this user's name and dish.
  ShowMsg("<caption align=\"left\"><font face=\"Tahoma\" size=\"4\">Your name and your dish</caption>");
  ShowMsg("<table bgcolor=\"#e0ffff\" width=\"90%\">");
  ShowMsg("<tr><td align=\"right\">Your name:</td><td><input type=\"text\" name=\"person\" size=\"30\"></td></tr>");
  ShowMsg("<tr><td align=\"right\">Your dish:</td>");
  ShowMsg("<td><textarea name=\"dish\" cols=\"44\" rows=\"3\">".""."</textarea></td></tr>");
}

CreateDishForm();
?>
<tr><td align="right">Click to add your dish:</td>
<td> <input type="Submit" name="Submit" value="Add me">
</td></tr>
</table>
</form>
</body>

</html>

