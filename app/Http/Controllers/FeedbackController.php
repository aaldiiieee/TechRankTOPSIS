<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function showFeedbackForm($id)
    {
        return view('pages.feedback.form', ['customerId' => $id]);
    }

    public function submitFeedback(Request $request, $id)
    {
        Feedback::create([
            'customer_id' => $id,
            'rating' => $request->input('rating'),
            'comments' => $request->input('comments'),
        ]);

        return redirect('/')->with('success', 'Thank you for your feedback!');
    }
}
