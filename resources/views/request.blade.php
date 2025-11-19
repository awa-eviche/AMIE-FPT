<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.v1.partials._head')
    <link rel="stylesheet" href="{{asset('assets/libs/splide/css/splide.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body class="leading-normal tracking-normal text-white" style="font-family: poppins;overflow-x: hidden;font-size: 14px;">
    @include('partials.head')
    <section class=" border-b py-8" style="background-image: url({{asset('frontAssets2/images/Group\ 11033\ \(1\).svg')}}); background-repeat: no-repeat;">
        <div class="container max-w-8xl mx-auto m-8" style="margin-top:80px;">
        <h1 class="text-black text-center text-2xl text-first-orange">Faites votre demande d'ouverture d'établissement</h1>
            <livewire:demandes.new-demande :typeDemande="$typeDemande" />
        </div>
    </section>
    <footer class="bg-white w-full" style="background-image: url({{asset('frontAssets2/images/Rectangle\ 39\ \(2\).svg')}}); font-weight: 200px; background-repeat: no-repeat;background-size: cover;">
        <div class="container mx-auto px-8 ">
            <div class="w-full flex flex-col md:flex-row py-6">
                <div class="flex-1 mb-6 text-black mr-11">
                    <a class="text-pink-600 no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="#">
                        <img src="{{asset('frontAssets2/images/LOGOFOOTERAMIFPT.png')}}" alt>
                    </a>
                    <!--p class="anoter" style="color: white; font-size: 10px; margin-top: 40px;"> Duis
                        aute irure dolor in reprehenderit in voluptate velitDuis aute
                        irure dolor in reprehenderit in voluptate velit esse cillum dolore
                        eu fugiat nulla pariatur. .</p-->

                    <button class="btn" style="padding-top: 35px;">
                        <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-black-500 bg-gray-700  dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 " placeholder="Votre adresse mail " required>
                        <img src alt>
                    </button>
                    <p class="copyright" style="font-size: 9px; color: white; margin-top: 100px;">© 2024 MFPT-CI. Tous droits réservés</p>
                </div>

                <div class="flex-1">
                    <p class="uppercase text-gray-500 md:mb-6" style="color: white;">Menu</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#" class="no-underline hover:underline text-gray-800 hover:text-pink-500" style="color: white; font-size: 12px;">Accueil</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#" class="no-underline hover:underline text-gray-800 hover:text-pink-500" style="color: white; font-size: 12px">Plateformes</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#" class="no-underline hover:underline text-gray-800 hover:text-pink-500" style="color: white; font-size: 12px">Actualités</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#" class="no-underline hover:underline text-gray-800 hover:text-pink-500" style="color: white; font-size: 12px">Avis</a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1">
                    <p class="uppercase text-gray-500 md:mb-6" style="color: white;">Liens
                        utiles</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#" class="no-underline hover:underline text-gray-800 hover:text-pink-500" style="color: white; font-size: 12px">Twitter</a>
                        </li>
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#" class="no-underline hover:underline text-gray-800 hover:text-pink-500" style="color: white; font-size: 12px">Instagram</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </footer>
    <script>
        var scrollpos = window.scrollY;
        var header = document.getElementById("header");
        var navcontent = document.getElementById("nav-content");
        var navaction = document.getElementById("navAction");
        var brandname = document.getElementById("brandname");
        var toToggle = document.querySelectorAll(".toggleColour");

        document.addEventListener("scroll", function() {
            /*Apply classes for slide in bar*/
            scrollpos = window.scrollY;

            if (scrollpos > 10) {
                header.classList.add("bg-white");
                navaction.classList.remove("bg-white");
                navaction.classList.add("image");
                navaction.classList.remove("text-gray-800");
                navaction.classList.add("text-white");
                //Use to switch toggleColour colours
                for (var i = 0; i < toToggle.length; i++) {
                    toToggle[i].classList.add("text-gray-800");
                    toToggle[i].classList.remove("text-white");
                }
                header.classList.add("shadow");
                navcontent.classList.remove("bg-gray-100");
                navcontent.classList.add("bg-white");
            } else {
                header.classList.remove("bg-white");
                navaction.classList.remove("gradient");
                navaction.classList.add("bg-white");
                navaction.classList.remove("text-white");
                navaction.classList.add("text-gray-800");
                //Use to switch toggleColour colours
                for (var i = 0; i < toToggle.length; i++) {
                    toToggle[i].classList.add("text-white");
                    toToggle[i].classList.remove("text-gray-800");
                }

                header.classList.remove("shadow");
                navcontent.classList.remove("bg-white");
                navcontent.classList.add("bg-gray-100");
            }
        });
    </script>
    <script>
        /*Toggle dropdown list*/
        /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

        var navMenuDiv = document.getElementById("nav-content");
        var navMenu = document.getElementById("nav-toggle");

        document.onclick = check;

        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

            //Nav Menu
            if (!checkParent(target, navMenuDiv)) {
                // click NOT on the menu
                if (checkParent(target, navMenu)) {
                    // click on the link
                    if (navMenuDiv.classList.contains("hidden")) {
                        navMenuDiv.classList.remove("hidden");
                    } else {
                        navMenuDiv.classList.add("hidden");
                    }
                } else {
                    // click both outside link and outside menu, hide menu
                    navMenuDiv.classList.add("hidden");
                }
            }
        }

        function checkParent(t, elm) {
            while (t.parentNode) {
                if (t == elm) {
                    return true;
                }
                t = t.parentNode;
            }
            return false;
        }
        // Initialization for ES Users
        import {
            Carousel,
            initTE,
        } from "tw-elements";

        initTE({
            Carousel
        });
    </script>
    @stack('myJS')
</body>

</html>

