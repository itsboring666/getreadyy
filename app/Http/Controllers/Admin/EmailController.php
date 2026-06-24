<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Email; // Assuming you have an Email model
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminBulkEmail;

class EmailController extends Controller
{
    public function index()
    {
        // Fetch all registered users
        $emails = \App\Models\User::latest()->get(); 
        return view('admin.emails', compact('emails'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Get all unique emails from users
        $subscribers = \App\Models\User::pluck('email')->unique()->toArray();

        foreach ($subscribers as $email) {
            Mail::to($email)->send(new AdminBulkEmail($request->subject, $request->message));
        }

        return redirect()->back()->with('success', 'Email sent to all ' . count($subscribers) . ' registered users.');
    }

    public function destroy($id)
    {
        // Removed delete functionality as this is now a list of all users, not just subscriptions.
        return redirect()->back()->with('error', 'Action disabled.');
    }
}
