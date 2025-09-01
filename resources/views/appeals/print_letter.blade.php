<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Kelulusan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        h1 { color: #2c3e50; }
        p { font-size: 1.1rem; }
        .letter-box { border: 1px solid #ccc; border-radius: 8px; padding: 2rem; background: #f9f9f9; max-width: 600px; margin: 2rem auto; }
    </style>
</head>
<body>
    <div class="letter-box">
        <h1>Surat Kelulusan</h1>
        <p><strong>Appeal ID:</strong> {{ $appeal->id }}</p>
        <p><strong>Approved by:</strong> {{ $appeal->approved_by }}</p>
        <p><strong>Status:</strong> {{ $appeal->status }}</p>
    </div>
</body>
</html> 