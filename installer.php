<?php
/**
* Simple WordPress Auto Installer
*
* @author Ohad Raz <admin@bainternet.info> | http://en.bainternet.info
* @package WordPress Auto Installer
* @version 0.4
* @file: installer.php
* @todo Better error handling.
*  
*/
?>
<?php
$versions = array(
  array(
    'label' => 'Local file',
    'url' => 'local',
    'description' => 'Use a custom install , zip to a file named latest.zip and place in the same directory of this file.'
  ),
  array(
    'label' => 'Latest version',
    'url' => 'http://wordpress.org/latest.zip',
    'description' => 'Download the latest stable English version'
  ),
  array(
    'label' => 'Last nightly',
    'url' => 'http://wordpress.org/nightly-builds/wordpress-latest.zip',
    'description' => 'Download the latest beta version'
  ),
  array(
    'label' => 'Hebrew - עברית',
    'lang_code' => 'he_IL',
    'url' => 'remote',
    'description' => 'Download the latest stable Hebrew version'
  ),
  array(
    'label' => 'Italian',
    'lang_code' => 'it_IT',
    'url' => 'remote',
    'description' => 'Download the latest stable Italian version'
  ),
  array(
    'label' => 'French - Français',
    'lang_code' => 'fr_FR',
    'url' => 'remote',
    'description' => 'Download the latest stable French version'
  ),
  array(
    'label' => 'Spanish - Español',
    'lang_code' => 'es_ES',
    'url' => 'remote',
    'description' => 'Download the latest stable Spanish version'
  ),
  array(
    'label' => 'Romanian - Română',
    'lang_code' => 'ro_RO',
    'url' => 'remote',
    'description' => 'Download the latest stable Romanian version'
  ),
  array(
    'label' => 'Russian — Русский',
    'lang_code' => 'ru_RU',
    'url' => 'remote',
    'description' => 'Download the latest stable Russian version'
  ),
  array(
    'label' => 'Japanese (日本語)',
    'url' => 'remote',
    'lang_code' => 'ja',
    'description' => 'Download the latest stable Japanese  version'
  ),
  array(
    'label' => 'Brazilian Portuguese',
    'url' => 'remote',
    'lang_code' => 'pt_BR',
    'description' => 'Download the latest stable Brazilian Portuguese version'
  ),
  array(
    'label' => 'European Portuguese',
    'url' => 'remote',
    'lang_code' => 'pt_PT',
    'description' => 'Download the latest stable European Portuguese version'
  ),
  array(
    'label' => 'Polish - Polski',
    'url' => 'remote',
    'lang_code' => 'pl_PL',
    'description' => 'Download the latest stable Polish version'
  ),
  array(
    'label' => 'Korean - 한국어',
    'url' => 'remote',
    'lang_code' => 'ko_KR',
    'description' => 'Download the latest stable Korean version'
  ),
  array(
    'label' => 'Hungarian - Magyar',
    'url' => 'remote',
    'lang_code' => 'hu_HU',
    'description' => 'Download the latest stable Hungarian version'
  ),
  array(
    'label' => 'Dutch - Nederlands',
    'url' => 'remote',
    'lang_code' => 'nl_NL',
    'description' => 'Download the latest stable Dutch version'
  ),
  array(
    'label' => 'Vietnamse - Tiếng Việt',
    'url' => 'remote',
    'lang_code' => 'vi',
    'description' => 'Download the latest stable Vietnamse version'
  ),
  array(
    'label' => 'Thai',
    'url' => 'remote',
    'lang_code' => 'th',
    'description' => 'Download the latest stable Thai version'
  ),
  array(
    'label' => 'Swedish - Svenska',
    'url' => 'remote',
    'lang_code' => 'sv_SE',
    'description' => 'Download the latest stable Swedish version'
  ),
  array(
    'label' => 'Arabic – عربي',
    'url' => 'remote',
    'lang_code' => 'ar',
    'description' => 'Download the latest stable Arabic version'
  ),
  array(
    'label' => 'Chinese - 中文',
    'url' => 'remote',
    'lang_code' => 'zh_CN',
    'description' => 'Download the latest stable Chinese version'
  ),
  array(
    'label' => 'Slovenian - Slovenščina',
    'url' => 'remote',
    'lang_code' => 'sl_SI',
    'description' => 'Download the latest stable Slovenian version'
  ),
  array(
    'label' => 'Slovak – Slovenčina',
    'url' => 'remote',
    'lang_code' => 'sk_SK',
    'description' => 'Download the latest stable Slovak version'
  ),
  array(
    'label' => 'Danish - Dansk',
    'url' => 'remote',
    'lang_code' => 'da_DK',
    'description' => 'Download the latest stable Danish version'
  ),
  array(
    'label' => 'Czech - Čeština',
    'url' => 'remote',
    'lang_code' => 'cs_CZ',
    'description' => 'Download the latest stable Czech version'
  ),
  array(
    'label' => 'Croatian - Hrvatski',
    'url' => 'remote',
    'lang_code' => 'hr',
    'description' => 'Download the latest stable Croatian version'
  ),
  //any other language you want goes here
);

$download_ok  = false;
$done_zip = false;
if (isset($_POST['install'])){
  //download latest
  if (isset($_POST['ver']) && in_array($_POST['ver'],array('1','2'))){
    $download_ok = http_get_file($versions[$_POST['ver']]['url'],'latest.zip');
  }elseif ($_POST['ver'] == '0'){
    //use local file
    $download_ok = file_exists('latest.zip');
    if(!$download_ok){
      echo '<br/> File dosen\'t exists, try downloading the latest version.';
    }
  }else{
    //use get latest stable url for remote
    $uri = Get_latest_version_url($versions[$_POST['ver']]['lang_code']);
    $download_ok = http_get_file($uri,'latest.zip');
  }
  //unzip
  if ($download_ok){
    $done_zip = extract_zip('latest.zip',$_POST['folder']);
  }else{
    echo '<br/> File dosen\'t exists, try downloading the latest version.';
    die();
  }
  
  //create database
  if (isset($_POST['mk_db']) && $_POST['mk_db'] == 'mkdb' ){
    create_db($_POST['db_user'],$_POST['db_pass'],$_POST['server'],$_POST['db_name']);
  }
  
  
  
  //redirect to installer
  if ($done_zip){
    ?>
    <div style="display: none;">
      <?php includejQuery(); ?>
      <form action="<?php echo $_POST['folder'].'/wp-admin/setup-config.php?step=2'; ?>" method="post" id="insa">
      <p>Below you should enter your database connection details. If you're not sure about these, contact your host. </p>
      <table class="form-table">
        <tbody><tr>
          <th scope="row"><label for="dbname">Database Name</label></th>
          <td><input type="text" value="<?php echo $_POST['db_name'];?>" size="25" id="dbname" name="dbname"></td>
          <td>The name of the database you want to run WP in. </td>
        </tr>
        <tr>
          <th scope="row"><label for="uname">User Name</label></th>
          <td><input type="text" value="<?php echo $_POST['db_user'];?>" size="25" id="uname" name="uname"></td>
          <td>Your MySQL username</td>
        </tr>
        <tr>
          <th scope="row"><label for="pwd">Password</label></th>
          <td><input type="text" value="<?php echo $_POST['db_pass'];?>" size="25" id="pwd" name="pwd"></td>
          <td>...and your MySQL password.</td>
        </tr>
        <tr>
          <th scope="row"><label for="dbhost">Database Host</label></th>
          <td><input type="text" value="<?php echo $_POST['server'];?>" size="25" id="dbhost" name="dbhost"></td>
          <td>You should be able to get this info from your web host, if <code>localhost</code> does not work.</td>
        </tr>
        <tr>
          <th scope="row"><label for="prefix">Table Prefix</label></th>
          <td><input type="text" size="25" value="<?php echo $_POST['db_prefix'];?>" id="prefix" name="prefix"></td>
          <td>If you want to run multiple WordPress installations in a single database, change this.</td>
        </tr>
      </tbody></table>
        <p class="step"><input id="bong" type="submit" class="button" value="Submit" name="submit"></p>
      </form>
    </div>
    <?php
    echo '<script type="text/javascript">
        jQuery(document).ready(function() {
          jQuery("#bong").click();
        });
      </script>';
      exit();
  }
}else{
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html>
  <head>
    <title>WordPress Installer For WAMP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
    html{background:#f9f9f9;}body{background:#fff;color:#333;font-family:sans-serif;margin:2em auto;padding:1em 2em;-webkit-border-radius:3px;border-radius:3px;border:1px solid #dfdfdf;max-width:700px;}a{color:#21759B;text-decoration:none;}a:hover{color:#D54E21;}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px Georgia,"Times New Roman",Times,serif;margin:30px 0 0 0;padding:0;padding-bottom:7px;}h2{font-size:16px;}p,li,dd,dt{padding-bottom:2px;font-size:14px;line-height:1.5;}code,.code{font-size:14px;}ul,ol,dl{padding:5px 5px 5px 22px;}a img{border:0;}abbr{border:0;font-variant:normal;}#logo{margin:6px 0 14px 0;border-bottom:none;text-align:center;}.step{margin:20px 0 15px;}.step,th{text-align:left;padding:0;}.submit input,.button,.button-secondary{font-family:sans-serif;text-decoration:none;font-size:14px!important;line-height:16px;padding:6px 12px;cursor:pointer;border:1px solid #bbb;color:#464646;-webkit-border-radius:15px;border-radius:15px;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box;}.button:hover,.button-secondary:hover,.submit input:hover{color:#000;border-color:#666;}.button,.submit input,.button-secondary{background:#f2f2f2 url(../images/white-grad.png) repeat-x scroll left top;}.button:active,.submit input:active,.button-secondary:active{background:#eee url(../images/white-grad-active.png) repeat-x scroll left top;}textarea{border:1px solid #dfdfdf;-webkit-border-radius:3px;border-radius:3px;font-family:sans-serif;width:695px;}.form-table{border-collapse:collapse;margin-top:1em;width:100%;}.form-table td{margin-bottom:9px;padding:10px 20px 10px 0;border-bottom:8px solid #fff;font-size:14px;vertical-align:top;}.form-table th{font-size:14px;text-align:left;padding:16px 20px 10px 0;border-bottom:8px solid #fff;width:140px;vertical-align:top;}.form-table code{line-height:18px;font-size:14px;}.form-table p{margin:4px 0 0 0;font-size:11px;}.form-table input{line-height:20px;font-size:15px;padding:2px;border:1px #DFDFDF solid;-webkit-border-radius:3px;border-radius:3px;font-family:sans-serif;}.form-table input[type=text],.form-table input[type=password]{width:206px;}.form-table th p{font-weight:normal;}.form-table.install-success td{vertical-align:middle;padding:16px 20px 10px 0;}.form-table.install-success td p{margin:0;font-size:14px;}.form-table.install-success td code{margin:0;font-size:18px;}#error-page{margin-top:50px;}#error-page p{font-size:14px;line-height:18px;margin:25px 0 20px;}#error-page code,.code{font-family:Consolas,Monaco,monospace;}#pass-strength-result{background-color:#eee;border-color:#ddd!important;border-style:solid;border-width:1px;margin:5px 5px 5px 0;padding:5px;text-align:center;width:200px;display:none;}#pass-strength-result.bad{background-color:#ffb78c;border-color:#ff853c!important;}#pass-strength-result.good{background-color:#ffec8b;border-color:#fc0!important;}#pass-strength-result.short{background-color:#ffa0a0;border-color:#f04040!important;}#pass-strength-result.strong{background-color:#c3ff88;border-color:#8dff1c!important;}.message{border:1px solid #e6db55;padding:.3em .6em;margin:5px 0 15px;background-color:#ffffe0;}body.rtl{font-family:Tahoma,arial;}.rtl h1{font-family:arial;margin:5px -4px 0 0;}.rtl ul,.rtl ol{padding:5px 22px 5px 5px;}.rtl .step,.rtl th,.rtl .form-table th{text-align:right;}.rtl .submit input,.rtl .button,.rtl .button-secondary{margin-right:0;}.rtl #user_login,.rtl #admin_email,.rtl #pass1,.rtl #pass2{direction:ltr;}#description {background-repeat: no-repeat;color: #4C4C4C;font-family: Georgia,"Times New Roman",Times,serif;font-size: 14px;font-style: italic;min-height: 45px;padding: 15px 10px;background: none repeat scroll 0 0 #DBECF8;border-radius: 6px 6px 6px 6px;float: right;}
    </style>
  </head>
  <body>
    <div>
      <h1 id="logo">
    <img src="http://s.wordpress.org/about/images/logos/wordpress-logo-hoz-rgb.png">
    </h1>
      <p>Simple WordPress Auto Installer for WAMP ( XAMP and other stacks)</p>
      <p>By Bainternet <a href="http://en.bainternet.info">WordPress Developer</a></p>
      <?php if (!function_exists('curl_init') || !in_array('curl', get_loaded_extensions())){ ?>
      <p><b>cURL</b> is NOT installed or enabled, This script needs cURL to work.</p>
      <?php } ?>
      <form method="POST" name="installer_form">
    <p>
      <input name="installer" type="hidden" value="ins" />
    Select Your installation:
    <select name="ver" id="ver">
    <?php
      $radios = '';
      foreach ($versions as $key => $arr){
        $radios .=  '<option  value="'.$key.'" />'.$arr['label'].'</option>';
      }
      $radios  = str_replace('value="1"','value="1" selected="selected"',$radios);
      echo $radios;
    ?>
    </select><br/>
    <span id="description">

    </span>
    </p>
    <p>Folder to create:  
      <input name="folder" id="folder" type="text" value="" />
    </p>
    <p>
      <input  name="mk_db" type="checkbox" value="mkdb" checked="checked"/> Create Database?
    </p>
    <p>Database server (localhost?)
      <input name="server" type="text" value="localhost" />
    </p>
    <p>Database Name
      <input name="db_name" id="db_name" type="text" value="" />
    </p>
    <p>Database User Name
      <input name="db_user" type="text" value="" />
    </p>
    <p>Database User password
      <input name="db_pass" type="text" value="" />
    </p>
    <p>Table Prefix
      <input name="db_prefix" type="text" value="wp_" />
    </p>
    <p class="step">
      <input name="install" type="submit" class="button" value="GO" />
    </p>
  </form>
  <div style="text-align: center">
    <small>
      <a href="https://github.com/bainternet/Wamp-WordPress-installer/zipball/master">
        Download
      </a> |
      <a href="https://github.com/bainternet/Wamp-WordPress-installer/issues">
        Bugs and Support
      </a> |
      <a href="http://en.bainternet.info" title="My other WordPress Goodies">
        More WordPress Goodies
      </a>      
    </small>
  </div>
  </div>
  <?php includejQuery(); ?>
  <script>
  var descs = [];
  jQuery(document).ready(function(){
    <?php
    foreach ($versions as $key => $arr){
      echo  'descs[' . $key . '] = "' .$arr['description']. '";';
      echo "\n";
    }
    ?>
    jQuery("#folder").change(function(){
      jQuery("#db_name").val(jQuery("#folder").val());
    });
    jQuery("#description").html(descs[jQuery("#ver").val()]);
    jQuery("#ver").change(function(){
      jQuery("#description").hide('fast');
      jQuery("#description").html(descs[jQuery(this).val()]);
      jQuery("#description").show('2300');
    });
  });
  </script>
  </body>
  </html>
  <?php
}


/**
 * http_get_file simple function to download a file using curl
 *
 * @author Ohad Raz <admin@bainternet.info>
 * @since 0.1
 * @param  (string) $remote_url url of file to download
 * @param  (string) $local_file name of local file to create
 *
 * @return (bool)
 */
function http_get_file($remote_url, $local_file){
    $fp = fopen($local_file, 'w');
    $cp = curl_init($remote_url);
    curl_setopt($cp, CURLOPT_FILE, $fp);
    $buffer = curl_exec($cp);
    curl_close($cp);
    fclose($fp);
    return true;
}


/**
 * extract_zip simple function to extrac a zip archive to a given folder
 *
 * @author Ohad Raz <admin@bainternet.info>
 * @since 0.1
 * @param  (string) $zip_File zip file name (full path)
 * @param  (string) $folder   destenation folder full path
 *
 * @return (bool)
 */
function extract_zip($zip_File,$folder){
  $zip = new ZipArchive() ;
  // open archive
  if ($zip->open($zip_File) !== TRUE) {
    die ('Could not open archive');
  }
  $zip->extractTo(getcwd());
  // close archive
  // print success message
  $zip->close();
  rename(getcwd().'/wordpress', getcwd().'/'.$folder);
  return true;
}

/**
 * create_db function to create a mysql database
 *
 * @author Ohad Raz <admin@bainternet.info>
 * @since 0.1
 * @param  (string) $user    mysql user name
 * @param  (string) $pass    mysql user password
 * @param  (string) $server  server name
 * @param  (string) $db_name database name to create
 *
 * @return (bool)
 */
function create_db($user,$pass,$server,$db_name){
  $link = mysql_connect($server, $user, $pass);
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //$sql = 'CREATE DATABASE '.$db_name;
  $sql = "CREATE DATABASE IF NOT EXISTS `$db_name`";
  if (mysql_query($sql, $link)) {
    return true;
  } else {
    return false;
  }
}
  
/**
 * Get_latest_version_url function to get the latest version download url
 *
 * @author Ohad Raz <admin@bainternet.info>
 * @since 0.3
 * @param  (string) $local   language local key
 *
 * @return (string)
 */
function Get_latest_version_url($local = "en_US"){
  $url =  'http://api.wordpress.org/core/version-check/1.6/?locale='.$local;
  $c = curl_init($url);
  curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
  $page = curl_exec($c);
  curl_close($c);
  $ret = unserialize( $page);
/*  echo '<pre>';
  echo $local;
  var_dump($ret);
  echo '</pre>';
  die();*/
  return $ret['offers'][0]['download'];
}

/**
 * includejQuery simple function to include jQuery js
 *
 * @author Ohad Raz <admin@bainternet.info>
 * @since 0.3
 *
 * @return VOID
 */
function includejQuery(){
  ?>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
  <?php
}
