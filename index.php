<?php
include_once('func.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>SIPmonitor</title>
  <link rel="stylesheet" type="text/css" href="style/jquery-ui.min.css" />
  <link rel="stylesheet" type="text/css" href="style/jquery-ui.structure.min.css" />
  <link rel="stylesheet" type="text/css" href="style/jquery-ui.theme.min.css" />
</head>

<body>



<?php

if(!isset($_POST['login']) || !isset($_POST['password'])) {
?>

  <!-- Begin Wrapper -->
  <div id="wrapper">
    <form method="post" style="margin:auto;width:250px;padding:0px 20px 20px 20px;text-align:center;border:1px solid #C0C0C0">
      <h1>SIPmonitor</h1>
      <input style="width:200px" autocomplete="off" class="ui-autocomplete-input" type="text" name="login" placeholder="Username"><br  />
      <input style="width:200px" autocomplete="off" class="ui-input" type="password" name="password" placeholder="Password"><br />
      <button style="width:200px" role="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-focus" id="button" type="submit"><span class="ui-button-text">Login</span></button>
    </form>
<?php
} else {
  if ($_POST['login']) {
    $login = $_POST['login'];
  } else {
    $login = '';
  }

  if ($_POST['password']) {
    $password = md5($_POST['password']);
  } else {
    $password = 'fred';
  }

  @$select = "SELECT id FROM users WHERE username = '$login' and password='$password'";
  $db = get_db();
  $res = @mysql_query($select);
  $row = @mysql_fetch_row($res);
  if($row[0]>0) {
    $_SESSION['auth'] = 1;
    header('location: gui.php');
    exit();
  } else {
    echo "ERROR: $password";
  }

}
?>

  </div>
   <!-- End Wrapper -->

</body>
</html>
