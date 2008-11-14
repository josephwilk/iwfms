<? session_start();

// fetch conf file for the admin to function
include_once($root.'/includes/configuration/core_configuration.php');
include_once($root. '/includes/security/admin_logged.php');

$websiteTitle='Intelligent Workflow Managment System';

time::starttiming();

function menu(){        
       
	if( isset($_SESSION['valid_user']) ){
?>
<table border="0" cellpadding="2" cellspacing="1" width="2">
  <tr> 
    <td> <table class="mainNavBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr> 
          <td width="17"><img border="0" src="images/color_bar.gif"></td>
          <td class="menuTitle">Root</td>
        </tr>
      </table>
      <table class="subNavBlock" border="0" cellpadding="2" cellspacing="2" width="100%">
        <tr> 
          <td width="20" align="right"><img src="images/iconHome.gif" vspace="0" hspace="0"></td>
          <td><a href="home.php">Home</a></td>
        </tr>
      
      	<tr> 
          <td><img src="images/icon_logout.gif"></td>
          <td><a href="index.php?logout=yes">Logout</a></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><br> <table class="mainNavBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr> 
          <td width="17"><img src="images/color_bar.gif"></td>
          <td class="menuTitle">Workflow</td>
        </tr>
      </table>
      <table class="subNavBlock" border="0" cellpadding="2" cellspacing="2" width="100%">
        <tr> 
          <td width="20"><img src="images/icon_workflow.gif"></td>
          <td><a href="createWorkflowForm.php">Add workflow</a></td>
        </tr>
      </table></td>
  <tr><td><br> 
   <table class="mainNavBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr> 
          <td width="17"><img src="images/color_bar.gif"></td>
          <td class="menuTitle">System</td>
        </tr>
      </table>
      <table class="subNavBlock" border="0" cellpadding="2" cellspacing="2" width="100%">
        <tr> 
          <td width="20"><img src="images/icon_refresh.gif"></td>
          <td><a href="refreshw3cDTD.php">Refresh HTML specification</a></td>
        </tr>
      </table></td>
  </tr>
  <tr>
  
    <td><br><table class="mainNavBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr> 
          <td width="17"><img src="images/color_bar.gif"></td>
          <td class="menuTitle">Debugging</td>
        </tr>
      </table>
      <table class="subNavBlock" border="0" cellpadding="2" cellspacing="2" width="100%">
        <tr> 
          <td><img src="images/icon_graph.gif"></td>
          <td><a href="prologPlansToGraphs.php">Prolog plans to Graphs</a></td>
        </tr>
        <tr> 
          <td><img src="images/icon_doc.gif"></td>
          <td><a href="doc/">Documentation</a></td>
        </tr>
      </table></td>
  </tr>
</table><br><br>
<?
	}
}

function HTMLHead($websiteTitle){ 

	
header("Expires: Mon, 26 Jul 1997 01:00:00 GMT");
header("Last-Modified: ". gmdate("D, d M Y H:i:s"). " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache"); 
	
	
?>
<!-- GLOBAL HEADER BEGINS -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.1 Transitional//EN">
<html>
<head>
<title>
<?= $websiteTitle; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="style/style.css" type="text/css">
<link rel="alternate stylesheet"
    title="Oldstyle"
    href="http://www.w3.org/StyleSheets/Core/Oldstyle">
</head>
<body >

<div style="position:relative; left:200px; top:108px; visibility:visible"><h3>Workflow is being generated, please wait...</h3></div>
<!-- TITLE -->
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr> 
    <td valign="middle" align="right" class="siteTitle"><img src="images/brain.jpg" > <font color="orange">i</font> W F M S </td>
  </tr>
  <tr> 
    <td class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
  </tr>
</table>
<!-- TITLE ENDS -->
<!-- TOP BAR AND LOGGED INFO -->
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr> 
  <td width="1" class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
    <td class="footerAndHeadercolour" >&nbsp; 
      
   
    <?
    
    // check for logout

    if (! isset($_GET['logout'] ) ){

		loggedIn();

	}else{

		logout();
	
	}
?> 
    
    </td>
    <td width="1" class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
  </tr>
</table>
<!-- TOP BAR AND LOGGED INFO ENDS -->
<!-- OUTER TABLE --><table width="100%" cellpadding="0" cellspacing="0" border="0"> 
<tr> 
<td width="1" class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
  <td> 
    <!-- LINES -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr> 
        <td class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
      </tr>
    </table>
    <!-- LINES END -->
    <!-- MAIN TABLE --><table width="100%" cellpadding="0" cellspacing="0" border="0" height="300"> 
    <tr> 
      <td class="leftTable" valign="top" width="160" align="center">
        <!-- NAV CELL -->
        <br>
        <? 
        menu();
        ?>
      </td>
      <td width="1" class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
      <td width="15"><img src="images/spacer.gif" border="0" width="5" height="1"></td>
      <td valign="top" width="1030"><br> 
        <?
}

HTMLHead($websiteTitle);

 // access restriction
include_once($root. '/includes/security/admin_restrict.php');
?>
      