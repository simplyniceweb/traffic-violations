<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class InvitationController extends Controller
{
    public function index()
    {
        $code = $this->generateInviteCode();
        $exist = Invitation::where('code', $code)->first();
        if ($exist) {
            // If the code already exists, generate a new one
            return redirect()->route('admin.invitations.index')->with('error', 'Invitation code already exists.');
        }

        // If the code is unique, create a new invitation
        Invitation::create(['code' => $code, 'status' => 5]);

        return response()->json(['status' => 'ok', 'code' => $code]);
    }

    public function generateInviteCode(): string
    {
        // Use your local timezone (Asia/Manila per your profile)
        $tz = new \DateTimeZone('Asia/Manila');

        // Capture time once to keep parts consistent
        $mt = microtime(true);
        $ms = (int) (($mt - floor($mt)) * 1000);

        $dt = (new \DateTime('now', $tz))->setTimestamp((int)$mt);

        // YYYYMMDD-HHMMSSmmm  (e.g., 20250901-193245123)
        $stamp = $dt->format('Ymd-His') . sprintf('%03d', $ms);

        // Add 40 bits of entropy to avoid collisions from same millisecond
        $entropy = random_bytes(5); // 5 bytes = 40 bits

        // Hash (binary), then take the first 5 bytes (40 bits) and base36 it for brevity
        $digest = hash('sha256', $stamp . $entropy, true);
        $first5 = substr($digest, 0, 5); // 40 bits
        $hex    = bin2hex($first5);      // 10 hex chars
        $base36 = strtoupper(str_pad(base_convert($hex, 16, 36), 8, '0', STR_PAD_LEFT));

        // Final code example: 20250901-193245123-6X9M1K2P
        return $stamp . '-' . $base36;
    }
}
