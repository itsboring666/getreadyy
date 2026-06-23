<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subjectLine ?? 'GET READY Newsletter' }}</title>
</head>
<body style="font-family: sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: auto;">
        <h2 style="color: #3B5998;">GET READY</h2>
        <p>{!! nl2br(e($content)) !!}</p>
        <hr>
        <small style="color: #999;">You’re receiving this email because you subscribed to GET READY updates.</small>
    </div>
</body>
</html>
