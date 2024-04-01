<?php

namespace App\Http\Traits;

use Illuminate\Validation\ValidationException;

Trait CommonTraits
{
    protected $result = null;

    function sendResponse($status, $message, $data = null)
    {
        return response()->json([
            'statusCode' => $status,
            'msg' => $message,
            'data' => $data
        ], $status);
    }

    public function sendValidationError(ValidationException $ex)
    {
        $errors = $ex->errors();

        return $this->sendResponse($ex->status, reset($errors)[0], collect($errors)->map(function($error) {
            return $error[0];
        }));
    }

    public function sendSuccessResponse($message = null, $data = null)
    {
        return $this->sendResponse(200, $message ? $message : __("success"), $data ? $data : $this->getResult());
    }

    public function sendErrorResponse($message, $data = null, $code = 422)
    {
        return $this->sendResponse($code, $message, $data);
    }

    public function getPageLimit($default = 8)
    {
        return request()->get('limit', $default);
    }

    public function validatePagination($pageSuffix = false)
    {
        request()->validate([
            getSuffix('page', $pageSuffix) => ['nullable', 'numeric', 'min:1'],
            'limit' => ['nullable', 'numeric', 'min:1']
        ]);
    }

    public function getPageData($query, $suffix = false, $pageSuffix = false)
    {
        $this->validatePagination();

        $listing = $query->paginate(
            $this->getPageLimit(),
            ['*'],
            getSuffix('page', $pageSuffix)
        );

        $this->addResult( getSuffix("total_items", $suffix), $listing->total());
        $this->addResult( getSuffix("current_page", $suffix), $listing->currentPage());
        $this->addResult( getSuffix("total_pages", $suffix), $listing->lastPage());
        $this->addResult( getSuffix("current_page_items", $suffix), $listing->count());

        return $listing;
    }

    public function addResult($key, $value)
    {
        $this->result[$key] = $value;
    }

    public function getResult()
    {
        return $this->result;
    }

//    public function redirectTo()
//    {
//        return route('/');
//    }

    public function redirectPostAuth()
    {
        return redirect()->intended(method_exists($this, "redirectTo") ? $this->redirectTo() : route('/'));
    }

    public function redirectWithError($redirect, $message)
    {
        return $redirect->with('error', $message);
    }

    protected function loggedIn($user)
    {
        $oldUser = (clone $user);

        if ($user->hasVerifiedEmail() && $user->is_new_login) {
            $user->fill(['is_new_login' => 0])->save();

            return $oldUser;
        }

        return $oldUser;
    }
}
