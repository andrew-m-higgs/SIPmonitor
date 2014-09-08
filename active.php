<div align="center">
<?php
  global $sip_response, $sip_payload, $cmd_listcalls, $cmd_iax2_netstats, $cmd_sip_channelstats;

  $json = exec($cmd_listcalls);
  $json_res = json_decode($json);

  exec($cmd_iax2_netstats, $iax2_netstats);
  exec($cmd_sip_channelstats, $sip_channelstats);

?>
  <br />
  <table class="sortable" style="width:90%">
  <tr>
    <th>Call Start</th>
    <th>Duration</th>
    <th>Caller Num (Name)</th>
    <th>Caller IP</th>
    <th>Caller Codec</th>
    <th>Called Num</th>
    <th>Called IP</th>
    <th>Called Codec</th>
    <th>Last Packet Time</th>
    <th>Last Response</th>
  </tr>
  <?php
  //THROW OUT ACTIVE CALLS
  if (count($json_res) < 2) {
    echo '<tr><td colspan="10"> <div align="center"> NO CALLS </div></td></tr>';
  } else {
    for ($i = 1; $i <= count($json_res) - 1; $i++) {
      echo '  <tr>';
      echo '    <td class="right">' . date("Y-m-d H:i:s", $json_res[$i][7]) . '</td>';
      echo '    <td class="center">' . $json_res[$i][8] . '</td>';

      //DISPLAY CALLER DETAILS
      echo '    <td class="right">' . $json_res[$i][4] . ' (' . $json_res[$i][5] . ') </td>';
      echo '    <td class="right">' . long2ip((float)$json_res[$i][9]) . '</td>';
      $payload = get_sip_payload($json_res[$i][2]);
      echo '    <td class="right">' . $payload . '</td>';

      //DISPLAY CALLED DETAILS
      echo '    <td class="right">' . $json_res[$i][6] . '</td>';
      echo '    <td class="right">' . long2ip((float)$json_res[$i][10]) . '</td>';
      $payload = get_sip_payload($json_res[$i][3]);
      echo '    <td class="right">' . $payload . '</td>';

      echo '    <td class="right">' . date("Y-m-d H:i:s", $json_res[$i][11]) . '</td>';
      $last_response = get_sip_response($json_res[$i][12]);
      echo '    <td class="center">' . $json_res[$i][12] . ' ' . $last_response . '</td>';

      echo '  </tr>';

    }
  }

  ?>
  </table>
  <h5>SIP Channelstats</h5><pre><?php for ($i = 0; $i < count($sip_channelstats); $i++) echo $sip_channelstats[$i] . "<br />" ?></pre>
  <h5>IAX2 Netstats</h5><pre><?php for ($i = 0; $i < count($iax2_netstats); $i++) echo $iax2_netstats[$i] . "<br />" ?></pre>
</div>
