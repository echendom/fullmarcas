<?php
   // OAuthHelper.php
   namespace App\Helpers;

   use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
   use League\OAuth2\Client\Provider\GenericProvider;

   class OAuthHelper
   {
       public static function getAccessToken()
       {
           $provider = new GenericProvider([
               'clientId'                => env('MICROSOFT_GRAPH_CLIENT_ID'),
               'clientSecret'            => env('MICROSOFT_GRAPH_CLIENT_SECRET'),
               'redirectUri'             => '',
               'urlAuthorize'            => '',
               'urlAccessToken'          => "https://login.microsoftonline.com/" . env('MICROSOFT_GRAPH_TENANT_ID') . "/oauth2/token",
               'urlResourceOwnerDetails' => '',
           ]);

           try {
               $accessToken = $provider->getAccessToken('client_credentials');
               return $accessToken->getToken();
           } catch (IdentityProviderException $e) {
               // Handle authentication error
               return null;
           }
       }
   }