<?
  $headers .= "Organization: babarindeos@unaab.edu.ng\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

  mail("kondishiva007@gmail.com", "Message", "A simple message.", $headers);
?>
