<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Mail;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Arr;

use App\Mail\ComplaintTest;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sendMailTest(Request $request)
    {

        try{
            Mail::to('chickpoksen@gmail.com')->queue(new ComplaintTest());
                echo "E-mel telah dihantar";
        }catch(Exception $e){
                echo $e->getMessage();
                Log::info(['Mal error on account approval'=> 'Mail not sent successfully']);
        }

        return redirect()->route('dashboard');
        
    }
}
