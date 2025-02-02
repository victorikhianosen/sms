<!DOCTYPE html>
<html lang="en">

<head>


    @include('includes.header')

</head>

<body>

    <main>
        @yield('guest-section')
    </main>


    <script src="{{ asset('assets/js/sweet-alart2.js') }}"></script>
    <script>
        window.addEventListener('alert', (event) => {
            const data = event.detail;

            Swal.fire({
                icon: data.type,
                text: data.text,
                position: data.position,
                timer: data.timer,
                buttons: data.button,
            });
        });
    </script>


    <script>
        @if (session('alert'))
            window.dispatchEvent(new CustomEvent('alert', {
                detail: {
                    type: '{{ session('alert.type') }}',
                    text: '{{ session('alert.text') }}',
                    position: '{{ session('alert.position') }}',
                    timer: {{ session('alert.timer') }},
                    button: {{ session('alert.button') ? 'true' : 'false' }}
                }
            }));
        @endif
    </script>

</body>

</html>
