<?php

    if (isset($_SESSION['userdata']) && sizeof($_SESSION) > 0) {
        $hassedUserId = md5($_SESSION['userdata']->__get('id_user'));
        $linkForConsultant = '';

        if ($_SESSION['userdata']->__get('typeOfUser') == 2) {
            $linkForConsultant = '<a href="\skole\leap-glocal\contactConsultant\consultant\index.php">Mulige spørsmål</a>';
        }
        echo '
        <nav>
            <a href="/skole/leap-glocal"><img alt="Leap Glocal logo" src="/skole/leap-glocal/img/leap_logo_full.png"></a>
            <section class="mainNavigation">
                <a href="">Finn andre gründere</a>
                <a href="">Gründerhubber/akseleratorer</a>
                <a href="">Støtteordninger</a>
                <a href="\skole\leap-glocal\contactConsultant\user\">Kontakt en konsulent</a>
            </section>
            <section>
                <a class="asButton" href="/skole/leap-glocal/profile.php?user='.$hassedUserId.'">'.$_SESSION['userdata']->__get('name').'</a>
            </section>
        </nav>
        
        ';
    } else {
        echo '
        <nav>
            <a href="/skole/leap-glocal"><img alt="Leap Glocal logo" src="/skole/leap-glocal/img/leap_logo_full.png"></a>
            <section>NAV ELEMENTER</section>
            <section>
                <a class="asButton" href="/skole/leap-glocal/loginRegister/login.php">Logg inn</a>
                <a class="asButton" href="/skole/leap-glocal/loginRegister/register.php">Bli medlem</a>
            </section>
        </nav>
        ';
    }
