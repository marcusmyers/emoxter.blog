        <header class="flex items-center shadow bg-white border-b h-24 py-4" role="banner">
            <div class="container flex items-center w-4xl mx-auto px-4 lg:px-8">
                <div class="flex items-center">
                    <a href="/" title="{{ $page->siteName }} home" class="inline-flex items-center">
                        <h1 class="text-lg md:text-2xl text-blue-900 font-semibold hover:text-blue-700 my-0">{{ $page->siteName }}</h1>
                    </a>
                </div>

                <div id="vue-search" class="flex flex-1 justify-end items-center">
                    <search></search>

                    @include('_nav.menu')

                    @include('_nav.menu-toggle')
                </div>
            </div>
        </header>

        @include('_nav.menu-responsive')
