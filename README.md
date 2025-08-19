password123
password

## pull changes
git pull


Send SMS to online officers:
$availableOfficers = User::where('role', 'officer')
    ->where('on_duty', true)
    ->where('last_seen_at', '>=', now()->subMinutes(10))
    ->get();