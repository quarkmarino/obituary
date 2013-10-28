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
/*App::error(function(NotAllowedException $e, $code){
  return Response::json($e->getMessage(), $e->getCode());
});*/
 
/**
 * Validation Exception Handler for json API
 */
/*App::error(function(ValidationException $e, $code){
  return Response::json($e->getMessages(), $code);
});*/
 
/**
 * Not Found Exception Handler for json API
 */
/*App::error(function(NotFoundException $e){
  return Response::json($e->getMessage(), $e->getCode());
});*/

/**
 * Not Found Exception Handler for web site
 */

App::missing(function(NotFoundException $exception)
{
  if (Request::is('admin/*'))
    return Response::make(View::make('admin.errors.404'), 404);
  else
    return Response::make(View::make('errors.404'), 404);
});

App::error(function($exception, $code)
{
  switch ($code)
  {
    case 403:
      return Response::make(View::make('errors.403'), 403);

    case 500:
      return Response::make(View::make('errors.500'), 500);

    default:
      return Response::make(View::make('errors.default'), $code);
  }
});
