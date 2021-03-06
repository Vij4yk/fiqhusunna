<div class="panel">
    <div class="panel-heading left-col-heading"><i
                class="fa fa-folder"></i> {{ isset($title) ? $title : trans('word.categories') }}</div>
    <div class="panel-body">
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu"
            style="display: block; position: static; margin-bottom: 5px; *width: 180px;">

            @foreach($categories as $category)
                <li class="
                    @if(count($category->childCategories))
                        dropdown-submenu
                    @endif
                        "><a href="{{ action('CategoryController@getArticle',$category->id) }}"><i
                                class="fa fa-folder"></i> {{ ucfirst($category->name) }}</a>
                    @if($category->childCategories)
                        <ul class="dropdown-menu">
                            @foreach($category->childCategories as $child)
                                <li>
                                    <a href="{{ action('CategoryController@getArticle',$child->id) }}">{{ $child->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
