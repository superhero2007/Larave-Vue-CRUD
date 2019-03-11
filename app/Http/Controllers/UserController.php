<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return $this->returnSuccessMessage('users', UserResource::collection($users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191'
        ]);

        try {
            // Create user
            $image = $request->input('image');
            $extension = explode('/', mime_content_type($image))[1];
            $filename = uniqid() . "." . $extension;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            Storage::put('public/' . $filename, base64_decode($image));
            $url = Storage::url('public/' . $filename);
            $user = User::create([
                'name' => $request->input('name', null),
                'email' => $request->input('email', null),
                'phonenumber' => $request->input('phonenumber', null),
                'image' => $url,
                'password' => $request->input('password', null)
            ]);

            if ($user) {
                return $this->returnSuccessMessage('user', new UserResource($user));
            }

            // Send error if user is not created
            return $this->returnError('user', 503, 'create');
        } catch (Exception $e) {
            // Send error
            return $this->returnErrorMessage(503, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return $this->returnSuccessMessage('user', new UserResource($user));
        }

        // Send error if user does not exist
        return $this->returnError('user', 404, 'show');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'filled|max:191'
        ]);

        try {
            $user = User::find($id);

            // Send error if user does not exist
            if (!$user) {
                return $this->returnError('user', 404, 'update');
            }
            $image = $request->input('image');
            if ($image) {
                $extension = explode('/', mime_content_type($image))[1];
                $filename = uniqid() . "." . $extension;
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                Storage::put('public/' . $filename, base64_decode($image));
                $url = Storage::url('public/' . $filename);
                $user->update(['image' => $url]);
            }

            // Update user
            if ($user->fill($request->only('name', 'email', 'phonenumber', 'password'))->save()) {
                return $this->returnSuccessMessage('user', new UserResource($user));
            }

            // Send error if there is an error on update
            return $this->returnError('user', 503, 'update');
        } catch (Exception $e) {
            // Send error
            return $this->returnErrorMessage(503, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            // Send error if user does not exist
            if (!$user) {
                return $this->returnError('user', 404, 'delete');
            }

            // Delete user
            if ($user->delete()) {
                return $this->returnSuccessMessage('message', 'User has been deleted successfully.');
            }

            // Send error if there is an error on delete
            return $this->returnError('user', 503, 'delete');
        } catch (Exception $e) {
            // Send error
            return $this->returnErrorMessage(503, $e->getMessage());
        }
    }
}
