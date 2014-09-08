<?php
include_once('func.php');
if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 1) {
   header('Location: index.php');
   exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>SIPmonitor
<?php
  if(@isset($_GET['site']))
    $site = stripslashes($_GET['site']);
  else
    $site = 'cdr';

  if ($site == 'active')
    echo ' - Active Calls</title><meta http-equiv="refresh" content="5" />';
  else if ($site == 'cdr')
    echo ' - Call Detail Records</title>';
  else if ($site == 'dash')
    echo ' - Dashboard</title>';
  else if ($site == 'about')
    echo ' - About</title>';
  else
    echo '</title>';
?>
  <link rel="stylesheet" type="text/css" href="style/table.css" />
  <link rel="stylesheet" type="text/css" href="style/jquery-ui.min.css" />
  <link rel="stylesheet" type="text/css" href="style/jquery-ui.structure.min.css" />
  <link rel="stylesheet" type="text/css" href="style/jquery-ui.theme.min.css" />
  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="js/sorttable.js"></script>
</head>
<body>

  <!-- Begin Wrapper -->
  <div id="wrapper">

    <!-- Begin Left Column -->
    <div id="leftcolumn">
    <?php
       include_once('menu.php');
    ?>

    </div>
    <!-- End Left Column -->

    <!-- Begin Right Column -->
    <div id="rightcolumn">
    <?php

      if(isset($_GET['mod']) && ($_GET['mod']=='logout')) {
        session_unset();
        session_destroy();
        header('location: index.php?mod=logout');
        exit();
      }


      switch($site)
      {
        case 'dash': require_once 'dash.php';
        break;
        case 'active': require_once 'active.php';
        break;
        case 'about': require_once 'about.php';
        break;
        case 'cdr': require_once 'cdr.php';
        break;
        default: require_once 'cdr.php';
      }

    ?>

     </div>
     <!-- End Right Column -->

   </div>
   <!-- End Wrapper -->

<script>
  $( "#navigation_bar" ).buttonset();

  $( "#tooltip" ).tooltip();
</script>


</body>
</html>
