<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Feedback Export</title>
  <style>
    body { font-family: Arial, sans-serif; color:#222; }
    table { width:100%; border-collapse: collapse; }
    th, td { border:1px solid #ddd; padding:8px; }
    th { background:#f7f7f7; }
  </style>
</head>
<body>
  <h2>Feedback Export</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach($feedback as $f)
      <tr>
        <td>{{ $f->id ?? '' }}</td>
        <td>{{ $f->name ?? '' }}</td>
        <td>{{ $f->email ?? '' }}</td>
        <td>{{ $f->message ?? '' }}</td>
        <td>{{ $f->created_at ?? '' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>