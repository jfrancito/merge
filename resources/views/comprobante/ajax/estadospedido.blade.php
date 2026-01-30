@if(isset($item) && isset($item['COD_ESTADO']))

    @if($item['COD_ESTADO'] == 'ETM0000000000001') 
        <span class="badge badge-default">{{ $item['TXT_ESTADO'] }}</span> 

    @else
        @if(is_null($item['COD_ESTADO'])) 
            <span class="badge badge-default">GENERADO</span>

        @else
            @if($item['COD_ESTADO'] == 'ETM0000000000002') 
                <span class="badge badge-warning">{{ $item['TXT_ESTADO'] }}</span>

            @else
                @if($item['COD_ESTADO'] == 'ETM0000000000003') 
                    <span class="badge badge-warning">{{ $item['TXT_ESTADO'] }}</span>

                @else
                    @if($item['COD_ESTADO'] == 'ETM0000000000004') 
                        <span class="badge badge-warning">{{ $item['TXT_ESTADO'] }}</span>

                    @else
                        @if($item['COD_ESTADO'] == 'ETM0000000000005') 
                            <span class="badge badge-primary">{{ $item['TXT_ESTADO'] }}</span>

                        @else
                            @if($item['COD_ESTADO'] == 'ETM0000000000006') 
                                <span class="badge badge-danger">{{ $item['TXT_ESTADO'] }}</span>

                            @else
                                @if($item['COD_ESTADO'] == 'ETM0000000000007') 
                                    <span class="badge badge-warning">{{ $item['TXT_ESTADO'] }}</span>

                                @else
                                    @if($item['COD_ESTADO'] == 'ETM0000000000008') 
                                        <span class="badge badge-success">{{ $item['TXT_ESTADO'] }}</span>

                                    @else
                                        @if($item['COD_ESTADO'] == 'ETM0000000000009') 
                                            <span class="badge badge-warning">{{ $item['TXT_ESTADO'] }}</span>

                                        @else
                                            @if($item['COD_ESTADO'] == 'ETM0000000000010') 
                                                <span class="badge badge-warning">{{ $item['TXT_ESTADO'] }}</span>

                                            @else
                                                @if($item['COD_ESTADO'] == 'ETM0000000000012') 
                                                    <span class="badge badge-warning">{{ $item['TXT_ESTADO'] }}</span>

                                                @else
                                                    @if($item['COD_ESTADO'] == 'ETM0000000000013') 
                                                        <span class="badge badge-primary">{{ $item['TXT_ESTADO'] }}</span>

                                                    @else
                                                        @if($item['COD_ESTADO'] == 'ETM0000000000014') 
                                                        <span class="badge badge-danger">{{ $item['TXT_ESTADO'] }}</span>

                                                        @else
                                                            <span class="badge badge-default">{{ $item['TXT_ESTADO'] ?? 'SIN ESTADO' }}</span>
                                                            @endif {{-- 13 --}}
                                                    @endif {{-- 13 --}}
                                                @endif {{-- 12 --}}
                                            @endif {{-- 10 --}}
                                        @endif {{-- 9 --}}
                                    @endif {{-- 8 --}}
                                @endif {{-- 7 --}}
                            @endif {{-- 6 --}}
                        @endif {{-- 5 --}}
                    @endif {{-- 4 --}}
                @endif {{-- 3 --}}
            @endif {{-- 2 --}}
        @endif {{-- null --}}
    @endif {{-- 1 --}}

@else
    <span class="badge badge-default">SIN DATA</span>
@endif
