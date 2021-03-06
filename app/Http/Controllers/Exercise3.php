<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Exercise3 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Student::all(), 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $r = json_decode($request->getContent(), true) ?? $request->all(),
            [
                'name' => 'required|string|min:2|max:100',
                'address' => 'required|string|min:2|max:100',
                'school' => 'required|string|min:2|max:100',
                'mobilenumber' => 'required|string|max:11|regex:/^09\d{9}/'
            ]
        );
        switch($validator->fails()) {
            case false: {
                $r = (object) $r;
                Student::create([
                    'name' => ucwords($r->name),
                    'address' => ucwords($r->address),
                    'school' => ucwords($r->school),
                    'mobilenumber' => $r->mobilenumber,
                ]);
                return response()->json(['response' => 'success'], 200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
                break;
            }
            default: {
                return response()->json($validator->failed(), 400, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
            }
        }
    }
}
