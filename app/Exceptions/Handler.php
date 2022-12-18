<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Session\TokenMismatchException;

/**
 * Class Handler
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @param Exception $exception
     *
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param Request $request
     * @param Exception                $exception
     *
     * @return Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Костыль для перевода поля message: The given data was invalid.
     *
     * @param Request $request
     * @param ValidationException $exception
     * @return JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return response()->json([
            'message' => __('validation.exception.message'),
            'errors' => $exception->errors()
        ], $exception->status);
    }

    /**
     * Костыль для вывода текста сообщения при отправки формы без csrf_token.
     * В случае появления необходимости разруливать тут в зависимости от запроса
     * использовать request(), request()->route() и т.п.
     *
     * Появилось из-за ситуации когда идет логин с не подтвержденным email. А потом сразу логин с норм данными.
     * Но без перезагрузки страницы токен становится не валдиным после персовго запроса.
     *
     * @param  Exception  $exception
     * @return array
     */
    protected function convertExceptionToArray(Exception $exception): array
    {
        $previousException = $exception->getPrevious();
        $messageArray = parent::convertExceptionToArray($exception);

        if ($previousException instanceof TokenMismatchException) {
            $messageArray['message'] = __('validation.exception.csrf_token_mismatch');
        }

        return $messageArray;
    }
}
