@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6 col-sm-6">
        <article class=" blog-teaser">
            <header>
                <img src="img/cat.png" alt="A Cat">
                <h3><a href="blog-detail.html">Cats Everywhere</a></h3>
                <span class="meta">24 July 2013, Alexander Rechsteiner</span>
                <hr>
            </header>
            <div class="body">
                Bacon ipsum dolor sit amet esse duis pastrami anim, pancetta fatback capicola officia tenderloin. Meatloaf culpa ut, bacon sed sausage jerky cillum est ham ad laboris ham hock dolore. Venison ut enim, aliqua elit frankfurter et incididunt consequat culpa nostru aliqua elit pancetta. 
            </div>
            <div class="clearfix">
                <a href="blog-detail.html" class="btn btn-tales-one">Read more</a>
            </div>
        </article>
    </div>
    <div class="col-md-6 col-sm-6">
        <article class="blog-teaser">
            <header>
                <img src="img/hands.png" alt="Hands">
                <h3><a href="blog-detail.html">Big Thinkers</a></h3>
                <span class="meta">24 July 2013, Alexander Rechsteiner</span>
                <hr>
            </header>
            <div class="body">
                Bacon ipsum dolor sit amet esse duis pastrami anim, pancetta fatback capicola officia tenderloin. Meatloaf culpa ut, bacon sed sausage jerky cillum est ham ad laboris ham hock dolore. Venison ut enim, aliqua elit frankfurter et incididunt consequat culpa nostru aliqua elit pancetta. 
            </div>
            <div class="clearfix">
                <a href="blog-detail.html" class="btn btn-tales-one">Read more</a>
            </div>
        </article>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <article class="blog-teaser">
            <header>
                <img src="img/bike.png" alt="A Bike">
                <h3><a href="blog-detail.html">My Insightful Article</a></h3>
                <span class="meta">24 July 2013, Alexander Rechsteiner</span>
                <hr>
            </header>
            <div class="body">
                Bacon ipsum dolor sit amet esse duis pastrami anim, pancetta fatback capicola officia tenderloin. Meatloaf culpa ut, bacon sed sausage jerky cillum est ham ad laboris ham hock dolore. Venison ut enim, aliqua elit frankfurter et incididunt consequat culpa nostru aliqua elit pancetta. 
            </div>
            <div class="clearfix">
                <a href="blog-detail.html" class="btn btn-tales-one">Read more</a>
            </div>
        </article>
    </div>
    <div class="col-md-6 col-sm-6">
        <article class="blog-teaser">
            <header>
                <img src="img/violin.png" alt="A Violin Player">
                <h3><a href="blog-detail.html">Why I Play Violin</a></h3>
                <span class="meta">24 July 2013, Alexander Rechsteiner</span>
                <hr>
            </header>
            <div class="body">
                Bacon ipsum dolor sit amet esse duis pastrami anim, pancetta fatback capicola officia tenderloin. Meatloaf culpa ut, bacon sed sausage jerky cillum est ham ad laboris ham hock dolore. Venison ut enim, aliqua elit frankfurter et incididunt consequat culpa nostru aliqua elit pancetta. 
            </div>
            <div class="clearfix">
                <a href="blog-detail.html" class="btn btn-tales-one">Read more</a>
            </div>
        </article>
    </div>
</div>
<div class="paging">
    <a href="#" class="newer"><i class="icon-long-arrow-left"></i> Newer</a>
     <span>&bull;</span>
    <a href="#" class="older">Older <i class="icon-long-arrow-right"></i></a>
</div>
@stop