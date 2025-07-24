<!DOCTYPE html>
<html lang="en">

<head>


    @include('includes.header')

</head>

<body>

    {{-- <main>
        @yield('auth-section')
    </main> --}}


    <div class="relative h-screen">
        <!-- Fixed Sidebar -->

        @include('includes.admin.sidebar')

        <!-- Fixed Navbar -->

        @include('includes.admin.navbar')




        @include('includes.admin.mobile_menu')


        <div
            class="relative bg-[#f2f2f2] ml-0 lg:ml-[240px] mt-0 lg:mt-[50px] h-full overflow-y-auto lg:pt-6 pb-6 px-6">

            @yield('admin-section')
        </div>





    </div>

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

    <script src="https://js.paystack.co/v1/inline.js"></script>
    {{-- <script src="https://js.paystack.co/v2/inline.js"> --}}


</body>

</html>
