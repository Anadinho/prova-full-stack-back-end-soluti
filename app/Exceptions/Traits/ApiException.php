<?php

namespace App\Exceptions\Traits;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ApiException{
    /**
     * Trata as exceçoes da api
     */
    protected function getJsonException ($request, $e)
    {
        if($e instanceof ModelNotFoundException){
            return $this->notFoundException(); 
        }

        if($e instanceof HttpException){
            return $this->httpexception($e);
        }

        if($e instanceof ValidationException){
            return $this->validationException($e);
        }

        return $this->genericException();
    }


    /**
     * retorna o erro interno servidor
     */    
    protected function notFoundException()
    {
        return $this->getResponse(
            "Recurso não encontrado",
            "01",
            404
        );
    }

    /**
     * retorna o erro 500
     */    
    protected function genericException()
    {
        return $this->getResponse(
            "Erro interno no servidor",
            "02",
            500
        );
    }

    /**
     * Retorna o erro de validação
    */
    protected function ValidationException($e)
    {
        return response()->json($e->errors(), $e->status);
    }

    /**
     * retorna o erro de http
     */    
    protected function HttpException($e)
    {

        return $this->getResponse(
            $e->getHeaders(),
            "03",
            $e->getStatusCode()
        );
    }

    /**
     * MOstra a resposta em json
     */
    protected function getResponse($message, $code, $status)
    {
        return response()->json([
            "errors" =>[
                [
                    "status"=>$status,
                    "code"=>$code,
                    "message"=>$message
                ]
            ]
        ], 404);  
    }    
}