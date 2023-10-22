<html>
    <head>
        <style>
            @page {
                size: 54mm 86mm landscape;
                margin: 4mm 4mm;
            }
            blockquote, dl, dd, h1, h2, h3, h4, h5, h6, hr, figure, p, pre {
                margin: 0;
            }
            h1, h2, h3, h4, h5, h6 {
                font-size: inherit;
                font-weight: inherit;
            }
            ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body style="margin: 0; padding: 0;">
        <h1 style="font-size: large">Perpustakaan</h1>
        <ul style="padding-top: 1mm; font-size: small;">
            <li><span style="font-weight: bold;">{{ $cardMemberNo }}</span></li>
            <li><span style="font-weight: bold; text-transform: uppercase;">{{ $cardMemberName }}</span></li>
            <li><span style="font-weight: medium; text-transform: lowercase;">{{  $cardMemberEmail }}</span></li>
        </ul>
        <span style="position: absolute; bottom: 0; right: 0; font-size: small;">Berlaku sampai: {{ $cardMemberExpired }}</span>
    </body>
</html>