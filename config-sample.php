<?php
  // SAMPLE CONFIG FILE
  // Make changes to this file and save as config.php

  // Database settings
  $dbname = 'voipmonitor';
  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = '';

  //System settings
  date_default_timezone_set('Africa/Johannesburg');
  // commands
  $cmd_listcalls = '/bin/echo listcalls | /usr/bin/nc localhost 5029';
  $cmd_sip_registry = '/usr/sbin/asterisk -x  "sip show registry"';
  $cmd_iax2_registry = '/usr/sbin/asterisk -x  "iax2 show registry"';
  $cmd_show_channels = '/usr/sbin/asterisk -x "core show channels verbose"';
  $cmd_sip_channelstats = '/usr/sbin/asterisk -x  "sip show channelstats"';
  $cmd_iax2_netstats = '/usr/sbin/asterisk -x  "iax2 show netstats"';

  // CDR settings
  $cdr_num_calls_per_page = 15;

  // SIP response code descriptions
  $sip_response[100] = 'Trying';
  $sip_response[180] = 'Ringing';
  $sip_response[181] = 'Call Being Forwarded';
  $sip_response[182] = 'Call Queued';
  $sip_response[183] = 'Session Progress';
  $sip_response[200] = 'OK';
  $sip_response[202] = 'Accepted';
  $sip_response[300] = 'Multiple Choices';
  $sip_response[301] = 'Moved Permanently';
  $sip_response[302] = 'Moved Temporarily';
  $sip_response[305] = 'Use Proxy';
  $sip_response[380] = 'Alternative Service';
  $sip_response[400] = 'Bad Request';
  $sip_response[401] = 'Unauthorized';
  $sip_response[402] = 'Payment Required';
  $sip_response[403] = 'Forbidden';
  $sip_response[404] = 'Not Found';
  $sip_response[405] = 'Method Not Allowed';
  $sip_response[406] = 'Not Acceptable';
  $sip_response[407] = 'Proxy Authentication Required';
  $sip_response[408] = 'Request Timeout';
  $sip_response[409] = 'Conflict';
  $sip_response[410] = 'Gone';
  $sip_response[411] = 'Length Required';
  $sip_response[413] = 'Request Entity Too Large';
  $sip_response[414] = 'Request URI Too Long';
  $sip_response[415] = 'Unsupported Media Type';
  $sip_response[416] = 'Unsupported URI Scheme';
  $sip_response[420] = 'Bad Extension';
  $sip_response[421] = 'Extension Required';
  $sip_response[423] = 'Interval Too Brief';
  $sip_response[480] = 'Temporarily Unavailable';
  $sip_response[481] = 'Call/Transaction Does Not Exist';
  $sip_response[482] = 'Loop Detected';
  $sip_response[483] = 'Too Many Hops';
  $sip_response[484] = 'Address Incomplete';
  $sip_response[485] = 'Ambiguous';
  $sip_response[486] = 'Busy Here';
  $sip_response[487] = 'Request Terminated';
  $sip_response[488] = 'Not Acceptable Here';
  $sip_response[491] = 'Request Pending';
  $sip_response[493] = 'Undecipherable';
  $sip_response[500] = 'Server Internal Error';
  $sip_response[501] = 'Not Implemented';
  $sip_response[502] = 'Bad Gateway';
  $sip_response[503] = 'Service Unavailable';
  $sip_response[504] = 'Server Time-Out';
  $sip_response[505] = 'Version Not Supported';
  $sip_response[513] = 'Message Too Large';
  $sip_response[600] = 'Busy Everywhere';
  $sip_response[603] = 'Declined';
  $sip_response[604] = 'Does Not Exist Anywhere';
  $sip_response[606] = 'Not Acceptable';

  // SIP payload types
  $sip_payload[0] = "8kHz PCMU codec";
  $sip_payload[1] = "8kHz 1016 codec";
  $sip_payload[2] = "8kHz G726-32 codec";
  $sip_payload[3] = "8kHz GSM codec";
  $sip_payload[4] = "8kHz G723 codec";
  $sip_payload[5] = "8kHz DVI4 codec";
  $sip_payload[6] = "16kHz DVI4 codec";
  $sip_payload[7] = "8kHz LPC codec";
  $sip_payload[8] = "8kHz PCMA codec";
  $sip_payload[9] = "8kHz G722 codec";
  $sip_payload[10] = "44.1kHz stereo L16 codec";
  $sip_payload[11] = "44.1kHz mono L16 codec";
  $sip_payload[12] = "8kHz QCELP codec";
  $sip_payload[13] = "8kHz CN codec";
  $sip_payload[14] = "MPA codec";
  $sip_payload[15] = "8kHz G728 codec";
  $sip_payload[16] = "11.025kHz DVI4 codec";
  $sip_payload[17] = "22.050kHz DVI4 codec";
  $sip_payload[18] = "8kHz G729 codec";
?>
