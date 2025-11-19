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
    <div class=" pt-4 pl-20 pr-70">
        <div class="container px-0 mx-auto flex flex-wrap flex-col md:flex-row items-center">
            <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
                <p class="uppercase tracking-loose w-full"></p>
                <h1 class="my-4 text-7xl font-bold leading-tight" style="color: black; color:  rgb(0, 0, 0); font-weight: 900PX
            ;">
                    Ministère
                </h1>


                <p class="leading-normal text-4xl mb-8 flex" style="line-height: 50px; color: black;">
                de la Formation professionnelle, de l'Apprentissage et de l'Insertion (MFPAI)

                </p>
                <p class="text_img" style="line-height: 25px; color: rgb(6, 3, 0); font-size: 15px;">Plateforme
                    de gestion intégrée des établissements de formation professionnelle
                    et technique du MFPAI </p><i class="fa fa-etsy" aria-hidden="true"></i>
                <button class="mx-auto lg:mx-0 hover:underline  text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out" style="background-color: rgb(6, 143, 125); color: white;">
                    En savoir plus
                </button>
            </div>
            <div class="blog-right  w-full md:w-3/5 py-6 text-center float-right">
                <img class="w-full md:w-4/2 z-50" src="{{asset('frontAssets2/images/Group 11030.svg')}}"/>
            </div>
        </div>
    </div>


    <section class=" border-b py-8" style="background-image: url({{asset('frontAssets2/images/Group\ 11033\ \(1\).svg')}}); background-repeat: no-repeat;">
        <div class="container max-w-5xl mx-auto m-8">
            <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
                Quelques
                <p class="sous-titre" style="font-size: 20px; font-style: normal;">services
                    & <span class="decor" style="text-decoration: underline;">directions</span> </p>
            </h2>
            <div class="w-full mb-2">
                <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="container pt-10">
                <div class="card-carousell  grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <!-- Card -->

                    <div class="shadow-2xl flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                        <div class="p-3 mr-4 text-green-500 ">
                            <img  src="{{asset('frontAssets2/images/Group 11031.svg')}}" alt="">
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Service 1
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200" style="font-size: 10px; line-height: 15px;">
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. </p>
                        </div>
                    </div>
                    <!-- Card -->
                    <div class="shadow-2xl flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                        <div class="p-3 mr-4 text-green-500">
                            <img src="{{asset('frontAssets2/images/Group 11032.svg')}}" alt="">
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Service 1
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200" style="font-size: 10px; line-height: 15px;">
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. </p>
                        </div>
                    </div>
                    <!-- Card -->
                    <div class="shadow-2xl flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                        <div class="p-3 mr-4 text-green">
                            <img src="{{asset('frontAssets2/images/Group 11033.svg')}}" alt="">
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Service 1
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200" style="font-size: 10px; line-height: 15px;">
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. </p>
                        </div>
                    </div>
                    <!-- Card -->
                    <div class="shadow-2xl flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                        <div class="p-3 mr-4 text-green-500">
                            <img src="{{asset('frontAssets2/images/Group 11033.svg')}}" alt="">
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Service 1
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200" style="font-size: 10px; line-height: 15px;">
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap flex-col-reverse sm:flex-row">
                <div class="w-full sm:w-1/2 p-0 mt-6">
                    <img src="{{asset('frontAssets2/images/Group 11035.svg')}}" alt>
                </div>
                <div class="w-full sm:w-1/2 p-2 mt-6">
                    <div class="align-middle">
                        <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                            <p class="text-gray-600 mb-1" style="line-height: 40px;"> A
                                propos</p>
                            <p class="miinistre;">du ministere</p>
                        </h3>
                        <p class="text-gray-600 mb-8 mt-10" style="font-size: 12px;">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam
                            at ipsum eu nunc commodo posuere et sit amet ligula.
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                            Tenetur nostrum impedit obcaecati veniam excepturi, temporibus
                            dolorum quos beatae et eligendi? Nobis aliquid illum ad magnam
                            natus dolorum aspernatur, autem obcaecati?
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et
                            doloremque, atque eius ab quas exercitationem deserunt
                            distinctio velit optio dolorem, voluptates asperiores mollitia
                            dolorum sunt perferendis maiores eos reiciendis recusandae.
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus
                            magnam adipisci illum aperiam ab architecto voluptatibus odio
                            illo error culpa, aliquam dolore possimus officiis facere
                            consequuntur, nostrum provident doloremque deleniti?Lorem, ipsum
                            dolor sit amet consectetur adipisicing elit. Expedita nam cumque
                            maxime neque aperiam et reiciendis. Reprehenderit, dolorem dicta
                            consequatur amet, nihil voluptates fugiat maiores, repellendus
                            id neque nam. A?
                            <br />
                            <br />
                            <br />
                            <br />

                            <button type="button" class="text-white  hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 " style="background-color: rgb(6, 143, 125) ;">En savoir plus</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class=" border-b py-8;" style="background-image: url({{asset('frontAssets2/images/Rectangle\ 13.svg')}}); background-repeat: no-repeat;">
        <div class="container max-w-5xl mx-auto m-0">

            <div class="w-full mb-2">
                <div class="h-7 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="container" style="color: black;">
                <p class="etablissement" style="font-size: 30px;"> <strong>Les établissements</strong> de </p>
                <P class="font" style="font-size: 30px; font-style: initial;">formation professionnelle</P>
            </div>

            <div class="flex flex-wrap flex-col-reverse sm:flex-row">
                <div class="w-full sm:w-1/2 p-0 ">

                </div>
                <div class="w-full sm:w-1/2 p-0">
                    <div class="align-middle">

                        <p class="text-gray-600 " style="font-size: 12px;">
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.

                        </p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800 mt-12 mb-12">
            Actualités
            <p class="sous-titre" style="font-size: 20px; font-style: normal;">
                <span class="decor" style="text-decoration: underline;"></span>
            </p>
        </h2>
        <div class="container pt-10 ml-52 mr-13">
            <div class="card-carousell  grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                <!-- Card -->

                <div class="shadow-2xl">
                    <div class="overflow-hidden bg-cover bg-no-repeat">

                        <img  src="{{asset('frontAssets2/images/Subtract.svg')}}" alt="">
                    </div>
                    <div>


                    </div>
                    <P class="bgb" style="color: black; font-size: 8px; margin-top: 12px; padding-left: 12px;">03 NOVEMBRE 2023</P>
                    <P class="bgb" style="color: black; font-size: 18px; padding-left: 12px;">Les Etablissements de
                        Formation Professionnelle</P>
                    <P class="bgb" style="color: black; font-size: 8px; color: rgb(6, 143, 125); margin-top: 12px; padding-left: 12px;">Lire la suite</P>


                </div>
                <!-- Card -->
                <div class="shadow-2xl">
                    <div class="overflow-hidden bg-cover bg-no-repeat">

                        <img src="{{asset('frontAssets2/images/Subtract.svg')}}" alt="">
                    </div>
                    <div>


                    </div>
                    <P class="bgb" style="color: black; font-size: 8px; margin-top: 12px; padding-left: 12px;">03 NOVEMBRE 2023</P>
                    <P class="bgb" style="color: black; font-size: 18px; padding-left: 12px;">Les Etablissements de
                        Formation Professionnelle</P>
                    <P class="bgb" style="color: black; font-size: 8px; color: rgb(6, 143, 125); margin-top: 12px; padding-left: 12px;">Lire la suite</P>


                </div>
                <!-- Card -->

                <!-- Card -->
                <div class="shadow-2xl">
                    <div class="overflow-hidden bg-cover bg-no-repeat">

                        <img src="{{asset('frontAssets2/images/Subtract.svg')}}" alt="">
                    </div>
                    <div>


                    </div>
                    <P class="bgb" style="color: black; font-size: 8px; margin-top: 12px; padding-left: 12px;">03 NOVEMBRE 2023</P>
                    <P class="bgb" style="color: black; font-size: 18px; padding-left: 12px;">Les Etablissements de
                        Formation Professionnelle</P>
                    <P class="bgb" style="color: black; font-size: 8px; color:rgb(6, 143, 125); margin-top: 12px; padding-left: 12px;">Lire la suite</P>


                </div>
            </div>
        </div>
        <h2 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800 mt-12 mb-12">
            Vous avez
            <p class="text" style="font-style: normal; font-size: 30px;">des question ?</p>
            <p class="sous-titre" style="font-size: 20px; font-style: normal;">
                <span class="decor" style="text-decoration: underline;"></span>
            </p>
            <button class="mx-auto lg:mx-0 hover:underline text-gray-100 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-100 ease-in-out" style="background-color: rgb(6, 143, 125); color: white; font-size: 20px; margin-top:70px;">
                Cliquer ici
            </button>
        </h2>

    </section>


    <!--Footer-->
    <footer class="bg-white" style="background-image: url({{asset('frontAssets2/images/Rectangle\ 39\ \(2\).svg')}}); font-weight: 200px; background-repeat: no-repeat;">
        <div class="container mx-auto px-8 ">
            <div class="w-full flex flex-col md:flex-row py-6">
                <div class="flex-1 mb-6 text-black mr-11">
                    <a class="text-pink-600 no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="#">
                        <img   src="{{asset('frontAssets2/images/Logo PIGE (1).svg')}}" alt>
                    </a>
                    <p class="anoter" style="color: white; font-size: 10px; margin-top: 40px;"> Duis
                        aute irure dolor in reprehenderit in voluptate velitDuis aute
                        irure dolor in reprehenderit in voluptate velit esse cillum dolore
                        eu fugiat nulla pariatur. .</p>

                    <button class="btn" style="padding-top: 35px;">
                        <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-black-500 bg-gray-700  dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 " placeholder="Votre adresse mail " required>
                        <img src alt>
                    </button>
                    <p class="copyright" style="font-size: 9px; color: white; margin-top: 100px;">© 2022
                        KGM Consulting. Copyright and rights reserved</p>
                </div>

                <div class="flex-1">
                    <p class="uppercase text-gray-500 md:mb-6" style="color: white;">Menu</p>
                    <ul class="list-reset mb-6">
                        <li class="mt-2 inline-block mr-2 md:block md:mr-0">
                            <a href="#" class="no-underline hover:underline text-gray-800 hover:text-pink-500" style="color: white; font-size: 12px;">Acceuil</a>
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