@extends('layouts.master')

@section('content')
    <h1>Hello There, This is an infamous <span class="about-bold">404!</span></h1>
    <span class="about-large">We are <span class="about-italic">not sure what you are looking for.</span> <br /> <span class="about-bold">You can </span></span>
    <span class="about-medium">find latest obituaries on the side bar or search for a specific one on the search box.</span>

    <div class="about-button">
        <a class="btn btn-xlarge btn-tales-one" href="#contact">Drop Me A Line</a>
    </div>
    <br />
    <hr>
    <div class="tales-superblock" id="contact">
        <h2>Contact</h2>
        
        <form action="#" method="get" accept-charset="utf-8" class="contact-form">
            <input type="text" name="name" id="contact-name" placeholder="Name" class="form-control input-lg">
            <input type="email" name="email" id="contact-email" placeholder="Email" class="form-control input-lg">
            <textarea rows="10" name="message" id="contact-body" placeholder="Your thoughts..." class="form-control input-lg"></textarea>
            <div class="buttons clearfix">
                <button type="submit" class="btn btn-xlarge btn-tales-one">Submit</button>
            </div>                    
        </form>
    </div>        
@stop

@section('aside')
    @parent
@stop