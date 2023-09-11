<!doctype html>

<title>Travel Agency</title>
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<script src="/js/jquery.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>


<body style="font-family: Open Sans, sans-serif">
    <section class="px-6 py-8">
        <nav class="md:flex md:items-center flex justify-evenly">

            <div class="flex items-center mr-auto">
                <a href="/" class="mr-4">
                    <img src="https://img.freepik.com/vector-premium/diseno-logotipo-viaje-avion-aire-plano_8035-9.jpg?w=2000" alt="Agency Logo" width="200">
                </a>
                <h1 class="font-serif text-3xl font-semibold text-sky-100 tracking-widest">Travel Agency</h1>
            </div>

            <div class="mt-8 md:mt-0 flex items-center  mx-10 lg:bg-gray-200 rounded-full">
                <form method="POST" action="#" class="lg:flex text-sm">
                    <div class="lg:py-3 lg:px-5 flex items-center">
                        <label for="email" class="hidden lg:inline-block"></label>

                        <input id="email" type="text" placeholder="Search for your city..."
                               class="lg:bg-transparent py-2 lg:py-0 pl-4 focus-within:outline-none">
                    </div>
                </form>
            </div>


        </nav>
                 {{  $slot  }}
        <footer class="bg-gray-100 border border-black border-opacity-5 rounded-xl text-center py-16 px-10 mt-16"></footer>
    </section>
</body>
