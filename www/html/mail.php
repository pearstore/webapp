<?php

$empfaenger = 'philipp.schubarth@its-stuttgart.de, dennis.just@its-stuttgart.de, djust97@web.de';
$betreff = 'Test-Mail';
$nachricht = '
<html>
<head>
  <title>Geburtstags-Erinnerungen für August</title>
</head>
<body>
  <p>Hier sind die Geburtstage im August:</p>
  <table>
    <tr>
      <th>Person</th><th>Tag</th><th>Monat</th><th>Jahr</th>
    </tr>
    <tr>
      <td>Max</td><td>3.</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Moritz</td><td>17.</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
$header[] = 'MIME-Version: 1.0';
$header[] = 'Content-type: text/html; charset=iso-8859-1';

// zusätzliche Header
$header[] = 'To: Philipp Schubarth <philipp.schubarth@its-stuttgart.de>, dennis.just@its-stuttgart.de, d.j.just124@gmail.com';
$header[] = 'From: Dennis Just <dennis@example.com>';
$header[] = 'X-Mailer: PHP/' . phpversion();

var_dump(mail($empfaenger, $betreff, $nachricht, implode("\r\n", $header)));
var_dump(array($empfaenger, $betreff, $nachricht, implode("\r\n", $header)));
