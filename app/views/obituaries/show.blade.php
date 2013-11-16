@section('content')
    <article class="blog-post">
        <header>
            <h1>{{ $obituary->deceased->full_name }}</h1>
            <div class="lead-image">
                <img src="/img/hands-big.png" alt="Hands" class="img-responsive">
                <div class="meta clearfix">
                    <div class="author">
                        <i class="icon-user"></i>
                        <span class="data">{{ $obituary->deceased->full_name }}</span>
                    </div>
                    <div class="date">
                        <i class="icon-calendar"></i>
                        <span class="data">{{ $obituary->deceased->date }}{{--26 July 2013--}}</span>
                    </div>
                    <div class="comments">
                        <i class="icon-comments"></i>
                        <span class="data"><a href="#comments">26 Condolences</a></span>
                    </div>                                
                </div>
            </div>
        </header>
        <div class="body">
            {{ $obituary->article }}
        </div>
    </article>

    <aside class="social-icons clearfix">
        <a href="#" class="social-icon color-one">
                <div class="inner-circle" ></div>
                <i class="icon-twitter"></i>
        </a>
        <a href="#" class="social-icon color-two">
                <div class="inner-circle" ></div>
                <i class="icon-google-plus"></i>
        </a>    
        <a href="#" class="social-icon color-three">
                <div class="inner-circle" ></div>
                <i class="icon-facebook"></i>
        </a>
    </aside>

    <aside class="comments" id="comments">
        <hr>

        <h2><i class="icon-comments"></i> 24 Condolences</h2>
        @foreach( $obituary->condolences as $condolence )
            @include('condolences._item', compact($condolence))
        @endforeach      
    </aside>

    <aside class="create-comment" id="create-comment">
        <hr>    

        <h2><i class="icon-heart"></i> Add Comment</h2>
        @include('condolences._form')
    </aside>
@stop

@section('aside')
    @parent
@stop