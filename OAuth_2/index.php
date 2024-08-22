<?php
$configs = include('config.php');
$redirect_uri = $configs['oauth_redirect_uri'];
$openID_redirect_uri = $configs['openID_redirect_uri'];
$refreshTokenPage = $configs['refreshTokenPage'];
 ?>
 <script
      type="text/javascript"
      src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere-1.3.3.js">
 </script>

 <script type="text/javascript">
     var redirectUrl = "<?=$redirect_uri?>"
     intuit.ipp.anywhere.setup({
             grantUrl:  redirectUrl,
             datasources: {
                  quickbooks : true,
                  payments : true
            },
             paymentOptions:{
                   intuitReferred : true
            }
     });
 </script>
<title>My Connect Page</title>
<?php
  session_start();
  if(isset($_SESSION['access_token']) && !empty($_SESSION['access_token'])){
    echo "<h3>Retrieve OAuth 2 Tokens from Sessions:</h3>";
    $tokens = array(
       'access_token' => $_SESSION['access_token'],
       'refresh_token' => $_SESSION['refresh_token']
    );
    var_dump($tokens);
    echo "<br /> <a href='" .$refreshTokenPage . "'>
          Refresh Token
    </a> <br />";
    echo "<br /> <a href='" .$refreshTokenPage . "?deleteSession=true'>
          Clean Session
    </a> <br />";
  }else{
    echo "<br /> <ipp:connectToIntuit></ipp:connectToIntuit><br />";
  }
?>



