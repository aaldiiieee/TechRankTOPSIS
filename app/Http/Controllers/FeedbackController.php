<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Customer;
use App\Models\Report;
use App\Models\TechnicianScore;

class FeedbackController extends Controller
{
    public function showFeedbackForm($id)
    {
        $report = Report::where('customerID', $id)->first();

        if (!$report) {
            return redirect()->back()->with('error', 'Report not found for this customer.');
        }

        return view('pages.feedback.form', ['customerId' => $id]);
    }

    public function submitFeedback(Request $request, $id)
    {
        $techID = Report::where('customerID', $id)->value('techID');

        if (!$techID) {
            return redirect()->back()->with('error', 'Technician ID not found for the given customer.');
        }

        // Simpan Feedback
        Feedback::create([
            'customer_id' => $id,
            'tech_id' => $techID,
            'rating' => $request->input('rating'),
            'comments' => $request->input('comments'),
        ]);

        // Hitung TOPSIS
        $this->calculateTopsis();

        return redirect('/')->with('success', 'Thank you for your feedback!');
    }

    private function calculateTopsis()
    {
        $feedbacks = Feedback::all();

        // Matriks keputusan
        $decisionMatrix = [];
        $techIds = [];
        foreach ($feedbacks as $feedback) {
            $decisionMatrix[] = [$feedback->rating];
            $techIds[] = $feedback->tech_id;
        }

        if (empty($decisionMatrix)) {
            throw new \Exception('Decision matrix is empty. Cannot calculate TOPSIS.');
        }

        // Normalisasi matriks
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);

        // Hitung solusi ideal positif dan negatif
        [$idealPositive, $idealNegative] = $this->calculateIdealSolutions($normalizedMatrix);

        // Hitung skor untuk setiap teknisi
        $scores = [];
        foreach ($normalizedMatrix as $key => $row) {
            $distancePositive = $this->calculateEuclideanDistance($row, $idealPositive);
            $distanceNegative = $this->calculateEuclideanDistance($row, $idealNegative);

            $denominator = $distancePositive + $distanceNegative;
            $scores[$techIds[$key]] = $denominator == 0 ? 0 : $distanceNegative / $denominator;
        }

        // Simpan skor teknisi
        arsort($scores);
        TechnicianScore::truncate();
        $rank = 1;
        foreach ($scores as $techId => $score) {
            TechnicianScore::create([
                'tech_id' => $techId,
                'score' => $score,
                'rank' => $rank++
            ]);
        }
    }

    private function normalizeMatrix($matrix)
    {
        $normalized = [];
        foreach ($matrix[0] as $col => $_) {
            $columnValues = array_column($matrix, $col);
            $norm = sqrt(array_sum(array_map(fn($x) => pow($x, 2), $columnValues)));
            foreach ($matrix as $rowIndex => $row) {
                $normalized[$rowIndex][$col] = $norm != 0 ? $row[$col] / $norm : 0;
            }
        }
        return $normalized;
    }

    private function calculateIdealSolutions($matrix)
    {
        $idealPositive = [];
        $idealNegative = [];
        foreach ($matrix[0] as $col => $_) {
            $columnValues = array_column($matrix, $col);
            $idealPositive[$col] = max($columnValues);
            $idealNegative[$col] = min($columnValues);
        }
        return [$idealPositive, $idealNegative];
    }

    private function calculateEuclideanDistance($row, $ideal)
    {
        return sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $row, $ideal)));
    }
}