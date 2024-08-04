<x-layouts.app title="Login">
    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-2xl sm:mx-auto">
            <div
                class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-sky-500 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
            </div>
            <div class="sm:w-[500px] relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                <div class="max-w-xl mx-auto">
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4"
                            role="alert">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div>
                        <h1 class="text-2xl font-semibold">Login</h1>
                    </div>

                    <div class="divide-y divide-gray-200">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                <div class="relative">
                                    <input autocomplete="off" id="email" name="email" type="text"
                                        class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600"
                                        placeholder="Email address" value="{{ old('email') }}" />
                                    <label for="email"
                                        class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Email
                                        Address</label>
                                </div>
                                <div class="relative">
                                    <input autocomplete="off" id="password" name="password" type="password"
                                        class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600"
                                        placeholder="Password" />
                                    <label for="password"
                                        class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
                                </div>
                                <div class="relative">
                                    <button type="submit"
                                        class="bg-cyan-500 text-white rounded-md px-2 py-1">Submit</button>
                                </div>
                                <div class="relative mt-4 text-gray-700">
                                    <p class="text-sm">Don't have an account? <a href="{{ route('v_register') }}"
                                            class="text-cyan-500 hover:underline">Register here</a>.</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
