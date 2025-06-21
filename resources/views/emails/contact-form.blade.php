<!DOCTYPE html>
<html>
<head><title>Nowe Zgłoszenie</title></head>
<body>
    <h2>Nowe zgłoszenie z intranetu</h2>
    <p><strong>Od:</strong> {{ $user->name }} ({{ $user->email }})</p>
    <p><strong>Kategoria:</strong> {{ $category }}</p>
    <hr>
    <h3>Treść zgłoszenia:</h3>
    <p>{!! nl2br(e($messageContent)) !!}</p>
    <hr>
    <p>Wiadomość wysłana z intranetu.</p>
</body>
</html>
