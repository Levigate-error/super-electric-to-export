@if(!empty($breadcrumbs))
    <section id="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li>
                            <a href="/">
                                Главная
                            </a>
                        </li>
                        @foreach($breadcrumbs as $item)
                            @if(!empty($item['url']))
                                <li>
                                    <a href="{{$item['url']}}">
                                        {{$item['title']}}
                                    </a>
                                </li>
                            @else
                                <li class="active">
                                    {{$item['title']}}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endif
