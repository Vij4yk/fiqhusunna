@extends('layouts.one_col')

@section('title')
    {{ $track->name }}
@endsection

@section('script')
    @parent
    <script>
        $(document).ready(function () {
            jplayer('{{$track}}', '{{ $trackUrl }}');
        });
    </script>
@endsection

@section('content')

    @if($track->trackeable)
        <div id="bc1" class="btn-group btn-breadcrumb pBottom20">
            <a href="{{url('home')}}" class="btn btn-default"><i class="fa fa-home"></i>&nbsp; </a>
            @if(is_a($track->trackeable, 'Category'))
                <a href="{{action('CategoryController@getTrack',$track->trackeable->id)}}" class="btn btn-default "><i
                            class="fa fa-folder"></i> {{ $track->trackeable->name }}</a>
            @else
                @if($track->trackeable->category)
                    <a href="{{action('CategoryController@getTrack',$track->trackeable->category->id)}}"
                       class="btn btn-default "><i
                                class="fa fa-folder"></i> {{ $track->trackeable->category->name }}</a>

                    <a href="{{action('AlbumController@show',$track->trackeable->id)}}"
                       class="btn btn-default "><i
                                class="fa fa-music"></i> {{ $track->trackeable->name }}</a>

                @endif
            @endif
            <a href="{{action('TrackController@show',$track->id)}}"
               class="btn btn-default "><i
                        class="fa fa-headphones"></i> {{ $track->name }}</a>
        </div>
    @endif

    <h1>{{$track->name}} </h1>
    <div class="col-md-12 pTop10 pBottom10 mTop10" style="background-color: #D8ECF0;">
        <a href="#">
            <i class="fa fa-pencil"></i>
        </a>
        {{$track->created_at->format('d-m-Y')}}
        &nbsp;&nbsp;&nbsp;
        <a href="{{ action('TrackController@downloadTrack',$track->id) }}">
            <i class="fa fa-download"></i>
        </a>
        {{ trans('word.save_file') }}
        {{ $track->downloads ? $track->downloads->count() : '0' }}
        &nbsp;&nbsp;&nbsp;
        <a href="#">
            <i class="fa fa-eye"></i>
        </a>
        {{ $track->metas ? $track->metas->count() : '0' }} {{ trans('word.views') }}
        &nbsp;&nbsp;&nbsp;
        <a href="#">
            <i class="fa fa-database"></i>
        </a>
        {{ $track->size }}
        {{--<br>--}}
        {{--@if($track->author)--}}
            {{--<a href="#"><i class="fa fa-user"></i></a>--}}
            {{--{{$track->author->name}}--}}
        {{--@endif--}}

        {{--<br>--}}
        {{--@if($track->place)--}}
            {{--<a href="#"><i class="fa fa-map-marker"></i></a>--}}
            {{--{{$track->place}}--}}
        {{--@endif--}}

        {{--<br>--}}
        {{--@if($track->record_date)--}}
            {{--{{ trans('word.record_date') }} :--}}
            {{--{{$track->record_date->format('m-d-Y')}}--}}
        {{--@endif--}}
        {{--<br>--}}
        {{--@if($track->record_date)--}}
            {{--{{ trans('word.record_date_hijri') }} :--}}
            {{--{{$track->record_date_hijri}}--}}
        {{--@endif--}}

    </div>
    @include('modules.track.jplayer',['track'=>$track])
@endsection