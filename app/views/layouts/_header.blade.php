<header>
    <div class="widewrapper masthead">
        <div class="container">
            <a href="/" id="logo">
                <img src="/img/tales-logo.png" alt="Tales Blog">
            </a>

            <div id="mobile-nav-toggle" class="pull-right">
                <a href="#" data-toggle="collapse" data-target=".tales-nav .navbar-collapse">
                    <i class="icon-reorder"></i>
                </a>
            </div>

            <nav class="pull-right tales-nav">
                <div class="collapse navbar-collapse">
                    <ul class="nav nav-pills navbar-nav">
                      
                        <li class="dropdown {% if home_active %}active{% endif %}">
                            <a class="dropdown-toggle"
                               data-toggle="dropdown"
                               href="#">
                                Blog 
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/">Inicio</a></li>
                                <li><a href="blog-detail">Blog Detail</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="about">Información</a>
                        </li>
                        <li>
                            <a href="contact">Contacto</a>
                        </li>
                        <li>
                            <a href="login">Acceder</a>
                        </li>                        
                    </ul>
                </div>
            </nav>        

        </div>
    </div>

    <div class="widewrapper subheader">
        <div class="container">
            <div class="tales-breadcrumb">
                <a href="#">Blog</a>
            </div>

            <div class="tales-searchbox">
                <form action="#" method="get" accept-charset="utf-8">
                    <button class="searchbutton" type="submit">
                        <i class="icon-search"></i>
                    </button>
                    <input class="searchfield" id="searchbox" type="text" placeholder="Search">
                </form>
            </div>
        </div>
    </div>
</header>