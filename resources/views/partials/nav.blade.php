<nav class="navbar navbar-static">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('home') }}"><i class="fa fa-home"></i><b> Fiqhussunna </b></a>
            <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <i class="fa fa-chevron-down"></i>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                @include('partials.article-category-menu')
                @include('partials.track-category-menu')

                {{--<li><a class="{{ (Request::segment('1') == 'about' ? 'active' :  false ) }}"--}}
                       {{--href="{{ action('PageController@getAbout') }}">{{ trans('word.about_us') }}</a></li>--}}
                {{--<li><a class="{{ (Request::segment('1') == 'contact' ? 'active' :  false ) }}"--}}
                       {{--href="{{ action('PageController@getContact') }}">{{ trans('word.contact_us') }}</a></li>--}}
            </ul>
            {{--<div class="pull-right locale">--}}
                {{--@include('partials.locale')--}}
                {{--<i class="fa fa-globe localeIcon"></i>--}}
            {{--</div>--}}
        </div>
    </div>
</nav>