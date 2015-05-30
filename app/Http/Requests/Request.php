<?php namespace App\Http\Requests;

use App\Http\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        if ($this->ajax() || $this->wantsJson())
        {
            $errorResponse = [
                "status" => 422,
                'message'   => 'Could not process the request.',
                'errors'    => $errors,
            ];
            return ApiResponse::errorForbidden($errorResponse);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }

    /**
     * Get the response for a forbidden operation.
     *
     * @return \Illuminate\Http\Response
     */
    public function forbiddenResponse()
    {
        if ($this->ajax() || $this->wantsJson())
        {
            $errorResponse = [
                "status" => 403,
                'message'   => 'Could not process the request.',
                'errors'    => [],
            ];
            return ApiResponse::errorForbidden($errorResponse);
        }

        abort(403);
    }

}
