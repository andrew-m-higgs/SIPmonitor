<?php
  global $cmd_sip_registry, $cmd_iax2_registry, $cmd_show_channels;

  exec($cmd_sip_registry, $sip_registry);
  exec($cmd_iax2_registry, $iax2_registry);
?>
<div align="center">
  <h3>Registries</h3>
    <table>
        <tr>
          <td><h5>Sip Registry</h5><pre><?php for ($i = 0; $i < count($sip_registry); $i++) echo $sip_registry[$i] . "<br />" ?></pre></td>
          <td><h5>IAX2 Registry</h5><pre><?php for ($i = 0; $i < count($iax2_registry); $i++) echo $iax2_registry[$i] . "<br />" ?></pre></td>
        </tr>
      </table>
</div>
