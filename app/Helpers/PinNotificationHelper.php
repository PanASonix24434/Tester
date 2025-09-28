<?php

namespace App\Helpers;

use App\Mail\ApplicationResultNotification;
use App\Models\User;
use App\Models\ProfileUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PinNotificationHelper
{
    /**
     * Send pin number notification based on user type
     * 
     * @param array $resultDetails
     * @param User $user
     * @param string|null $applicantType
     * @param string|null $profileUserId
     */
    public static function sendPinNotification($resultDetails, $user, $applicantType = null, $profileUserId = null)
    {
        try {
            // Determine if this is a vessel manager application
            $isVesselManager = false;
            if ($applicantType === 'vessel_manager' && $profileUserId) {
                $isVesselManager = true;
            } elseif ($user->profile()) {
                // Check if user has a profile (vessel manager)
                $isVesselManager = true;
            }

            if ($isVesselManager) {
                // For vessel managers, send email without pin number
                // They must ask the user for the pin number
                $resultDetails['pin_number'] = null;
                $resultDetails['pin_message'] = 'PIN number tidak dihantar melalui email. Sila hubungi pemohon untuk mendapatkan PIN number.';
                
                // Send to vessel manager
                Mail::to($user->email)->send(new ApplicationResultNotification($resultDetails));
                
                // Also send to the actual user (if different from vessel manager)
                if ($profileUserId) {
                    $profileUser = ProfileUser::find($profileUserId);
                    if ($profileUser && $profileUser->user_id !== $user->id) {
                        $actualUser = User::find($profileUser->user_id);
                        if ($actualUser) {
                            $userResultDetails = $resultDetails;
                            $userResultDetails['pin_number'] = $resultDetails['pin_number'] ?? 'PIN akan dihantar kepada pengurus vesel';
                            $userResultDetails['pin_message'] = 'PIN number telah dihantar kepada pengurus vesel anda.';
                            Mail::to($actualUser->email)->send(new ApplicationResultNotification($userResultDetails));
                        }
                    }
                }
            } else {
                // For regular users, send email with pin number
                Mail::to($user->email)->send(new ApplicationResultNotification($resultDetails));
            }
            
        } catch (\Exception $e) {
            Log::error('Pin notification email sending failed: ' . $e->getMessage());
        }
    }
}
