<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    //================= SWAGGER
    /**
     * @SWG\Get(
     *     path="/api/v1/users",
     *     summary="Get all users",
     *     tags={"users"},
     *     description="Get all users",
     *     consumes={"application/xml", "application/json"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, user data provided",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Request errors",
     *     ),
     * )
     */
    //================= SWAGGER

    public function getAll()
    {
        $users = User::all();

        return response()->json(compact('users'));
    }

    //================= SWAGGER
    /**
     * @SWG\Get(
     *     path="/api/v1/users/{id}",
     *     summary="Get user by ID",
     *     tags={"users"},
     *     description="Get user by ID",
     *     consumes={"application/xml", "application/json"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="user id",
     *         required=true,
     *         type="number",
     *         default=1,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, user data provided",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Request errors",
     *     ),
     * )
     */
    //================= SWAGGER


    public function getById(User $user)
    {
        return response()->json(compact('user'));
    }

    //================= SWAGGER
    /**
     * @SWG\POST(
     *     path="/api/v1/users/create",
     *     summary="Add user",
     *     tags={"users"},
     *     description="Add user",
     *     consumes={"application/xml", "application/json"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="Your name",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="Your last name",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="age",
     *         in="query",
     *         description="Your age",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         in="query",
     *         description="Your email",
     *         required=true,
     *         type="string",
     *     ),
     *       @SWG\Parameter(
     *         name="image",
     *         in="formData",
     *         description="User's image",
     *         required=false,
     *         type="file",
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Your password",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, user created",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Request errors",
     *     ),
     *     @SWG\Response(
     *         response="422",
     *         description="Validation errors",
     *     )
     * )
     */
    //================= SWAGGER

    public function addUser(ImageUploadRequest $request)
    {

        $user = new User([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'age' => $request->input('age'),
            'email' => $request->input('email'),
            'file_name' => $request->input('file_name'),
            'password' => bcrypt($request->input('password')),
        ]);

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $img->store(User::FOLDER);
            $file_name = $img->hashName();
        } else {
            $file_name = 'default.png';
        }
        $user->file_name = $file_name;
        $status = $user->save();

        return response()->json(compact('status'));
    }

    //================= SWAGGER
    /**
     * @SWG\Post(
     *     path="/api/v1/users/{id}/update",
     *     summary="Update user by ID",
     *     tags={"users"},
     *     description="Update user by ID",
     *     consumes={"application/xml", "application/json"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="user id",
     *         required=true,
     *         type="number",
     *         default=1,
     *     ),
     *     @SWG\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="Your name",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="Your last name",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="age",
     *         in="query",
     *         description="Your age",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         in="query",
     *         description="Your email",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="image",
     *         in="formData",
     *         description="User's image",
     *         required=false,
     *         type="file",
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="query",
     *         description="Your password",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, user data provided",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User not found",
     *     ),
     * )
     */
    //================= SWAGGER

    public function edit(ImageUploadRequest $request, User $user)
    {
        $data = $request->all([
            'first_name',
            'last_name',
            'age',
            'email',
            'file_name',
            'password',
        ]);

        if ($request->hasFile('image')) {
            if ($user->file_name !== 'default.png') {
                File::delete(storage_path('app/public/users/' . $user->file_name));
            }
            $img = $request->file('image');
            $img->store(User::FOLDER);
            $file_name = $img->hashName();
        }

        $data['file_name'] = $file_name;
        $data['password'] = bcrypt($data['password']);
        $status = $user->update($data);

        return response()->json(compact('status'));
    }


    //================= SWAGGER
    /**
     * @SWG\DELETE(
     *     path="/api/v1/users/{id}/delete",
     *     summary="Delete user by ID",
     *     tags={"users"},
     *     description="Delete user by ID",
     *     consumes={"application/xml", "application/json"},
     *     produces={"application/xml", "application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="user id",
     *         required=true,
     *         type="number",
     *         default=1,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation, user data provided",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User not found",
     *     ),
     * )
     */
    //================= SWAGGER

    public function delete(User $user)
    {
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        File::delete(storage_path('app/public/users/' . $user->file_name));

        $status = $user->delete();
        return response()->json(compact('status'));
    }


}
