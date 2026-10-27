<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $report['title'] }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        h2 { margin: 0 0 4px 0; }
        .period { color: #555; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #444; padding: 4px 6px; text-align: left; }
        th { background: #e9ecef; }
        .summary { margin-top: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>{{ $report['title'] }}</h2>
    <div class="period">{{ $report['period'] }} | Dicetak: {{ now()->format('d-m-Y H:i') }}</div>

    <table>
        <thead>
            <tr>
                @foreach ($report['headings'] as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($report['rows'] as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($report['headings']) }}" style="text-align:center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @foreach ($report['summary'] as $label => $value)
        <div class="summary">{{ $label }}: {{ $value }}</div>
    @endforeach
</body>
</html>