<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*** preferences for sending the E-mail	***/

//The mail sending protocol.
$config['protocol'] = 'sendmail';

//The server path to Sendmail.
$config['mailpath'] = '/usr/sbin/sendmail';

//Character set
$config['charset'] = 'utf-8';

//Type of mail(text or html). If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
$config['mailtype'] = 'html';

//Enable word-wrap.TRUE or FALSE (boolean)
$config['wordwrap'] = TRUE;