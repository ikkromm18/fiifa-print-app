<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
</head>

<body>


    <div class="min-h-screen bg-slate-100 flex flex-col justify-center items-center">


        <x-alert />

        <div class="bg-white p-8 shadow-sm rounded-sm">
            <div class="flex justify-center items-center gap-4 mb-4">
                <img class="w-16" src="./images/fiifa_logo.png" alt="">

                <h3 class="text-3xl font-bold dark:text-white">FiiFa Print</h3>

            </div>

            <form class="min-w-sm mx-auto" action="{{ route('signin') }}" method="post">
                @csrf

                {{-- <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                        email</label>
                    <input type="email" id="email" name="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="name@flowbite.com" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">{{ $message }}
                        </p>
                    @enderror

                </div> --}}
                <x-input label="Email" type="email" name="email" value="{{ old('email') }}"
                    placeholder="email@example.com" />

                <x-input label="Password" type="password" name="password" placeholder="Masukkan Password" />



                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
            </form>
        </div>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
