<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HelpController extends Controller
{
    /**
     * Show the help/contact page
     */
    public function contact()
    {
        return view('help.contact');
    }

    /**
     * Submit a support request
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'category' => 'required|in:orders,prescriptions,technical,payment,other',
        ]);

        $user = auth()->user();

        // Here you can either:
        // 1. Save to database
        // 2. Send email
        // 3. Integrate with ticketing system

        // For now, we'll just store in session and show success message
        return redirect()->route('help.contact')
                        ->with('success', 'Thank you for contacting us! We will respond to your inquiry shortly.');
    }

    /**
     * Show FAQ/Help page
     */
    public function index()
    {
        $faqs = [
            [
                'question' => 'How do I place an order?',
                'answer' => 'You can browse medicines, add them to your cart, and proceed to checkout. You can pay online or using other available payment methods.',
            ],
            [
                'question' => 'How do I upload a prescription?',
                'answer' => 'Go to "My Prescriptions" in your dashboard and click "Upload Prescription". You can upload PDF, JPG, PNG files up to 5MB.',
            ],
            [
                'question' => 'How long does delivery take?',
                'answer' => 'Standard delivery takes 2-3 business days. Express delivery options are available for selected areas.',
            ],
            [
                'question' => 'Can I cancel or modify my order?',
                'answer' => 'You can cancel orders that are in "pending" status. Once processing has started, modifications are not possible.',
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept credit cards, debit cards, and digital payment methods. All transactions are secure and encrypted.',
            ],
        ];

        return view('help.index', compact('faqs'));
    }
}
