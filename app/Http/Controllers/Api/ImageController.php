<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    public function upload(Request $request)
    {
        $data = $request->all();
        $account = Account::findOrFail($data['account_id']);

        $path = $request->file('image')->store('tmp');
        $filename = basename($path);

        Image::make(storage_path('app/' . $path))
            ->fit(200, 200)
            ->save(storage_path('app/account-images/' . $filename));

        $image = new \App\Image;

        $image->file_name = $filename;
        $image->image_type_id = 1;

        $image->account()
            ->associate($account);

        $image->save();

        return response()
            ->json([
                'ok' => 1,
                'image' => $image
            ]);
    }

    public function image($fileName)
    {
        $path = storage_path('app/user-images/' . $fileName);
//        dd($path);
//        dd(File::exists($path));
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::create($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = [
            'ok' => 1
        ];
        try {
            $image = Image::findOrFail($id);
            $response['transaction'] = $image;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        return response()
            ->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $accountId
     * @return \Illuminate\Http\Response
     */
    public function showByAccount($accountId)
    {
        $response = [
            'ok' => 1
        ];
        try {
            $account = Account::findOrFail($accountId);
            $response['images'] = $account->images;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        return response()
            ->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
