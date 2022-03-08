@extends('layouts.app')

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('/css/common/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/timeline_').strtolower( Request::cookie('mode') ?? 'default' ).'.css?'.time() }}">
@endsection

@section('pageJs')
<script>
    //timeline
    $(document).on('click', '.allyear', function() {
        var year = $(this).text()
        $('.timeline > dl > dd').each(function(index) {
            if (year == $(this).data('year')) {
                $(this).slideToggle(300)
            }
        })
    })

    $(document).on('click', '.events-header', function() {
        $(this).next().slideToggle(300)
    })

    $(document).on('click', '.collapse-all', function(){
        $('.events-body').slideToggle(300)
    })
</script>
@endsection

@section('content')
    <div class="container">
        <div class="css-list-text">{{ __('web.app.Timeline') }}</div>
        <form method="post" action="{{ route('timeline') }}">
            @csrf
        @include('common.timebar')

        <div class="timeline" id="timeline">
            <dl>
            @foreach($list as $key => $val)
                @if($key == 0 || !isset($year) || $year != $val['year'])
                    <dt class="allyear">{{ $val['year'] }}</dt>
                @endif
                @php
                    $year = $val['year'];
                @endphp
                <dd data-year="{{ $year }}" class="pos-{{ $val['action'] == '1' ? 'left' : 'right' }} clearfix">
                    <div class="circ circ{{ $val['action'] }} animation"></div>
                    <div class="time">{{ date('m-d A h:i', strtotime($val['time'])) }}</div>
                    <div class="events">
                        <div class="events-header"><li class="fas type{{ $val['action'] }}"></li> {{ $val['name'].' '.$val['record_type'] }}</div>
                        <div class="events-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-4 col-12">
                                    <img width="100%" class="events-object img-responsive img-rounded" src="{{ $val['img'] }}" />
                                </div>
                                <div class="col-md-9 col-sm-8 col-12">
                                    <a href="{{ route('dibbling_record', ['user_id'=>$val['user_id']]) }}"><span class="events-title css-list-name">{{ $val['user_name'] }}</span></a>
                                    <div class="events-desc css-list-title">{{ $val['title'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="events-footer"></div>
                    </div>
                </dd>
            @endforeach
            <dd class="pos-left clearfix">
                <div class="circ"></div>
                <div class="time">{{ date('Y-m-d', strtotime(Auth::user()->created_at)).' '.__('web.app.Register') }}</div>
                <div class='events' style='visibility:hidden'></div>
            </dd>
            </dl>
        </div>
    </form>
    </div>
@endsection
