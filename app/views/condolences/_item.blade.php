<article class="comment{{-- $condolence->reply ? ' reply' : '' --}}">
	<header class="clearfix">
		{{--<img src="/img/avatar.png" alt="A Smart Guy" class="avatar">--}}
		<div class="meta">
		<h3><a href="#">{{ $condolence->name }}</a></h3>
		<span class="date">
			27 July 2013
		</span>
		<span class="separator"> - </span>
		{{--<a href="#create-comment" class="reply-link">Reply</a>--}}
		</div>
	</header>
	<div class="body">
		{{ $condolence->message }}
	</div>
</article>