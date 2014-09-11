<div align="center">

<?php
  //Setup call search form
  if(isset($_GET) && @$_GET['site']=='cdr')
{
  $caller_search_types  = '<div style="font-size:9px;margin-left:90px" id="caller_search_type_bar">';
  $onclick = "$('#caller_search_type').val('s');";
  $caller_search_types .= '<input id="caller_starts_with" onclick="'. $onclick . '" name="caller_search_type_bar" type="radio"                  ><label class="ui-corner-left " value="s" for="caller_starts_with">Starts</label>';
  $onclick = "$('#caller_search_type').val('c');";
  $caller_search_types .= '<input id="caller_contains"    onclick="'. $onclick . '" name="caller_search_type_bar" type="radio" checked="checked"><label                         value="c" for="caller_contains"   >Contains</label>';
  $onclick = "$('#caller_search_type').val('e');";
  $caller_search_types .= '<input id="caller_ends_with"   onclick="'. $onclick . '" name="caller_search_type_bar" type="radio"                  ><label                         value="e" for="caller_ends_with"  >Ends</label>';
  $onclick = "$('#caller_search_type').val('i');";
  $caller_search_types .= '<input id="caller_is"          onclick="'. $onclick . '" name="caller_search_type_bar" type="radio"                  ><label class="ui-corner-right" value="i" for="caller_is"         >Is</label>';
  $caller_search_types .= '</div>';

  $called_search_types  = '<div style="font-size:9px;margin-left:90px" id="called_search_type_bar">';
  $onclick = "$('#called_search_type').val('s');";
  $called_search_types .= '<input id="called_starts_with" onclick="'. $onclick . '" name="called_search_type_bar" type="radio"                  ><label class="ui-corner-left " for="called_starts_with">Starts</label>';
  $onclick = "$('#called_search_type').val('c');";
  $called_search_types .= '<input id="called_contains"    onclick="'. $onclick . '" name="called_search_type_bar" type="radio" checked="checked"><label                         for="called_contains"   >Contains</label>';
  $onclick = "$('#called_search_type').val('e');";
  $called_search_types .= '<input id="called_ends_with"   onclick="'. $onclick . '" name="called_search_type_bar" type="radio"                  ><label                         for="called_ends_with"  >Ends</label>';
  $onclick = "$('#called_search_type').val('i');";
  $called_search_types .= '<input id="called_is"          onclick="'. $onclick . '" name="called_search_type_bar" type="radio"                  ><label class="ui-corner-right" for="called_is"         >Is</label>';
  $called_search_types .= '</div>';

?>

<div id="dialog" title="Search CDR for Calls">
  <form action="gui.php?site=cdr" method="post"><pre>
    Start: <input style="width:120px" type="text" name="start" placeholder="yyyy-mm-dd" value="<?php if (isset($_POST['start'])) echo $_POST['start'] ?>">
      End: <input style="width:120px" type="text" name="end" placeholder="yyyy-mm-dd" value="<?php if (isset($_POST['end'])) echo $_POST['end'] ?>">
   Caller: <input style="width:120px" type="text" name="caller" value="<?php if (isset($_POST['caller'])) echo $_POST['caller'] ?>" /><input type="hidden" name="caller_search_type" id="caller_search_type" value="c" /><?php echo $caller_search_types ?>
   Called: <input style="width:120px" type="text" name="called" value="<?php if (isset($_POST['called'])) echo $_POST['called'] ?>" /><input type="hidden" name="called_search_type" id="called_search_type" value="c" /><?php echo $called_search_types ?>

           <button type="submit" name="search" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text">Search</span></button></pre>
  </form>
</div>
<?php
}
?>

<table class="sortable" style="width:90%">
<tr>
  <th style="text-align:center">ID</th>
  <th style="text-align:center">Call Start<br />(Duration)<br />Connected</th>
  <th style="text-align:right">Caller Num<br />(Name)<br />Codec</th>
  <th style="text-align:right">Caller IP<br />RTP MOS<br />Delay Dist<br />Loss Dist</th>
  <th style="text-align:center">Last Response</th>
  <th style="text-align:right">Called Num</th>
  <th style="text-align:right">Called IP<br />RTP MOS<br />Delay Dist<br />Loss Dist</th>
</tr>
<?php
  global $cdr_num_calls_per_page;
  $db = get_db();

  if(!isset($_GET['str'])) {
    $limit = $cdr_num_calls_per_page;
    $str = 1;
  } else {
    if($_GET['str'] > 0)
      $str = (int)$_GET['str'];
    else
    $str = 1;

    $limit_a = $cdr_num_calls_per_page * ($str - 1);
    $limit = $limit_a . ',' . $cdr_num_calls_per_page;
    $limit = mysql_real_escape_string($limit);
  }

  $select = "SELECT c.id, c.calldate, c.callend, c.duration, c.connect_duration, \n";

  //CALLER DETAILS
  $select .= "c.caller, c.callername, c.caller_domain, c.a_payload, \n";
  $select .= "inet_ntoa(c.sipcallerip) AS caller_ip, c.a_mos_f1_mult10, c.a_mos_f2_mult10, c.a_mos_adapt_mult10, \n";
  $select .= "c.a_d50, c.a_d70, c.a_d90, c.a_d120, c.a_d150, c.a_d200, c.a_d300, \n";
  $select .= "c.a_sl1, c.a_sl2, c.a_sl3, c.a_sl4, c.a_sl5, c.a_sl6, c.a_sl7, c.a_sl8, c.a_sl9, c.a_sl10, \n";
  $select .= "c.a_rtcp_avgjitter_mult10, c.a_rtcp_avgfr_mult10, \n";

  //CALLED DETAILS
  $select .= "c.called, c.called_domain, \n";
  $select .= "inet_ntoa(c.sipcalledip) AS called_ip, c.b_mos_f1_mult10, c.b_mos_f2_mult10, c.b_mos_adapt_mult10, \n";
  $select .= "c.b_d50, c.b_d70, c.b_d90, c.b_d120, c.b_d150, c.b_d200, c.b_d300, \n";
  $select .= "c.b_sl1, c.b_sl2, c.b_sl3, c.b_sl4, c.b_sl5, c.b_sl6, c.b_sl7, c.b_sl8, c.b_sl9, c.b_sl10, \n";
  $select .= "c.b_rtcp_avgjitter_mult10, c.b_rtcp_avgfr_mult10 \n";

  $select .= ", c.lastSIPresponseNum AS last_response \n";

  $select .= "FROM cdr c ";

  // CHECK FOR IGNORED SIP RESPONSES
  if (strlen($sip_responses_to_ignore) > 2) {
    $where_sql = " WHERE lastSIPresponseNum NOT IN ($sip_responses_to_ignore) ";
  } else {
    $where_sql = '';
  }

  if(isset($_POST['start'])) {

    if (strlen($where_sql) < 2)
      $where_sql = ' WHERE ';

    // CHECK DATES
    if((strlen($_POST['start']) > 2) && (strlen($_POST['end']) > 2)) {
      $start = mysql_real_escape_string($_POST['start']);
      $end =  mysql_real_escape_string($_POST['end']);
      if (strlen($where_sql) > 2)
        $where_sql .= ' AND ';
      $where_sql .= "calldate BETWEEN '$start' AND '$end' ";
    } else if (strlen($_POST['start']) > 2) {
      $start = mysql_real_escape_string($_POST['start']);
      if (strlen($where_sql) > 2)
        $where_sql .= ' AND ';
      $where_sql .= "calldate = '$start' ";
    } else if (strlen($_POST['end']) > 2) {
      $end =  mysql_real_escape_string($_POST['end']);
      if (strlen($where_sql) > 2)
        $where_sql .= ' AND ';
      $where_sql .= "calldate = '$end' ";
    }

    // CHECK CALLER FIELD
    if(isset($_POST['caller'])  && (strlen($_POST['caller']) > 2)) {
      $caller = $_POST['caller'];
      if (strlen($where_sql) > 2) {
        $where_sql .= " AND ";
      }
      switch($_POST['caller_search_type']) {
        case "s":
          $where_sql .= "caller LIKE '$caller%' ";
          break;
        case "e":
          $where_sql .= "caller LIKE '%$caller' ";
          break;
        case "i":
          $where_sql .= "caller = '$caller' ";
          break;
        default:
          $where_sql .= "caller LIKE '%$caller%' ";
          break;
      }
    }

    // CHECK CALLED FIELD
    if(isset($_POST['called'])  && (strlen($_POST['called']) > 2)) {
      $called = $_POST['called'];
      if (strlen($where_sql) > 2) {
        $where_sql .= " AND ";
      }
      switch($_POST['called_search_type']) {
        case 's':
          $where_sql .= "called LIKE '$called%' ";
          break;
        case 'e':
          $where_sql .= "called LIKE '%$called' ";
          break;
        case 'i':
          $where_sql .= "called = '$called' ";
          break;
        default:
          $where_sql .= "called LIKE '%$called%' ";
          break;
      }
    }

    $select .= $where_sql;
    $order_sql = "\n ORDER BY calldate DESC LIMIT $limit\n";
    $select .= $order_sql;
  } else {
    $select .= $where_sql;
    $select .= " ORDER BY calldate DESC LIMIT $limit\n";
  }
  $result = mysql_query($select);
  if(mysql_num_rows($result) < 1)
  echo '<tr><td colspan="3"> <div align="center"> NO RESULTS </div></td></tr>';

  $row_num = 1;

  while($row = mysql_fetch_array($result))
  {
    if ($row_num > 1) {
      $row_num = 1;
      echo '  <tr class="even_row">';
    } else {
      echo '  <tr class="odd_row">';
      $row_num += 1;
    }
    echo '    <td style="text-align:center">' . $row['id'] . '</td>';
    echo '    <td style="text-align:center">' . $row['calldate'] . '<br />(' . $row['duration'] . ')<br />' . $row['connect_duration'] . '</td>';

    //DISPLAY CALLER DETAILS
    echo '    <td class="right">' . $row['caller'] . '@' . $row['caller_domain'] . '<br />';
    echo '     (' . $row['callername'] . ')<br />' . get_sip_payload($row['a_payload']);
    echo '    </td>';
    if ($row['a_mos_f1_mult10'] > 0) {
      echo '    <td class="right"><strong>' . $row['caller_ip'] . '</strong><br />';
      echo '      ' . sprintf("%01.1f", $row['a_mos_f1_mult10'] / 10) . '|' . sprintf("%01.1f", $row['a_mos_f2_mult10'] / 10) . '|' . sprintf("%01.1f", $row['a_mos_adapt_mult10'] / 10) . '<br />';
      echo '      ' . $row['a_d50'] . ':' . $row['a_d70'] . ':' . $row['a_d90'] . ':' . $row['a_d120'] . ':' . $row['a_d150'] . ':' . $row['a_d200'] . ':' . $row['a_d300'] . '<br />';
      echo '      ' . $row['a_sl1'] . ':' . $row['a_sl2'] . ':' . $row['a_sl3'] . ':' . $row['a_sl4'] . ':' . $row['a_sl5'] . ':' . $row['a_sl6'] . ':' . $row['a_sl7'] . ':' . $row['a_sl8'] . ':' . $row['a_sl9'] . ':' . $row['a_sl10'] . '</td>';
    } else {
      echo '    <td style="text-align:right">N/A</td>';
    }

    $last_response = get_sip_response($row['last_response']);
    echo '    <td style="text-align:center">' . $row['last_response'] . ' ' . $last_response . '</td>';

    //DISPLAY CALLED DETAILS
    echo '    <td class="right">' . $row['called'] . '@' . $row['called_domain'] . '<br />';
    echo '    </td>';
    if ($row['b_mos_f1_mult10'] > 0) {
      echo '    <td class="right"><strong>' . $row['called_ip'] . '</strong><br />';
      echo '      ' . sprintf("%01.1f", $row['b_mos_f1_mult10'] / 10) . '|' . sprintf("%01.1f", $row['b_mos_f2_mult10'] / 10) . '|' . sprintf("%01.1f", $row['b_mos_adapt_mult10'] / 10).'<br />';
      if ($row['b_rtcp_avgjitter_mult10'] > 0) {
        echo '<span title="Average RTCP Jitter"';
        if (($row['b_rtcp_avgjitter_mult10'] / 10) >= $ugly_jitter_avg) {
          echo ' class="ugly"';
        } else if (($row['b_rtcp_avgjitter_mult10'] / 10) >= $bad_jitter_avg) {
          echo ' class="bad"';
        }
        echo '>J:' . $row['b_rtcp_avgjitter_mult10'] / 10 . '</span> | ';
      }
      echo '<span title="Delayed by: 0 - 50ms">' . $row['b_d50'] . '</span>:';
      echo '<span title="Delayed by: 50 - 70ms">' . $row['b_d70'] . '</span>:';
      echo '<span title="Delayed by: 70 - 90ms">' . $row['b_d90'] . '</span>:';
      echo '<span title="Delayed by: 90 - 120ms">' . $row['b_d120'] . '</span>:';
      echo '<span title="Delayed by: 120 - 150ms">' . $row['b_d150'] . '</span>:';
      echo '<span title="Delayed by: 150 - 200ms">' . $row['b_d200'] . '</span>:';
      echo '<span title="Delayed by: > 200ms">' . $row['b_d300'] . '</span><br />';
      if ($row['b_rtcp_avgfr_mult10'] > 0) {
        echo '<span title="Average RTCP Fraction Loss"';
        if (($row['b_rtcp_avgfr_mult10'] / 10) >= $ugly_loss_avg) {
          echo ' class="ugly"';
        } else if (($row['b_rtcp_avgfr_mult10'] / 10) >= $ugly_loss_avg) {
          echo ' class="bad"';
        }
        echo '>L:' . $row['b_rtcp_avgfr_mult10'] / 10 . '</span> | ';
      }
      echo '<span title="Consecutive Packet Loss Distribution: 1 packet">' . $row['b_sl1'] . '</span>:';
      echo '<span title="Consecutive Packet Loss Distribution: 2 packets">' . $row['b_sl2'] . '</span>:';
      echo '<span title="Consecutive Packet Loss Distribution: 3 packets">' . $row['b_sl3'] . '</span>:';
      echo '<span title="Consecutive Packet Loss Distribution: 4 packets">' . $row['b_sl4'] . '</span>:';
      echo '<span title="Consecutive Packet Loss Distribution: 5 packets">' . $row['b_sl5'] . '</span>:';
      echo '<span title="Consecutive Packet Loss Distribution: 6  packets">' . $row['b_sl6'] . '</span>:';
      echo '<span title="Consecutive Packet Loss Distribution: 7 packets">' . $row['b_sl7'] . '</span>:';
      echo '<span title="Consecutive Packet Loss Distribution: 8 packets">' . $row['b_sl8'] . '</span>:';
      echo '<span title="Consecutive Packet Loss Distribution: 9 packets">' . $row['b_sl9'] . '</span>:';
      echo '<span title="Consecutive Packet Loss Distribution: > 10 packets">' . $row['b_sl10'] . '</span></td>';
    } else {
      echo '    <td style="text-align:right">N/A</td>';
    }

    echo '  </tr>';

  }
  mysql_free_result($result);
  mysql_close($db);


$str_a = $str - 1;
$str_b = $str + 1;

$html = '<br /><div style="font-size:9px" style="margin:30px" id="navigation_button_set">';
if($str > 1)
  $html .= '<a href="gui.php?site=cdr&str=' . $str_a . '" class="ui-button ui-widget ui-state-default ui-button-text-only"> << prev </a>';
else
  $html .= '<a href="#" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"> << prev </a>';

$html .= '<a href="#" id="dialog-link" class="ui-button ui-widget ui-state-default ui-button-text-only">Search Calls</a>';
$html .= '<a href="gui.php?site=cdr&str=' . $str_b . '" class="ui-button ui-widget ui-state-default ui-button-text-only"> next >> </a>';
$html .= '</div><br />';

echo $html;

?>
</table>
<?php
  if ($show_sql)
    echo '<div style="text-align:left"><strong>SQL Used : </strong><pre>' . $select.'</pre>';
?>
</div>
<script>
  $( "#navigation_button_set" ).buttonset();
  $( "#caller_search_type_bar" ).buttonset();
  $( "#called_search_type_bar" ).buttonset();
  $( "#dialog" ).dialog({
    autoOpen: false,
    width: 350,
  });


  // Link to open the dialog
  $( "#dialog-link" ).click(function( event ) {
    $( "#dialog" ).dialog( "open" );
    event.preventDefault();
  });
</script>
