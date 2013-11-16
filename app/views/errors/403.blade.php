@extends('layouts.master')

@section('content')
    <h1>Eah!, You shouldn't be trying to do that <span class="about-bold">403!</span></h1>
    <span class="about-large">You are not alowed to do that <span class="about-italic">But </span> <br /> <span class="about-bold">you can </span></span>
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