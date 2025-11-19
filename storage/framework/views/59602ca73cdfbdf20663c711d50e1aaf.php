<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <?php echo $__env->make('layouts.v1.partials._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/splide/css/splide.min.css')); ?>">
</head>

<body class="leading-normal tracking-normal text-black"
      style="font-family: poppins;overflow-x: hidden;font-size: 14px;">
<?php echo $__env->make('partials.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div
    class="w-full bg-entreprise bg-no-repeat bg-cover bg-top flex flex-col sm:justify-between items-beetween sm:pt-0">
    <div class="flex flex-wrap">
        <div class="md:w-2/5 lg:w-3/5 xl:w-2/5 md:py-44 md:px-36 sm:py-10 sm:px-12 wc-full">
            <div class="flex flex-col">
                <div class="text-white font-bold  md:text-5xl sm:text-2xl pt-10">Contact</div>
                <div class="text-white font-medium md:text-xl pt-10 flex items-center">
                    <span>Accueil</span>
                    <span class="mx-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 6 10"
                                 fill="none">
                                <path
                                    d="M0.146447 9.85355C-0.0488155 9.65829 -0.0488155 9.34171 0.146447 9.14645L4.29289 5L0.146447 0.853553C-0.0488155 0.658291 -0.0488155 0.341708 0.146447 0.146446C0.341709 -0.0488167 0.658291 -0.0488167 0.853553 0.146446L5.35355 4.64645C5.54882 4.84171 5.54882 5.15829 5.35355 5.35355L0.853553 9.85355C0.658291 10.0488 0.341709 10.0488 0.146447 9.85355Z"
                                    fill="white"/>
                            </svg>
                        </span>
                    <span class="font-bold">Contact</span>
                </div>
            </div>
        </div>
    </div>
</div>

<main>
    <div class="p-5">
        <div class="md:container md:mx-auto pt-10">
            <h1 class="font-poppins_black text-first-orange text-center text-4xl sm:px-2 lg:px-4 pt-4 pb-2">
                Contactez nous
            </h1>
            <div class="flex flex-col items-center justify-center">
                <p class="text-center text-black w-1/3 text-sm">
                </p>
                <hr class="border-green-600 border w-1/6 m-5">
            </div>
            <?php echo $__env->make('layouts.v1.partials._alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="w-full flex justify-center items-center flex-wrap">
                <div class="mx-auto max-w-screen-lg pt-10">
                    <h1 class="text-2xl text-first-orange pb-10 justify-center">Pour toute Information ou assistance en
                        matière
                        de gestion intégrée des établissements de formation professionnelle</h1>
                    <div class="mx-auto max-w-screen-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 flex flex-col">
                                <div class="text-first-orange text-center">
                                    <span class="px-2"><i class="fab fa-facebook fa-2x"></i></span>
                                    <span class="px-2"><i class="fab fa-twitter  fa-2x"></i></span>
                                    <span class="px-2"><i class="fab fa-linkedin fa-2x"></i></span>
                                    <span class="px-2"><i class="fab fa-instagram  fa-2x"></i></span>
                                    <span class="px-2"><i class="fab fa-youtube  fa-2x"></i></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="contact" class="md:mb-24 sm:mb-20 mb-16">
        <div class="container mx-auto px-4">
            <div
                class="max-w-7xl grid grid-cols-1 md:grid-cols-2 mx-auto bg-gray-50 rounded-3xl xl:py-20 lg:py-16 sm:py-10 py-8 xl:px-14 lg:px-10 sm:px-8 px-6">
                <div class="xl:pr-24 lg:pr-12 md:pr-6">
                    <div class="">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-600 sm:text-4xl mb-2">
                            Contact
                        </h2>

                    </div>
                    <div class="">
                        <div class="flex items-center gap-4 mb-7">
                            <div class="">
                                <img alt="" width="30" height="40" decoding="async" data-nimg="1"
                                     class="min-w-[18px]" src="https://infygpt.infyom.com/images/location.svg"/>
                            </div>
                            <p class="text-base font-inter font-normal text-gray-600">Sphere Ministerielle Diamniadio, Arrondissement 2 Batiment C, Dakar-Senegal</p>
                        </div>
                        <div class="flex items-center gap-4 mb-7">
                            <div class="">
                                <img alt="" width="18" height="24" decoding="async" data-nimg="1"
                                     class="min-w-[18px]" src="https://infygpt.infyom.com/images/phone.svg"/>

                            </div>
                            <a href="tel:+221 33 865 70 03"
                               class="text-base text-gray-600
                            font-inter font-normal">
                                +221 33 865 70 03</a>
                        </div>
                        <div class="flex items-center gap-4 mb-7">
                            <div class="">
                                <img alt="" width="20" height="24" decoding="async" data-nimg="1"
                                     class="min-w-[18px]" src="https://infygpt.infyom.com/images/email.svg"/>

                            </div>
                            <a href="mailto:hello@example.com"
                               class="text-base font-inter font-normal text-gray-600">mfpaa@mfpaa.gouv.sn</a>
                        </div>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('contact.send')); ?>" class="max-w-2xl mt-2">
                    <?php echo csrf_field(); ?>
                    <div>
                        <div>
                            <div>
                                <span class="font-inter text-sm font-medium required text-black">Nom complet</span>
                                <input
                                    class="w-full bg-white border text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline"
                                    type="text" id="name" name="name"
                                    placeholder=""
                                    required>
                            </div>
                        </div>
                        <div class="mt-2.5">
                            <span class="font-inter text-sm font-medium required text-black">Adresse e-mail</span>
                            <input
                                class="w-full bg-white border text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline"
                                name="email" id="email" type="email" placeholder=""
                                required>
                        </div>
                        <div class="mt-2.5">
                            <span class="font-inter text-sm font-medium required text-black">Message</span>
                            <textarea
                                class="w-full h-32 bg-white border text-gray-900 mt-2 p-3 rounded-lg focus:outline-none focus:shadow-outline"
                                name="message" id="message" placeholder=""
                                required></textarea>
                        </div>
                        <div class="mt-2.5 text-end">
                            <button type="submit"
                                    class="w-1/3 border-solid border-2 border-first-orange bg-white text-first-orange px-2 py-3 hover:text-white  hover:bg-first-orange font-black rounded-md">
                                Envoyer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.v1.partials._script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="<?php echo e(asset('assets/libs/splide/js/splide.min.js')); ?>"></script>

<script>
    const dropdownButton = document.querySelector('.dropdown');
    const dropdownMenu = document.getElementById('dropdownMenu');

    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });
</script>

<script>
    var scrollpos = window.scrollY;
    var header = document.getElementById("header");
    var navcontent = document.getElementById("nav-content");
    var navaction = document.getElementById("navAction");
    var brandname = document.getElementById("brandname");
    var toToggle = document.querySelectorAll(".toggleColour");

    document.addEventListener("scroll", function () {
        /*Apply classes for slide in bar*/
        scrollpos = window.scrollY;

        header.classList.add("bg-white");
        for (var i = 0; i < toToggle.length; i++) {
            toToggle[i].classList.add("text-gray-800");
            toToggle[i].classList.remove("text-white");
        }
        header.classList.add("shadow");
        navcontent.classList.remove("bg-gray-100");
        navcontent.classList.add("bg-white");

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
</script>
<?php echo $__env->yieldPushContent('myJS'); ?>
</body>

</html>
<?php /**PATH /var/www/html/pgi/resources/views/contact.blade.php ENDPATH**/ ?>