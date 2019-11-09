<?php

namespace App\Http\Controllers;

use App\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $socials = Social::get()->map(function ($s) {
            return collect([
                'type' => $s->type,
                'auth_url' => $s->auth_url,
                'token_url' => $s->token_url,
            ]);
        });

        return response()->json([
            'socials' => $socials
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Social $social
     * @return \Illuminate\Http\Response
     */
    public function show(Social $social)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Social $social
     * @return \Illuminate\Http\Response
     */
    public function edit(Social $social)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Social $social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Social $social)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Social $social
     * @return \Illuminate\Http\Response
     */
    public function destroy(Social $social)
    {
        //
    }

    public function set(Request $request)
    {
        $user = Auth::user();


        $social = Social::where("type", $request->type)->first();

        $alredy_exists = $user->socials->find($social->id);
        if (!$alredy_exists) {
            $user->socials()->attach($social->id, ['temp_code' => $request->code]);
        } else {
            $user->socials()->updateExistingPivot($social->id, ['temp_code' => $request->code]);
        }

        return response()->json([
            'token_url' => $social->token_url . $request->code
        ], 200);

        switch ($social->type) {
            case "vk":
                #$social->getVkToken($request->code);
                break;
            default;
        }

        return response()->json([
            'OK'
        ], 200);
    }
}
