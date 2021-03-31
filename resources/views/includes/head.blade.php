<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<!--
<link rel="icon" type="image/png" sizes="32x32" href="wp-content/uploads/fbrfg/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="wp-content/uploads/fbrfg/favicon-16x16.png">
-->

<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

<!-- Styles -->

<style type="text/css">
    [x-cloak] {
        display: none;
    }
</style>

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<link rel="stylesheet" href="{{ asset('css/intlTelInput.css') }}">


<!--
<link rel="stylesheet" href="{{ asset('css/prism.css') }}">
-->

<!-- pas necessaire mais l'ordre a une importance -->
<link rel="stylesheet" href="https://deo8mru8cr8lj.cloudfront.net/be670015-0e71-4dca-8785-c28ecea8d203/css/prism.css">
<link rel="stylesheet" href="https://deo8mru8cr8lj.cloudfront.net/be670015-0e71-4dca-8785-c28ecea8d203/css/app.css?id=f0e7cc70116e39bc73c8">

<!-- nécessaire pour modal bootstrap mais incompatible avec les modal Alpine
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
-->

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

@livewireStyles

<!-- Scripts

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
-->

<!-- livewire:datatables / necessaire au bon fonctionnement -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<!--
    <script src="https://kit.fontawesome.com/107c56b88c.js" crossorigin="anonymous"></script>
-->

<script src="{{ asset('js/app.js') }}" type="text/js"></script>
<script src="{{ asset('js/prism.js') }}" type="text/js"></script>

<script src="{{ asset('js/intlTelInput.js') }}" type="text/js"></script>
<script src="{{ asset('js/utils.js') }}" type="text/js"></script>


@livewireScripts
