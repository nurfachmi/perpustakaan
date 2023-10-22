@php
    $tombolKirimKartuAnggota = isset($send_card_url) ? "<a class=\"dropdown-item\" href=\"$send_card_url\">Kirim Kartu Anggota</a>" : '';
    $tombolUbah = isset($edit_url) ? "<a class=\"dropdown-item\" href=\"$edit_url\">Ubah</a>" : '';
    $tombolHapus = isset($delete_url) ? "<a class=\"dropdown-item\" data-url=\"$delete_url\" data-redirect=\"$redirect_url\" data-name=\"$name\" onclick=\"softDelete(this)\">Hapus</a>" : '';
@endphp

@if ($tombolUbah || $tombolHapus || isset($custom_links))
<div class="btn-group">
    <div class="dropdown">
        <button class="btn btn-primary btn-sm dropdown-toggle shadow-sm" type="button" id="dropdownMenuButton"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{__('general.action')}}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            {!! $tombolKirimKartuAnggota !!}
            @if (isset($resource))
                @can("$resource.edit")
                    {!! $tombolUbah !!}
                @endcan
            @else
                {!! $tombolUbah !!}
            @endif
            @if (isset($resource))
                @can("$resource.destroy")
                    {!! $tombolHapus !!}
                @endcan
            @else
                {!! $tombolHapus !!}
            @endif

            @if (isset($custom_links))
                @foreach ($custom_links as $link)
                    @if (isset($link['name']))
                        @can($link['name'])
                            <a class="dropdown-item" href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                        @endcan
                    @else
                        <a class="dropdown-item" href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                    @endif
                @endforeach
            @endif

            @stack('item')

        </div>
    </div>
    @stack('opsi')
</div>
@endif