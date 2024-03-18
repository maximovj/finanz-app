<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    <select
        id="finanz_select-periodo"
        onchange="fncg_handleChangeBalanzaPeriodo(this)"
        name="{{ $field['name'] }}@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)[]@endif"
        @include('crud::fields.inc.attributes')
        @if (isset($field['allows_multiple']) && $field['allows_multiple']==true)multiple @endif
        >

        @if ($field['allows_null'])
            <option value="">-</option>
        @endif

        @if (count($field['options']))
            @foreach ($field['options'] as $key => $value)
                @if((old(square_brackets_to_dots($field['name'])) !== null && (
                        $key == old(square_brackets_to_dots($field['name'])) ||
                        (is_array(old(square_brackets_to_dots($field['name']))) &&
                        in_array($key, old(square_brackets_to_dots($field['name'])))))) ||
                        (null === old(square_brackets_to_dots($field['name'])) &&
                            ((isset($field['value']) && (
                                        $key == $field['value'] || (
                                                is_array($field['value']) &&
                                                in_array($key, $field['value'])
                                                )
                                        )) ||
                                (!isset($field['value']) && isset($field['default']) &&
                                ($key == $field['default'] || (
                                                is_array($field['default']) &&
                                                in_array($key, $field['default'])
                                            )
                                        )
                                ))
                        ))
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- no styles -->
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            function fncg_handleHidenBalanzaPeriodo(){
                const arr = ['anio_1era', 'mes_1era', 'anio_2da', 'mes_2da'];
                arr.forEach((item) => {
                    $('#balanza-'+item).hide();
                });
            }

            function fncg_handleChangeBalanzaPeriodo(ev){
                console.log(ev);
                const select_value = ev.value;
                if(select_value === 'na'){
                    fncg_handleHidenBalanzaPeriodo();
                }else if (select_value === 'anual'){
                    fncg_handleHidenBalanzaPeriodo();
                    $('#balanza-anio_1era').attr('class', 'col-md-12');
                    $('#balanza-anio_1era').show();

                } else if (select_value === 'rango_especifico'){
                    fncg_handleHidenBalanzaPeriodo();
                    $('#balanza-anio_1era').attr('class', 'col-md-6');
                    $('#balanza-anio_1era').show();
                    $('#balanza-mes_1era').attr('class', 'col-md-6');
                    $('#balanza-mes_1era').show();
                } else if (select_value === 'periodo_especifico'){
                    fncg_handleHidenBalanzaPeriodo();
                    $('#balanza-anio_1era').attr('class', 'col-md-6');
                    $('#balanza-anio_1era').show();
                    $('#balanza-mes_1era').attr('class', 'col-md-6');
                    $('#balanza-mes_1era').show();

                    $('#balanza-anio_2da').attr('class', 'col-md-6');
                    $('#balanza-anio_2da').show();
                    $('#balanza-mes_2da').attr('class', 'col-md-6');
                    $('#balanza-mes_2da').show();
                } else {
                    fncg_handleHidenBalanzaPeriodo();
                }
            }
            
            fncg_handleChangeBalanzaPeriodo($('#finanz_select-periodo')[0]);
        </script>
    @endpush
@endif