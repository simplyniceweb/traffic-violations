password123
password

## pull changes
git pull


Send SMS to online officers:
$availableOfficers = User::where('role', 'officer')
    ->where('on_duty', true)
    ->where('last_seen_at', '>=', now()->subMinutes(10))
    ->get();


1. Viewing of users
2. Different login for officers with invitation code
    2.1 http://127.0.0.1:8000/login/officer?invitationcode=123456
3. Home navigation
4. Warning reporter
    4.1 Warning description
    4.2 Ban reporter