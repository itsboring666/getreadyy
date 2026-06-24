<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:100',
            'message' => 'required|string|min:10|max:2000',
        ]);

        try {
            \App\Models\ContactMessage::create($validated);

            Mail::send([], [], function ($mail) use ($validated) {
                $mail->to('tamilkumaran1672@gmail.com')
                     ->replyTo($validated['email'], $validated['name'])
                     ->subject('[GET READY] Contact: ' . $validated['subject'])
                     ->html("
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #eee;'>
                            <h2 style='background:#000; color:#e63946; padding: 16px; margin:0 0 24px; font-size:24px;'>GET READY — New Message</h2>
                            <table style='width:100%; font-size:14px; line-height:1.8;'>
                                <tr><td style='padding:6px 0; color:#666; width:120px;'><strong>From:</strong></td><td>{$validated['name']}</td></tr>
                                <tr><td style='padding:6px 0; color:#666;'><strong>Email:</strong></td><td>{$validated['email']}</td></tr>
                                <tr><td style='padding:6px 0; color:#666;'><strong>Phone:</strong></td><td>" . ($validated['phone'] ?? 'Not provided') . "</td></tr>
                                <tr><td style='padding:6px 0; color:#666;'><strong>Subject:</strong></td><td>{$validated['subject']}</td></tr>
                            </table>
                            <hr style='margin:20px 0; border:none; border-top:1px solid #eee;'>
                            <p style='font-size:14px; color:#333; line-height:1.8;'>{$validated['message']}</p>
                            <hr style='margin:20px 0; border:none; border-top:1px solid #eee;'>
                            <p style='font-size:11px; color:#999;'>Sent from the GET READY website contact form.</p>
                        </div>
                     ");
            });

            return back()->with('success', 'Message sent! We will get back to you within 24 hours.');
        } catch (\Exception $e) {
            Log::error('Contact form mail failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send message. Please email us directly at tamilkumaran1672@gmail.com');
        }
    }
}
