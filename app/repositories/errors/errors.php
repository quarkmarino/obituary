<?php

/**
 * General HttpException handler
 */
/*App::error( function(Symfony\Component\HttpKernel\Exception\HttpException $e, $code){
  $headers = $e->getHeaders();
 
  switch($code)
  {
    case 401:
      $default_message = 'Invalid API key';
      $headers['WWW-Authenticate'] = 'Basic realm="CRM REST API"';
    break;
 
    case 403:
      $default_message = 'Insufficient privileges to perform this action';
    break;
 
    case 404:
      $default_message = 'The requested resource was not found';
    break;
 
    default:
      $default_message = 'An error was encountered';
  }
 
  return Response::json(array(
    'error' => $e->getMessage() ?: $default_message
  ), $code, $headers);
});*/
 
/**
 * Not Allowed Exception Handler for json API
 */
App::error(function(NotAllowedException $e){
  return Request::ajax() ?
    Response::json($e->getMessage(), $e->getCode()) :
    Response::make(View::make('errors.403'), $e->getCode());
});
 
/**
 * Validation Exception Handler for json API
 */
App::error(function(ValidationException $e){
  return Request::ajax() ?
    Response::json($e->getErrors()->toArray(), $e->getCode()) :
    Response::make(View::make('errors.400'), $e->getCode());
});
 
/**
 * Not Found Exception Handler for json API
 */
/*App::error(function(NotFoundException $e){
  return Response::json($e->getMessage(), $e->getCode());
});*/

/**
 * Not Found Exception Handler for web site
 */

App::missing(function(NotFoundException $e)
{
  return Request::ajax() ?
    Response::json($e->getMessage(), $e->getCode()) :
    (
      Request::is('admin/*') ?
        Response::make(View::make('admin.errors.404'), $e->getCode()) :
        Response::make(View::make('errors.404'), $e->getCode());
    )
  }
});

App::error(function($exception, $code){
  return $code == 500 ?
    Response::make(View::make('errors.500'), 500) :
    Response::make(View::make('errors.default'), $code);
});
