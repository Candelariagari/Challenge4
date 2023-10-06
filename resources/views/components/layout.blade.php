
<!doctype html>

<title>Travel Agency</title>
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="/js/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3.2.29"></script>
<script type="module" src="{{ asset('js/components/Airline-dropdown.js') }}"></script>
<script src="https://unpkg.com/@vuepic/vue-datepicker@latest"></script>
<link rel="stylesheet" href="https://unpkg.com/@vuepic/vue-datepicker@latest/dist/main.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<body style="font-family: Open Sans, sans-serif">
    <section class="px-6 py-8">
        <nav class="md:flex md:items-center flex justify-evenly">

            <div class="flex items-center mr-auto">
                <a href="/" class="mr-4">
                    <img src="https://img.freepik.com/vector-premium/diseno-logotipo-viaje-avion-aire-plano_8035-9.jpg?w=2000" alt="Agency Logo" width="200">
                </a>
                <h1 class="font-serif text-3xl font-semibold text-sky-100 tracking-widest">Travel Agency</h1>
            </div>

        </nav>
                 {{  $slot  }}
    </section>
</body>
