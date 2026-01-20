<div class="be-left-sidebar">
    <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Inicio</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                        <li class="divider">Menú</li>
                        <li class="active"><a href="{{ url('/bienvenido') }}"><i class="icon mdi mdi-home"></i><span>Inicio</span></a>
                        </li>
                        @php
                            $visualizar = 0;
                        @endphp
                        @foreach(Session::get('listamenu') as $grupo)

                            @if($grupo->orden >= 100 and $visualizar === 0)
                                @php
                                    $visualizar = 1;
                                @endphp
                                <li class="divider">Reportes</li>
                            @endif


                            <li class="parent" @click="menu='4'"><a href="#"><i
                                            class="icon mdi {{$grupo->icono}}"></i><span>{{$grupo->nombre}}</span></a>
                                <ul class="sub-mensu">
                                    @foreach($grupo->opcion()->orderBy('orden', 'asc')->get() as $opcion)
                                        @if(in_array($opcion->id, Session::get('listaopciones')))
                                            <li>
                                                <a href="{{ url('/'.$opcion->pagina.'/'.Hashids::encode(substr($opcion->id, -8))) }}">{{$opcion->nombre}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="progress-widget {{Session::get('color')}}">
            {{Session::get('empresas')->NOM_EMPR}}
        </div>

    </div>
</div>

