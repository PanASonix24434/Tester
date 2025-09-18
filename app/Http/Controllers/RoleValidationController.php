<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleValidationController extends Controller
{
    /**
     * Validate user role and return appropriate action for tindakan button
     * 
     * @param string $appealId
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateTindakanAction($appealId)
    {
        try {
            // Check if user is authenticated
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'action' => 'login',
                    'message' => 'User not authenticated',
                    'redirect_url' => route('login')
                ], 401);
            }

            $user = auth()->user();
            $userRole = strtolower(trim($user->peranan ?? ''));
            $userId = $user->id ?? 'unknown';

            Log::info("Role validation for user ID: $userId, Role: '$userRole', Appeal ID: $appealId");

            // Validate role and return appropriate action
            if (empty($userRole)) {
                Log::warning("User has empty role. User ID: $userId");
                return response()->json([
                    'success' => false,
                    'action' => 'error',
                    'message' => 'Role is not set. Please contact the administrator.',
                    'error_code' => 'NO_ROLE'
                ], 403);
            }

            // Check for Pelesen role
            if (stripos($userRole, 'pelesen') !== false) {
                Log::info("Pelesen role detected - showing status content for appeal: $appealId");
                return response()->json([
                    'success' => true,
                    'action' => 'status_content',
                    'message' => 'Show status content',
                    'appeal_id' => $appealId,
                    'role' => 'pelesen'
                ]);
            }

            // Check for PPL role (Pegawai Perikanan)
            if (stripos($userRole, 'pegawai perikanan') !== false) {
                Log::info("PPL role detected - routing to PPL review for appeal: $appealId");
                return response()->json([
                    'success' => true,
                    'action' => 'redirect',
                    'message' => 'Redirect to PPL review',
                    'redirect_url' => route('appeals.ppl_review', ['id' => $appealId]),
                    'role' => 'ppl'
                ]);
            }

            // Check for KCL role (Ketua Cawangan)
            if (stripos($userRole, 'ketua cawangan') !== false) {
                Log::info("KCL role detected - routing to KCL review for appeal: $appealId");
                return response()->json([
                    'success' => true,
                    'action' => 'redirect',
                    'message' => 'Redirect to KCL review',
                    'redirect_url' => route('appeals.kcl_review', ['id' => $appealId]),
                    'role' => 'kcl'
                ]);
            }

            // Check for PK role (Pengarah Kanan)
            if (stripos($userRole, 'pengarah kanan') !== false) {
                Log::info("PK role detected - routing to PK review for appeal: $appealId");
                return response()->json([
                    'success' => true,
                    'action' => 'redirect',
                    'message' => 'Redirect to PK review',
                    'redirect_url' => route('appeals.pk_review', ['id' => $appealId]),
                    'role' => 'pk'
                ]);
            }

            // No matching role found
            Log::warning("No matching role found for user with ID: $userId, Role: '$userRole'");
            return response()->json([
                'success' => false,
                'action' => 'error',
                'message' => 'Unauthorized action. Role not recognized.',
                'error_code' => 'UNKNOWN_ROLE',
                'role' => $userRole
            ], 403);

        } catch (\Exception $e) {
            Log::error("Error in role validation: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'action' => 'error',
                'message' => 'Internal server error',
                'error_code' => 'SERVER_ERROR'
            ], 500);
        }
    }

    /**
     * Get user role information
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserRole()
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $user = auth()->user();
            $userRole = strtolower(trim($user->peranan ?? ''));

            return response()->json([
                'success' => true,
                'user_id' => $user->id,
                'role' => $userRole,
                'role_display' => ucwords($userRole)
            ]);

        } catch (\Exception $e) {
            Log::error("Error getting user role: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving user role'
            ], 500);
        }
    }
}
