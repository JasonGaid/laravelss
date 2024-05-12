<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\User;

class ViolationController extends Controller
{
    public function checkAndReportViolations($title, $content, $userId)
    {
        $titleViolated = $this->checkForViolations($title);
        $contentViolated = $this->checkForViolations($content);

        if ($titleViolated || $contentViolated) {
            // Increment report count and check for thresholds
            $response = $this->reportViolation($userId);
            if ($response) {
                return $response;
            }
        }
    }

    private function checkForViolations($text)
    {
        $forbiddenWords = Violation::pluck('keyword')->toArray();

        foreach ($forbiddenWords as $word) {
            if (stripos($text, $word) !== false) {
                return true;
            }
        }

        return false;
    }

    private function reportViolation($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $user->increment('report_count');

            // Check if the report count matches any threshold
            $thresholds = [1, 2, 4, 5, 7, 8, 10, 11]; // Add more thresholds as needed

            if (in_array($user->report_count, $thresholds)) {
                // Return an alert message based on the threshold
                $alertMessage = $this->getAlertMessage($user->report_count);
                return response()->json(['message' => $alertMessage]);
            }

            // Check if the report count is a multiple of 3
            if ($user->report_count % 3 === 0) {
                // Change user status to "ban"
                $user->status = 'ban';
                $user->save();
            }
        } catch (\Exception $e) {
            \Log::error('Failed to increment report count for user: ' . $e->getMessage());
        }
    }

    
}
