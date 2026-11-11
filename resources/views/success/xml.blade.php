
@if ($xml)

  @php 
    $obj = json_decode($xml);
    $pts = array_search('TS', array_column($obj, 'tipo'));
    $ptw = array_search('TW', array_column($obj, 'tipo'));
    $ptd = array_search('TD', array_column($obj, 'tipo'));

    $cts = $obj[$pts]->data_0;
    $ctw = $obj[$ptw]->data_0;
    $ctd = $obj[$ptd]->data_0;

    $tts = $obj[$pts]->data_1;
    $ttw = $obj[$ptw]->data_1;
    $ttd = $obj[$ptd]->data_1;


  @endphp  



<div class="be-content xml_content">
  <div class="main-content container-fluid">
    <div class="row">

      @if($cts>0)
      <div class="colxml col-xs-12 col-sm-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div role="alert" class="alert alert-success alert-icon alert-icon-border alert-dismissible">
              <div class="icon"><span class="mdi mdi-check"></span></div>
              <div class="message">

                  <button type="button"  aria-label="Close" class="close xmlclose">
                      <span aria-hidden="true" class="mdi mdi-close"></span>
                  </button>

                  <button type="button"  aria-label="Ocultar" class="close xmlocultarmostrar">
                      <span aria-hidden="true" class="mdi mdi-chevron-right mdi-hc-2x"></span>
                      <span aria-hidden="true" class="mdi mdi-chevron-down mdi-hc-2x"></span>
                  </button>

                  <strong>{{$cts}} </strong> {{$tts}}
              </div>
            </div>


            <div class = 'xmlscrollpanel'>

              <div class="panel panel-border scrollpanel no4 none">

                <div class="panel-body">
                    @foreach($obj as $item)
                      @if($item->tipo == 'S')
                        <p class="text-muted"> 
                          <strong>{{$item->data_0}} :</strong>
                          {{$item->data_1}}
                        </p>
                      @endif
                    @endforeach
                </div>
              </div>

            </div>




          </div>
        </div>
      </div>
      @endif

      @if($ctw>0)
      <div class="colxml col-xs-12 col-sm-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible">
              <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
              <div class="message">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close xmlclose"><span aria-hidden="true" class="mdi mdi-close"></span></button>

                <button type="button"  aria-label="Ocultar" class="close xmlocultarmostrar">
                    <span aria-hidden="true" class="mdi mdi-chevron-right mdi-hc-2x"></span>
                    <span aria-hidden="true" class="mdi mdi-chevron-down mdi-hc-2x"></span>
                </button>                      

                <strong>{{$ctw}} </strong> {{$ttw}}
              </div>
            </div>

            <div class = 'xmlscrollpanel'>

              <div class="panel panel-border scrollpanel no4 none">

                <div class="panel-body">
                    @foreach($obj as $item)
                      @if($item->tipo == 'W')
                        <p class="text-muted"> 
                          <strong>{{$item->data_0}} :</strong>
                          {{$item->data_1}}
                        </p>
                      @endif
                    @endforeach 
                </div>
              </div>

            </div>


          </div>
        </div>
      </div>
      @endif

      @if($ctd>0)
      <div class="colxml col-xs-12 col-sm-4">
        <div class="panel panel-default">
          <div class="panel-body">
            <div role="alert" class="alert alert-danger alert-icon alert-icon-border alert-dismissible">
              <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
              <div class="message">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close xmlclose"><span aria-hidden="true" class="mdi mdi-close"></span></button>

                <button type="button"  aria-label="Ocultar" class="close xmlocultarmostrar">
                    <span aria-hidden="true" class="mdi mdi-chevron-right mdi-hc-2x"></span>
                    <span aria-hidden="true" class="mdi mdi-chevron-down mdi-hc-2x"></span>
                </button>  

                <strong>{{$ctd}} </strong> {{$ttd}}
              </div>
            </div>

            <div class = 'xmlscrollpanel'>

              <div class="panel panel-border scrollpanel no4 none">

                <div class="panel-body">
                    @foreach($obj as $item)
                      @if($item->tipo == 'D')
                        <p class="text-muted"> 
                          <strong>{{$item->data_0}} :</strong>
                          {{$item->data_1}}
                        </p>
                      @endif
                    @endforeach 
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
      @endif

    </div>
  </div>
</div>
@endif
