<?php

	//facebooksdkV4/src/Facebook
require_once( 'Facebook/HttpClients/FacebookHttpable.php' );
require_once( 'Facebook/HttpClients/FacebookCurl.php' );
require_once( 'Facebook/HttpClients/FacebookCurlHttpClient.php' );

require_once( 'Facebook/Entities/AccessToken.php' );
require_once( 'Facebook/Entities/SignedRequest.php' );

require_once( 'Facebook/FacebookSession.php' );
require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
require_once( 'Facebook/FacebookRequest.php' );
require_once( 'Facebook/FacebookResponse.php' );
require_once( 'Facebook/FacebookSDKException.php' );
require_once( 'Facebook/FacebookRequestException.php' );
require_once( 'Facebook/FacebookOtherException.php' );
require_once( 'Facebook/FacebookAuthorizationException.php' );
require_once( 'Facebook/GraphObject.php' );
require_once( 'Facebook/GraphSessionInfo.php' );


use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookCurlHttpClient;

use Facebook\Entities\AccessToken;
use Facebook\Entities\SignedRequest;

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;

// start session
session_start();

FacebookSession::setDefaultApplication('911841698833998','ea6c9430e462cb37c9f946c46d821acc');
$session = new FacebookSession('CAAM9ULCM5k4BALSukvVz6m6G1K00asfcqgaOZAFHsdFBP0AobRJ91vblWkSyoSWu7wisLmNIqYDYAGvFzaGZA8ZAtpJHF285pcapUEDAdNX45LmT0qQ7dW9oXnlUrqPUGlOeMJZBoZBQrSIiboNSiVUcTTrGNmKUKPar8rB8fXnPiAvZC5xdrZBrNUaapx9ui6ZCrkNXmMsesvnYXmWkoGH63tBpN5HAr5kZD');

try {
  $me = (new FacebookRequest(
    $session, 'GET', '/me'
  ))->execute()->getGraphObject(GraphUser::className());
  echo $me->getName();
} catch (FacebookRequestException $e) {
  // The Graph API returned an error
} catch (\Exception $e) {
  // Some other error occurred
}

/*
$facebook = new Facebook(array( 
	'appId' => Configure::read('fb_settings.fb_app_id'), 
	'secret' => Configure::read('fb_settings.fb_secret_key'), 
	'sharedSession' => true, ));
*/
?>


