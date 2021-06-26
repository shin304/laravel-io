<div class="bg-white">
    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <p class="text-center text-base leading-6 font-semibold uppercase text-gray-600 tracking-wider">
            We'd like to thank these <strong>amazing companies</strong> for supporting us
        </p>

        <div class="mt-6 grid grid-cols-2 gap-8 lg:grid-cols-3">
            <div class="col-span-2 flex justify-center lg:col-span-1 px-2">
                <a class="flex items-center" href="https://beyondco.de">
                    <img class="max-h-12" src="{{ asset('images/sponsors/beyondcode.png') }}" alt="Beyond Code">
                </a>
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1 px-2">
                <a class="flex items-center" href="https://devsquad.com">
                    <img class="max-h-12" src="{{ asset('images/sponsors/devsquad.png') }}" alt="Devsquad">
                </a>
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1 px-2">
                <a class="flex items-center" href="https://usefathom.com/ref/7A8QGC">
                    <img class="max-h-12" src="{{ asset('images/sponsors/fathom.png') }}" alt="Fathom">
                </a>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-8 lg:grid-cols-3">
            <div class="col-span-2 flex justify-center lg:col-span-1 px-2">
                <a class="flex items-center" href="https://forge.laravel.com/">
                    <img class="max-h-12" src="{{ asset('images/sponsors/forge.png') }}" alt="Forge">
                </a>
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1 px-2">
                <a class="flex items-center" href="https://envoyer.io/">
                    <img class="max-h-12" src="{{ asset('images/sponsors/envoyer.png') }}" alt="Envoyer">
                </a>
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1 px-2">
                <a class="flex items-center" href="https://blackfire.io/">
                    <img class="max-h-12" src="{{ asset('images/sponsors/blackfire-io.png') }}" alt="Blackfire.io">
                </a>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-8 lg:grid-cols-3">
            <div class="col-span-2 flex justify-center lg:col-span-1 px-2">
                <a class="flex items-center" href="https://akaunting.com/developers?utm_source=Laravelio&utm_medium=Banner&utm_campaign=Developers">
                    <img class="max-h-12" src="{{ asset('images/sponsors/akaunting.png') }}" alt="Akaunting">
                </a>
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1 px-2">
                <a class="flex items-center" href="https://larajobs.com">
                    <img class="max-h-12" src="{{ asset('images/sponsors/larajobs.svg') }}" alt="LaraJobs">
                </a>
            </div>

            <div class="col-span-2 flex justify-center lg:col-span-1 px-2">
                <a class="flex items-center" href="https://ter.li/vj4bxb">
                    <img class="max-h-12" src="{{ asset('images/sponsors/scout-apm.jpg') }}" alt="Scout APM">
                </a>
            </div>
        </div>

        <div class="mt-4">
            @include('layouts._ads._cta', ['text' => 'Your logo here?'])
        </div>
    </div>
</div>
